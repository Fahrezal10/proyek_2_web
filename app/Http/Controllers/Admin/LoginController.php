<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Menampilkan Halaman Form Login
        public function showLogin()
    {
        return view('admin.auth.login');
    }
    

    // 2. Memproses Data Saat Tombol Login Diklik
    public function prosesLogin(Request $request)
    {
        // Validasi inputan tidak boleh kosong
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cek ke database apakah username & password cocok
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            // Kalau berhasil, arahkan ke dashboard
            return redirect()->intended('/admin/dashboard');
        }

        // Kalau gagal, kembalikan ke halaman login dengan pesan error
        return back()->with('error', 'Username atau Password salah!');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}