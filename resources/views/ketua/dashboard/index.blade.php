<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ketua - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', sans-serif; }
        
        /* CSS SIDEBAR */
        .sidebar { background-color: #12261E; min-height: 100vh; color: #FFFFFF; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; overflow-y: auto; }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover { background-color: #1D3A2E; color: #fff; }
        .sidebar-link.active { background-color: #798880; color: #FFFFFF; font-weight: bold; }
        
        /* CSS MAIN CONTENT */
        .main-content { margin-left: 250px; padding: 40px; transition: 0.3s; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .bg-dark-green { background-color: #12261E; color: white; }
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .status-badge { padding: 8px 16px; border-radius: 50px; font-weight: 600; font-size: 0.85rem; }
    </style>
</head>
<body>

<div class="sidebar p-4">
    <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
    <hr style="border-color: #274D3D;" class="mb-4">
   <p class="sidebar-label mb-3">Menu Ketua</p>
    <a href="/admin/dashboard" class="sidebar-link active"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
    
    <a href="/admin/pemasukan" class="sidebar-link"><i class="fa-solid fa-file-import"></i> Lihat Pemasukan</a>
    <a href="/admin/pengeluaran" class="sidebar-link"><i class="fa-solid fa-file-export"></i> Lihat Pengeluaran</a>
    <a href="{{ route('ketua.riwayat') }}" class="sidebar-link {{ request()->is('admin/history-laporan*') ? 'active' : '' }}">
    <i class="fa-solid fa-clock-rotate-left"></i> History Laporan
    </a>

    
    <hr style="border-color: #274D3D;" class="mt-5 mb-4">
    <form action="/admin/logout" method="POST" class="d-grid mt-auto" id="formLogoutSidebar">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm fw-bold" style="border-color: #dc3545; color: #dc3545; border-radius: 8px;">
            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
        </button>
    </form>
</div>

<div class="main-content">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold text-dark m-0">Ringkasan Pengawasan</h3>
            <p class="text-muted">Selamat datang, Bpk. {{ Auth::user()->nama }} (Ketua Masjid)</p>
        </div>
        <div class="col-auto">
            <div class="p-2 bg-white rounded-circle shadow-sm">
                <i class="fa-solid fa-user-tie fa-2x px-2 text-dark"></i>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card card-custom bg-dark-green p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 opacity-75">Saldo Kas Terkini</p>
                        <h2 class="fw-bold m-0">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h2>
                    </div>
                    <i class="fa-solid fa-vault fa-2x opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom bg-warning p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 text-dark opacity-75">Perlu Persetujuan Anda</p>
                        <h2 class="fw-bold m-0 text-dark">{{ $totalLaporanMenunggu }} Laporan</h2>
                    </div>
                    <i class="fa-solid fa-file-signature fa-2x text-dark opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0"><i class="fa-solid fa-clipboard-check me-2 text-primary"></i> Antrean Validasi Laporan</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Periode</th>
                        <th class="py-3 text-center">Pemasukan</th>
                        <th class="py-3 text-center">Pengeluaran</th>
                        <th class="py-3 text-center">Saldo Akhir</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanMasuk as $laporan)
                    <tr>
                        <td class="fw-bold text-dark">{{ $laporan->periode_bulan }}</td>
                        <td class="text-success text-center">Rp {{ number_format($laporan->total_pemasukan, 0, ',', '.') }}</td>
                        <td class="text-danger text-center">Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}</td>
                        <td class="fw-bold text-center">Rp {{ number_format($laporan->saldo_akhir, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="status-badge bg-warning text-dark border border-warning">
                                <i class="fa-solid fa-clock me-1"></i> Menunggu
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('ketua.laporan.detail', $laporan->id_laporan) }}" class="btn btn-dark btn-sm px-4 rounded-pill shadow-sm">
                                Periksa & Validasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-circle-check fa-3x mb-3 d-block opacity-25"></i>
                            Semua laporan sudah terverifikasi. Tidak ada antrean baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>