<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PemasukanController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Warga\BerandaController;
use App\Http\Controllers\Admin\DashboardSekretarisController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Warga\KritikSaranController;
use App\Http\Controllers\Admin\KritikSaranAdminController;

// =========================================================
// 1. JALUR WARGA / PUBLIK (Akses: http://127.0.0.1:8000/)
// =========================================================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/informasi', [App\Http\Controllers\Warga\BerandaController::class, 'informasi'])->name('warga.informasi');
Route::get('/informasi/{id}', [App\Http\Controllers\Warga\BerandaController::class, 'detail'])->name('warga.informasi.detail');
Route::get('/pemasukan', [App\Http\Controllers\Warga\LayananController::class, 'pemasukan'])->name('warga.pemasukan');
Route::get('/pengeluaran', [App\Http\Controllers\Warga\LayananController::class, 'pengeluaran'])->name('warga.pengeluaran');
Route::get('/donasi', [App\Http\Controllers\Warga\DonasiController::class, 'index'])->name('warga.donasi');
Route::post('/donasi/proses', [App\Http\Controllers\Warga\DonasiController::class, 'proses'])->name('warga.donasi.proses');
Route::get('/donasi/struk/{order_id}', [App\Http\Controllers\Warga\DonasiController::class, 'struk'])->name('warga.donasi.struk');
Route::post('/kritik-saran/kirim', [KritikSaranController::class, 'store'])->name('warga.kritik_saran.store');


// =========================================================
// 2. JALUR KHUSUS ADMIN (Akses: http://127.0.0.1:8000/admin/...)
// =========================================================
Route::prefix('admin')->group(function () {

    // Khusus yang BELUM login (Tamu / Pengurus mau masuk)
    // Akses: http://127.0.0.1:8000/admin/login
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [LoginController::class, 'prosesLogin']);
    });

    // Khusus yang SUDAH login (Pengurus/Admin)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- JALUR PEMASUKAN ---
        Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan');
        Route::post('/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
        Route::put('/pemasukan/{id}', [PemasukanController::class, 'update'])->name('pemasukan.update');
        Route::delete('/pemasukan/{id}', [PemasukanController::class, 'destroy'])->name('pemasukan.destroy');
        Route::get('/admin/donasi', [App\Http\Controllers\Admin\DonasiController::class, 'index'])->name('admin.donasi');

        // --- JALUR PENGELUARAN ---
        Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
        Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
        Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

        // --- JALUR LAPORAN BENDAHARA ---
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::post('/laporan/preview', [LaporanController::class, 'preview'])->name('laporan.preview');
        Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
        Route::post('/laporan/{id}/preview-revisi', [LaporanController::class, 'previewRevisi'])->name('laporan.preview_revisi');
        Route::post('/laporan/{id}/update-revisi', [LaporanController::class, 'updateRevisi'])->name('laporan.update_revisi');

        // --- JALUR VERIFIKASI KETUA ---
        Route::get('/ketua/laporan/{id}', [LaporanController::class, 'detailKetua'])->name('ketua.laporan.detail');
        Route::post('/ketua/laporan/{id}/approve', [LaporanController::class, 'approveKetua'])->name('ketua.laporan.approve');
        Route::post('/ketua/laporan/{id}/reject', [LaporanController::class, 'rejectKetua'])->name('ketua.laporan.reject');
        Route::get('/riwayat', [LaporanController::class, 'historyKetua'])->name('ketua.riwayat');

        Route::get('/sekretaris/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
        Route::post('/sekretaris/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
        // Tambahin di bawah route store kegiatan lu
        Route::put('/sekretaris/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/sekretaris/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
        Route::get('/kritik-saran', [KritikSaranAdminController::class, 'index'])->name('sekretaris.kritik_saran');
        Route::post('/kritik-saran/{id_pesan}/baca', [KritikSaranAdminController::class, 'tandaiDibaca'])->name('sekretaris.kritik_saran.baca');
        // --- LOGOUT ---
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});