<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profileindex(Request $request)
    {
        $query = User::with('penduduk');

        // Pencarian berdasarkan email atau nama penduduk
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                    ->orWhereHas('penduduk', function ($p) use ($request) {
                        $p->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan status_verifikasi
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Pagination dengan query string tetap
        $user = $query->paginate(10)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($user->items())->map(function ($item) {
            return [
                'id_user'           => $item->id_user,
                'email'             => $item->email,
                'status_verifikasi' => $item->status_verifikasi,
                'role'              => $item->role,
                'foto'              => $item->foto,
                'nama'              => $item->penduduk ? $item->penduduk->nama : null,
                'nik'               => $item->nik,
                'nama'          => $item->nama,
                'password'          => $item->password,
            ];
        });

        $daftarNik = Penduduk::select('nik')->get();

        return view('admin.akun.profil', [
            'user'      => $user,
            'userJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'daftarNik' => $daftarNik,
            'role'      => $request->role,
            'status'    => $request->status,
        ]);
    }

    public function index(Request $request)
    {
        $query = User::with(['penduduk', 'verifikasi']);

        // Pencarian berdasarkan email atau nama penduduk
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                    ->orWhereHas('penduduk', function ($p) use ($request) {
                        $p->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan status_verifikasi
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Pagination dengan query string tetap
        $user = $query->paginate(10)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($user->items())->map(function ($item) {
            return [
                'id_user'           => $item->id_user,
                'email'             => $item->email,
                'status_verifikasi' => $item->status_verifikasi,
                'role'              => $item->role,
                'foto'              => $item->foto,
                'nama'              => $item->penduduk ? $item->penduduk->nama : null,
                'nik'               => $item->nik,
                'nama'          => $item->nama,
                'password'          => $item->password,
                'id_verifikasi'     => $item->verifikasi?->id,
            ];
        });

        $daftarNik = Penduduk::select('nik')->get();

        return view('admin.akun.akun-warga', [
            'user'      => $user,
            'userJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            'daftarNik' => $daftarNik,
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
                'nik' => 'required|exists:penduduk,nik',
                'nama' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:user,admin',
                'status_verifikasi' => 'required|in:Terverifikasi,Menunggu Verifikasi,Belum Terverifikasi',
            ]);

            // Enkripsi password sebelum disimpan
            $validated['password'] = bcrypt($validated['password']);

            User::create($validated);

            return redirect()->back()->with('success', 'User Baru berhasil ditambahkan!');
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
    public function update(Request $request, string $id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        // Update data
        $user->update($request->all());

        // Ambil bagian sebelum '@' dari email
        $searchKeyword = strstr($user->email, '@', true);

        // Redirect ke halaman dengan query search
        return redirect()->to('/admin/akun-warga?search=' . urlencode($searchKeyword))
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::where('id_user', $id)->delete();

            return redirect()->back()->with('success', 'Data user berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
