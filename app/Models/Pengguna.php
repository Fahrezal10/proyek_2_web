<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_user';
    public $timestamps = false; // Karena di SQL kamu tidak ada kolom created_at/updated_at
    protected $fillable = ['nama', 'username', 'password', 'role'];
}