<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Pengeluaran - Ketua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background-color: #12261E; min-height: 100vh; color: #FFFFFF; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; overflow-y: auto; }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover { background-color: #1D3A2E; color: #fff; }
        .sidebar-link.active { background-color: #798880; color: #FFFFFF; font-weight: bold; }
        
        .main-content { margin-left: 250px; padding: 40px; }
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="sidebar p-4">
    <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
    <hr style="border-color: #274D3D;" class="mb-4">
   <p class="sidebar-label mb-3">Menu Ketua</p>
    <a href="/admin/dashboard" class="sidebar-link"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
    
    <a href="/admin/pemasukan" class="sidebar-link"><i class="fa-solid fa-file-import"></i> Lihat Pemasukan</a>
    <a href="/admin/pengeluaran" class="sidebar-link active"><i class="fa-solid fa-file-export"></i> Lihat Pengeluaran</a>
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-danger">Monitoring Pengeluaran</h3>
        <span class="badge bg-light text-dark border p-2 px-3 rounded-pill shadow-sm">
            Saldo Kas: <strong class="text-success">Rp. {{ number_format($saldoKas, 0, ',', '.') }}</strong>
        </span>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td class="text-danger fw-bold">- Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        @if($item->foto_bukti)
                            <a href="{{ asset('uploads/bukti/'.$item->foto_bukti) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Nota</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>