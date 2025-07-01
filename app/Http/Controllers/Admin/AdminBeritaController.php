<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Berita::with('user');

        if ($request->has('search')) {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
        }


        // Filter berdasarkan role
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination dengan query string tetap
        $berita = $query->paginate(10)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($berita->items())->map(function ($item) {
            return [
                'id_berita'         => $item->id_berita,
                'judul_berita'      => $item->judul_berita,
                'isi_berita'        => \Illuminate\Support\Str::limit($item->isi_berita, 50),
                'isi_berita_full'        => $item->isi_berita,
                'gambar_cover'      => $item->gambar_cover,
                'tanggal_publish' => \Carbon\Carbon::parse($item->tanggal_publish)->diffForHumans(),
                'penulis'           => $item->penulis ? $item->user->penduduk->nama : null,
                'status'            => $item->status,
            ];
        });

        $penulis = User::select('id_user')->get();

        return view('admin.berita.berita', [
            'berita'      => $berita,
            'beritaJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'penulis'   => $penulis,
            'role'      => $request->role,
            'status'    => $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul_berita' => 'required|string|max:255',
                'isi_berita' => 'required|string',
                'gambar_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'penulis' => 'required|exists:users,id_user',
                'status' => 'required|in:draft,published,archived',
                'tags' => 'nullable|string|max:255',
            ]);

            // Handle upload gambar
            if ($request->hasFile('gambar_cover')) {
                $file = $request->file('gambar_cover');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('gambar_berita', $filename, 'public');
                $validated['gambar_cover'] = $path;
            }

            // Atur tanggal_publish berdasarkan status
            if ($validated['status'] === 'published') {
                $validated['tanggal_publish'] = now(); // tanggal & waktu saat ini
            } else {
                $validated['tanggal_publish'] = null;
            }

            Berita::create($validated);

            return redirect()->back()->with('success', 'Berita berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $berita = Berita::where('id_berita', $id)->firstOrFail();

            // Ambil semua data yang mau diupdate
            $data = $request->all();

            // Kalau status diubah jadi "published", set tanggal_publish ke sekarang
            if ($request->status === 'published') {
                $data['tanggal_publish'] = Carbon::now();
            }

            // Update data ke database
            $berita->update($data);

            $searchKeyword = Str::limit(strip_tags($berita->judul_berita), 50);

            return redirect()->route('adminberita.index', ['search' => $searchKeyword])
                ->with('success', 'Berita berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->to('/admin/berita')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Berita::where('id_berita', $id)->delete();

            return redirect()->back()->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }
}
