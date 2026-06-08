<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';
    public $timestamps = false; 

    protected $fillable = [
        'id_user', 
        'nama_kegiatan', 
        'tanggal_pelaksanaan', 
        'lokasi', 
        'deskripsi', 
        'poster'
    ];
}