<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\LaporanKeuangan;

class LaporanController extends Controller
{
    // Tampilkan halaman laporan
    public function index()
    {
        $riwayatLaporan = LaporanKeuangan::orderBy('id_laporan', 'desc')->get();
        return view('admin.laporan.index', compact('riwayatLaporan'));
    }

    // FUNGSI: Tombol Pratinjau Diklik
    public function preview(Request $request)
    {
        $bulan = $request->bulan;
        $minggu = $request->minggu_ke;
        $periodeGabungan = $bulan . " - Minggu " . $minggu;

        // SKENARIO: Cek apakah laporan bulan & minggu ini udah pernah diajuin?
        $cekLaporan = LaporanKeuangan::where('periode_bulan', $periodeGabungan)->first();
        if ($cekLaporan) {
            return redirect()->back()->with('error', 'Laporan untuk periode ini sudah ada!');
        }

        // Ambil data transaksi di periode tersebut
        $transaksi = Transaksi::where('bulan', $bulan)->where('minggu_ke', $minggu)->get();

        // SKENARIO: Cek apakah transaksinya kosong?
        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data transaksi keuangan pada periode yang dipilih. Laporan tidak dapat dibuat.');
        }

        // Hitung Otomatis
        $totalPemasukan = $transaksi->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Lempar datanya ke tampilan (buat ngebuka modal otomatis)
        return redirect()->back()->with([
            'show_preview' => true,
            'p_bulan' => $bulan,
            'p_minggu' => $minggu,
            'p_periode_gabungan' => $periodeGabungan,
            'p_pemasukan' => $totalPemasukan,
            'p_pengeluaran' => $totalPengeluaran,
            'p_saldo' => $saldoAkhir
        ]);
    }

    // FUNGSI: Tombol Ajukan Laporan Diklik
    public function store(Request $request)
    {
        LaporanKeuangan::create([
            'periode_bulan' => $request->periode_bulan,
            'total_pemasukan' => $request->total_pemasukan,
            'total_pengeluaran' => $request->total_pengeluaran,
            'saldo_akhir' => $request->saldo_akhir,
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()->route('laporan')->with('success', 'Laporan Berhasil Diajukan ke Ketua Masjid');
    }

    // 1. Fungsi untuk menghitung ulang dan menampilkan pratinjau
    // FUNGSI UNTUK MENYIMPAN HASIL EDITAN BENDAHARA
    public function updateRevisi(Request $request, $id)
    {
        $laporan = \App\Models\LaporanKeuangan::findOrFail($id);
        
        // Pecah periode buat ambil patokan bulan & minggu
        $parts = explode(' - Minggu ', $laporan->periode_bulan);
        $bulan = $parts[0] ?? '';
        $minggu = $parts[1] ?? '';

        // HITUNG OTOMATIS DARI DATABASE (Gak butuh $request lagi)
        // Kasih '?? 0' biar kalau transaksinya kosong, database tetep nerima angka 0, bukan null
        $pemasukanBaru = \App\Models\Transaksi::where('bulan', $bulan)
                                              ->where('minggu_ke', $minggu)
                                              ->where('jenis_transaksi', 'pemasukan')
                                              ->sum('nominal') ?? 0;

        $pengeluaranBaru = \App\Models\Transaksi::where('bulan', $bulan)
                                                ->where('minggu_ke', $minggu)
                                                ->where('jenis_transaksi', 'pengeluaran')
                                                ->sum('nominal') ?? 0;

        $saldoBaru = $pemasukanBaru - $pengeluaranBaru;
        
        // UPDATE DATANYA
        $laporan->update([
            'total_pemasukan' => $pemasukanBaru,
            'total_pengeluaran' => $pengeluaranBaru,
            'saldo_akhir' => $saldoBaru,
            'status_verifikasi' => 'menunggu', // Balik ke antrean Ketua
            'catatan_revisi' => null // Catatan lama ilang
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui dan diajukan ulang!');
    }

    

    // ==========================================
    // FUNGSI KHUSUS KETUA MASJID
    // ==========================================

    public function detailKetua($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        
        // Pecah teks periode
        $parts = explode(' - Minggu ', $laporan->periode_bulan);
        $bulan = $parts[0] ?? '';
        $minggu = $parts[1] ?? '';

        $pemasukan = Transaksi::where('bulan', $bulan)->where('minggu_ke', $minggu)->where('jenis_transaksi', 'pemasukan')->get();
        $pengeluaran = Transaksi::where('bulan', $bulan)->where('minggu_ke', $minggu)->where('jenis_transaksi', 'pengeluaran')->get();

        // LOGIKA EFISIEN: Cek parameter 'dari' di URL
        // Jika URL mengandung ?dari=riwayat, maka tombol kembali ke Riwayat
        if (request()->input('dari') == 'riwayat') {
            $urlKembali = route('ketua.riwayat');
        } else {
            $urlKembali = route('dashboard');
        }

        return view('ketua.dashboard.detail', compact('laporan', 'pemasukan', 'pengeluaran', 'urlKembali'));
    }

    public function approveKetua($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        $laporan->update([
            'status_verifikasi' => 'terverifikasi',
            'catatan_revisi' => null
        ]);

        return redirect()->route('dashboard')->with('success', 'Laporan Keuangan Berhasil Disetujui!');
    }

    public function rejectKetua(Request $request, $id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        $laporan->update([
            'status_verifikasi' => 'revisi',
            'catatan_revisi' => $request->catatan_revisi
        ]);

        return redirect()->route('dashboard')->with('error', 'Laporan dikembalikan ke Bendahara untuk direvisi.');
    }

    public function historyKetua()
    {
        // Ambil laporan yang sudah diproses (Terverifikasi atau Revisi)
        $history = LaporanKeuangan::whereIn('status_verifikasi', ['terverifikasi', 'revisi'])
                                    ->orderBy('id_laporan', 'desc')
                                    ->get();

        // ARAHIN KE FOLDER BARU: views/ketua/riwayat/index.blade.php
        return view('ketua.riwayat.index', compact('history'));
    }
}