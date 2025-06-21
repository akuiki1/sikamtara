<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Administrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanAdministrasi;
use Illuminate\Support\Facades\Storage;

class AdministrasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Administrasi::with('user');

        if ($request->has('search')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search . '%');
        }

        if ($request->has('search.riwayat')) {
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



        $dataRiwayat = $this->indexRiwayat($request);

        return view('user.administrasi', [
            'administrasi'      => $administrasi,
            'administrasiJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'role'      => $request->role,
            'status'    => $request->status,
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

        if ($request->has('search.riwayat')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search['riwayat'] . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $riwayatAdministrasi = $query->paginate(8)->appends($request->query());

        $transformed = collect($riwayatAdministrasi->items())->map(function ($item) {
            return [
                'id_pengajuan_administrasi'     => $item->id_pengajuan_administrasi,
                'nama_administrasi'   => $item->administrasi->nama_administrasi,
                'id_user'           => $item->id_user,
                'tanggal_pengajuan'      => \Carbon\Carbon::parse($item->tanggal_pengajuan)->diffForHumans(),
                'form'         => Str::limit(Str::after(basename($item->form), '_'), 35),
                'lampiran'         => Str::limit(Str::after(basename($item->lampiran), '_'), 35),
                'status_pengajuan'           => $item->status_pengajuan,
                'surat_final'      => $item->surat_final,
                'updated_at'      => \Carbon\Carbon::parse($item->updated_at)->diffForHumans(),
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

    public function apply(Request $request, $id_administrasi)
    {
        $request->validate([
            'form' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            $userId = Auth::id();

            // Simpan file
            if ($request->hasFile('form')) {
                $formFile = $request->file('form');
                $formFilename = time() . '_' . $formFile->getClientOriginalName();
                $formPath = $formFile->storeAs('formulir', $formFilename, 'public');
            }

            $lampiranPath = null;
            if ($request->hasFile('lampiran')) {
                $lampiranFile = $request->file('lampiran');
                $lampiranFilename = time() . '_' . $lampiranFile->getClientOriginalName();
                $lampiranPath = $lampiranFile->storeAs('lampiran', $lampiranFilename, 'public');
            }

            // Simpan ke DB
            PengajuanAdministrasi::create([
                'id_user' => $userId,
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

        return Storage::disk('public')->download($path, $filename);
    }
}
