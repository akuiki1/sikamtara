<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class AdminProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('admin.akun.profil', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user(); // Laravel-way

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:users,nik,' . $user->id_user . ',id_user',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:8',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'google_id' => 'nullable|string',
            'google_email' => 'nullable|email',
            'google_avatar' => 'nullable|url',
        ]);

        $user->nama = $validated['username'];
        $user->nik = $validated['nik'];
        $user->email = $validated['email'];

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->foto = $path;
        }

        // Google
        $user->google_id = $validated['google_id'] ?? null;
        $user->google_email = $validated['google_email'] ?? null;

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user
        ]);
    }
}
