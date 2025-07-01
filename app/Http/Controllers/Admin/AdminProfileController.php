<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.akun.profil', [
            'title' => 'Edit Profil',
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
                'foto' => 'nullable|image|max:2048',
                'password' => 'nullable|min:6|confirmed',
            ]);

            $user->nama = $validated['nama'];
            $user->email = $validated['email'];

            if ($request->hasFile('foto')) {
                if ($user->foto) {
                    Storage::delete('public/' . $user->foto);
                }

                $fotoPath = $request->file('foto')->store('foto', 'public');
                $user->foto = $fotoPath;
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->back()->with('success', 'Profil diperbaharui!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
