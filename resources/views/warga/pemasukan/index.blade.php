<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pemasukan - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --gold-accent: #E5C05C;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --dark-green: #23342D;
            --darker-green: #15221D;
        }

        body, html {
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA;
        }

        .header-curved {
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--darker-green) 100%);
            padding-top: 30px; padding-bottom: 120px;
            border-bottom-left-radius: 50% 15%; border-bottom-right-radius: 50% 15%;
            position: relative;
        }

        .navbar-custom {
            background: var(--glass-bg); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid var(--glass-border); border-radius: 50px; padding: 10px 30px;
        }

        .logo-img { height: 55px; width: auto; object-fit: contain; }

        .nav-link {
            color: #ffffff !important; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; margin: 0 15px; transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: var(--gold-accent) !important; }

        .page-title {
            font-family: 'Playfair Display', serif; color: #FFFFFF; font-weight: 800; font-size: 3.5rem; letter-spacing: 2px; margin-top: 60px; margin-bottom: 10px;
        }

        .data-container {
            margin-top: -60px; position: relative; z-index: 10; background: #ffffff; border-radius: 16px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06); padding: 35px; margin-bottom: 80px;
        }

        .btn-toggle-view {
            border: 1px solid var(--dark-green); color: var(--dark-green); font-weight: 600; border-radius: 8px; padding: 8px 20px; transition: 0.3s; background: transparent;
        }
        .btn-toggle-view.active, .btn-toggle-view:hover {
            background-color: var(--dark-green); color: #ffffff;
        }

        .table-custom th {
            background-color: var(--dark-green) !important; color: #ffffff !important; font-weight: 600; padding: 15px; text-align: center;
        }
        .table-custom td { padding: 15px; vertical-align: middle; }
    </style>
</head>

<body>

    <div class="header-curved">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-custom d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/img/logoproyek2.png') }}" alt="Logo" class="logo-img">
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><i class="fa-solid fa-bars text-white"></i></button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('warga.informasi') }}">Informasi</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="dropdown">Layanan</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fw-bold" href="{{ route('warga.pemasukan') }}">Pemasukan</a></li>
                                <li><a class="dropdown-item" href="{{ route('warga.pengeluaran') }}">Pengeluaran</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('warga.donasi') }}">Donasi</a></li>
                    </ul>
                </div>
                <div class="d-none d-lg-block" style="width: 55px;"></div>
            </nav>

            <div class="text-center">
                <h1 class="page-title">REKAP PEMASUKAN</h1> 
                <p class="text-white-50 mb-4">Transparansi Dana Masjid Jami' Al Istiqomah</p>
                
                <div class="d-inline-block bg-white shadow-sm" style="border-radius: 50px; padding: 10px 25px; border: 2px solid var(--gold-accent);">
                    <i class="fa-solid fa-wallet fs-5 me-2" style="color: var(--dark-green); vertical-align: middle;"></i>
                    <span class="text-muted fw-bold me-2" style="font-size: 0.95rem;">Total Saldo Kas Saat Ini:</span>
                    <span class="fw-bold fs-5" style="color: var(--dark-green);">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="data-container">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
                <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-folder-open text-warning me-2"></i>Data Kas Masuk</h5>

                <div class="d-flex align-items-center gap-3">
                    <form action="{{ route('warga.pemasukan') }}" method="GET" class="m-0">
                        <select name="bulan" class="form-select fw-bold border-success text-success" onchange="this.form.submit()" style="border-radius: 8px; cursor: pointer;">
                            <option value="">-- Semua Bulan --</option>
                            @php
                                $listBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @foreach($listBulan as $bln)
                                <option value="{{ $bln }}" {{ (isset($bulanDipilih) && $bulanDipilih == $bln) ? 'selected' : '' }}>{{ $bln }}</option>
                            @endforeach
                        </select>
                    </form>

                    <div class="btn-group">
                        <button class="btn-toggle-view active" id="btn-tabel" onclick="switchView('tabel')"><i class="fa-solid fa-table me-2"></i>Tabel</button>
                        <button class="btn-toggle-view" id="btn-grafik" onclick="switchView('grafik')"><i class="fa-solid fa-chart-bar me-2"></i>Grafik</button>
                    </div>
                </div>
            </div>

            <div id="view-tabel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 15%;">Tanggal</th>
                                <th>Keterangan / Sumber Dana</th>
                                <th style="width: 20%;">Nominal</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tabelPemasukan as $key => $row)
                                <tr>
                                    <td class="text-center fw-bold text-secondary">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                                    <td class="fw-semibold text-dark">{{ $row->kategori }}</td>
                                    <td class="text-end fw-bold text-success">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-dark fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#detailMasuk{{ $row->id_transaksi }}">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr> 
                                    <td colspan="5" class="text-center py-5 text-muted fw-bold">
                                        <i class="fa-solid fa-folder-open fs-1 opacity-25 d-block mb-3"></i>
                                        Tidak ada data pemasukan kas di periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="view-grafik" class="d-none py-3">
                <div style="position: relative; height:400px; width:100%">
                    <canvas id="chartPemasukan"></canvas>
                </div>
            </div>
        </div>
    </div>
    @foreach($tabelPemasukan as $row)
        <div class="modal fade" id="detailMasuk{{ $row->id_transaksi }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                    <div class="modal-header" style="background-color: var(--dark-green); color: white; border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-invoice-dollar me-2 text-warning"></i>Detail Pemasukan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <span class="text-muted fw-bold">Tanggal:</span>
                                <span class="fw-bold text-dark">{{ date('d F Y', strtotime($row->tanggal)) }}</span>
                            </li>
                            <li class="list-group-item px-0 py-3">
                                <span class="text-muted fw-bold d-block mb-1">Keterangan Sumber Dana:</span>
                                <span class="fw-semibold text-dark" style="line-height: 1.6;">{{ $row->keterangan }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <span class="text-muted fw-bold">Kategori Bulan:</span>
                                <span class="badge bg-secondary">{{ $row->bulan }}</span>
                            </li>
                        </ul>
                        <div class="mt-4 p-3 bg-light rounded-3 text-center border">
                            <small class="text-muted d-block fw-bold mb-1">Total Nominal Masuk</small>
                            <h3 class="fw-bold text-success m-0">Rp {{ number_format($row->nominal, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        // Fungsi Switch Antara Tabel dan Grafik
        function switchView(type) {
            if (type === 'tabel') {
                document.getElementById('view-tabel').classList.remove('d-none');
                document.getElementById('view-grafik').classList.add('d-none');
                document.getElementById('btn-tabel').classList.add('active');
                document.getElementById('btn-grafik').classList.remove('active');
            } else {
                document.getElementById('view-tabel').classList.add('d-none');
                document.getElementById('view-grafik').classList.remove('d-none');
                document.getElementById('btn-tabel').classList.remove('active');
                document.getElementById('btn-grafik').classList.add('active');
            }
        }

        // Script Setup Grafik Chart.js
        const ctx = document.getElementById('chartPemasukan').getContext('2d');
        const chartPemasukan = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Total Pemasukan (Rp)',
                    data: @json($grafikPemasukan),
                    backgroundColor: '#23342D',
                    borderColor: '#E5C05C',
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>