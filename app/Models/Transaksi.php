<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Nama tabel di database
    protected $primaryKey = 'id_transaksi'; // Primary key-nya
    public $timestamps = false; // Matikan fitur otomatis created_at & updated_at

    protected $fillable = [
        'id_user',
        'id_laporan',
        'id_donasi',
        'jenis_transaksi',
        'kategori',
        'nominal',
        'bulan',
        'minggu_ke',
        'keterangan',
        'tanggal',
        'foto_bukti'
    ];
}