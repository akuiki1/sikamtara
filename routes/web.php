<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\socialiteController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\PembiayaanController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\admin\KeluargaController;
use App\Http\Controllers\admin\AdminApbdesController;
use App\Http\Controllers\admin\AdminBeritaController;
use App\Http\Controllers\admin\AdminDApbdesController;
use App\Http\Controllers\admin\AdminProfileController;
use App\Http\Controllers\admin\AdminPendudukController;
use App\Http\Controllers\Admin\AdminPengumumanController;
use App\Http\Controllers\admin\AdminProfilDesaController;
use App\Http\Controllers\admin\AdminAdministrasiController;
use App\Http\Controllers\admin\AdminPengaduanController;

Route::get('/', [BerandaController::class, 'index'])->name('Beranda');
Route::get('/ringkasan-tahun', [BerandaController::class, 'ringkasanTahun']);

Route::get('/auth/google', [socialiteController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [socialiteController::class, 'callback'])->name('google.callback');


Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
// Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback']);

Route::get('/profil-desa', function () {
    return view('user.profil-desa', ['title' => 'Profil Desa']);
});

Route::get('/informasi/pengumuman', function () {
    return view('user.pengumuman', ['title' => 'pengumuman']);
});

Route::get('/informasi/berita', [BeritaController::class, 'index'])->name('berita.index');


Route::get('informasi/berita/detail', function () {
    return view('user.detailberita', ['title' => 'Detail Berita']);
});

Route::get('/informasi/kependudukan', [PendudukController::class, 'index'])->name('user.kependudukan');
Route::get('/informasi/apbdes', [KeuanganController::class, 'index'])->name('user.keuangan');

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/layanan/administrasi', [AdministrasiController::class, 'index'])->name('administrasi');
    Route::post('layanan/administrasi/{id}', [AdministrasiController::class, 'apply'])->name('services.apply');
    Route::get('layanan/administrasi/surat-final/{id}', [AdministrasiController::class, 'downloadSuratFinal'])->name('surat.final.download');

    Route::get('/layanan/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');

    Route::get('profile/edit', [UserProfileController::class, 'edit'])->name('profil.edit');
    Route::post('profile/update', [UserProfileController::class, 'update'])->name('profil.update');
});


// halaman admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // halaman profil admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/profil-desa', [AdminProfilDesaController::class, 'index'])->name('profildesa.index');
    Route::put('/profil/sejarah', [AdminProfilDesaController::class, 'updateSejarah'])->name('sejarah.update');
    Route::put('/profil/visimisi', [AdminProfilDesaController::class, 'updateSejarah'])->name('visimisi.update');

    // halaman kelola layanan admin
    Route::get('/layanan/administrasi', [AdminAdministrasiController::class, 'index'])->name('adminadministrasi.index');
    Route::get('/layanan/administrasi/preview-form/{filename}', [AdminAdministrasiController::class, 'previewForm']);
    Route::post('/layanan/administrasi', [AdminAdministrasiController::class, 'store'])->name('adminadministrasi.store');
    Route::put('/layanan/administrasi/{id}', [AdminAdministrasiController::class, 'update'])->name('adminadministrasi.update');
    Route::delete('/layanan/administrasi/{id}', [AdminAdministrasiController::class, 'destroy'])->name('adminadministrasi.destroy');
    Route::post('/layanan/update-status', [AdminAdministrasiController::class, 'updateStatus'])->name('layanan.updateStatus');
    Route::get('/layanan/riwayat', [AdminAdministrasiController::class, 'getRiwayatLayanan']);
    Route::delete('/layanan/hapus/{id}', [AdminAdministrasiController::class, 'hapusLayanan'])->name('layanan.hapus');
    Route::post('/upload-surat-final/{id}', [AdminAdministrasiController::class, 'uploadSuratFinal']);

    Route::get('/layanan/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin.pengaduan.index');

    Route::get('/berita', [AdminBeritaController::class, 'index'])->name('adminberita.index');
    Route::post('/berita', [AdminBeritaController::class, 'store'])->name('adminberita.store');
    Route::put('/berita/{id}', [AdminBeritaController::class, 'update'])->name('adminberita.update');
    Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('adminberita.destroy');

    Route::get('/pengumuman', [AdminPengumumanController::class, 'index'])->name('adminpengumuman.index');
    Route::post('/pengumuman', [AdminPengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{id}', [AdminPengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [AdminPengumumanController::class, 'destroy'])->name('pengumuman.destroy');


    //halaman admin - akun
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::get('/akun-warga', [UserController::class, 'index'])->name('user.index');
    Route::post('/akun-warga', [UserController::class, 'store'])->name('user.store');
    Route::post('/akun-warga/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/akun-warga/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/penduduk', [AdminPendudukController::class, 'index'])->name('penduduk.index');
    Route::post('/penduduk', [AdminPendudukController::class, 'store'])->name('penduduk.store');
    Route::put('/penduduk/{nik}', [AdminPendudukController::class, 'update'])->name('penduduk.update');
    Route::delete('/penduduk/{nik}', [AdminPendudukController::class, 'destroy'])->name('penduduk.destroy');

    Route::get('/keluarga', [KeluargaController::class, 'index'])->name('keluarga.index');
    Route::post('/keluarga', [KeluargaController::class, 'store'])->name('keluarga.store');
    Route::put('/keluarga/{kode_keluarga}', [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::delete('/keluarga/{kode_keluarga}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');

    //halaman admin - apbdes
    Route::post('/apbdes/import-apbdes', [AdminApbdesController::class, 'import'])->name('import.apbdes');
    Route::get('/apbdes/dataAnggaran', [AdminApbdesController::class, 'dataAnggaran'])->name('adminapbdes.dataAnggaran');

    Route::get('/apbdes/pendapatan', [AdminApbdesController::class, 'pendapatan'])->name('adminapbdes.pendapatan');
    Route::post('/apbdes/pendapatan/store', [AdminApbdesController::class, 'pendapatanStore'])->name('adminapbdes.pendapatan.store');
    Route::put('/admin/apbdes/pendapatan/{id}', [AdminApbdesController::class, 'pendapatanUpdate'])->name('adminapbdes.pendapatan.update');
    Route::delete('/admin/apbdes/pendapatan/{id}', [AdminApbdesController::class, 'pendapatanDestroy'])->name('adminapbdes.pendapatan.destroy');

    Route::get('/apbdes/belanja', [AdminApbdesController::class, 'belanja'])->name('adminapbdes.belanja');
    Route::post('/apbdes/belanja/bidang/store', [AdminApbdesController::class, 'bidangBelanjaStore'])->name('bidang.belanja.store');
    Route::put('/apbdes/belanja/bidang/update', [AdminApbdesController::class, 'bidangBelanjaUpdate'])->name('bidang.belanja.update');
    Route::delete('/apbdes/belanja/bidang/delete', [AdminApbdesController::class, 'bidangBelanjaDestroy'])->name('bidang.belanja.destroy');
    Route::post('/apbdes/belanja/rincian/store', [AdminApbdesController::class, 'rincianBelanjaStore'])->name('rincian.belanja.store');
    Route::put('/apbdes/belanja/rincian/update', [AdminApbdesController::class, 'rincianBelanjaUpdate'])->name('rincian.belanja.update');
    Route::delete('/apbdes/belanja/rincian/delete', [AdminApbdesController::class, 'rincianBelanjaDestroy'])->name('rincian.belanja.destroy');

    Route::get('/apbdes/pembiayaan', [PembiayaanController::class, 'index'])->name('adminapbdes.pembiayaan');
    Route::post('/apbdes/pembiayaan', [PembiayaanController::class, 'store'])->name('adminapbdes.pembiayaan.store');
    Route::put('/admin/apbdes/pembiayaan/update', [PembiayaanController::class, 'update'])->name('adminapbdes.pembiayaan.update');
    Route::delete('/admin/apbdes/pembiayaan/delete', [PembiayaanController::class, 'destroy'])->name('adminapbdes.pembiayaan.delete');

    Route::get('/apbdes/rekapitulasi', [AdminApbdesController::class, 'rekapitulasi'])->name('adminapbdes.rekapitulasi');
    Route::post('/apbdes', [AdminApbdesController::class, 'store'])->name('adminapbdes.store');
    Route::put('/apbdes/update/{id}', [AdminApbdesController::class, 'update'])->name('adminapbdes.update');
    Route::delete('/apbdes/delete/{id}', [AdminApbdesController::class, 'destroy'])->name('adminapbdes.destroy');

    // Route::get('/detail-apbdes', [AdminDApbdesController::class, 'index'])->name('admindapbdes.index');
    Route::post('/detail-apbdes', [AdminDApbdesController::class, 'store'])->name('admindapbdes.store');
    Route::put('/detail-apbdes/update/{id}', [AdminDApbdesController::class, 'update'])->name('admindapbdes.update');
    Route::delete('/detail-apbdes/delete/{id}', [AdminDApbdesController::class, 'destroy'])->name('admindapbdes.destroy');
});
