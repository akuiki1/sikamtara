<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index() {

        $berita = Berita::where('status', 'published')
            ->orderBy('tanggal_publish', 'desc')
            ->take(6)
            ->get();

        return view('welcome', [
            'berita' => $berita
        ]);
    }
}
