<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background-color: #12261E; min-height: 100vh; color: #FFFFFF; position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; }
        .main-content { margin-left: 16.666667%; }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover { background-color: #1D3A2E; color: #fff; }
        .sidebar-link.active { background-color: #798880; color: #FFFFFF; font-weight: bold; }
        .dropdown-menu-custom { background-color: #1D3A2E; border-radius: 8px; padding: 5px 0; margin-left: 10px; }
        .dropdown-link-custom { color: #D1DCD6; text-decoration: none; padding: 10px 15px; display: flex; align-items: center; border-radius: 6px; transition: 0.2s; margin: 0 5px; }
        .dropdown-link-custom i { width: 20px; margin-right: 10px; font-size: 0.9rem; }
        .dropdown-link-custom:hover { background-color: #274D3D; color: #fff; }
        .dropdown-link-custom.active { color: #1E88E5; font-weight: bold; background-color: rgba(30, 136, 229, 0.1); }
        .rotate-icon { transition: transform 0.3s ease; }
        .rotate-icon.rotated { transform: rotate(180deg); }
        .btn-tambah { background-color: #1E88E5; color: #fff; border-radius: 8px; padding: 10px 20px; transition: 0.3s; border: none; }
        .btn-tambah:hover { background-color: #1565C0; color: #fff; transform: translateY(-2px); }
        .table-container { background-color: #fff; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .table-header-custom { background-color: #12261E; color: #fff; font-weight: bold; text-align: center; padding: 15px; font-size: 1.1rem; border-bottom: 3px solid #1E88E5; }
        .table-subheader { background-color: #D1DCD6; color: #12261E; font-weight: bold; }
        .table > :not(caption) > * > * { padding: 15px; border-bottom-color: #EEF2F0; }
        .modal-content-custom { border-radius: 16px; border: none; background-color: #F8FAF9; }
        .modal-header-custom { background-color: #12261E; color: white; border-radius: 16px 16px 0 0; padding: 20px; border-bottom: none; border-top: 5px solid #1E88E5;}
        .form-control-custom { border-radius: 8px; border: 1px solid #ced4da; padding: 10px 15px; background-color: #fff; }
        .btn-batal { border: 1px solid #12261E; color: #12261E; font-weight: bold; border-radius: 8px; padding: 10px 25px; background-color: transparent; }
        .btn-simpan { background-color: #1E88E5; color: white; font-weight: bold; border-radius: 8px; padding: 10px 25px; border: none; }
        .badge {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .cursor-pointer:hover {
            opacity: 0.8;
            transform: scale(1.05);
            transition: 0.2s;
        }
        .btn-warning {
            background-color: #FFC107;
            border: none;
        }
        .btn-warning:hover {
            background-color: #E0A800;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            <p class="sidebar-label mb-3">Menu</p>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <div>
                <div class="sidebar-link d-flex justify-content-between align-items-center" id="manajemenKasLink">
                    <div class="d-flex align-items-center"><i class="fa-solid fa-briefcase"></i> Manajemen Kas</div>
                    <i class="fa-solid fa-chevron-down rotate-icon {{ request()->routeIs('pemasukan') || request()->routeIs('pengeluaran') ? 'rotated' : '' }}" id="manajemenKasIcon"></i>
                </div>
                <div class="dropdown-menu-custom" id="manajemenKasMenu" style="display: {{ request()->routeIs('pemasukan') || request()->routeIs('pengeluaran') ? 'block' : 'none' }};">
                    <a href="{{ route('pemasukan') }}" class="dropdown-link-custom {{ request()->routeIs('pemasukan') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-import"></i> Catat Pemasukan
                    </a>
                    <a href="{{ route('pengeluaran') }}" class="dropdown-link-custom {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-export"></i> Catat Pengeluaran
                    </a>
                </div>
            </div>
            <a href="{{ route('admin.donasi') }}" class="sidebar-link"><i class="fa-solid fa-heart-pulse"></i> Kelola Donasi</a>
            <a href="{{ route('laporan') }}" class="sidebar-link {{ request()->routeIs('laporan') ? 'active' : '' }}">
                <i class="fa-solid fa-file-contract"></i> Laporan Keuangan
            </a>
            <hr style="border-color: #274D3D;" class="mt-5 mb-4">
            <form action="/admin/logout" method="POST" class="d-grid mt-auto" id="formLogoutSidebar">
                @csrf
                <button type="button" onclick="konfirmasiLogoutSidebar()" class="btn btn-outline-light btn-sm fw-bold" style="border-color: #dc3545; color: #dc3545; border-radius: 8px;">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </div>

        <div class="col-md-10 p-4 px-5 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <h4 class="fw-bold text-dark m-0">Manajemen Laporan Keuangan</h4>
                <div class="d-flex justify-content-end mb-4 mt-2">
                    <button class="btn-tambah fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBuatLaporan">
                        <i class="fa-solid fa-file-signature me-2"></i> Buat Laporan Baru
                    </button>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header-custom bg-dark">Riwayat Laporan Diajukan</div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0">
                        <thead class="table-subheader">
                            <tr>
                                <th>Periode Laporan</th>
                                <th>Total Pemasukan</th>
                                <th>Total Pengeluaran</th>
                                <th>Saldo Akhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($riwayatLaporan as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->periode_bulan }}</td>
                            <td class="text-success fw-bold">Rp. {{ number_format($item->total_pemasukan, 0, ',', '.') }}</td>
                            <td class="text-danger fw-bold">- Rp. {{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                            <td class="fw-bold" style="color: #12261E;">Rp. {{ number_format($item->saldo_akhir, 0, ',', '.') }}</td>
                            
                            <td>
                                @if($item->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                        <i class="fa-solid fa-clock me-1"></i> Menunggu
                                    </span>
                                @elseif($item->status_verifikasi == 'revisi')
                                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill shadow-sm cursor-pointer" 
                                        data-bs-toggle="modal" data-bs-target="#modalCatatan{{ $item->id_laporan }}" 
                                        title="Klik untuk lihat catatan">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Revisi
                                    </span>
                                @else
                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm">
                                        <i class="fa-solid fa-check-double me-1"></i> Terverifikasi
                                    </span>
                                @endif
                            </td>
                            
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-secondary shadow-sm px-3">
                                        <i class="fa-solid fa-print me-1"></i> Cetak
                                    </button>

                                    @if($item->status_verifikasi == 'revisi')
                                        <form action="{{ route('laporan.update_revisi', $item->id_laporan) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning fw-bold text-dark shadow-sm px-3 mb-1" onclick="return confirm('Sistem akan menyinkronkan data dengan transaksi terbaru. Lanjutkan?')">
                                                <i class="fa-solid fa-rotate-right me-1"></i> Ajukan Ulang
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @if($item->status_verifikasi == 'revisi')
                        <div class="modal fade" id="modalCatatan{{ $item->id_laporan }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title fw-bold">Catatan Revisi Ketua</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="p-3 bg-light rounded border-start border-danger border-4">
                                            <p class="mb-0 italic">"{{ $item->catatan_revisi }}"</p>
                                        </div>
                                        <p class="mt-3 small text-muted">
                                            *Silakan perbaiki data transaksi Anda di menu Manajemen Kas, lalu klik tombol <strong>Ajukan Ulang</strong>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                        <tr>
                            <td colspan="6" class="text-muted py-5 text-center">Belum ada laporan yang diajukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBuatLaporan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title modal-title-custom">Pilih Periode Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('laporan.preview') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="fw-bold mb-2">Bulan Laporan</label>
                        <select class="form-select form-control-custom" name="bulan" required>
                            <option value="Januari">Januari</option><option value="Februari">Februari</option><option value="Maret">Maret</option>
                            <option value="April" selected>April</option><option value="Mei">Mei</option><option value="Juni">Juni</option>
                            <option value="Juli">Juli</option><option value="Agustus">Agustus</option><option value="September">September</option>
                            <option value="Oktober">Oktober</option><option value="November">November</option><option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="fw-bold mb-2">Minggu Ke-</label>
                        <select class="form-select form-control-custom" name="minggu_ke" required>
                            <option value="1">Minggu ke-1</option><option value="2">Minggu ke-2</option><option value="3">Minggu ke-3</option>
                            <option value="4">Minggu ke-4</option><option value="5">Minggu ke-5</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn-simpan py-2"><i class="fa-solid fa-magnifying-glass me-2"></i> Pratinjau Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPreviewLaporan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom bg-success border-success">
                <h5 class="modal-title modal-title-custom"><i class="fa-solid fa-file-invoice me-2"></i> Draf Pratinjau Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="text-center mb-4">
                    <h5 class="fw-bold">Laporan Keuangan Masjid</h5>
                    <p class="text-muted">Periode: {{ session('p_periode_gabungan') }}</p>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded border shadow-sm text-center">
                            <small class="text-muted fw-bold">Total Pemasukan</small>
                            <h4 class="text-success fw-bold m-0 mt-2">Rp {{ number_format(session('p_pemasukan'), 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded border shadow-sm text-center">
                            <small class="text-muted fw-bold">Total Pengeluaran</small>
                            <h4 class="text-danger fw-bold m-0 mt-2">Rp {{ number_format(session('p_pengeluaran'), 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white border-success border rounded shadow-sm text-center" style="border-width: 2px !important;">
                            <small class="text-muted fw-bold">SALDO AKHIR</small>
                            <h4 class="text-dark fw-bold m-0 mt-2">Rp {{ number_format(session('p_saldo'), 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning border-warning">
                    <i class="fa-solid fa-circle-info me-2"></i> Pastikan data pratinjau di atas sudah benar sebelum diajukan ke Ketua Masjid.
                </div>
            </div>
            
            <div class="modal-footer bg-white">
                <form action="{{ route('laporan.store') }}" method="POST" class="w-100 d-flex justify-content-end m-0">
                    @csrf
                    <input type="hidden" name="periode_bulan" value="{{ session('p_periode_gabungan') }}">
                    <input type="hidden" name="total_pemasukan" value="{{ session('p_pemasukan') }}">
                    <input type="hidden" name="total_pengeluaran" value="{{ session('p_pengeluaran') }}">
                    <input type="hidden" name="saldo_akhir" value="{{ session('p_saldo') }}">
                    
                    <button type="button" class="btn-batal me-2" data-bs-dismiss="modal">Tutup Pratinjau</button>
                    <button type="submit" class="btn-simpan bg-success border-success">
                        <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('manajemenKasLink').addEventListener('click', function() {
        let menu = document.getElementById('manajemenKasMenu');
        let icon = document.getElementById('manajemenKasIcon');
        if (menu.style.display === "block") { menu.style.display = "none"; icon.classList.remove('rotated'); } 
        else { menu.style.display = "block"; icon.classList.add('rotated'); }
    });

    function konfirmasiLogoutSidebar() {
        Swal.fire({ title: 'Yakin ingin keluar?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#12261E', confirmButtonText: 'Ya, Keluar!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { document.getElementById('formLogoutSidebar').submit(); } })
    }
</script>

@if(session('show_preview'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalPreviewLaporan'));
        myModal.show();
    });
</script>
@endif

@if(session('success'))
<script> Swal.fire({ title: 'Berhasil!', text: '{{ session('success') }}', icon: 'success', confirmButtonColor: '#12261E' }); </script>
@endif

@if(session('error'))
<script> Swal.fire({ title: 'Ditolak Sistem!', text: '{{ session('error') }}', icon: 'error', confirmButtonColor: '#dc3545' }); </script>
@endif

</body>
</html>