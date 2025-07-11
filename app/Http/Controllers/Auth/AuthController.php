<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
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

    public function register(Request $request)
    {
        $request->validate([
            'nik' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]{16}$/',
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.regex' => 'NIK hanya boleh berisi angka.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek apakah NIK ada di tabel penduduk
        $nikTerdaftar = Penduduk::where('nik', $request->nik)->exists();

        if (! $nikTerdaftar) {
            return back()->withInput()->with('error', 'NIK anda belum terdaftar! Silakan hubungi admin desa.');
        }

        // Blok try-catch untuk menangkap error DB
        try {
            User::create([
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'verified_is' => false,
            ]);

            return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (QueryException $e) {
            // Error dari database (misal koneksi error atau constraint)
            Log::error('Gagal registrasi user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Coba lagi nanti.');
        } catch (\Throwable $e) {
            // Untuk error lainnya (misal error PHP atau logic)
            Log::critical('Error fatal saat register: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan tak terduga. Silakan hubungi admin.');
        }
    }
}
