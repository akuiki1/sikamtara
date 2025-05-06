<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KeuanganController;
use App\Models\Apbdes;

Route::get('/', function () {
    return view('welcome', ['title' => 'Beranda']);
});

// Grup route untuk admin
Route::prefix('admin')->name('admin.')->middleware('auth', 'role:admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Surat Pengajuan
    Route::get('/surat-pengajuan', [SuratController::class, 'index'])->name('surats');

    // Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');

    // Penduduk
    Route::get('/penduduk', [PendudukController::class, 'adminIndex'])->name('penduduk');

    // Pengaturan
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    // Logout Admin (optional)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Untuk registrasi
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);


Route::get('/dashboard', fn() => 'Welcome to dashboard')->middleware('auth');

Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback']);

Route::get('/profil-desa', function () {
    return view('profil.profil-desa', ['title' => 'Profil Desa']);
});

Route::get('/informasi/pengumuman', function () {
    return view('informasi.pengumuman.pengumuman', ['title' => 'pengumuman']);
});

Route::get('/informasi/berita', [BeritaController::class, 'index']);


Route::get('informasi/berita/detail', function () {
    return view('informasi.berita.detailberita', ['title' => 'Detail Berita']);
});

Route::get('/informasi/kependudukan', function () {
    return view('informasi.penduduk.penduduk', ['title' => 'Informasi Penduduk']);
});

// Route::get('/informasi/apbdes', function () {
//     return view('informasi.keuangan.keuangan', ['title' => 'Informasi Keuangan']);
// });

Route::get('/informasi/apbdes', function () {
    $tahunTerbaru = Apbdes::orderByDesc('tahun')->value('tahun') ?? date('Y');
    return redirect("/informasi/apbdes/{$tahunTerbaru}");
});


Route::get('/layanan/administrasi', [AdministrasiController::class, 'index'])->name('administrasi');
Route::get('/administrasi/ajukan/{id}', [AdministrasiController::class, 'apply'])->name('services.apply');

Route::get('/layanan/pengaduan', function () {
    return view('layanan.pengaduan.pengaduan', ['title' => 'Pengaduan']);
});

Route::get('/keuangan', function () {
    return view('informasi.keuangan.keuangan', ['title' => 'Informasi Keuangan']);
});
