<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('status', 'published');

        // Filter Search
        if ($request->has('search') && $request->search != '') {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
        }

        // Filter Urutan
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'judul_asc':
                    $query->orderBy('judul_berita', 'asc');
                    break;
                case 'judul_desc':
                    $query->orderBy('judul_berita', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('tanggal_publish', 'asc');
                    break;
                case 'terbaru':
                default:
                    $query->orderBy('tanggal_publish', 'desc');
                    break;
            }
        } else {
            $query->orderBy('tanggal_publish', 'desc');
        }

        $berita = $query->paginate(30);
        return view('user.berita', compact('berita'));
    }

    public function detail($id)
    {
        $berita = Berita::findOrFail($id);
        return view('user.berita-detail', compact('berita'));
    }
}
