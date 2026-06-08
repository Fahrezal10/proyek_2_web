<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KritikSaran extends Model
{
    protected $table = 'kritik_saran';
    protected $primaryKey = 'id_pesan';
    public $timestamps = false; 

    protected $fillable = [
        'nama_pengirim', 
        'isi_pesan', 
        'tanggal_kirim', 
        'status'
    ];
}