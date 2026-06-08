<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sekretaris - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            <p class="sidebar-label mb-3">Menu Sekretaris</p>

            <a href="{{ route('dashboard') }}" class="sidebar-link active">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('kegiatan') }}" class="sidebar-link">
                <i class="fa-solid fa-bullhorn"></i> Informasi Kegiatan
            </a>
            <a href="{{ route('sekretaris.kritik_saran') }}" class="sidebar-link">
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

        <div class="main-content">
            <div
                class="navbar-custom p-3 px-5 d-flex justify-content-between align-items-center bg-white shadow-sm mb-4">
                <h5 class="m-0 fw-bold" style="color: #12261E;">Sistem Informasi Manajemen Masjid</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-secondary">Halo, {{ $user->nama }}</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                        style="width: 42px; height: 42px; background-color: #12261E; color: white; font-size: 1.1rem;">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="p-4 px-5 pt-2">
                <h2 class="fw-bold mb-4" style="color: #12261E;">Halo, {{ $user->nama }}!</h2>
                <div class="alert shadow-sm border-0 mb-5"
                    style="background-color: #FFFFFF; color: #495057; border-radius: 12px; border-left: 6px solid #1E88E5;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="alert-heading fw-bold mb-1" style="color: #12261E;">Selamat Datang di SMART-KAS!
                            </h5>
                            <p class="mb-0">Anda saat ini login sebagai <strong
                                    style="color: #1E88E5;">{{ strtoupper($user->role) }}</strong>. Kelola informasi dan
                                publikasi jadwal kegiatan masjid dengan mudah dan terstruktur.</p>
                        </div>
                        <a href="{{ route('kegiatan') }}" class="btn btn-primary fw-bold shadow-sm"
                            style="border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i> Tambah Kegiatan
                        </a>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="box-summary border-bottom border-primary border-4 text-center h-100">
                            <div class="mb-3"><i class="fa-solid fa-bullhorn fs-1 text-primary"></i></div>
                            <small class="text-muted fw-bold text-uppercase">Total Semua Kegiatan</small>
                            <h2 class="fw-bold mt-2 text-dark">{{ $totalKegiatan ?? 0 }} Data</h2>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="box-summary border-bottom border-success border-4 text-center h-100">
                            <div class="mb-3"><i class="fa-solid fa-calendar-check fs-1 text-success"></i></div>
                            <small class="text-muted fw-bold text-uppercase">Kegiatan Mendatang</small>
                            <h2 class="fw-bold mt-2 text-dark">{{ $kegiatanMendatang ?? 0 }} Agenda</h2>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="box-summary border-bottom border-secondary border-4 text-center h-100">
                            <div class="mb-3"><i class="fa-solid fa-clock-rotate-left fs-1 text-secondary"></i></div>
                            <small class="text-muted fw-bold text-uppercase">Kegiatan Selesai</small>
                            <h2 class="fw-bold mt-2 text-dark">{{ $kegiatanSelesai ?? 0 }} Agenda</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="table-container">
                            <div class="table-header-custom d-flex justify-content-between align-items-center">
                                <span><i class="fa-solid fa-calendar-days me-2"></i> Jadwal Kegiatan Terdekat</span>
                                <a href="{{ route('kegiatan') }}" class="btn btn-sm btn-outline-light"
                                    style="border-radius: 6px; font-size: 0.8rem;">Lihat Semua</a>
                            </div>
                            <div class="p-4">
                                @if(isset($kegiatanTerdekat) && count($kegiatanTerdekat) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Lokasi</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($kegiatanTerdekat as $keg)
                                                    <tr>
                                                        <td class="fw-bold">
                                                            {{ date('d M Y', strtotime($keg->tanggal_pelaksanaan)) }}</td>
                                                        <td>{{ $keg->nama_kegiatan }}</td>
                                                        <td><i class="fa-solid fa-location-dot text-danger me-1"></i>
                                                            {{ $keg->lokasi }}</td>
                                                        <td class="text-center">
                                                            <span class="badge bg-success rounded-pill px-3">Segera</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-1 mb-3 opacity-50"></i>
                                        <p class="mb-0 fw-bold">Belum ada jadwal kegiatan terdekat.</p>
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