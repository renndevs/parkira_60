<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

// 1. Halaman Login & Otentikasi
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// 2. Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// 3. Kelola Akun
// URL tetap pakai kebab-case agar SEO friendly dan cocok dengan Sidebar
Route::get('/kelola-akun', [UserController::class, 'index'])->middleware('auth');
Route::post('/kelola-akun', [UserController::class, 'store'])->middleware('auth');
Route::put('/kelola-akun/{id}', [UserController::class, 'update'])->middleware('auth');
Route::delete('/kelola-akun/{id}', [UserController::class, 'destroy'])->middleware('auth');

// 4. Data Kendaraan
Route::get('/data-kendaraan', [KendaraanController::class, 'index'])->middleware('auth');
Route::post('/data-kendaraan', [KendaraanController::class, 'store'])->middleware('auth');
Route::put('/data-kendaraan/{id}', [KendaraanController::class, 'update'])->middleware('auth');
Route::delete('/data-kendaraan/{id}', [KendaraanController::class, 'destroy'])->middleware('auth');

// Rute Area Parkir
Route::get('/area-parkir', [AreaParkirController::class, 'index'])->middleware('auth');
Route::post('/area-parkir', [AreaParkirController::class, 'store'])->middleware('auth');
Route::put('/area-parkir/{id}', [AreaParkirController::class, 'update'])->middleware('auth');
Route::delete('/area-parkir/{id}', [AreaParkirController::class, 'destroy'])->middleware('auth');

// Rute Tarif Parkir
Route::get('/tarif-parkir', [TarifController::class, 'index'])->middleware('auth');
Route::post('/tarif-parkir', [TarifController::class, 'store'])->middleware('auth');
Route::put('/tarif-parkir/{id}', [TarifController::class, 'update'])->middleware('auth');
Route::delete('/tarif-parkir/{id}', [TarifController::class, 'destroy'])->middleware('auth');

// Rute Log Aktivitas (Hanya Read/GET)
Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->middleware('auth');

// Update bagian rute transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->middleware('auth');
Route::post('/transaksi/masuk', [TransaksiController::class, 'store'])->middleware('auth');
Route::put('/transaksi/keluar/{id}', [TransaksiController::class, 'update'])->middleware('auth');

// Pastikan ini di dalam middleware auth (dan role owner jika ada)
Route::get('/owner/laporan', [LaporanController::class, 'index']);
Route::get('/owner/laporan/cetak', [LaporanController::class, 'cetak']);