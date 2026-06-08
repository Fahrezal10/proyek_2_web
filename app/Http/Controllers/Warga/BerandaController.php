<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Tetep manggil file view yang sama di resources/views/warga/beranda/index.blade.php
        return view('warga.beranda.index');
    }

    public function informasi()
    {
        // Ambil data kegiatan buat ditampilin di card
        $informasiKegiatan = \App\Models\Kegiatan::orderBy('tanggal_pelaksanaan', 'desc')->get();
        
        return view('warga.informasi.index', compact('informasiKegiatan'));
    }

    public function detail($id)
    {
        // Cari data kegiatan berdasarkan ID yang diklik
        $kegiatan = \App\Models\Kegiatan::findOrFail($id);
        
        // Arahkan ke halaman detail (pastikan file ini udah lu bikin ya bos)
        return view('warga.informasi.detail', compact('kegiatan'));
    }
}