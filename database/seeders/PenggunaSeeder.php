<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; 

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        // Matikan proteksi bentrok (Foreign Key) sementara
        Schema::disableForeignKeyConstraints();

        // Bersihkan tabel pengguna (jaga-jaga kalau ada sisa)
        DB::table('pengguna')->truncate();

        // Masukkan akun pengurus SMART-KAS
        DB::table('pengguna')->insert([
            [
                'nama' => 'Muhammad Fahrezal',
                'username' => 'Fahrezal',
                'password' => Hash::make('123456'), // Ini bakal jadi Bcrypt asli
                'role' => 'ketua'
            ],
            [
                'nama' => 'Tata Sri Noviyani',
                'username' => 'Tata',
                'password' => Hash::make('123456'),
                'role' => 'bendahara'
            ],
            [
                'nama' => 'Muhamad Hanif',
                'username' => 'Hanif',
                'password' => Hash::make('123456'),
                'role' => 'sekretaris'
            ]
        ]);

        // Nyalakan kembali proteksi database
        Schema::enableForeignKeyConstraints();
    }
}