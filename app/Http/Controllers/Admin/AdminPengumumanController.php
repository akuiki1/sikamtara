<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminPengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::with('user');

        if ($request->has('search')) {
            $query->where('judul_pengumuman', 'like', '%' . $request->search . '%');
        }


        // Filter berdasarkan role
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination dengan query string tetap
        $pengumuman = $query->paginate(10)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($pengumuman->items())->map(function ($item) {
            return [
                'id_pengumuman'         => $item->id_pengumuman,
                'judul_pengumuman'      => $item->judul_pengumuman,
                'isi_pengumuman'        => \Illuminate\Support\Str::limit($item->isi_pengumuman, 50),
                'isi_pengumuman_full'        => $item->isi_pengumuman,
                'file_lampiran'      => $item->file_lampiran,
                'tanggal_publish' => \Carbon\Carbon::parse($item->tanggal_publish)->diffForHumans(),
                'penulis'           => $item->penulis ? $item->user->penduduk->nama : null,
                'status'            => $item->status,
            ];
        });

        $penulis = User::select('id_user')->get();

        return view('admin.berita.pengumuman', [
            'pengumuman'      => $pengumuman,
            'pengumumanJs'    => $transformed,
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
                'judul_pengumuman' => 'required|string|max:255',
                'isi_pengumuman' => 'required|string',
                'file_lampiran' => 'nullable|file|mimes:jpg,jpeg,png|max:5120', // max 5MB
                'penulis' => 'required|exists:users,id_user',
                'status' => 'required|in:draft,published,archived',
            ]);

            // Handle upload file lampiran
            if ($request->hasFile('file_lampiran')) {
                $file = $request->file('file_lampiran');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('lampiran_pengumuman', $filename, 'public');
                $validated['file_lampiran'] = $path;
            }

            // Atur tanggal_publish berdasarkan status
            $validated['tanggal_publish'] = $validated['status'] === 'published' ? now() : null;

            Pengumuman::create($validated);

            return redirect()->back()->with('success', 'Pengumuman baru berhasil ditambahkan!');
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
            $pengumuman = Pengumuman::where('id_pengumuman', $id)->firstOrFail();

            $data = $request->except('file_lampiran'); // pisahkan dulu file_lampiran

            if ($request->status === 'published') {
                $data['tanggal_publish'] = Carbon::now();
            }

            // Handle file lampiran jika di-upload ulang
            if ($request->hasFile('file_lampiran')) {
                // Hapus file lama jika ada
                if ($pengumuman->file_lampiran && Storage::exists($pengumuman->file_lampiran)) {
                    Storage::delete($pengumuman->file_lampiran);
                }

                // Simpan file baru
                $file = $request->file('file_lampiran');
                $path = $file->store('lampiran_pengumuman', 'public');
                $data['file_lampiran'] = $path;
            }

            $pengumuman->update($data);

            $searchKeyword = Str::limit(strip_tags($pengumuman->judul_pengumuman), 50);

            return redirect()->route('pengumuman.index', ['search' => $searchKeyword])
                ->with('success', 'Pengumuman berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->to('/admin/pengumuman')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Pengumuman::where('id_pengumuman', $id)->delete();

            return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }
}
