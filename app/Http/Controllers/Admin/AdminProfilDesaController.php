<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Sejarah;
use App\Models\Visimisi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StrukturPemerintahan;
use App\Models\ProgramPembangunanDesa;

class AdminProfilDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StrukturPemerintahan::with('user.penduduk');

        if ($request->has('search')) {
            $query->whereHas('user.penduduk', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Jika ingin filter status, pastikan ada kolom 'status' di tabel
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $strukturPemerintahan = $query->get();

        $transformed = $strukturPemerintahan->map(function ($item) {
            return [
                'id' => $item->id,
                'jabatan' => $item->jabatan,
                'deskripsi' => Str::limit($item->deskripsi, 100),
                'nama' => $item->user->penduduk->nama ?? '-',
            ];
        });

        $sejarah = Sejarah::first();
        $visimisi = Visimisi::first();
        $users = User::with('penduduk')->get();
        $programs = ProgramPembangunanDesa::orderByDesc('tanggal_mulai')->get();

        return view('admin.profil-desa', [
            'strukturPemerintahan' => $strukturPemerintahan,
            'strukturPemerintahanJs' => $transformed,
            'search' => $request->search,
            'sejarah' => $sejarah,
            'visimisi' => $visimisi,
            'users' => $users,
            'programs' => $programs
        ]);
    }

    public function updateSejarah(Request $request)
    {
        $request->validate([
            'sejarah' => 'required|string',
            'foto' => 'nullable|string',
        ]);

        try {
            // Ambil entri pertama
            $sejarah = Sejarah::first();

            if ($sejarah) {
                $sejarah->update([
                    'sejarah' => $request->sejarah,
                    'foto' => $request->foto ?? '',
                ]);
            } else {
                // Kalau belum ada, baru buat
                Sejarah::create([
                    'sejarah' => $request->sejarah,
                    'foto' => $request->foto ?? '',
                ]);
            }

            return redirect()->back()->with('success', 'Sejarah desa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui sejarah: ' . $e->getMessage());
        }
    }

    public function updateVisimisi(Request $request)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        try {
            $visimisi = Visimisi::first();

            if ($visimisi) {
                $visimisi->update([
                    'visi' => $request->visi,
                    'misi' => $request->misi,
                ]);
            } else {
                Visimisi::create([
                    'visi' => $request->visi,
                    'misi' => $request->misi,
                ]);
            }

            return redirect()->back()->with('success', 'Visi dan misi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function strukturCreate(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
        ]);

        try {
            StrukturPemerintahan::create($request->all());

            return redirect()->back()->with('success', 'Data struktur pemerintahan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function strukturUpdate(Request $request, $id)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
        ]);

        try {
            $struktur = StrukturPemerintahan::findOrFail($id);
            $struktur->update($request->all());

            return redirect()->back()->with('success', 'Data struktur pemerintahan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function strukturDestroy($id)
    {
        $struktur = StrukturPemerintahan::findOrFail($id);
        $struktur->delete();

        return redirect()->back()->with('success', 'Data struktur pemerintahan berhasil dihapus.');
    }

    public function pembangunanStore(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'jenis_program' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'anggaran' => 'required|numeric|min:0',
            'sumber_dana' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'status' => 'required|in:perencanaan,pelaksanaan,selesai,batal',
            'deskripsi' => 'nullable|string',
            'foto_dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_dokumentasi')) {
            $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('program', 'public');
        }

        ProgramPembangunanDesa::create($validated);

        return redirect()->back()->with('success', 'Program pembangunan berhasil ditambahkan.');
    }
}
