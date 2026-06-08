<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-width=1.0">
    <title>Dashboard - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .sidebar { 
                background-color: #12261E; 
                height: 100vh; 
                color: #FFFFFF; 
                box-shadow: 4px 0 10px rgba(0,0,0,0.1); 
                
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                overflow-y: auto;
            }
        .main-content {
            margin-left: 16.666667%; /* Ini lebar standar col-md-2 */
        }
        @media (max-width: 768px) {
            .sidebar { position: relative; height: auto; width: 100%; }
            .main-content { margin-left: 0; }
        }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        
        /* DIBIKIN TUMPUL: border-radius 8px */
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover { background-color: #1D3A2E; color: #fff; }
        
        /* Highlight Menu Aktif Sesuai Figma (Abu-abu Kehijauan) */
        .sidebar-link.active { background-color: #798880; color: #FFFFFF; font-weight: bold; }
        .sidebar-link.active i { color: #FFFFFF; }

        /* DIBIKIN TUMPUL: Dropdown Manajemen Kas */
        .dropdown-menu-custom { background-color: #1D3A2E; border-radius: 8px; padding: 5px 0; margin-left: 10px; display: none; }
        .dropdown-link-custom { color: #D1DCD6; text-decoration: none; padding: 10px 15px; display: flex; align-items: center; border-radius: 6px; transition: 0.2s; margin: 0 5px; }
        .dropdown-link-custom i { width: 20px; margin-right: 10px; font-size: 0.9rem; }
        .dropdown-link-custom:hover { background-color: #274D3D; color: #fff; }
        .rotate-icon { transition: transform 0.3s ease; }
        .rotate-icon.rotated { transform: rotate(180deg); }

        .navbar-custom { background-color: #fff; border-bottom: 1px solid #e0e0e0; }
        .text-dark-green { color: #12261E; }
        
        /* DIBIKIN TUMPUL BGT: Card Ringkasan (border-radius 16px) */
        .card-ringkasan { background-color: #12261E; color: #FFFFFF; border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.3s; }
        .card-ringkasan:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        
        /* DIBIKIN TUMPUL BGT: Card Konten (border-radius 16px) */
        .card-content { border: none; border-radius: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); background-color: #fff; }
        .table-striped tbody tr:nth-of-type(odd) { background-color: #F8F9FA; }
        
        /* Teks default untuk tabel */
        .text-tabel { color: #212529; } 
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2 sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            
            <p class="sidebar-label mb-3">Menu</p>
            
            <a href="/admin/dashboard" class="sidebar-link active">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            
            <div>
                <div class="sidebar-link d-flex justify-content-between align-items-center" id="manajemenKasLink">
                    <div class="d-flex align-items-center"><i class="fa-solid fa-briefcase"></i> Manajemen Kas</div>
                    <i class="fa-solid fa-chevron-down rotate-icon" id="manajemenKasIcon"></i>
                </div>
                <div class="dropdown-menu-custom" id="manajemenKasMenu">
                    <a href="/admin/pemasukan" class="dropdown-link-custom">
                        <i class="fa-solid fa-file-import"></i> Catat Pemasukan
                    </a>
                    <a href="{{ route('pengeluaran') }}" class="dropdown-link-custom {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-export"></i> Catat Pengeluaran
                    </a>
                </div>
            </div>
            
            <a href="{{ route('admin.donasi') }}" class="sidebar-link">
                <i class="fa-solid fa-heart-pulse"></i> Kelola Donasi
            </a>
            <a href="/admin/laporan" class="sidebar-link">
                <i class="fa-solid fa-file-contract"></i> Laporan Keuangan
            </a>
            
            <hr style="border-color: #274D3D;" class="mt-5 mb-4">
            
            <form action="/admin/logout" method="POST" class="d-grid mt-auto" id="formLogout">
                @csrf
                <button type="button" onclick="konfirmasiLogout()" class="btn btn-outline-light btn-sm fw-bold" style="border-color: #dc3545; color: #dc3545; border-radius: 8px;">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </div>

        <div class="col-md-10 p-0 main-content">
            
            <div class="navbar-custom p-3 px-5 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark-green">Sistem Informasi Keuangan Masjid</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-secondary">Halo, {{ $user->nama }}</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px; background-color: #12261E; color: white; font-size: 1.1rem;">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="p-4 px-5">
                <h2 class="fw-bold text-dark-green mb-4">Halo, {{ $user->nama }}!</h2>
                <div class="alert shadow-sm border-0 mb-4" style="background-color: #FFFFFF; color: #495057; border-radius: 12px; border-left: 6px solid #12261E;">
                    <h5 class="alert-heading fw-bold mb-1" style="color: #12261E;">Selamat Datang di SMART-KAS!</h5>
                    <p class="mb-0">Anda saat ini login sebagai <strong style="color: #12261E;">{{ strtoupper($user->role) }}</strong>. Kelola keuangan masjid dengan aman dan terstruktur.</p>
                </div>

                <div class="row g-4 mt-1 mb-4">
                    <div class="col-md-4">
                        <div class="card card-ringkasan p-4">
                            <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #FFFFFF;">Total Pemasukan</h6>
                            <h2 class="fw-bold m-0" style="color: #fff;">Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-ringkasan p-4">
                            <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #FFFFFF;">Total Pengeluaran</h6>
                            <h2 class="fw-bold m-0" style="color: #fff;">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-ringkasan p-4">
                            <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #FFFFFF;">Total Saldo Kas Masjid</h6>
                            <h2 class="fw-bold m-0" style="color: #fff;">Rp. {{ number_format($saldoKas, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>

                <div class="card card-content p-4 mb-4">
                    <h5 class="fw-bold text-dark-green mb-3">Grafik Keuangan 2026</h5>
                    <div class="p-3 bg-light rounded text-center text-muted" style="height: 300px; line-height: 280px;">
                        <canvas id="chartKeuangan"></canvas>
                    </div>
                </div>

                <div class="card card-content p-4">
                    <h5 class="fw-bold text-dark-green mb-3">Transaksi Terakhir</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="text-secondary fw-bold" style="font-size: 0.9rem;">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerakhir as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    
                                    <td>
                                        {{ $item->kategori }} 
                                        @if($item->keterangan) 
                                            <span class="text-muted" style="font-size: 0.85rem;">({{ $item->keterangan }})</span> 
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if($item->jenis_transaksi == 'pemasukan')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success">Uang Masuk</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Uang Keluar</span>
                                        @endif
                                    </td>
                                    
                                    <td class="fw-bold {{ $item->jenis_transaksi == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                        Rp. {{ number_format($item->nominal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada transaksi tercatat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const manajemenKasLink = document.getElementById('manajemenKasLink');
    const manajemenKasMenu = document.getElementById('manajemenKasMenu');
    const manajemenKasIcon = document.getElementById('manajemenKasIcon');

    manajemenKasLink.addEventListener('click', function() {
        if (manajemenKasMenu.style.display === "block") {
            manajemenKasMenu.style.display = "none";
            manajemenKasIcon.classList.remove('rotated');
        } else {
            manajemenKasMenu.style.display = "block";
            manajemenKasIcon.classList.add('rotated');
        }
    });
</script>

<script>
    function konfirmasiLogout() {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Anda akan keluar dari sesi SMART-KAS saat ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', 
            cancelButtonColor: '#12261E',  
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            background: '#F4F7F6',
            color: '#12261E',
            borderRadius: '16px' // Bikin popup JS-nya juga agak melengkung
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formLogout').submit();
            }
        })
    }
</script>

<script>
    const ctx = document.getElementById('chartKeuangan').getContext('2d');
    
    // Data dari Controller Laravel
    const dataPemasukan = @json($dataPemasukan);
    const dataPengeluaran = @json($dataPengeluaran);

    new Chart(ctx, {
        type: 'line', // Jenis grafik garis (seperti di Figma)
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: dataPemasukan,
                    borderColor: '#198754', // Hijau
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    fill: true,
                    tension: 0.4 // Biar garisnya melengkung smooth
                },
                {
                    label: 'Pengeluaran',
                    data: dataPengeluaran,
                    borderColor: '#dc3545', // Merah
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>