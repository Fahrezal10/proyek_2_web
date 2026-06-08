<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan; // Manggil model yang barusan lu kirim
use Illuminate\Http\Request;

class KegiatanApiController extends Controller
{
    public function getInformasi()
    {
        // Narik semua data kegiatan, diurutin dari yang paling baru
        $kegiatan = Kegiatan::orderBy('tanggal_pelaksanaan', 'desc')->get();

        // Ngeluarin data dalam format JSON yang dibungkus atribut 'data'
        return response()->json([
            'sukses' => true,
            'pesan'  => 'Data Informasi Kegiatan',
            'data'   => $kegiatan // Ini yang ditangkep sama Flutter ( listKegiatan = data['data'] )
        ], 200);
    }
}