<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiApiController extends Controller
{
    public function getTransaksi()
    {
        // Narik data Pemasukan dan diurutin dari yang terbaru
        $pemasukan = Transaksi::where('jenis_transaksi', 'Pemasukan') // Sesuaikan huruf besar/kecil dengan isi database lu
                              ->orderBy('tanggal', 'desc')
                              ->get();

        // Narik data Pengeluaran dan diurutin dari yang terbaru
        $pengeluaran = Transaksi::where('jenis_transaksi', 'Pengeluaran')
                                ->orderBy('tanggal', 'desc')
                                ->get();

        // Kirim sekaligus dalam satu paket JSON
        return response()->json([
            'sukses' => true,
            'pesan'  => 'Data Transaksi Berhasil Diambil',
            'data'   => [
                'pemasukan'   => $pemasukan,
                'pengeluaran' => $pengeluaran
            ]
        ], 200);
    }
}