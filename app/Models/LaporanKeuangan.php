<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    // Arahin ke tabel buatan lu
    protected $table = 'laporan_keuangan'; 
    protected $primaryKey = 'id_laporan';
    public $timestamps = false; // Matikan karena lu ga pake kolom created_at
    
    // Kolom apa aja yang boleh diisi
    protected $fillable = [
        'periode_bulan', 
        'total_pemasukan', 
        'total_pengeluaran', 
        'saldo_akhir', 
        'status_verifikasi',
        'catatan_revisi'
    ];
}