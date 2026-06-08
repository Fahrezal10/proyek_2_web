<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kegiatan - SMART-KAS</title>
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

        .btn-tambah {
            background-color: #1E88E5;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            transition: 0.3s;
            border: none;
            font-weight: bold;
        }

        .btn-tambah:hover {
            background-color: #1565C0;
            color: #fff;
            transform: translateY(-2px);
        }

        .table-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header-custom {
            background-color: #12261E;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            font-size: 1.1rem;
            border-bottom: 3px solid #1E88E5;
        }

        .table-subheader {
            background-color: #D1DCD6;
            color: #12261E;
            font-weight: bold;
        }

        .table> :not(caption)>*>* {
            padding: 15px;
            border-bottom-color: #EEF2F0;
            vertical-align: middle;
        }

        .modal-content-custom {
            border-radius: 16px;
            border: none;
            background-color: #F8FAF9;
        }

        .modal-header-custom {
            background-color: #12261E;
            color: white;
            border-radius: 16px 16px 0 0;
            padding: 20px;
            border-bottom: none;
            border-top: 5px solid #1E88E5;
        }

        .form-control-custom {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            background-color: #fff;
        }

        .btn-simpan {
            background-color: #1E88E5;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            padding: 10px 25px;
            border: none;
        }

        .poster-preview {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            <p class="sidebar-label mb-3">Menu Sekretaris</p>

            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('kegiatan') }}" class="sidebar-link active">
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

        <div class="main-content p-4 px-5">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <h4 class="fw-bold text-dark m-0">Manajemen Informasi Kegiatan</h4>

                <button class="btn-tambah shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKegiatan">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Kegiatan
                </button>
            </div>

            <div class="table-container">
                <div class="table-header-custom">Daftar Kegiatan Masjid</div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0">
                        <thead class="table-subheader">
                            <tr>
                                <th>No</th>
                                <th>Poster</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kegiatan as $key => $item)
                                <tr>
                                    <td class="fw-bold">{{ $key + 1 }}</td>
                                    <td>
                                        @if($item->poster)
                                            <img src="{{ asset('uploads/kegiatan/' . $item->poster) }}" alt="Poster"
                                                class="poster-preview shadow-sm">
                                        @else
                                            <span class="text-muted small">No Image</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-start">{{ $item->nama_kegiatan }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->tanggal_pelaksanaan)) }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditKegiatan{{ $item->id_kegiatan }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <form action="{{ route('kegiatan.destroy', $item->id_kegiatan) }}" method="POST"
                                            class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditKegiatan{{ $item->id_kegiatan }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content modal-content-custom">
                                            <div class="modal-header modal-header-custom">
                                                <h5 class="modal-title fw-bold"><i
                                                        class="fa-solid fa-pen-to-square me-2"></i> Edit Informasi Kegiatan
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4 text-start">
                                                <form action="{{ route('kegiatan.update', $item->id_kegiatan) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label class="fw-bold mb-2">Nama Kegiatan <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-custom"
                                                            name="nama_kegiatan" value="{{ $item->nama_kegiatan }}"
                                                            required>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="fw-bold mb-2">Tanggal Pelaksanaan <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="date" class="form-control form-control-custom"
                                                                name="tanggal_pelaksanaan"
                                                                value="{{ $item->tanggal_pelaksanaan }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="fw-bold mb-2">Lokasi <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-custom"
                                                                name="lokasi" value="{{ $item->lokasi }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="fw-bold mb-2">Deskripsi Kegiatan <span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control form-control-custom" name="deskripsi"
                                                            rows="3" required>{{ $item->deskripsi }}</textarea>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="fw-bold mb-2">Ganti Poster (Opsional)</label>
                                                        <input type="file" class="form-control form-control-custom"
                                                            name="poster" accept=".jpg,.jpeg,.png">
                                                        <small class="text-muted mt-1 d-block"><i
                                                                class="fa-solid fa-circle-info me-1"></i>Biarkan kosong jika
                                                            tidak ingin mengubah gambar.</small>
                                                    </div>

                                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                                        <button type="button"
                                                            class="btn btn-outline-dark fw-bold rounded-3 px-4"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn-simpan"><i
                                                                class="fa-solid fa-floppy-disk me-2"></i> Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted py-5 text-center">Belum ada data informasi kegiatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahKegiatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-bullhorn me-2"></i> Form Informasi Kegiatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">

                    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="fw-bold mb-2">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" name="nama_kegiatan"
                                placeholder="Contoh: Kajian Rutin Malam Jumat" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Tanggal Pelaksanaan <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-custom" name="tanggal_pelaksanaan"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-custom" name="lokasi"
                                    placeholder="Contoh: Ruang Utama Masjid" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold mb-2">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-custom" name="deskripsi" rows="3"
                                placeholder="Tuliskan detail kegiatan di sini..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold mb-2">Upload Poster (JPG/PNG, Max 2MB) <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-custom" name="poster"
                                accept=".jpg,.jpeg,.png" required>
                            <small class="text-muted mt-1 d-block"><i class="fa-solid fa-circle-info me-1"></i>Gambar
                                akan ditampilkan di halaman beranda warga.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-dark fw-bold rounded-3 px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-simpan"><i class="fa-solid fa-cloud-arrow-up me-2"></i>
                                Upload & Publikasikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if($errors->any())
        <script>
            Swal.fire({
                title: 'Gagal Menyimpan!',
                html: '<b>{!! implode("<br>", $errors->all()) !!}</b>',
                icon: 'warning',
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonColor: '#12261E'
            }); 
        </script>
    @endif

</body>

</html>