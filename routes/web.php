<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Nantinya controller-controller ini yang akan kita buat satu per satu
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\TargetProfilController;
use App\Http\Controllers\BobotGapKontroller;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ObservasiController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Autentikasi
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute dengan Wajib Login
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Umum
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // 1. RUTE KHUSUS ADMIN (Subag Pembinaan)
    // ==========================================
    Route::middleware(['role:Admin'])->group(function () {
        // Kelola Data Master
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('jabatan', JabatanController::class)->except(['index']);
        Route::resource('kriteria', KriteriaController::class);
        
        // Pengaturan Parameter SPK
        Route::resource('target-profil', TargetProfilController::class);
        Route::resource('bobot-gap', BobotGapKontroller::class);
        Route::get('/pengaturan', [\App\Http\Controllers\PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [\App\Http\Controllers\PengaturanController::class, 'update'])->name('pengaturan.update');
        
        // Input Data Arsip Objektif
        Route::resource('arsip', ArsipController::class);
        
        // Eksekusi SPK Profile Matching
        Route::get('/spk/proses', [SpkController::class, 'proses'])->name('spk.proses');
        Route::post('/spk/hitung', [SpkController::class, 'hitung'])->name('spk.hitung');
        Route::post('/spk/eksekusi', [SpkController::class, 'eksekusi'])->name('spk.eksekusi');
    });

    // ==========================================
    // RUTE BERSAMA (Admin & Pimpinan)
    // ==========================================
    Route::middleware(['role:Admin,Pimpinan'])->group(function () {
        Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
        Route::get('/spk/hasil', [SpkController::class, 'hasil'])->name('spk.hasil');
        Route::get('/cetak-sk-mutasi', [LaporanController::class, 'cetakSK'])->name('cetak.sk');
    });

    Route::middleware(['role:Admin'])->group(function () {
        // Cetak Laporan (Hanya Admin yang bisa cetak semua laporan)
        Route::get('/laporan/pegawai', [LaporanController::class, 'pegawai'])->name('laporan.pegawai');
        Route::get('/laporan/jabatan', [LaporanController::class, 'jabatan'])->name('laporan.jabatan');
        Route::get('/laporan/target', [LaporanController::class, 'target'])->name('laporan.target');
        Route::get('/laporan/arsip', [LaporanController::class, 'arsip'])->name('laporan.arsip');
        Route::get('/laporan/observasi', [LaporanController::class, 'observasi'])->name('laporan.observasi');
        Route::get('/laporan/detail-spk', [LaporanController::class, 'detailSpk'])->name('laporan.detail');
    });

    // ==========================================
    // 2. RUTE KHUSUS ATASAN PENILAI (Eselon IV)
    // ==========================================
    Route::middleware(['role:Atasan'])->group(function () {
        // Input Nilai Observasi Subjektif (Inisiatif & Kerjasama)
        Route::get('/observasi', [ObservasiController::class, 'index'])->name('observasi.index');
        Route::get('/observasi/{id}/edit', [ObservasiController::class, 'edit'])->name('observasi.edit');
        Route::put('/observasi/{id}', [ObservasiController::class, 'update'])->name('observasi.update');
    });

    // ==========================================
    // 3. RUTE KHUSUS PIMPINAN (Kajari)
    // ==========================================
    Route::middleware(['role:Pimpinan'])->group(function () {
        // Validasi Hasil Rotasi
        Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
        Route::get('/validasi/detail/{id_jabatan}', [ValidasiController::class, 'show'])->name('validasi.show');
        Route::post('/validasi/{id}/setuju', [ValidasiController::class, 'setuju'])->name('validasi.setuju');
        Route::post('/validasi/{id}/tolak', [ValidasiController::class, 'tolak'])->name('validasi.tolak');
        Route::post('/validasi/{id}/batal', [ValidasiController::class, 'batal'])->name('validasi.batal');
        
        // Laporan Final & Cetak SK Rotasi
        Route::get('/laporan/ranking', [LaporanController::class, 'ranking'])->name('laporan.ranking');
    });
});