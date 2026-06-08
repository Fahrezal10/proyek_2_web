<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - SMART-KAS</title>
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
        .main-content { margin-left: 250px; padding: 40px; }
        .box-summary { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-align: center; }
        .table-container { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
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
    
    <a href="#" class="sidebar-link active">
        <i class="fa-solid fa-clipboard-check"></i> Verifikasi Laporan
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
    <a href="{{ $urlKembali }}" class="btn btn-outline-dark mb-4">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
    </a>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Rincian Laporan Keuangan</h3>
        <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill border border-warning">Menunggu Verifikasi</span>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3"><div class="box-summary"><small class="text-muted fw-bold">Periode</small><h5 class="fw-bold mt-2">{{ $laporan->periode_bulan }}</h5></div></div>
        <div class="col-md-3"><div class="box-summary border-bottom border-success border-3"><small class="text-muted fw-bold">Total Pemasukan</small><h4 class="text-success fw-bold mt-2">Rp {{ number_format($laporan->total_pemasukan, 0, ',', '.') }}</h4></div></div>
        <div class="col-md-3"><div class="box-summary border-bottom border-danger border-3"><small class="text-muted fw-bold">Total Pengeluaran</small><h4 class="text-danger fw-bold mt-2">Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}</h4></div></div>
        <div class="col-md-3"><div class="box-summary bg-dark text-white"><small class="text-white-50 fw-bold">Saldo Akhir</small><h4 class="fw-bold mt-2">Rp {{ number_format($laporan->saldo_akhir, 0, ',', '.') }}</h4></div></div>
    </div>

    <div class="table-container">
        <h5 class="fw-bold mb-3 text-danger"><i class="fa-solid fa-file-export me-2"></i> Rincian Pengeluaran & Nota</h5>
        <table class="table table-hover align-middle border">
            <thead class="table-light">
                <tr>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Bukti Nota</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluaran as $item)
                <tr>
                    <td class="fw-bold">{{ $item->kategori }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td class="text-danger">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        @if($item->foto_bukti)
                            <a href="{{ asset('uploads/bukti/'.$item->foto_bukti) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-image"></i> Lihat Nota</a>
                        @else
                            <span class="text-muted small">Tidak ada nota</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Tidak ada pengeluaran pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-4">
        <button type="button" class="btn btn-danger px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTolak">
            <i class="fa-solid fa-xmark me-2"></i> Revisi
        </button>
        <button type="button" class="btn btn-success px-4 fw-bold" onclick="konfirmasiSetujui()">
            <i class="fa-solid fa-check-double me-2"></i> Setujui & Sahkan
        </button>
    </div>
</div>

<form id="formApprove" action="{{ route('ketua.laporan.approve', $laporan->id_laporan) }}" method="POST" style="display: none;">@csrf</form>

<div class="modal fade" id="modalTolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Catatan Penolakan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('ketua.laporan.reject', $laporan->id_laporan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan ditolak / direvisi:</label>
                        <textarea class="form-control" name="catatan_revisi" rows="4" placeholder="Misal: Nota kurang jelas..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger fw-bold">Kirim Revisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiSetujui() {
        Swal.fire({
            title: 'Sahkan Laporan?', 
            text: "Apakah Anda yakin data laporan ini sudah benar dan valid?", 
            icon: 'question',
            showCancelButton: true, 
            confirmButtonColor: '#198754', 
            cancelButtonColor: '#6c757d', 
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) { 
                // Script ini yang bakal nge-trigger form hidden #formApprove
                document.getElementById('formApprove').submit(); 
            }
        });
    }
</script>
</body>
</html>