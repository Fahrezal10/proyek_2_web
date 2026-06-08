<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background-color: #12261E; min-height: 100vh; color: #FFFFFF; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; overflow-y: auto; }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover, .sidebar-link.active { background-color: #1D3A2E; color: #fff; }
        .sidebar-link.active { background-color: #798880; color: #FFFFFF; font-weight: bold; }
        .main-content { margin-left: 250px; padding: 40px; }
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .badge-status { padding: 8px 15px; border-radius: 50px; font-weight: 600; font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="sidebar p-4">
    <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
    <hr style="border-color: #274D3D;" class="mb-4">
    <p class="sidebar-label mb-3">Menu Ketua</p>
    
    <a href="/admin/dashboard" class="sidebar-link">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>
    <a href="/admin/pemasukan" class="sidebar-link">
        <i class="fa-solid fa-file-import"></i> Lihat Pemasukan
    </a>
    <a href="/admin/pengeluaran" class="sidebar-link">
        <i class="fa-solid fa-file-export"></i> Lihat Pengeluaran
    </a>
    <a href="/admin/riwayat" class="sidebar-link active">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Laporan
    </a>
    
    <hr style="border-color: #274D3D;" class="mt-5 mb-4">
    <form action="/admin/logout" method="POST" class="d-grid mt-auto">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm fw-bold" style="border-color: #dc3545; color: #dc3545; border-radius: 8px;">
            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
        </button>
    </form>
</div>

<div class="main-content">
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Tracking & Riwayat Laporan</h3>
        <p class="text-muted">Daftar semua laporan yang telah Anda proses (ACC/Revisi).</p>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Periode</th>
                        <th>Saldo Akhir</th>
                        <th>Status Terakhir</th>
                        <th>Catatan Anda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->periode_bulan }}</td>
                        <td>Rp {{ number_format($item->saldo_akhir, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status_verifikasi == 'terverifikasi')
                                <span class="badge-status bg-success text-white"><i class="fa-solid fa-check-circle me-1"></i> Terverifikasi</span>
                            @else
                                <span class="badge-status bg-danger text-white"><i class="fa-solid fa-rotate me-1"></i> Direvisi</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            <em>{{ $item->catatan_revisi ?? '-' }}</em>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('ketua.laporan.detail', $item->id_laporan) }}?dari=riwayat" class="btn btn-sm btn-outline-dark px-3 rounded-pill">
                                <i class="fa-solid fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat laporan yang diproses.</td>
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