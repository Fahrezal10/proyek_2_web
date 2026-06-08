<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Donasi - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .sidebar { background-color: #12261E; height: 100vh; color: #FFFFFF; box-shadow: 4px 0 10px rgba(0,0,0,0.1); position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; }
        .main-content { margin-left: 16.666667%; }
        @media (max-width: 768px) { .sidebar { position: relative; height: auto; width: 100%; } .main-content { margin-left: 0; } }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover { background-color: #1D3A2E; color: #fff; }
        .sidebar-link.active { background-color: #798880; color: #FFFFFF; font-weight: bold; }
        .sidebar-link.active i { color: #FFFFFF; }
        .dropdown-menu-custom { background-color: #1D3A2E; border-radius: 8px; padding: 5px 0; margin-left: 10px; display: none; }
        .dropdown-link-custom { color: #D1DCD6; text-decoration: none; padding: 10px 15px; display: flex; align-items: center; border-radius: 6px; transition: 0.2s; margin: 0 5px; }
        .dropdown-link-custom i { width: 20px; margin-right: 10px; font-size: 0.9rem; }
        .dropdown-link-custom:hover { background-color: #274D3D; color: #fff; }
        .rotate-icon { transition: transform 0.3s ease; }
        .rotate-icon.rotated { transform: rotate(180deg); }

        .navbar-custom { background-color: #fff; border-bottom: 1px solid #e0e0e0; }
        .text-dark-green { color: #12261E; }
        .card-ringkasan { background-color: #12261E; color: #FFFFFF; border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.3s; }
        .card-ringkasan:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        .card-ringkasan-light { background-color: #FFFFFF; color: #12261E; border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.03); transition: 0.3s; border-left: 5px solid #E5C05C; }
        .card-content { border: none; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); background-color: #fff; }
        
        .table-custom { margin-bottom: 0; }
        .table-custom thead th { background-color: #F8F9FA; color: #6c757d; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #e9ecef; padding: 15px; }
        .table-custom tbody td { padding: 15px; vertical-align: middle; color: #495057; font-size: 0.9rem; border-bottom: 1px solid #f1f3f5; }
        .table-custom tbody tr:hover { background-color: #f8f9fa; }
        
        .badge-success-soft { background-color: rgba(25, 135, 84, 0.1); color: #198754; border: 1px solid rgba(25, 135, 84, 0.2); }
        .badge-warning-soft { background-color: rgba(255, 193, 7, 0.1); color: #d39e00; border: 1px solid rgba(255, 193, 7, 0.2); }
        .badge-danger-soft { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); }
        
        .search-input { border-radius: 8px; border: 1px solid #ced4da; padding-left: 35px; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            <p class="sidebar-label mb-3">Menu</p>
            
            <a href="/admin/dashboard" class="sidebar-link">
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
                    <a href="{{ route('pengeluaran') }}" class="dropdown-link-custom">
                        <i class="fa-solid fa-file-export"></i> Catat Pengeluaran
                    </a>
                </div>
            </div>
            
            <!-- AKTIF DI KELOLA DONASI -->
            <a href="/admin/donasi" class="sidebar-link active">
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

        <!-- MAIN CONTENT -->
        <div class="col-md-10 p-0 main-content">
            
            <!-- NAVBAR -->
            <div class="navbar-custom p-3 px-5 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark-green">Kelola Donasi Online</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-secondary">Halo, {{ $user->nama ?? 'Admin' }}</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px; background-color: #12261E; color: white; font-size: 1.1rem;">
                        {{ strtoupper(substr($user->nama ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="p-4 px-5">
                
                <!-- SUMMARY CARDS -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card card-ringkasan p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold m-0" style="font-size: 0.9rem; color: #9CAEA5;">Total Donasi Berhasil</h6>
                                <i class="fa-solid fa-check-circle text-success fs-4"></i>
                            </div>
                            <h2 class="fw-bold m-0" style="color: #fff;">Rp. {{ number_format($totalDonasiSukses ?? 0, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-ringkasan-light p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold m-0" style="font-size: 0.9rem; color: #6c757d;">Menunggu Pembayaran</h6>
                                <i class="fa-solid fa-clock-rotate-left text-warning fs-4"></i>
                            </div>
                            <h3 class="fw-bold m-0 text-dark-green">{{ $jumlahPending ?? 0 }} <span class="fs-6 text-muted fw-normal">Transaksi</span></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-ringkasan-light p-4" style="border-left-color: #dc3545;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold m-0" style="font-size: 0.9rem; color: #6c757d;">Donasi Batal</h6>
                                <i class="fa-solid fa-xmark-circle text-danger fs-4"></i>
                            </div>
                            <h3 class="fw-bold m-0 text-dark-green">{{ $jumlahBatal ?? 0 }} <span class="fs-6 text-muted fw-normal">Transaksi</span></h3>
                        </div>
                    </div>
                </div>

                <!-- TABEL & FILTER DATA DONASI -->
                <div class="card card-content p-0 mb-5">
                    
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h5 class="fw-bold text-dark-green m-0"><i class="fa-solid fa-list me-2"></i>Riwayat Donasi Warga</h5>
                        
                        <!-- FORM PENCARIAN & FILTER -->
                        <form action="" method="GET" class="d-flex gap-2 m-0">
                            <div class="position-relative">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input type="text" name="search" class="form-control search-input" placeholder="Cari Order ID / Nama..." value="{{ request('search') }}">
                            </div>
                            <select name="status" class="form-select" style="border-radius: 8px; width: 150px;">
                                <option value="">Semua Status</option>
                                <option value="Berhasil" {{ request('status') == 'Berhasil' ? 'selected' : '' }}>Berhasil</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                            <button type="submit" class="btn" style="background-color: #12261E; color: white; border-radius: 8px;" title="Terapkan Filter">
                                <i class="fa-solid fa-filter"></i>
                            </button>
                            
                            @if(request('search') || request('status'))
                                <a href="{{ url()->current() }}" class="btn btn-outline-danger" style="border-radius: 8px;" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- ISI TABEL -->
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Order ID</th>
                                    <th style="width: 20%;">Tanggal & Waktu</th>
                                    <th style="width: 25%;">Nama Donatur</th>
                                    <th style="width: 15%;">Metode</th>
                                    <th style="width: 15%;">Nominal</th>
                                    <th style="width: 10%; text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataDonasi ?? [] as $donasi)
                                <tr>
                                    <td>
                                        <span class="fw-bold" style="color: #12261E;">{{ $donasi->order_id }}</span>
                                    </td>
                                    <td>
                                        {{ date('d M Y, H:i', strtotime($donasi->tgl_donasi)) }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-3 border" style="width: 35px; height: 35px; color: #12261E;">
                                                <i class="fa-solid fa-user fs-6"></i>
                                            </div>
                                            <span class="fw-bold">{{ $donasi->nama_donatur }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($donasi->payment_type)
                                            <span class="text-uppercase fw-bold text-muted" style="font-size: 0.8rem;">
                                                <i class="fa-solid fa-wallet me-1"></i> {{ str_replace('_', ' ', $donasi->payment_type) }}
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic" style="font-size: 0.8rem;">-</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($donasi->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @php $statusAman = trim(strtolower($donasi->status)); @endphp
                                        
                                        @if($statusAman == 'berhasil')
                                            <span class="badge badge-success-soft px-3 py-2 rounded-pill">Berhasil</span>
                                        @elseif($statusAman == 'pending')
                                            <span class="badge badge-warning-soft px-3 py-2 rounded-pill">Pending</span>
                                        @else
                                            <span class="badge badge-danger-soft px-3 py-2 rounded-pill">Batal</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa-solid fa-box-open mb-3" style="font-size: 3rem; color: #ced4da;"></i>
                                            <h6 class="fw-bold">Belum Ada Data Donasi</h6>
                                            <p class="small">Data donasi yang sesuai tidak ditemukan atau kosong.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- PAGINATION BAWAAN LARAVEL -->
                    @if(isset($dataDonasi) && $dataDonasi->hasPages())
                    <div class="p-3 border-top d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            Menampilkan data ke {{ $dataDonasi->firstItem() }} - {{ $dataDonasi->lastItem() }} dari total {{ $dataDonasi->total() }}
                        </span>
                        <nav>
                            {{ $dataDonasi->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                    @endif

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
            borderRadius: '16px' 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formLogout').submit();
            }
        })
    }
</script>

</body>
</html>