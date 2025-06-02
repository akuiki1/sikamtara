<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Administrasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PengajuanAdministrasi;


class AdminAdministrasiController extends Controller
{
    public function previewForm($filename)
    {
        $path = storage_path('app/public/form_administrasi/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Administrasi::with('user');

        if ($request->has('search')) {
            $query->where('nama_administrasi', 'like', '%' . $request->search . '%');
        }


        // Filter berdasarkan role
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination dengan query string tetap
        $administrasi = $query->paginate(8)->appends($request->query());

        // Data untuk JavaScript (Alpine)
        $transformed = collect($administrasi->items())->map(function ($item) {
            return [
                'id_administrasi'         => $item->id_administrasi,
                'nama_administrasi'      => $item->nama_administrasi,
                'deskripsi'        => \Illuminate\Support\Str::limit($item->deskripsi, 100),
                'deskripsi_full'        => $item->deskripsi,
                'persyaratan'        => $item->persyaratan,
                'form'      => $item->form,
                'name_form' => Str::limit(Str::after(basename($item->form), '_'), 35),
            ];
        });

        // $penulis = User::select('id_user')->get();

        $jumlahLayanan = Administrasi::count();
        $jumlahMasuk = PengajuanAdministrasi::whereIn('status_pengajuan', ['baru', 'ditinjau'])->count();
        $jumlahSiapTtd = PengajuanAdministrasi::where('status_pengajuan', 'diproses')->count();
        $jumlahSelesaiTahunIni = PengajuanAdministrasi::where('status_pengajuan', 'selesai')
            ->whereYear('tanggal_pengajuan', Carbon::now()->year)
            ->count();

        return view('admin.layanan.administrasi', [
            'administrasi'      => $administrasi,
            'administrasiJs'    => $transformed,
            'search'    => $request->search,
            'filter'    => $request->filter,
            // 'penulis'   => $penulis,
            'role'      => $request->role,
            'status'    => $request->status,
            'jumlahLayanan' => $jumlahLayanan,
            'jumlahMasuk' => $jumlahMasuk,
            'jumlahSiapTtd' => $jumlahSiapTtd,
            'jumlahSelesaiTahunIni' => $jumlahSelesaiTahunIni,

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
                'nama_administrasi' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'persyaratan' => 'required|string',
                'form' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            if ($request->hasFile('form')) {
                $file = $request->file('form');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('form_administrasi', $filename, 'public');
                $validated['form'] = $path;
            }

            Administrasi::create($validated);

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
            $administrasi = Administrasi::where('id_administrasi', $id)->firstOrFail();

            $data = $request->except('form');

            if ($request->hasFile('form')) {
                $file = $request->file('form');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('form_administrasi', $filename, 'public');
                $data['form'] = $path;
            }

            $administrasi->update($data);

            $searchKeyword = Str::limit(strip_tags($administrasi->nama_administrasi), 50);

            return redirect()->route('adminadministrasi.index', ['search' => $searchKeyword])
                ->with('success', 'Layanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('adminadministrasi.index')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Administrasi::where('id_administrasi', $id)->delete();

            return redirect()->back()->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus layanan: ' . $e->getMessage());
        }
    }
}
