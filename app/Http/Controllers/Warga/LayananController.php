<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi; 

class LayananController extends Controller
{
    public function pemasukan(Request $request)
    {
        $tahunSekarang = date('Y');
        $bulanDipilih = $request->bulan;

        // --- HITUNG TOTAL SALDO KAS SAAT INI ---
        $totalPemasukanAll = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaranAll = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $totalSaldo = $totalPemasukanAll - $totalPengeluaranAll;

        // 1. Ambil data rincian untuk Tabel (Dengan fitur Filter)
        $query = Transaksi::where('jenis_transaksi', 'pemasukan');
        
        if ($bulanDipilih) {
            $query->where('bulan', $bulanDipilih)->whereYear('tanggal', $tahunSekarang);
        }
        
        $tabelPemasukan = $query->orderBy('tanggal', 'desc')->get();

        // 2. Siapkan data untuk Grafik
        $grafikPemasukan = [];
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        for ($m = 1; $m <= 12; $m++) {
            $namaBulan = $bulanIndo[$m];
            $grafikPemasukan[] = Transaksi::where('jenis_transaksi', 'pemasukan')
                ->where('bulan', $namaBulan)
                ->whereYear('tanggal', $tahunSekarang)
                ->sum('nominal');
        }

        // Jangan lupa variabel $totalSaldo dikirim ke view
        return view('warga.pemasukan.index', compact('tabelPemasukan', 'grafikPemasukan', 'bulanDipilih', 'totalSaldo'));
    }

    public function pengeluaran(Request $request)
    {
        $tahunSekarang = date('Y');
        $bulanDipilih = $request->bulan;

        // --- HITUNG TOTAL SALDO KAS SAAT INI ---
        $totalPemasukanAll = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaranAll = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $totalSaldo = $totalPemasukanAll - $totalPengeluaranAll;

        // 1. Ambil data rincian untuk Tabel (Dengan fitur Filter)
        $query = Transaksi::where('jenis_transaksi', 'pengeluaran');
        
        if ($bulanDipilih) {
            $query->where('bulan', $bulanDipilih)->whereYear('tanggal', $tahunSekarang);
        }
        
        $tabelPengeluaran = $query->orderBy('tanggal', 'desc')->get();

        // 2. Siapkan data untuk Grafik
        $grafikPengeluaran = [];
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        for ($m = 1; $m <= 12; $m++) {
            $namaBulan = $bulanIndo[$m];
            $grafikPengeluaran[] = Transaksi::where('jenis_transaksi', 'pengeluaran')
                ->where('bulan', $namaBulan)
                ->whereYear('tanggal', $tahunSekarang)
                ->sum('nominal');
        }

        // Jangan lupa variabel $totalSaldo dikirim ke view
        return view('warga.pengeluaran.index', compact('tabelPengeluaran', 'grafikPengeluaran', 'bulanDipilih', 'totalSaldo'));
    }
}