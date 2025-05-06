<?php

namespace App\Http\Controllers;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{

    public function index()
    {
        $berita = Berita::where('status', 'published')
            ->orderBy('tanggal_publish', 'desc')
            ->take(6)
            ->get();

        return view('informasi.berita.berita', compact('berita'));
    }
}
