<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiApiController extends Controller
{
    public function prosesDonasi(Request $request)
    {
        $request->validate([
            'nama_donatur' => 'required|string',
            'nominal' => 'required|numeric|min:1000'
        ]);

        // 1. Bikin Order ID unik
        $orderId = 'DONASI-' . time();

        // 2. Simpan ke database dengan status Pending
        $donasi = Donasi::create([
            'order_id'     => $orderId,
            'nama_donatur' => $request->nama_donatur,
            'nominal'      => $request->nominal,
            'tgl_donasi'   => now(),
            'status'       => 'Pending' // Nanti diubah jadi 'Success' lewat Webhook Midtrans
        ]);

        // 3. Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // Ubah ke true kalau udah rilis
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->nominal,
            ],
            'customer_details' => [
                'first_name' => $request->nama_donatur,
            ]
        ];

        try {
            // 4. Minta URL Halaman Pembayaran (Bukan cuma Token, karena kita di Mobile)
            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

            return response()->json([
                'sukses' => true,
                'pesan'  => 'Berhasil membuat link pembayaran',
                'payment_url' => $paymentUrl // Link ini yang bakal dibuka di HP
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'sukses' => false,
                'pesan'  => $e->getMessage()
            ], 500);
        }
    }
}