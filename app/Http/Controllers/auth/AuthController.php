<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Arahkan berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'kepala desa':
                    return redirect()->intended('dashboard');
                case 'user':
                    return redirect()->intended('/');
                default:
                    return redirect('/')->with('warn', 'Role anda tidak tersedia. Hubungi admin.');
            }
        }

        return back()->with('loginError', 'Email atau password salah!');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
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
