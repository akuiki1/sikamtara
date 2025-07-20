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
use Illuminate\Support\Facades\Storage;

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
        $wilayah = \App\Models\LuasWilayah::first();

        return view('admin.profil-desa', [
            'strukturPemerintahan' => $strukturPemerintahan,
            'strukturPemerintahanJs' => $transformed,
            'search' => $request->search,
            'sejarah' => $sejarah,
            'visimisi' => $visimisi,
            'users' => $users,
            'programs' => $programs,
            'wilayah' => $wilayah,
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
                ]);
            } else {
                // Kalau belum ada, baru buat
                Sejarah::create([
                    'sejarah' => $request->sejarah,
                ]);
            }

            return redirect()->to(route('profildesa.index') . '#sejarah')->with('success', 'Sejarah desa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to(route('profildesa.index') . '#sejarah')->with('error', 'Gagal memperbarui sejarah: ' . $e->getMessage());
        }
    }

    public function updateWilayah(Request $request)
    {
        $request->validate([
            'luas' => 'required|numeric|min:0.01',
        ]);

        try {
            // Ambil entri pertama (asumsi cuma satu baris data)
            $wilayah = \App\Models\LuasWilayah::first();

            if ($wilayah) {
                $wilayah->update([
                    'luas' => $request->luas,
                ]);
            } else {
                // Kalau belum ada, buat baru
                \App\Models\LuasWilayah::create([
                    'luas' => $request->luas,
                ]);
            }

            return redirect()->to(route('profildesa.index') . '#dataWilayah')->with('success', 'Data luas wilayah berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to(route('profildesa.index') . '#dataWilayah')->with('error', 'Gagal memperbarui data wilayah: ' . $e->getMessage());
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

            return redirect()->to(route('profildesa.index') . '#visimisi')->with('success', 'Visi dan misi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to(route('profildesa.index') . '#visimisi')->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    public function updateLuasWilayah(Request $request)
    {
        $request->validate([
            'luas' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:10',
        ]);

        try {
            $luasWilayah = \App\Models\LuasWilayah::first();

            if ($luasWilayah) {
                $luasWilayah->update([
                    'luas' => $request->luas,
                    'satuan' => $request->satuan,
                ]);
            } else {
                \App\Models\LuasWilayah::create([
                    'luas' => $request->luas,
                    'satuan' => $request->satuan,
                ]);
            }

            return redirect()->to(route('profildesa.index') . '#datawilayah')->with('success', 'Data luas wilayah berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to(route('profildesa.index') . '#datawilayah')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
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

            return redirect()->to(route('profildesa.index') . '#struktur')->with('success', 'Data struktur pemerintahan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->to(route('profildesa.index') . '#struktur')->with('failed', 'Gagal menambahkan data: ' . $e->getMessage());
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

            return redirect()->to(route('profildesa.index') . '#struktur')->with('success', 'Data struktur pemerintahan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to(route('profildesa.index') . '#struktur')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function strukturDestroy($id)
    {
        $struktur = StrukturPemerintahan::findOrFail($id);
        $struktur->delete();

        return redirect()->to(route('profildesa.index') . '#struktur')->with('success', 'Data struktur pemerintahan berhasil dihapus.');
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

        return redirect()->to(route('profildesa.index') . '#program')->with('success', 'Program pembangunan berhasil ditambahkan.');
    }

    public function pembangunanUpdate(Request $request, $id)
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

        $program = ProgramPembangunanDesa::findOrFail($id);

        if ($request->hasFile('foto_dokumentasi')) {
            $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('program', 'public');
        }

        $program->update($validated);

        return redirect()->to(route('profildesa.index') . '#program')->with('success', 'Program berhasil diperbarui.');
    }

    public function pembangunanDestroy($id)
    {
        $program = ProgramPembangunanDesa::findOrFail($id);

        // Optional: hapus file foto
        if ($program->foto_dokumentasi && Storage::disk('public')->exists($program->foto_dokumentasi)) {
            Storage::disk('public')->delete($program->foto_dokumentasi);
        }

        $program->delete();

        return redirect()->to(route('profildesa.index') . '#program')->with('success', 'Program berhasil dihapus.');
    }
}
