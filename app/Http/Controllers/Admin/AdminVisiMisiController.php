<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilDesa; // Model yang menyimpan data Visi dan Misi desa

class AdminVisiMisiController extends Controller
{
    // Menampilkan halaman edit Visi dan Misi
    public function index()
    {
        // Ambil data Visi dan Misi dari tabel 'profil_desa'
        $profilDesa = ProfilDesa::first(); // Ambil data pertama (asumsi hanya ada 1 record)
        
        // Jika belum ada data, buat data baru
        if (!$profilDesa) {
            $profilDesa = ProfilDesa::create([
                'visi' => '',
                'misi' => ''
            ]);
        }

        return view('admin.visimisi', [
            'title' => 'Visi dan Misi Desa',
            'visi' => $profilDesa->visi,
            'misi' => $profilDesa->misi
        ]);
    }

    // Mengupdate data Visi dan Misi
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'visi' => 'required|string|max:1000',
            'misi' => 'required|string|max:2000',
        ]);

        // Ambil data ProfilDesa pertama, atau buat jika belum ada
        $profilDesa = ProfilDesa::first();

        if (!$profilDesa) {
            $profilDesa = ProfilDesa::create([
                'visi' => $request->visi,
                'misi' => $request->misi
            ]);
        } else {
            // Update data yang ada
            $profilDesa->update([
                'visi' => $request->visi,
                'misi' => $request->misi
            ]);
        }

        // Kirim pesan sukses dan kembali ke halaman sebelumnya
        return redirect()->route('admin.profil.visi-misi')
            ->with('success', 'Visi dan Misi desa berhasil diperbarui!');
    }
}
