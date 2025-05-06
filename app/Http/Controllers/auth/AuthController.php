<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegistrationForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'verified_is' => false,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
