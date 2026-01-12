<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Pemerintah\DashboardController as PemerintahDashboard;
use App\Http\Controllers\Pemerintah\ManajemenSekolahController as PemerintahManajemen;
use App\Http\Controllers\Pemerintah\PenggunaController as PemerintahPengguna;
use App\Http\Controllers\Pemerintah\KelolaMenuController as PemerintahKelolaMenu;
use App\Http\Controllers\Pemerintah\KeluhanController as PemerintahKeluhan;
use App\Http\Controllers\Pemerintah\LaporanController as PemerintahLaporan;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Sekolah\DashboardController as SekolahDashboard;
use App\Http\Controllers\Sekolah\KelolaMenuController as SekolahKelolaMenu;
use App\Http\Controllers\Sekolah\KeluhanController as SekolahKeluhan;
use App\Http\Controllers\Sekolah\LaporanController as SekolahLaporan;
use App\Http\Controllers\Sekolah\RiwayatLaporanController as SekolahRiwayat;
use App\Http\Controllers\Sekolah\ProfilController as SekolahProfil;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// GRUP USER: PEMERINTAH (ADMIN)
Route::middleware(['auth', 'role:admin'])
    ->prefix('pemerintah')
    ->name('pemerintah.')
    ->group(function () {
        Route::get('/dashboard', [PemerintahDashboard::class, 'index'])->name('dashboard');
        Route::get('/monitoring', function () { return view('pemerintah.monitoring'); })->name('monitoring');
        // Laporan
        Route::get('/laporan', [PemerintahLaporan::class, 'index'])->name('laporan');
        // Route::get('/laporan', function () { return view('pemerintah.laporan'); })->name('laporan');
        // Keluhan
        Route::get('/keluhan', [PemerintahKeluhan::class, 'index'])->name('keluhan');
        Route::get('/keluhan/data', [PemerintahKeluhan::class, 'data'])->name('keluhan.data');
        Route::get('/keluhan/{id}', [PemerintahKeluhan::class, 'show'])->name('keluhan.show');
        Route::put('/keluhan/{id}', [PemerintahKeluhan::class, 'update'])->name('keluhan.update');
        // Route::get('/menu', function () { return view('pemerintah.menu'); })->name('menu');
        Route::get('/manajemen-sekolah', [PemerintahManajemen::class, 'index'])->name('sekolah');
        Route::post('/manajemen-sekolah', [PemerintahManajemen::class, 'store'])->name('sekolah.store');
        Route::get('/manajemen-sekolah/{id}/edit', [PemerintahManajemen::class, 'edit']);
        Route::put('/manajemen-sekolah/{id}', [PemerintahManajemen::class, 'update'])->name('sekolah.update');
        Route::delete('/manajemen-sekolah/{id}', [PemerintahManajemen::class, 'destroy'])->name('sekolah.destroy');
        // Pengguna
        Route::get('/pengguna', [PemerintahPengguna::class, 'index'])->name('pengguna');
        Route::post('/pengguna', [PemerintahPengguna::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{id}/edit', [PemerintahPengguna::class, 'edit']);
        Route::put('/pengguna/{id}', [PemerintahPengguna::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{id}', [PemerintahPengguna::class, 'destroy'])->name('pengguna.destroy');
        // Kelola Menu & Hari
        Route::get('/menu', [PemerintahKelolaMenu::class, 'index'])->name('menu');
        Route::get('/menu/list-hari', [PemerintahKelolaMenu::class, 'listHari'])->name('menu.list_hari');
        Route::post('/menu/store-hari', [PemerintahKelolaMenu::class, 'storeHari'])->name('menu.store_hari');
        Route::post('/menu/toggle-hari', [PemerintahKelolaMenu::class, 'toggleHari'])->name('menu.toggle_hari');
        Route::post('/menu/update-hari', [PemerintahKelolaMenu::class, 'updateHari'])->name('menu.update_hari');
        Route::delete('/menu/delete-hari', [PemerintahKelolaMenu::class, 'deleteHari'])->name('menu.delete_hari');
        Route::post('/menu', [PemerintahKelolaMenu::class, 'storeMenu'])->name('menu.store');
        Route::get('/menu/by-sekolah', [PemerintahKelolaMenu::class, 'menuBySekolah'])->name('menu.by_sekolah');
        Route::get('/menu/{id}', [PemerintahKelolaMenu::class, 'showMenu'])->name('menu.show');
        Route::put('/menu/{id}', [PemerintahKelolaMenu::class, 'updateMenu'])->name('menu.update');
        Route::delete('/menu/{id}', [PemerintahKelolaMenu::class, 'deleteMenu'])->name('menu.delete');
    });
    
Route::get('/notifikasi', [NotifikasiController::class, 'index'])
    ->middleware('auth')
    ->name('notifikasi.index');
Route::post('/notifikasi/read-one', [NotifikasiController::class, 'markReadOne'])
    ->name('notifikasi.read.one');

// GRUP USER: SEKOLAH
Route::middleware(['auth', 'role:sekolah'])
      ->prefix('sekolah')
      ->name('sekolah.')
      ->group(function () {
          Route::get('/dashboard', [SekolahDashboard::class, 'index'])->name('dashboard');
          Route::get('/input_laporan', [SekolahLaporan::class, 'index'])->name('input_laporan');
          Route::post('/input_laporan', [SekolahLaporan::class, 'store'])->name('input_laporan.store');
          Route::get('/keluhan', [SekolahKeluhan::class, 'index'])->name('keluhan');
          Route::post('/keluhan', [SekolahKeluhan::class, 'store'])->name('keluhan.store');
          Route::get('/keluhan/status', [SekolahKeluhan::class, 'statusSaya'])->name('keluhan.status');
          Route::get('/menu', [SekolahKelolaMenu::class, 'index'])->name('menu');
          Route::get('/menu/data', [SekolahKelolaMenu::class, 'getMenuData'])->name('menu.data');
          Route::get('/riwayat', [SekolahRiwayat::class, 'index'])->name('riwayat');
          Route::get('/riwayat/data', [SekolahRiwayat::class, 'data'])->name('riwayat.data');
          Route::get('/profil', [SekolahProfil::class, 'index'])->name('profil');
          Route::post('/profil/update', [SekolahProfil::class, 'update'])->name('profil.update');
        //   Route::get('/profil', function () { return view('sekolah.profil'); })->name('profil');

    });