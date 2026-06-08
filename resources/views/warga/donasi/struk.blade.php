<!DOCTYPE html>
<html lang="id">
<head>
    <title>Terima Kasih - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100 p-3">

    <div class="text-center p-4 p-md-5 bg-white shadow-lg rounded-4 w-100" style="max-width: 500px;">
        <i class="fa-solid fa-circle-check text-success mb-4" style="font-size: 80px;"></i>
        <h2 class="fw-bold text-dark mb-3">Jazakumullah Khairan!</h2>
        <p class="text-muted fs-5 mb-4">Donasi Anda sebesar <strong class="text-success">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</strong> berhasil diterima.</p>
        
        <div class="bg-light p-3 rounded-3 text-start mb-4 border">
            <p class="mb-1 small text-muted"><strong>Order ID:</strong> {{ $donasi->order_id }}</p>
            <p class="mb-1 small text-muted"><strong>Nama:</strong> {{ $donasi->nama_donatur }}</p>
            <p class="mb-0 small text-muted"><strong>Tanggal:</strong> {{ date('d F Y H:i', strtotime($donasi->tgl_donasi)) }}</p>
        </div>

        <a href="{{ route('beranda') }}" class="btn fw-bold w-100" style="background-color: #12261E; color: #E5C05C; padding: 12px;">
            Kembali ke Halaman Utama
        </a>
    </div>

</body>
</html>