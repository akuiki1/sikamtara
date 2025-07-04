<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::with('user.penduduk')
            ->where('status', 'published')
            ->orderByDesc('tanggal_publish')
            ->get();


        $dataPengumuman = $pengumuman->map(function ($item) {
            return [
                'id' => $item->id_pengumuman,
                'judul' => $item->judul_pengumuman,
                'isi' => $item->isi_pengumuman,
                'file_lampiran' => asset('storage/' . $item->file_lampiran),
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y'),
                'penulis' => $item->user->penduduk->nama ?? 'Admin',
            ];
        })->values();

        return view('user.pengumuman', [
            'title' => 'Pengumuman',
            'pengumuman' => $pengumuman,
            'dataPengumuman' => $dataPengumuman,
        ]);
    }
}
