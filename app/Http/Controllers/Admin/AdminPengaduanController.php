<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\RiwayatStatusPengaduan;

class AdminPengaduanController extends Controller
{

    public function index(Request $request)
    {
        $total = Pengaduan::count();

        $terkirim = Pengaduan::whereHas('statusTerakhir', function ($q) {
            $q->where('status', 'terkirim');
        })->count();

        $diproses = Pengaduan::whereHas('statusTerakhir', function ($q) {
            $q->whereIn('status', ['diterima', 'diproses']);
        })->count();

        $ditutup = Pengaduan::whereHas('statusTerakhir', function ($q) {
            $q->whereIn('status', ['selesai', 'ditolak']);
        })->count();

        $query = Pengaduan::with(['user.penduduk', 'statusTerakhir']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_pengaduan', 'like', '%' . $request->search . '%')
                    ->orWhere('isi_pengaduan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('statusTerakhir', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $pengaduans = $query->latest()->paginate(20)->appends(request()->query());

        $pengaduanJs = collect($pengaduans->items())->map(function ($item) {
            return [
                'id_pengaduan' => $item->id_pengaduan,
                'judul_pengaduan' => $item->judul_pengaduan,
                'isi_pengaduan' => $item->isi_pengaduan,
                'status' => $item->statusTerakhir->status ?? 'tidak diketahui',
                'created_at' => $item->created_at->toDateTimeString(),
                'nama' => $item->user->penduduk->nama ?? '-',
                'lampiran' => $item->lampiran,
            ];
        });

        return view('admin.layanan.pengaduan', [
            'title' => 'Pengaduan Warga',
            'total' => $total,
            'terkirim' => $terkirim,
            'diproses' => $diproses,
            'ditutup' => $ditutup,
            'pengaduans' => $pengaduans,
            'pengaduanJs' => $pengaduanJs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        try {
            $path = null;
            if ($request->hasFile('lampiran')) {
                $path = $request->file('lampiran')->store('lampiran_pengaduan', 'public');
            }

            $pengaduan = Pengaduan::create([
                'id_user' => $request->id_user,
                'judul_pengaduan' => $request->judul_pengaduan,
                'isi_pengaduan' => $request->isi_pengaduan,
                'lampiran' => $path ?? '',
            ]);

            $pengaduan->statuses()->create([
                'status' => 'terkirim',
            ]);

            return back()->with('success', 'Pengaduan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal tambah pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan pengaduan.');
        }
    }

    public function acc(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id_pengaduan',
        ]);

        $pengaduan = Pengaduan::with('statusTerakhir')->findOrFail($request->id_pengaduan);

        if ($pengaduan->statusTerakhir->status !== 'terkirim') {
            return back()->with('error', 'Hanya pengaduan dengan status "terkirim" yang dapat diterima.');
        }

        try {
            $pengaduan->statuses()->create([
                'status' => 'diterima',
            ]);

            return back()->with('success', 'Pengaduan berhasil diterima.');
        } catch (\Exception $e) {
            Log::error('Gagal menerima pengaduan: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id_pengaduan',
        ]);

        $pengaduan = Pengaduan::with('statusTerakhir')->findOrFail($request->id_pengaduan);

        if (!in_array($pengaduan->statusTerakhir->status, ['terkirim', 'diterima'])) {
            return back()->with('error', 'Pengaduan hanya bisa ditolak jika berstatus "terkirim" atau "diterima".');
        }

        try {
            $pengaduan->statuses()->create([
                'status' => 'ditolak',
            ]);

            return back()->with('success', 'Pengaduan berhasil ditolak.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menolak pengaduan.');
        }
    }

    public function proses(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id_pengaduan',
        ]);

        $pengaduan = Pengaduan::with('statusTerakhir')->findOrFail($request->id_pengaduan);

        if ($pengaduan->statusTerakhir->status !== 'diterima') {
            return back()->with('error', 'Pengaduan hanya bisa diproses jika berstatus "diterima".');
        }

        try {
            $pengaduan->statuses()->create([
                'status' => 'diproses',
            ]);

            return back()->with('success', 'Pengaduan berhasil diproses.');
        } catch (\Exception $e) {
            Log::error('Gagal memproses pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pengaduan.');
        }
    }

    public function selesaikan(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id_pengaduan',
        ]);

        $pengaduan = Pengaduan::with('statusTerakhir')->findOrFail($request->id_pengaduan);

        if ($pengaduan->statusTerakhir->status !== 'diproses') {
            return back()->with('error', 'Pengaduan hanya bisa diselesaikan jika berstatus "diproses".');
        }

        try {
            $pengaduan->statuses()->create([
                'status' => 'selesai',
            ]);

            return back()->with('success', 'Pengaduan berhasil diselesaikan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyelesaikan pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyelesaikan pengaduan.');
        }
    }

    public function destroy(Request $request)
    {
        $request->validate(['id_pengaduan' => 'required|exists:pengaduans,id_pengaduan']);

        $pengaduan = Pengaduan::with('statusTerakhir')->findOrFail($request->id_pengaduan);

        if ($pengaduan->statusTerakhir->status !== 'ditolak') {
            return back()->with('error', 'Hanya pengaduan yang ditolak yang bisa dihapus.');
        }

        try {
            $pengaduan->delete(); 
            return back()->with('success', 'Pengaduan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus pengaduan.');
        }
    }
}
