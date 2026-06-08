<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';
    public $timestamps = false; 

    protected $fillable = [
        'order_id', 
        'nama_donatur', 
        'nominal', 
        'tgl_donasi', 
        'payment_type', 
        'status'
    ];
}