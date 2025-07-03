<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index() {
        $pengumuman = Pengumuman::with('user.penduduk')
            ->where('status', 'published')
            ->orderByDesc('tanggal_publish')
            ->paginate(10);

        return view ("user.pengumuman", [
            'title' => 'Pengumuman',
            'pengumuman' => $pengumuman,
        ]);
    }
}
