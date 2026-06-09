<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KritikSaran; // Panggil model lu
use Illuminate\Http\Request;

class KritikController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string',
            'isi_pesan' => 'required|string',
        ]);

        KritikSaran::create([
            'nama_pengirim' => $request->nama_pengirim,
            'isi_pesan'     => $request->isi_pesan,
            'tanggal_kirim' => now(), 
            'status'        => 'belum dibaca' 
        ]);

        return response()->json(['sukses' => true, 'pesan' => 'Terima kasih atas masukannya!'], 200);
    }
}