<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KritikSaran; // Pastikan pakai model lu

class KritikSaranController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi (Cuma butuh isi_pesan karena kategori udah dihapus)
        $request->validate([
            'isi_pesan' => 'required',
        ]);

        // 2. Simpan ke database pakai nama kolom dari model lu
        KritikSaran::create([
            'nama_pengirim' => $request->nama_pengirim ? $request->nama_pengirim : 'Hamba Allah', 
            'isi_pesan'     => $request->isi_pesan,
            'tanggal_kirim' => date('Y-m-d H:i:s'), // Insert manual
            'status'        => 'Belum Dibaca', // Status default
        ]);

        // 3. Kembalikan response JSON buat pop-up JS
        return response()->json([
            'success' => true,
            'message' => 'Kritik dan saran berhasil disimpan'
        ]);
    }
}