<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminVerifikasiController extends Controller
{
    public function index($id)
    {
        $verifikasi = Verifikasi::findOrFail($id);
        return view('admin.akun.verifikasi', compact('verifikasi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status_verifikasi' => 'required|string',
        ]);

        // Cari user berdasarkan id_user (FK dari verifikasi)
        $verifikasi = Verifikasi::findOrFail($id);
        $user = $verifikasi->user; // relasi harus dibuat di model Verifikasi

        // Update status verifikasi user
        $user->status_verifikasi = $request->status_verifikasi;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Status verifikasi berhasil diperbarui.');
    }
}
