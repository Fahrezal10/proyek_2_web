<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KritikSaran;
use Illuminate\Support\Facades\Auth;

class KritikSaranAdminController extends Controller
{
    // Fungsi buat nampilin halaman Kotak Saran (beserta hitungan & filter)
    public function index(Request $request)
    {
        $user = Auth::user(); 

        // 1. Hitung Data untuk Kotak Ringkasan Atas
        $totalPesan = KritikSaran::count();
        $belumDibaca = KritikSaran::where('status', 'Belum Dibaca')->count();
        $sudahDibaca = KritikSaran::where('status', 'Sudah Dibaca')->count();

        // 2. Siapkan Query buat Tabel
        $query = KritikSaran::query();

        // Fitur Pencarian (Cari berdasarkan nama atau isi pesan)
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_pengirim', 'like', '%' . $keyword . '%')
                  ->orWhere('isi_pesan', 'like', '%' . $keyword . '%');
            });
        }

        // Fitur Filter Status dropdown
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Ambil data, urutkan dari yang terbaru, Pagination 10 data per halaman
        $dataPesan = $query->orderBy('tanggal_kirim', 'desc')->paginate(10);

        return view('sekretaris.kritik_saran.index', compact(
            'user', 'totalPesan', 'belumDibaca', 'sudahDibaca', 'dataPesan'
        ));
    }

    // Fungsi otomatis ubah status pas pesan ditutup di modal
    public function tandaiDibaca($id_pesan)
    {
        // Cari pesan berdasarkan primary key lu (id_pesan)
        $pesan = KritikSaran::where('id_pesan', $id_pesan)->firstOrFail();
        
        // Kalau statusnya belum dibaca, kita ubah jadi Sudah Dibaca
        if (strtolower($pesan->status) == 'belum dibaca') {
            $pesan->update(['status' => 'Sudah Dibaca']);
        }

        // Balikin ke halaman semula secara otomatis
        return back();
    }
}