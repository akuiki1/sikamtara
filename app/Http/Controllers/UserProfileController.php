<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id_user, 'id_user'),
            ],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data user
        $user->nama = $request->nama;
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function verifikasi()
    {
        $user = Auth::user();

        // Jika sudah terverifikasi, arahkan balik
        if ($user->status_verifikasi === 'Terverifikasi') {
            return redirect()->route('profil.edit')->with('info', 'Akun kamu sudah terverifikasi.');
        }

        // Ambil data verifikasi jika ada
        $verifikasi = Verifikasi::where('id_user', $user->id_user)->first();

        return view('user.verifikasi', [
            'user' => $user,
            'verifikasi' => $verifikasi,
        ]);
    }
    

    public function verifikasiStore(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userId = $user->id_user;

        // Cek apakah data verifikasi sudah ada
        $verifikasi = Verifikasi::where('id_user', $userId)->first();

        // Validasi hanya jika file dikirim
        $rules = [];
        if (!$verifikasi || $request->hasFile('foto_ktp')) {
            $rules['foto_ktp'] = 'image|max:2048';
        }
        if (!$verifikasi || $request->hasFile('selfie_ktp')) {
            $rules['selfie_ktp'] = 'image|max:2048';
        }
        if (!$verifikasi || $request->hasFile('foto_kk')) {
            $rules['foto_kk'] = 'image|max:2048';
        }

        $request->validate($rules);

        // Simpan file baru jika dikirim
        $data = [];
        if ($request->hasFile('foto_ktp')) {
            if ($verifikasi && $verifikasi->foto_ktp) {
                Storage::disk('public')->delete($verifikasi->foto_ktp);
            }
            $data['foto_ktp'] = $request->file('foto_ktp')->store('verifikasi/ktp', 'public');
        }

        if ($request->hasFile('selfie_ktp')) {
            if ($verifikasi && $verifikasi->selfie_ktp) {
                Storage::disk('public')->delete($verifikasi->selfie_ktp);
            }
            $data['selfie_ktp'] = $request->file('selfie_ktp')->store('verifikasi/selfie', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            if ($verifikasi && $verifikasi->foto_kk) {
                Storage::disk('public')->delete($verifikasi->foto_kk);
            }
            $data['foto_kk'] = $request->file('foto_kk')->store('verifikasi/kk', 'public');
        }

        // Simpan ke DB
        if ($verifikasi) {
            $verifikasi->update($data);
        } else {
            $data['id_user'] = $userId;
            Verifikasi::create($data);
        }

        $user->status_verifikasi = 'Menunggu Verifikasi';
        $user->save();

        return redirect()->route('profil.edit')->with('success', 'Dokumen berhasil dikirim atau diperbarui.');
    }
}
