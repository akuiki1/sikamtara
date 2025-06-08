<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function index()
    {
        $services = [
            [
                'id' => 1,
                'title' => 'Pembuatan KTP',
                'short_description' => 'Layanan pembuatan KTP untuk warga desa.',
                'full_description' => 'Dokumen yang diperlukan: fotokopi KK, akta kelahiran, dan surat pengantar RT/RW.',
            ],
            [
                'id' => 2,
                'title' => 'Pembuatan Surat Domisili',
                'short_description' => 'Surat keterangan domisili untuk keperluan administrasi.',
                'full_description' => 'Dokumen yang diperlukan: fotokopi KK dan KTP, serta surat permohonan.',
            ],
            // Tambahkan layanan lain di sini
        ];

        // Kalau kamu juga punya data history pengajuan user
        $submissions = []; // kosongkan dulu atau ambil dari database kalau sudah ada

        return view('user.administrasi', compact('services', 'submissions'));
    }

    public function apply($id)
    {
        // Nanti bisa fetch data service dari database berdasarkan ID.
        // Untuk sementara kita kasih dummy saja.

        $service = [
            'id' => $id,
            'title' => 'Contoh Layanan',
            'description' => 'Ini halaman untuk mengajukan layanan dengan ID: ' . $id,
        ];

        return view('layanan.administrasi.apply', compact('service'));
    }
}
