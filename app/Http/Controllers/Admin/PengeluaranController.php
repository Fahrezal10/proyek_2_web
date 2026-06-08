<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PengeluaranController extends Controller
{
    // 1. FUNGSI TAMPIL HALAMAN AWAL
   public function index()
{
    $riwayat = Transaksi::where('jenis_transaksi', 'pengeluaran')->orderBy('id_transaksi', 'desc')->get();
    
    $totalPemasukan = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('nominal');
    $totalPengeluaran = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
    $saldoKas = $totalPemasukan - $totalPengeluaran;

    if (Auth::user()->role == 'ketua') {
        return view('ketua.pengeluaran.index', compact('riwayat', 'saldoKas'));
    }

    return view('admin.pengeluaran.index', compact('riwayat', 'saldoKas'));
}

    // 2. FUNGSI SIMPAN DATA (MULTI-ROW / BORONGAN)
    public function store(Request $request)
    {
        // Tangkap semua inputan yang bentuknya array (karena form-nya bisa nambah baris)
        $kategoriArr = $request->kategori;
        $nominalArr = $request->nominal;
        $keteranganArr = $request->keterangan;
        $fotoArr = $request->file('foto_bukti');

        // --- VALIDASI 1: Cek apakah ada nominal yang diisi ---
        if (empty($nominalArr) || count($nominalArr) < 1) {
            return redirect()->back()->with('error', 'Harap isi minimal 1 rincian pengeluaran beserta nominalnya!');
        }

        // --- VALIDASI 2: Cek Saldo Kas (Jangan sampai ngutang/minus) ---
        $totalInput = array_sum($nominalArr); // Jumlahin semua form nominal yang diisi
        
        $pemasukan = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $pengeluaran = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;

        if ($totalInput > $saldoKas) {
            return redirect()->back()->with('error', 'Saldo kas tidak mencukupi! Sisa saldo: Rp. ' . number_format($saldoKas, 0, ',', '.'));
        }

        // --- PROSES SIMPAN KE DATABASE (LOOPING) ---
        // Kita muter sebanyak jumlah baris form yang ditambahin sama Bendahara
        for ($i = 0; $i < count($kategoriArr); $i++) {
            
            // Cek kalau baris ini nominalnya beneran diisi (lebih dari 0)
            if (!empty($nominalArr[$i]) && $nominalArr[$i] > 0) {
                
                $namaFile = null;
                
                // Proses Upload Foto per baris (kalau Bendahara ngupload gambar di baris ini)
                if (isset($fotoArr[$i])) {
                    $file = $fotoArr[$i];
                    // Bikin nama file unik biar nggak bentrok (Waktu + Angka Random + Nama Asli)
                    $namaFile = time() . '_' . rand(100,999) . '_' . $file->getClientOriginalName();
                    // Pindahin file aslinya ke folder public/uploads/bukti/
                    $file->move(public_path('uploads/bukti'), $namaFile);
                }

                // Masukin ke database
                Transaksi::create([
                    'id_user' => Auth::id() ?? 1,
                    'jenis_transaksi' => 'pengeluaran',
                    'kategori' => $kategoriArr[$i],
                    'nominal' => $nominalArr[$i],
                    'bulan' => $request->bulan, // Ini ngambil dari dropdown bulan paling atas
                    'minggu_ke' => $request->minggu_ke, // Ini ngambil dari dropdown minggu paling atas
                    'keterangan' => $keteranganArr[$i],
                    'tanggal' => now(), // Catat tanggal asli waktu diklik simpan
                    'foto_bukti' => $namaFile
                ]);
            }
        }

        // Kalau sukses semua, balikin ke halaman tadi dengan pesan sukses
        return redirect()->back()->with('success', 'Data Pengeluaran Berhasil Disimpan');
    }

    // 3. FUNGSI HAPUS DATA
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Hapus file foto fisik di foldernya kalau sebelumnya dia pernah upload
        if ($transaksi->foto_bukti) {
            $pathFile = public_path('uploads/bukti/' . $transaksi->foto_bukti);
            if (File::exists($pathFile)) {
                File::delete($pathFile);
            }
        }

        // Baru hapus datanya dari tabel database
        $transaksi->delete();
        return redirect()->back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}