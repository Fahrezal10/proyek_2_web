<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Online - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <style>
        :root {
            --gold-accent: #E5C05C;
            --dark-green: #12261E;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F4F7F6;
        }

        .donation-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: none;
        }

        .donation-header {
            background: linear-gradient(135deg, var(--dark-green) 0%, #1a3a2d 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .btn-pay {
            background-color: var(--gold-accent);
            color: var(--dark-green);
            font-weight: 700;
            border-radius: 12px;
            padding: 14px;
            transition: 0.3s;
        }

        .btn-pay:hover {
            background-color: #d4ae4a;
            transform: translateY(-2px);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            border-color: var(--dark-green);
            box-shadow: 0 0 0 0.25rem rgba(18, 38, 30, 0.2);
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="container" style="max-width: 550px;">
        <a href="{{ route('beranda') }}" class="text-decoration-none text-muted fw-bold mb-3 d-inline-block">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>

        <div class="card donation-card">
            <div class="donation-header">
                <i class="fa-solid fa-hand-holding-heart fs-1 mb-3" style="color: var(--gold-accent);"></i>
                <h2 class="fw-bold m-0" style="font-family: 'Playfair Display', serif;">Infaq & Sedekah</h2>
                <p class="text-white-50 mt-2 mb-0 small">"Sedekah tidaklah mengurangi harta."</p>
            </div>

            <div class="card-body p-4 p-md-5">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('warga.donasi.proses') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="fw-bold text-muted small mb-2">Nama Hamba Allah</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="fa-regular fa-user text-muted"></i></span>
                            <!-- Name disesuaikan dengan database: nama_donatur -->
                            <input type="text" name="nama_donatur" class="form-control border-start-0"
                                placeholder="Masukkan nama Anda..." required value="{{ old('nama_donatur') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted small mb-2">Nominal Donasi (Min. Rp 1.000)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 fw-bold">Rp</span>
                            <input type="number" name="nominal"
                                class="form-control border-start-0 fs-5 fw-bold text-success" placeholder="0" min="1000"
                                required value="{{ old('nominal') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-pay w-100" id="btn-submit">
                        <i class="fa-solid fa-lock me-2"></i>Lanjut Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(isset($snapToken))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let btnSubmit = document.getElementById('btn-submit');
                btnSubmit.innerHTML = '<i class="fa-solid fa-qrcode me-2"></i>Bayar Sekarang';
                btnSubmit.type = 'button';

                snap.pay('{{ $snapToken }}', {
                    onSuccess: function (result) {
                        window.location.href = "{{ route('warga.donasi.struk', $donasi->order_id) }}";
                    },
                    onPending: function (result) {
                        alert("Menunggu pembayaran Anda diselesaikan!");
                    },
                    onError: function (result) {
                        alert("Pembayaran gagal diproses!");
                    },
                    onClose: function () {
                        alert('Pembayaran dibatalkan atau waktu telah habis.');
                        window.location.href = "{{ route('warga.donasi') }}";
                    }
                });

                btnSubmit.onclick = function () { snap.pay('{{ $snapToken }}'); };
            });
        </script>
    @endif

</body>

</html>