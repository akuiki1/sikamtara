<?php

use App\Models\Apbdes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\admin\KeluargaController;
use App\Http\Controllers\admin\PendudukController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\admin\AdminBeritaController;
use App\Http\Controllers\Admin\AdminPengumumanController;
use App\Http\Controllers\admin\AdminAdministrasiController;
use App\Http\Controllers\admin\AdminApbdesController;
use App\Http\Controllers\DashboardController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
Route::get('/admin/layanan/administrasi', [AdminAdministrasiController::class, 'index'])->name('adminadministrasi.index');
Route::get('admin/layanan/administrasi/preview-form/{filename}', [AdminAdministrasiController::class, 'previewForm']);
Route::post('/admin/layanan/administrasi', [AdminAdministrasiController::class, 'store'])->name('adminadministrasi.store');
Route::put('/admin/layanan/administrasi/{id}', [AdminAdministrasiController::class, 'update'])->name('adminadministrasi.update');
Route::delete('/admin/layanan/administrasi/{id}', [AdminAdministrasiController::class, 'destroy'])->name('adminadministrasi.destroy');


Route::get('/admin/layanan/pengaduan', function () {
    return view('admin.layanan.pengaduan', ['title' => 'Kelola Pengaduan Masyarakat']);
});

Route::get('/admin/berita', [AdminBeritaController::class, 'index'])->name('adminberita.index');
Route::post('/admin/berita', [AdminBeritaController::class, 'store'])->name('adminberita.store');
Route::put('/admin/berita/{id}', [AdminBeritaController::class, 'update'])->name('adminberita.update');
Route::delete('/admin/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('adminberita.destroy');

Route::get('/admin/pengumuman', [AdminPengumumanController::class, 'index'])->name('pengumuman.index');
Route::post('/admin/pengumuman', [AdminPengumumanController::class, 'store'])->name('pengumuman.store');
Route::put('/admin/pengumuman/{id}', [AdminPengumumanController::class, 'update'])->name('pengumuman.update');
Route::delete('/admin/pengumuman/{id}', [AdminPengumumanController::class, 'destroy'])->name('pengumuman.destroy');


//halaman admin - akun
Route::get('/admin/akun', function () {
    return view('admin.akun.profil', ['title' => 'Setelan Akun']);
});

Route::get('/admin/akun-warga', [UserController::class, 'index'])->name('user.index');
Route::post('/admin/akun-warga', [UserController::class, 'store'])->name('user.store');
Route::post('/admin/akun-warga/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/admin/akun-warga/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');


//halaman admin - kependudukan
// Route::get('/admin/penduduk', function () {
//     return view('admin.penduduk.penduduk', ['title' => 'Kelola Data Penduduk']);
// });
Route::prefix('admin')->group(function () {
    Route::resource('penduduk', PendudukController::class);
});
Route::get('/admin/penduduk', [PendudukController::class, 'index']);
Route::put('/admin/penduduk/{nik}', [PendudukController::class, 'update'])->name('penduduk.update');
Route::delete('/admin/penduduk/{nik}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

// Route::get('/admin/keluarga', function () {
//     return view('admin.penduduk.keluarga', ['title' => 'Kelola Data Keluarga']);
// });

Route::get('/admin/keluarga', [KeluargaController::class, 'index'])->name('keluarga.index');
Route::post('/admin/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
Route::put('/admin/keluarga/{kode_keluarga}', [KeluargaController::class, 'update'])->name('keluarga.update');
Route::delete('/admin/keluarga/{kode_keluarga}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

//halaman admin - apbdes

Route::get('/admin/apbdes', [AdminApbdesController::class, 'index'])->name('adminapbdes.index');
Route::post('/admin/apbdes', [AdminApbdesController::class, 'store'])->name('adminapbdes.store');
Route::post('/admin/apbdes/update/{id}', [AdminApbdesController::class, 'update'])->name('adminapbdes.update');
Route::delete('/admin/apbdes/delete/{id}', [AdminApbdesController::class, 'destroy'])->name('adminapbdes.destroy');


Route::get('/admin/detail-apbdes', function () {
    return view('admin.apbdes.detail-apbdes', ['title' => 'Kelola Data APBDes']);
});
