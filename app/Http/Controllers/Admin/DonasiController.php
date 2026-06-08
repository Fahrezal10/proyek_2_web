<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data admin/bendahara yang sedang login
        $user = Auth::user(); 

        // 2. Hitung data untuk 3 kartu ringkasan di atas
        $totalDonasiSukses = Donasi::where('status', 'Berhasil')->sum('nominal');
        $jumlahPending = Donasi::where('status', 'Pending')->count();
        $jumlahBatal = Donasi::whereIn('status', ['Batal', 'Batal/Kedaluwarsa', 'expire', 'cancel', 'deny'])->count();

        // 3. Mulai siapkan query untuk tabel
        $query = Donasi::query();

        // 4. Logika Pencarian (Jika admin mengetik di kolom search)
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('order_id', 'like', '%' . $keyword . '%')
                  ->orWhere('nama_donatur', 'like', '%' . $keyword . '%');
            });
        }

        // 5. Logika Filter Status (Jika admin memilih dropdown)
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'Batal') {
                $query->whereIn('status', ['Batal', 'Batal/Kedaluwarsa', 'expire', 'cancel', 'deny']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // 6. Ambil data final (Urut dari terbaru, 10 baris per halaman)
        $dataDonasi = $query->orderBy('tgl_donasi', 'desc')->paginate(10);

        // 7. Lempar ke halaman view
        return view('admin.donasi.index', compact(
            'user', 
            'totalDonasiSukses', 
            'jumlahPending', 
            'jumlahBatal', 
            'dataDonasi'
        ));
    }
}