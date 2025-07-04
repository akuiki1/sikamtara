<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Pengaduan::with('user.penduduk')
            ->where('id_user', $userId);

        // Statistik milik user
        $total = Pengaduan::where('id_user', $userId)->count();
        $terkirim = Pengaduan::where('id_user', $userId)->where('status', 'terkirim')->count();
        $diproses = Pengaduan::where('id_user', $userId)->whereIn('status', ['diterima', 'diproses'])->count();
        $ditutup = Pengaduan::where('id_user', $userId)->whereIn('status', ['selesai', 'ditolak'])->count();

        // Filter pencarian
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

        // Untuk Alpine.js
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

        return view('user.pengaduan', [
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
        $user = Auth::user();

        // Cek apakah user sudah terverifikasi
        if ($user->status_verifikasi !== 'Terverifikasi') {
            return back()->with('error', 'Akun Anda belum terverifikasi. Silakan verifikasi terlebih dahulu untuk mengirim pengaduan.');
        }

        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        try {
            $path = null;

            if ($request->hasFile('lampiran')) {
                $originalName = $request->file('lampiran')->getClientOriginalName();
                $safeName = time() . '_' . $originalName;
                $path = $request->file('lampiran')->storeAs('lampiran_pengaduan', $safeName, 'public');
            }

            Pengaduan::create([
                'id_user' => $user->id_user,
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


    public function update(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduans,id_pengaduan',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'lampiran' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pengaduan = Pengaduan::where('id_pengaduan', $request->id_pengaduan)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();

        $pengaduan->judul_pengaduan = $request->judul_pengaduan;
        $pengaduan->isi_pengaduan = $request->isi_pengaduan;

        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama
            if ($pengaduan->lampiran && Storage::exists($pengaduan->lampiran)) {
                Storage::delete($pengaduan->lampiran);
            }

            $lampiranPath = $request->file('lampiran')->store('lampiran_pengaduan', 'public');
            $pengaduan->lampiran = $lampiranPath;
        }

        $pengaduan->save();

        return redirect()->back()->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate(['id_pengaduan' => 'required|exists:pengaduans,id_pengaduan']);

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);

        $pengaduan->delete();

        try {
            $pengaduan->delete();
            return back()->with('success', 'Pengaduan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pengaduan: ' . $e->getMessage());
        }
    }
}
