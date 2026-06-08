<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi; // Pakai model lu
use App\Models\Transaksi;
use Midtrans\Config;
use Midtrans\Snap;

class DonasiController extends Controller
{
    public function __construct()
    {
        // Setup konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        return view('warga.donasi.index');
    }

    public function proses(Request $request)
    {
        // Validasi sesuai nama kolom di form lu
        $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1000',
        ], [
            'nominal.min' => 'Mohon maaf, nominal donasi minimal adalah Rp 1.000'
        ]);

        $orderId = 'DNS-' . time();

        // Simpan data pakai kolom dari model lu
        $donasi = Donasi::create([
            'order_id' => $orderId,
            'nama_donatur' => $request->nama_donatur,
            'nominal' => $request->nominal,
            'tgl_donasi' => date('Y-m-d H:i:s'), // Insert manual karena timestamps false
            'status' => 'Pending'
            // payment_type dikosongin dulu, nanti diisi pas Midtrans ngasih webhook
        ]);

        // Parameter ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $donasi->nominal,
            ],
            'customer_details' => [
                'first_name' => $donasi->nama_donatur,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('warga.donasi.index', compact('snapToken', 'donasi'));
    }

    // Webhook Callback dari Midtrans
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $donasi = Donasi::where('order_id', $request->order_id)->first();
            
            if ($donasi) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    // Update status dan payment type dari Midtrans
                    $donasi->update([
                        'status' => 'Berhasil',
                        'payment_type' => $request->payment_type // Cth: 'qris', 'echannel', 'gopay'
                    ]);
                    
                    // Lempar ke tabel Transaksi biar kebaca di rekap kas
                    Transaksi::create([
                        'tanggal' => date('Y-m-d'),
                        'bulan' => \Carbon\Carbon::now()->translatedFormat('F'),
                        'jenis_transaksi' => 'pemasukan',
                        'kategori' => 'Donasi Warga', 
                        'keterangan' => 'Donasi Online Hamba Allah: ' . $donasi->nama_donatur,
                        'nominal' => $donasi->nominal
                    ]);

                } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                    $donasi->update(['status' => 'Batal/Kedaluwarsa']);
                }
            }
        }
        return response()->json(['message' => 'Callback received']);
    }

    public function struk($order_id)
    {
        $donasi = Donasi::where('order_id', $order_id)->firstOrFail();
        return view('warga.donasi.struk', compact('donasi'));
    }
}