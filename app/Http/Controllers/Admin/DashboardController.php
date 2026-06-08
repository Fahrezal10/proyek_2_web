<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi; // Wajib dipanggil biar bisa akses tabel transaksi
use App\Models\Kegiatan;  // Tambahin ini bos biar bisa akses tabel kegiatan milik Sekretaris

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tahunSekarang = date('Y');

        // =========================================================
        // JALUR KHUSUS SEKRETARIS (Biar langsung potong kompas di sini)
        // =========================================================
        // JALUR KHUSUS SEKRETARIS
        if ($user->role == 'sekretaris') {
            $totalKegiatan = Kegiatan::count();
            
            // Hitung kegiatan yang tanggalnya hari ini atau ke depan
            $kegiatanMendatang = Kegiatan::where('tanggal_pelaksanaan', '>=', date('Y-m-d'))->count();
            
            // Hitung kegiatan yang udah lewat
            $kegiatanSelesai = Kegiatan::where('tanggal_pelaksanaan', '<', date('Y-m-d'))->count();
            
            // Ambil 3 kegiatan paling dekat dari hari ini
            $kegiatanTerdekat = Kegiatan::where('tanggal_pelaksanaan', '>=', date('Y-m-d'))
                                        ->orderBy('tanggal_pelaksanaan', 'asc')
                                        ->limit(3)
                                        ->get();

            return view('sekretaris.dashboard.index', compact(
                'user', 'totalKegiatan', 'kegiatanMendatang', 'kegiatanSelesai', 'kegiatanTerdekat'
            ));
        }

        // 1. Hitung Total Pemasukan & Pengeluaran (Ini punya Bendahara & Ketua)
        $totalPemasukan = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaran = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        
        // 2. Hitung Sisa Saldo
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        // 3. Ambil 5 Transaksi Terakhir (Campuran masuk & keluar, diurutkan dari yang terbaru)
        $transaksiTerakhir = Transaksi::orderBy('tanggal', 'desc')
                                      ->orderBy('id_transaksi', 'desc')
                                      ->limit(5)
                                      ->get();

        // 4. Siapkan Data Grafik berdasarkan kolom 'bulan' (Januari - Desember)
        $dataPemasukan = [];
        $dataPengeluaran = [];
        
        // Bikin kamus nama bulan biar gampang dicocokin sama isi database
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        for ($m = 1; $m <= 12; $m++) {
            $namaBulan = $bulanIndo[$m]; // Ngambil teks 'Januari', 'Februari', dst

            $dataPemasukan[] = Transaksi::where('jenis_transaksi', 'pemasukan')
                ->where('bulan', $namaBulan) // <-- NYARI BERDASARKAN KOLOM BULAN
                ->whereYear('tanggal', $tahunSekarang) // Tetep dibatesin tahun ini biar data tahun lalu ga ikut masuk
                ->sum('nominal');

            $dataPengeluaran[] = Transaksi::where('jenis_transaksi', 'pengeluaran')
                ->where('bulan', $namaBulan) // <-- NYARI BERDASARKAN KOLOM BULAN
                ->whereYear('tanggal', $tahunSekarang)
                ->sum('nominal');
        }

        // JALUR KHUSUS KETUA
        if ($user->role == 'ketua') {
            $laporanMasuk = \App\Models\LaporanKeuangan::where('status_verifikasi', 'menunggu')->get();
            $totalLaporanMenunggu = $laporanMasuk->count();

            // Arahin ke folder views/ketua/index.blade.php
            return view('ketua.dashboard.index', compact('user', 'saldoKas', 'laporanMasuk', 'totalLaporanMenunggu'));
        }

        // JALUR KHUSUS BENDAHARA (Jika bukan sekretaris & bukan ketua)
        return view('admin.dashboard.index', compact(
            'user', 
            'totalPemasukan', 
            'totalPengeluaran', 
            'saldoKas', 
            'transaksiTerakhir',
            'dataPemasukan',
            'dataPengeluaran'
        ));
    }
}