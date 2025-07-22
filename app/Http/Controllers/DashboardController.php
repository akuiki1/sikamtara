<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanAdministrasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $laki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();
        $jumlahPenduduk = $laki + $perempuan;

        $akunTerverifikasi = User::where('status_verifikasi', 'Terverifikasi')->count();
        $layananMenunggu = PengajuanAdministrasi::whereIn('status_pengajuan', ['baru', 'ditinjau'])->count();
        $pengaduanMasuk = Pengaduan::whereHas('statusTerakhir', function ($q) {
            $q->whereIn('status', ['terkirim', 'diterima']);
        })->count();

        $pengaduan = Pengaduan::with(['user.penduduk', 'statusTerakhir'])
            ->whereHas('statusTerakhir', function ($q) {
                $q->whereIn('status', ['terkirim', 'diterima']);
            })
            ->latest()
            ->get();

        $pengajuan = PengajuanAdministrasi::with('user')
            ->whereIn('status_pengajuan', ['baru', 'ditinjau'])
            ->latest()
            ->get();

        $aktivitas = $pengaduan->concat($pengajuan)->sortByDesc('created_at')->values();

        // Manual paginate (10 per halaman)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;
        $pagedData = $aktivitas->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $aktivitasPaginated = new LengthAwarePaginator($pagedData, $aktivitas->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $dataRiwayat = $this->indexRiwayat($request);

        return view('admin.dashboard', [
            'statistik_penduduk' => [
                'laki' => $laki,
                'perempuan' => $perempuan,
            ],
            'jumlahPenduduk' => $jumlahPenduduk,
            'akunTerverifikasi' => $akunTerverifikasi,
            'layananMenunggu' => $layananMenunggu,
            'pengaduanMasuk' => $pengaduanMasuk,
            'aktivitas' => $aktivitasPaginated,
            'title' => 'Sikamtara',
            'jumlahLayanan' => $dataRiwayat['jumlahLayanan'],
            'jumlahMasuk' => $dataRiwayat['jumlahMasuk'],
            'jumlahSiapTtd' => $dataRiwayat['jumlahSiapTtd'],
            'jumlahSelesaiTahunIni' => $dataRiwayat['jumlahSelesaiTahunIni'],
            'pengajuanAdministrasi' => $dataRiwayat['pengajuanAdministrasi'],
            'riwayatAdministrasi' => $dataRiwayat['riwayatAdministrasi'],
        ]);
    }

    public function indexRiwayat(Request $request)
    {
        $query = PengajuanAdministrasi::with('user', 'administrasi')
            ->where('id_user', Auth::id());

        if ($request->filled('search_riwayat')) {
            $query->whereHas('administrasi', function ($q) use ($request) {
                $q->where('nama_administrasi', 'like', '%' . $request->input('search_riwayat') . '%');
            });
        }

        if ($request->filled('status_pengajuan')) {
            $query->where('status_pengajuan', $request->status_pengajuan);
        }

        $riwayatAdministrasi = $query->paginate(8)->appends($request->query());

        $transformed = collect($riwayatAdministrasi->items())->map(function ($item) {
            return [
                'id_pengajuan_administrasi' => $item->id_pengajuan_administrasi,
                'nama_administrasi' => $item->administrasi->nama_administrasi,
                'id_user' => $item->id_user,
                'tanggal_pengajuan' => \Carbon\Carbon::parse($item->tanggal_pengajuan)->diffForHumans(),
                'form' => $item->form, // ASLI
                'lampiran' => $item->lampiran, // ASLI
                'surat_final' => $item->surat_final, // ASLI
                'status_pengajuan' => $item->status_pengajuan,
                'updated_at' => \Carbon\Carbon::parse($item->updated_at)->diffForHumans(),

                // Ini khusus hanya untuk ditampilkan di UI, bukan untuk path
                'form_name' => Str::limit(Str::after(basename($item->form), '_'), 35),
                'lampiran_name' => Str::limit(Str::after(basename($item->lampiran), '_'), 35),
                'surat_final_name' => Str::limit(Str::after(basename($item->surat_final), '_'), 35),
            ];
        });


        $jumlahLayanan = PengajuanAdministrasi::where('id_user', Auth::id())->count();

        $jumlahMasuk = PengajuanAdministrasi::where('id_user', Auth::id())
            ->whereIn('status_pengajuan', ['baru', 'ditinjau'])
            ->count();

        $jumlahSiapTtd = PengajuanAdministrasi::where('id_user', Auth::id())
            ->where('status_pengajuan', 'diproses')
            ->count();

        $jumlahSelesaiTahunIni = PengajuanAdministrasi::where('id_user', Auth::id())
            ->where('status_pengajuan', 'selesai')
            ->whereYear('tanggal_pengajuan', Carbon::now()->year)
            ->count();


        return [
            'riwayatAdministrasi' => $riwayatAdministrasi,
            'pengajuanAdministrasi' => $transformed,
            'jumlahLayanan' => $jumlahLayanan,
            'jumlahMasuk' => $jumlahMasuk,
            'jumlahSiapTtd' => $jumlahSiapTtd,
            'jumlahSelesaiTahunIni' => $jumlahSelesaiTahunIni,

        ];
    }

    public function update(Request $request, $id_pengajuan)
    {
        $request->validate([
            'form' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            $pengajuan = PengajuanAdministrasi::findOrFail($id_pengajuan);

            // Ganti file form jika diunggah
            if ($request->hasFile('form')) {
                $formFile = $request->file('form');
                $formFilename = time() . '_' . $formFile->getClientOriginalName();
                $formPath = $formFile->storeAs('formulir', $formFilename, 'public');
                $pengajuan->form = $formPath;
            }

            // Ganti lampiran jika diunggah
            if ($request->hasFile('lampiran')) {
                $lampiranFile = $request->file('lampiran');
                $lampiranFilename = time() . '_' . $lampiranFile->getClientOriginalName();
                $lampiranPath = $lampiranFile->storeAs('lampiran', $lampiranFilename, 'public');
                $pengajuan->lampiran = $lampiranPath;
            }

            $pengajuan->updated_at = now();
            $pengajuan->save();

            return redirect()->back()->with('success', 'Pengajuan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui pengajuan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pengajuan = PengajuanAdministrasi::findOrFail($id);

            // Hapus file form jika ada
            if ($pengajuan->form && Storage::disk('public')->exists($pengajuan->form)) {
                Storage::disk('public')->delete($pengajuan->form);
            }

            // Hapus file lampiran jika ada
            if ($pengajuan->lampiran && Storage::disk('public')->exists($pengajuan->lampiran)) {
                Storage::disk('public')->delete($pengajuan->lampiran);
            }

            // Hapus record dari database
            $pengajuan->delete();

            return redirect()->back()->with('success', 'Pengajuan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        }
    }

    public function downloadSuratFinal($id)
    {
        $pengajuan = PengajuanAdministrasi::with(['user', 'administrasi'])->findOrFail($id);

        if (!$pengajuan->surat_final) {
            return abort(404, 'Surat final tidak ditemukan.');
        }

        $path = $pengajuan->surat_final;

        if (!Storage::disk('public')->exists($path)) {
            return abort(404, 'File tidak tersedia di penyimpanan.');
        }

        // Siapkan nama file dari nama layanan dan nama user
        $namaLayanan = Str::slug($pengajuan->administrasi->nama_administrasi ?? 'layanan');
        $namaUser = Str::slug($pengajuan->user->username ?? 'user');
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = "{$namaLayanan}-{$namaUser}.{$ext}";

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        return $disk->download($path, $filename);
    }
}
