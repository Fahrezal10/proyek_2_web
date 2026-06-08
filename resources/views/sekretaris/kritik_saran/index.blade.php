<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak Saran - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #EEF2F0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: #12261E;
            min-height: 100vh;
            color: #FFFFFF;
            position: fixed;
            top: 0;
            left: 0;
            width: 16.666667%;
            z-index: 1000;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 16.666667%;
            padding-bottom: 50px;
        }

        .sidebar-brand {
            color: #FFFFFF;
            letter-spacing: 1px;
        }

        .sidebar-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #9CAEA5;
            letter-spacing: 1px;
        }

        .sidebar-link {
            color: #D1DCD6;
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.3s;
            cursor: pointer;
        }

        .sidebar-link i {
            width: 25px;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar-link:hover {
            background-color: #1D3A2E;
            color: #fff;
        }

        .sidebar-link.active {
            background-color: #798880;
            color: #FFFFFF;
            font-weight: bold;
        }

        .box-summary {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .box-summary:hover {
            transform: translateY(-5px);
        }

        .table-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header-custom {
            background-color: #12261E;
            color: #fff;
            font-weight: bold;
            padding: 15px 20px;
            font-size: 1.1rem;
            border-bottom: 3px solid #1E88E5;
        }
        
        /* CSS tambahan buat motong teks pesan yang kepanjangan */
        .text-truncate-2 { 
            display: -webkit-box; 
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            white-space: normal; 
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        
        <!-- SIDEBAR -->
        <div class="sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            <p class="sidebar-label mb-3">Menu Sekretaris</p>

            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('kegiatan') }}" class="sidebar-link">
                <i class="fa-solid fa-bullhorn"></i> Informasi Kegiatan
            </a>
            
            <!-- ROUTE BARU YANG DITAMBAHKAN -->
            <a href="{{ route('sekretaris.kritik_saran') }}" class="sidebar-link active">
                <i class="fa-solid fa-envelope-open-text"></i> Kotak Saran
            </a>

            <hr style="border-color: #274D3D;" class="mt-5 mb-4">
            <form action="/admin/logout" method="POST" class="d-grid mt-auto">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm fw-bold"
                    style="border-color: #dc3545; color: #dc3545; border-radius: 8px;">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            
            <!-- NAVBAR -->
            <div class="navbar-custom p-3 px-5 d-flex justify-content-between align-items-center bg-white shadow-sm mb-4">
                <h5 class="m-0 fw-bold" style="color: #12261E;">Kotak Kritik & Saran Warga</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-secondary">Halo, {{ $user->nama ?? 'Sekretaris' }}</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                        style="width: 42px; height: 42px; background-color: #12261E; color: white; font-size: 1.1rem;">
                        {{ strtoupper(substr($user->nama ?? 'S', 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="p-4 px-5 pt-2">
                
                <!-- SUMMARY BOXES -->
                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="box-summary border-bottom border-primary border-4 text-center h-100">
                            <div class="mb-3"><i class="fa-solid fa-inbox fs-1 text-primary"></i></div>
                            <small class="text-muted fw-bold text-uppercase">Total Semua Pesan</small>
                            <h2 class="fw-bold mt-2 text-dark">{{ $totalPesan ?? 0 }} Data</h2>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="box-summary border-bottom border-danger border-4 text-center h-100" style="background-color: #fffafb;">
                            <div class="mb-3"><i class="fa-solid fa-envelope-circle-check fs-1 text-danger"></i></div>
                            <small class="text-danger fw-bold text-uppercase">Pesan Baru (Belum Dibaca)</small>
                            <h2 class="fw-bold mt-2 text-dark">{{ $belumDibaca ?? 0 }} Pesan</h2>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="box-summary border-bottom border-success border-4 text-center h-100">
                            <div class="mb-3"><i class="fa-solid fa-envelope-open fs-1 text-success"></i></div>
                            <small class="text-muted fw-bold text-uppercase">Sudah Dibaca</small>
                            <h2 class="fw-bold mt-2 text-dark">{{ $sudahDibaca ?? 0 }} Pesan</h2>
                        </div>
                    </div>
                </div>

                <!-- TABLE SECTION -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-container">
                            
                            <!-- Header & Filter -->
                            <div class="table-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <span><i class="fa-regular fa-comments me-2"></i> Daftar Pesan Warga</span>
                                
                                <form action="" method="GET" class="d-flex gap-2 m-0">
                                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pesan / nama..." value="{{ request('search') }}" style="border-radius: 6px;">
                                    <select name="status" class="form-select form-select-sm" style="border-radius: 6px; width: 130px;">
                                        <option value="">Semua</option>
                                        <option value="Belum Dibaca" {{ request('status') == 'Belum Dibaca' ? 'selected' : '' }}>Pesan Baru</option>
                                        <option value="Sudah Dibaca" {{ request('status') == 'Sudah Dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-light text-dark" style="border-radius: 6px;"><i class="fa-solid fa-filter"></i></button>
                                    
                                    @if(request('search') || request('status'))
                                        <a href="{{ url()->current() }}" class="btn btn-sm btn-danger" style="border-radius: 6px;" title="Reset Filter"><i class="fa-solid fa-rotate-left"></i></a>
                                    @endif
                                </form>
                            </div>
                            
                            <!-- Table Data -->
                            <div class="p-4">
                                @if(isset($dataPesan) && count($dataPesan) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th style="width: 15%;">Tanggal</th>
                                                    <th style="width: 20%;">Pengirim</th>
                                                    <th style="width: 35%;">Cuplikan Pesan</th>
                                                    <th class="text-center" style="width: 15%;">Status</th>
                                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dataPesan as $pesan)
                                                    <tr style="{{ strtolower($pesan->status) == 'belum dibaca' ? 'background-color: rgba(220,53,69,0.04);' : '' }}">
                                                        <td class="text-muted" style="font-size: 0.9rem;">
                                                            <strong class="text-dark">{{ date('d M Y', strtotime($pesan->tanggal_kirim)) }}</strong><br>
                                                            <i class="fa-regular fa-clock me-1"></i>{{ date('H:i', strtotime($pesan->tanggal_kirim)) }} WIB
                                                        </td>
                                                        <td class="fw-bold">{{ $pesan->nama_pengirim }}</td>
                                                        <td>
                                                            <div class="text-muted text-truncate-2" style="font-size: 0.9rem;">
                                                                {{ $pesan->isi_pesan }}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(strtolower($pesan->status) == 'belum dibaca')
                                                                <span class="badge bg-danger rounded-pill px-3">Pesan Baru</span>
                                                            @else
                                                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">Dibaca</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="modal" data-bs-target="#bacaPesan{{ $pesan->id_pesan }}" style="border-radius: 6px;">
                                                                <i class="fa-solid fa-book-open me-1"></i> Buka
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL BACA PESAN UNTUK SETIAP BARIS -->
                                                    <div class="modal fade" id="bacaPesan{{ $pesan->id_pesan }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                                                                <div class="modal-header" style="background-color: #12261E; color: white; border-radius: 12px 12px 0 0;">
                                                                    <h5 class="modal-title fw-bold"><i class="fa-regular fa-envelope-open me-2 text-primary"></i>Detail Pesan</h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body p-4 text-start">
                                                                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                                                        <div>
                                                                            <small class="text-muted d-block fw-bold text-uppercase">Dari:</small>
                                                                            <span class="fw-bold fs-5 text-dark">{{ $pesan->nama_pengirim }}</span>
                                                                        </div>
                                                                        <div class="text-end">
                                                                            <small class="text-muted d-block fw-bold text-uppercase">Waktu Dikirim:</small>
                                                                            <span class="fw-bold text-dark">{{ date('d M Y, H:i', strtotime($pesan->tanggal_kirim)) }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="bg-light p-3 border" style="border-radius: 8px;">
                                                                        <p class="m-0 text-dark" style="line-height: 1.8; white-space: pre-wrap;">{{ $pesan->isi_pesan }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer border-0 pb-4 justify-content-center bg-white">
                                                                    <form action="{{ route('sekretaris.kritik_saran.baca', $pesan->id_pesan) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm" style="border-radius: 8px;">
                                                                            <i class="fa-solid fa-check-double me-2"></i>Tutup & Tandai Dibaca
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END MODAL -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    @if($dataPesan->hasPages())
                                    <div class="mt-4 d-flex justify-content-between align-items-center">
                                        <small class="text-muted fw-bold">Menampilkan {{ $dataPesan->firstItem() }} - {{ $dataPesan->lastItem() }} dari {{ $dataPesan->total() }} pesan</small>
                                        <nav>{{ $dataPesan->appends(request()->query())->links('pagination::bootstrap-5') }}</nav>
                                    </div>
                                    @endif
                                    
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fs-1 mb-3 opacity-50"></i>
                                        <p class="mb-0 fw-bold">Belum ada data pesan yang sesuai.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>