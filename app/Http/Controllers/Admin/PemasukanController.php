<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    // 1. Fungsi buat nampilin halaman dan tabel
    public function index()
{
    $riwayat = Transaksi::where('jenis_transaksi', 'pemasukan')->orderBy('id_transaksi', 'desc')->get();
    
    // Hitung Saldo Kas agar tidak error di view
    $totalPemasukan = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('nominal');
    $totalPengeluaran = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
    $saldoKas = $totalPemasukan - $totalPengeluaran;

    // CEK ROLE: Jika Ketua, arahkan ke folder ketua
    if (Auth::user()->role == 'ketua') {
        return view('ketua.pemasukan.index', compact('riwayat', 'saldoKas'));
    }

    // Jika Bendahara, tetap ke folder admin
    return view('admin.pemasukan.index', compact('riwayat', 'saldoKas'));
}

    // 2. Fungsi buat nyimpen data pas diklik "Simpan"
    public function store(Request $request)
    {
        $data_pemasukan = [
            'Infaq Jumat' => $request->infaq_jumat,
            'Kotak Amal Harian' => $request->kotak_amal,
            'Zakat / Fidyah' => $request->zakat,
            'Donasi Online' => $request->donasi_online,
            'Pemasukan Lainnya' => $request->pemasukan_lainnya,
        ];

        foreach ($data_pemasukan as $kategori => $nominal) {
            if (!empty($nominal) && $nominal > 0) {
                Transaksi::create([
                    'id_user' => Auth::id() ?? 1,
                    'jenis_transaksi' => 'pemasukan',
                    'kategori' => $kategori,
                    'nominal' => $nominal,
                    'bulan' => $request->bulan,
                    'minggu_ke' => $request->minggu,
                    'keterangan' => $request->keterangan,
                    'tanggal' => now(),
                ]);
            }
        }
        return redirect()->back()->with('success', 'Data pemasukan berhasil dicatat!');
    }

    // 3. Fungsi untuk nyimpen data yang diedit
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        $transaksi->update([
            'bulan' => $request->bulan,
            'minggu_ke' => $request->minggu,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data pemasukan berhasil diubah!');
    }

    // 4. Fungsi untuk menghapus data
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Data pemasukan berhasil dihapus!');
    }

    
}