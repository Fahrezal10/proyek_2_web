<?php

use App\Http\Controllers\Api\KegiatanApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\DonasiApiController;
use App\Http\Controllers\Api\KritikController;

Route::get('/kegiatan', [KegiatanApiController::class, 'getInformasi']);
Route::get('/transaksi', [TransaksiApiController::class, 'getTransaksi']);
Route::post('/donasi', [DonasiApiController::class, 'prosesDonasi']);
Route::post('/kritik', [KritikController::class, 'store']);