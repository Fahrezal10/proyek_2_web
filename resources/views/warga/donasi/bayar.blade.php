<!DOCTYPE html>
<html lang="id">
<head>
    <title>Selesaikan Pembayaran - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <style>body { background-color: #0f1c16; color: white; }</style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card bg-dark text-white shadow border-0 text-center" style="width: 400px; border-radius: 16px;">
        <div class="card-body p-5">
            <h5 class="fw-bold mb-3">Detail Donasi</h5>
            <h2 class="text-success fw-bold mb-4">Rp {{ number_format($nominal, 0, ',', '.') }}</h2>
            <p class="text-muted small">Atas Nama: <strong class="text-white">{{ $nama }}</strong></p>
            
            <button id="pay-button" class="btn w-100 fw-bold mt-3" style="background-color: #E5C05C; color: #15221D;">Bayar Sekarang</button>
            
            <a href="{{ route('warga.donasi') }}" class="btn btn-outline-light w-100 mt-2 border-0 small">Batal</a>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function () {
            // Trigger snap popup
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil! Terima kasih orang baik.");
                    window.location.href = "{{ route('beranda') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup layar popup sebelum menyelesaikan pembayaran');
                }
            });
        };
    </script>
</body>
</html>