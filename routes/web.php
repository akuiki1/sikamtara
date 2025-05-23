<?php

use App\Models\Apbdes;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\admin\KeluargaController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\admin\PendudukController;


Route::get('/', function () {
    return view('welcome', ['title' => 'Beranda']);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Untuk registrasi
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

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


// halaman admin
Route::get('/dashboard', function () {
    return view('admin.dashboard', ['title' => 'Dashboard']);
});

// halaman profil admin
Route::get('/profil/demografi', function () {
    return view('admin.profil.demografi', ['title' => 'Demografi']);
});

Route::get('/profil/infrastruktur-desa', function () {
    return view('admin.profil.infrastruktur', ['title' => 'Infrastruktur Desa']);
});
Route::get('/profil/sejarah-desa', function () {
    return view('admin.profil.sejarah', ['title' => 'Sejarah Desa']);
});

Route::get('/profil/struktur-pemerintahan', function () {
    return view('admin.profil.struktur-pemerintahan', ['title' => 'Struktur Pemerintahan']);
});

Route::get('/profil/visi-misi', function () {
    return view('admin.profil.visi-misi', ['title' => 'Visi & Misi']);
});
Route::get('visi-misi', [VisiMisiController::class, 'index'])->name('admin.visimisi.index');
Route::put('visi-misi', [VisiMisiController::class, 'update'])->name('admin.visimisi.update');

Route::get('/profil/wilayah', function () {
    return view('admin.profil.wilayah', ['title' => 'Wilayah Administrasi']);
});


// halaman kelola layanan admin
Route::get('/admin/layanan/administrasi', function () {
    return view('admin.layanan.administrasi', ['title' => 'Kelola Layanan Administrasi']);
});

Route::get('/admin/layanan/pengaduan', function () {
    return view('admin.layanan.pengaduan', ['title' => 'Kelola Pengaduan Masyarakat']);
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');


Route::get('/admin/pengumuman', function () {
    return view('admin.berita.pengumuman', ['title' => 'Kelola Pengumuman Desa']);
});

//halaman admin - akun
Route::get('/admin/akun', function () {
    return view('admin.akun.profil', ['title' => 'Setelan Akun']);
});

Route::get('/admin/akun-warga', function () {
    return view('admin.akun.akun-warga', ['title' => 'Kelola Akun Warga']);
});

//halaman admin - kependudukan
// Route::get('/admin/penduduk', function () {
//     return view('admin.penduduk.penduduk', ['title' => 'Kelola Data Penduduk']);
// });
Route::prefix('admin')->group(function () {
    Route::resource('penduduk', PendudukController::class);
});
Route::get('/admin/penduduk', [PendudukController::class, 'index']);
Route::put('/penduduk/{id}', [PendudukController::class, 'update']);

// Route::get('/admin/keluarga', function () {
//     return view('admin.penduduk.keluarga', ['title' => 'Kelola Data Keluarga']);
// });

Route::get('/admin/keluarga', [KeluargaController::class, 'index'])->name('keluarga.index');
Route::post('/admin/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
Route::put('/admin/keluarga/{id}', [KeluargaController::class, 'update'])->name('keluarga.update');
Route::delete('/admin/keluarga/{id}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

//halaman admin - apbdes
Route::get('/admin/apbdes', function () {
    return view('admin.apbdes.apbdes', ['title' => 'Kelola Data APBDes']);
});

Route::get('/admin/detail-apbdes', function () {
    return view('admin.apbdes.detail-apbdes', ['title' => 'Kelola Data APBDes']);
});
