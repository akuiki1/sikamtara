<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Administrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanAdministrasi;


class AdminAdministrasiController extends Controller
{
    public function previewForm($filename)
    {
        $path = storage_path('app/public/form_administrasi/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Administrasi::with('user');

        if ($request->has('search')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search . '%');
        }


        // Filter berdasarkan role
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination dengan query string tetap
        $administrasi = $query->paginate(8)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($administrasi->items())->map(function ($item) {
            return [
                'id_administrasi'         => $item->id_administrasi,
                'nama_administrasi'      => $item->nama_administrasi,
                'deskripsi'        => \Illuminate\Support\Str::limit($item->deskripsi, 100),
                'deskripsi_full'        => $item->deskripsi,
                'persyaratan'        => $item->persyaratan,
                'form'      => $item->form,
                'name_form' => Str::limit(Str::after(basename($item->form), '_'), 35),
                'name_form_edit' => Str::limit(Str::after(basename($item->form), '_'), 25),
            ];
        });

        // $penulis = User::select('id_user')->get();
        $layananDiproses = $this->layananDiproses();
        $layananMasuk = $this->layananMasuk();
        $layananRiwayat = $this->layananRiwayat($request);
        $jumlahLayanan = Administrasi::count();
        $jumlahMasuk = PengajuanAdministrasi::whereIn('status_pengajuan', ['baru', 'ditinjau'])->count();
        $jumlahSiapTtd = PengajuanAdministrasi::where('status_pengajuan', 'diproses')->count();
        $jumlahSelesaiTahunIni = PengajuanAdministrasi::where('status_pengajuan', 'selesai')
            ->whereYear('tanggal_pengajuan', Carbon::now()->year)
            ->count();

        return view('admin.layanan.administrasi', [
            'administrasi'      => $administrasi,
            'administrasiJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'layananDiproses' => $layananDiproses,
            'layananRiwayat' => $layananRiwayat,
            'role'      => $request->role,
            'status'    => $request->status,
            'jumlahLayanan' => $jumlahLayanan,
            'jumlahMasuk' => $jumlahMasuk,
            'jumlahSiapTtd' => $jumlahSiapTtd,
            'jumlahSelesaiTahunIni' => $jumlahSelesaiTahunIni,
            'layananMasuk' => $layananMasuk,

        ]);
    }

    public function layananMasuk()
    {
        return PengajuanAdministrasi::with(['user', 'administrasi'])
            ->whereIn('status_pengajuan', ['baru', 'ditinjau'])
            ->orderByDesc('tanggal_pengajuan')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_pengajuan_administrasi,
                    'nama_user' => $item->user->penduduk->nama ?? 'Tidak diketahui',
                    'nama_layanan' => $item->administrasi->nama_administrasi ?? 'Tidak diketahui',
                    'tanggal_pengajuan' => Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d F Y'),
                    'status' => $item->status_pengajuan,
                    'form' => $item->form,
                    'lampiran' => $item->lampiran,
                ];
            });
    }

    public function layananDiproses()
    {
        return PengajuanAdministrasi::with('user', 'administrasi')
            ->where('status_pengajuan', 'diproses')
            ->orderByDesc('tanggal_pengajuan')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_pengajuan_administrasi,
                    'nama_user' => $item->user->penduduk->nama ?? 'Tidak diketahui',
                    'nama_layanan' => $item->administrasi->nama_administrasi ?? 'Tidak diketahui',
                    'tanggal_pengajuan' => \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d F Y'),
                    'status' => $item->status_pengajuan,
                    'form' => $item->form,
                    'lampiran' => $item->lampiran,
                ];
            });
    }

    public function uploadSuratFinal(Request $request, $id)
    {
        $request->validate([
            'surat_final' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $pengajuan = PengajuanAdministrasi::with('user.penduduk', 'administrasi')->findOrFail($id);

        // Ambil nama user dan layanan
        $namaUser = $pengajuan->user->penduduk->nama ?? 'pengguna';
        $namaLayanan = $pengajuan->administrasi->nama_administrasi ?? 'layanan';

        // Ubah ke format lowercase + strip spasi
        $namaFile = 'surat_' . Str::slug($namaLayanan) . '_' . Str::slug($namaUser);

        // Ambil ekstensi asli
        $ext = $request->file('surat_final')->getClientOriginalExtension();

        // Gabungkan jadi nama file lengkap
        $fileName = $namaFile . '.' . $ext;

        // Simpan file
        $path = $request->file('surat_final')->storeAs('surat_final', $fileName, 'public');

        // Simpan ke DB
        $pengajuan->surat_final = $path;
        $pengajuan->status_pengajuan = 'selesai';
        $pengajuan->save();

        return back()->with('success', 'Surat final berhasil diunggah.');
    }

    public function layananRiwayat(Request $request)
    {
        $query = PengajuanAdministrasi::with(['user.penduduk', 'administrasi'])
            ->whereIn('status_pengajuan', ['ditolak', 'selesai']);

        if ($request->filled('search_riwayat')) {
            $query->whereHas('administrasi', function ($q) use ($request) {
                $q->where('nama_administrasi', 'like', '%' . $request->search_riwayat . '%');
            });
        }

        if ($request->filled('status_pengajuan')) {
            $query->where('status_pengajuan', $request->status_pengajuan);
        }

        return $query->orderByDesc('tanggal_pengajuan')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_pengajuan_administrasi,
                    'nama_user' => $item->user->penduduk->nama ?? 'Tidak diketahui',
                    'nama_layanan' => $item->administrasi->nama_administrasi ?? 'Tidak diketahui',
                    'tanggal_pengajuan' => \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d F Y'),
                    'status' => $item->status_pengajuan,
                    'form' => $item->form,
                    'lampiran' => $item->lampiran,
                    'surat_final' => $item->surat_final,
                ];
            });
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pengajuan_administrasis,id_pengajuan_administrasi',
            'status' => 'required|in:ditinjau,diproses,ditolak',
        ]);

        try {
            $pengajuan = PengajuanAdministrasi::findOrFail($request->id);
            $pengajuan->status_pengajuan = $request->status;
            $pengajuan->save();

            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function hapusLayanan($id)
    {
        $pengajuan = PengajuanAdministrasi::findOrFail($id);

        if ($pengajuan->status_pengajuan !== 'ditolak') {
            return response()->json(['message' => 'Hanya pengajuan ditolak yang bisa dihapus.'], 403);
        }

        $pengajuan->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_administrasi' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'persyaratan' => 'required|string',
                'form' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            if ($request->hasFile('form')) {
                $file = $request->file('form');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('form_administrasi', $filename, 'public');
                $validated['form'] = $path;
            }

            Administrasi::create($validated);

            return redirect()->back()->with('success', 'Berita berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $administrasi = Administrasi::where('id_administrasi', $id)->firstOrFail();

            $data = $request->except('form');

            if ($request->hasFile('form')) {
                $file = $request->file('form');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('form_administrasi', $filename, 'public');
                $data['form'] = $path;
            }

            $administrasi->update($data);

            $searchKeyword = Str::limit(strip_tags($administrasi->nama_administrasi), 50);

            return redirect()->route('adminadministrasi.index', ['search' => $searchKeyword])
                ->with('success', 'Layanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('adminadministrasi.index')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Administrasi::where('id_administrasi', $id)->delete();

            return redirect()->back()->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            // Cek apakah error karena foreign key constraint (kode 1451)
            if ($e->getCode() == 23000 && str_contains($e->getMessage(), '1451')) {
                return redirect()->back()->with('error', 'Gagal menghapus layanan karena sudah ada pengajuan yang menggunakan layanan ini.');
            }

            // Untuk error lainnya
            return redirect()->back()->with('error', 'Gagal menghapus layanan: ' . $e->getMessage());
        }
    }

    public function apply(Request $request, $id_administrasi)
    {
        $request->validate([
            'form' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            $user = Auth::user();

            // Cek status verifikasi user
            if ($user->status_verifikasi !== 'Terverifikasi') {
                return redirect()->back()->with('error', 'Anda belum terverifikasi dan tidak dapat mengajukan administrasi.');
            }

            // Simpan file form
            if ($request->hasFile('form')) {
                $formFile = $request->file('form');
                $formFilename = time() . '_' . $formFile->getClientOriginalName();
                $formPath = $formFile->storeAs('formulir', $formFilename, 'public');
            }

            // Simpan file lampiran jika ada
            $lampiranPath = null;
            if ($request->hasFile('lampiran')) {
                $lampiranFile = $request->file('lampiran');
                $lampiranFilename = time() . '_' . $lampiranFile->getClientOriginalName();
                $lampiranPath = $lampiranFile->storeAs('lampiran', $lampiranFilename, 'public');
            }

            // Simpan data ke DB
            PengajuanAdministrasi::create([
                'id_user' => $user->id_user,
                'id_administrasi' => $id_administrasi,
                'form' => $formPath,
                'lampiran' => $lampiranPath,
                'status' => 'diajukan',
                'tanggal_pengajuan' => now(),
            ]);

            return redirect()->back()->with('success', 'Berhasil membuat pengajuan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
