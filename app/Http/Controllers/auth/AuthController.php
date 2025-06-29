<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\penduduk;
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
                    return redirect()->intended(route('dashboard.index'));
                case 'user':
                    return redirect()->intended('/');
                default:
                    return redirect('/')->with('warn', 'Role anda tidak tersedia. Hubungi admin.');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil Logout');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ✅ Cek apakah NIK ada di tabel penduduk
        $nikTerdaftar = penduduk::where('nik', $request->nik)->exists();

        if (! $nikTerdaftar) {
            // Kirim pesan error ke halaman sebelumnya
            return back()->withInput()->with('error', 'NIK anda belum terdaftar! Silahkan hubungi admin desa.');
        }

        // Jika NIK valid, lanjut registrasi
        User::create([
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'verified_is' => false,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
