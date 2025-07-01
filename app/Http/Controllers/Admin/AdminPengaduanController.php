<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AdminPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $total = Pengaduan::count();
        $terkirim = Pengaduan::where('status', 'terkirim')->count();
        $diproses = Pengaduan::whereIn('status', ['diterima', 'diproses'])->count();
        $ditutup = Pengaduan::whereIn('status', ['selesai', 'ditolak'])->count();

        $query = Pengaduan::with('user.penduduk');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_pengaduan', 'like', '%' . $request->search . '%')
                    ->orWhere('isi_pengaduan', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->paginate(20)->appends(request()->query());

        // Buat array JSON untuk Alpine
        $pengaduanJs = collect($pengaduans->items())->map(function ($item) {
            return [
                'id_pengaduan' => $item->id_pengaduan,
                'judul_pengaduan' => $item->judul_pengaduan,
                'isi_pengaduan' => $item->isi_pengaduan,
                'status' => $item->status,
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

            Pengaduan::create([
                'id_user' => $request->id_user,
                'judul_pengaduan' => $request->judul_pengaduan,
                'isi_pengaduan' => $request->isi_pengaduan,
                'lampiran' => $path ?? '',
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

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);

        if ($pengaduan->status !== 'terkirim') {
            return back()->with('error', 'Hanya pengaduan dengan status "terkirim" yang dapat diterima.');
        }

        try {
            $pengaduan->status = 'diterima';
            $pengaduan->save();

            return back()->with('success', 'Pengaduan berhasil diterima.');
        } catch (\Exception $e) {
            Log::error('Gagal menerima pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menerima pengaduan.');
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id_pengaduan',
        ]);

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);

        if (!in_array($pengaduan->status, ['terkirim', 'diterima'])) {
            return back()->with('error', 'Pengaduan hanya bisa ditolak jika berstatus "terkirim" atau "diterima".');
        }

        try {
            $pengaduan->status = 'ditolak';
            $pengaduan->save();

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

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);

        if ($pengaduan->status !== 'diterima') {
            return back()->with('error', 'Pengaduan hanya bisa diproses jika berstatus "diterima".');
        }

        try {
            $pengaduan->status = 'diproses';
            $pengaduan->save();

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

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);

        if ($pengaduan->status !== 'diproses') {
            return back()->with('error', 'Pengaduan hanya bisa diselesaikan jika berstatus "diproses".');
        }

        try {
            $pengaduan->status = 'selesai';
            $pengaduan->save();

            return back()->with('success', 'Pengaduan berhasil diselesaikan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyelesaikan pengaduan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyelesaikan pengaduan.');
        }
    }

    public function destroy(Request $request)
    {
        $request->validate(['id_pengaduan' => 'required|exists:pengaduans,id_pengaduan']);

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);


        if ($pengaduan->status !== 'ditolak') {
            return back()->with('error', 'Hanya pengaduan yang ditolak yang bisa dihapus.');
        }

        $pengaduan->delete();

        try {
            $pengaduan->delete();
            return back()->with('success', 'Pengaduan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pengaduan: ' . $e->getMessage());
        }
    }
}
