<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth; // Tambahin ini buat ngambil id_user yang login

class KegiatanController extends Controller
{
    // Skenario 2: Menampilkan halaman daftar kegiatan masjid
    public function index()
    {
        // Panggil berdasarkan tanggal pelaksanaan terbaru
        $kegiatan = Kegiatan::orderBy('tanggal_pelaksanaan', 'desc')->get();

        // GANTI BARIS DI BAWAH INI:
        return view('sekretaris.kegiatan.index', compact('kegiatan'));
    }

    // Skenario 5, 6, 7, 8: Proses Upload & Validasi
    public function store(Request $request)
    {
        // SKENARIO ALTERNATIF 1 & 2: Validasi ketat sesuai Use Case
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal_pelaksanaan' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Max 2MB sesuai use case
        ], [
            // Kustomisasi pesan error persis plek-ketiplek seperti dokumen Use Case
            'required' => 'Harap lengkapi semua data wajib!',
            'poster.image' => 'Format poster harus JPG/PNG dan maksimal 2MB!',
            'poster.mimes' => 'Format poster harus JPG/PNG dan maksimal 2MB!',
            'poster.max' => 'Format poster harus JPG/PNG dan maksimal 2MB!',
        ]);

        // Skenario 8: Menyimpan file gambar poster
        $file = $request->file('poster');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('uploads/kegiatan'), $nama_file);

        // Skenario 8: Menyimpan data ke basis data
        Kegiatan::create([
            'id_user' => Auth::id(), // Ambil ID Sekretaris yang lagi login
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'poster' => $nama_file,
        ]);

        // Skenario 10: Menampilkan pesan notifikasi berhasil
        return redirect()->back()->with('success', 'Informasi Kegiatan Berhasil Ditambahkan');
    }

    // FUNGSI UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal_pelaksanaan' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Boleh kosong kalau gak mau ganti gambar
        ]);

        $kegiatan = Kegiatan::findOrFail($id);

        // Cek kalau user upload poster baru
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/kegiatan'), $nama_file);

            // Hapus file lama kalau ada (Opsional, biar server ga penuh)
            if (file_exists(public_path('uploads/kegiatan/' . $kegiatan->poster))) {
                @unlink(public_path('uploads/kegiatan/' . $kegiatan->poster));
            }

            $kegiatan->poster = $nama_file;
        }

        // Update data lainnya
        $kegiatan->nama_kegiatan = $request->nama_kegiatan;
        $kegiatan->tanggal_pelaksanaan = $request->tanggal_pelaksanaan;
        $kegiatan->lokasi = $request->lokasi;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->save();

        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Diperbarui!');
    }

    // FUNGSI HAPUS DATA
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Hapus file gambar dari folder
        if (file_exists(public_path('uploads/kegiatan/' . $kegiatan->poster))) {
            @unlink(public_path('uploads/kegiatan/' . $kegiatan->poster));
        }

        // Hapus data dari database
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Dihapus!');
    }
}