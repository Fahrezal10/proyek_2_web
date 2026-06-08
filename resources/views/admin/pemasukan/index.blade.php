<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-width=1.0">
    <title>Catat Pemasukan - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background-color: #12261E; min-height: 100vh; color: #FFFFFF; box-shadow: 4px 0 10px rgba(0,0,0,0.05); }
        .sidebar-brand { color: #FFFFFF; letter-spacing: 1px; }
        .sidebar-label { font-size: 0.8rem; text-transform: uppercase; color: #9CAEA5; letter-spacing: 1px; }
        .sidebar-link { color: #D1DCD6; text-decoration: none; padding: 12px 15px; display: flex; align-items: center; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .sidebar-link i { width: 25px; margin-right: 10px; font-size: 1.1rem; }
        .sidebar-link:hover { background-color: #1D3A2E; color: #fff; }
        .dropdown-menu-custom { background-color: #1D3A2E; border-radius: 8px; padding: 5px 0; margin-left: 10px; }
        .dropdown-link-custom { color: #D1DCD6; text-decoration: none; padding: 10px 15px; display: flex; align-items: center; border-radius: 6px; transition: 0.2s; margin: 0 5px; }
        .dropdown-link-custom i { width: 20px; margin-right: 10px; font-size: 0.9rem; }
        .dropdown-link-custom:hover { background-color: #274D3D; color: #fff; }
        .dropdown-link-custom.active { color: #1E88E5; font-weight: bold; background-color: rgba(30, 136, 229, 0.1); }
        .rotate-icon { transition: transform 0.3s ease; }
        .rotate-icon.rotated { transform: rotate(180deg); }
        .navbar-custom { background-color: #EEF2F0; }
        .btn-tambah { background-color: #12261E; color: #fff; border-radius: 8px; padding: 10px 20px; transition: 0.3s; border: none; }
        .btn-tambah:hover { background-color: #1D3A2E; color: #fff; transform: translateY(-2px); }
        .table-container { background-color: #fff; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .table-header-custom { background-color: #12261E; color: #fff; font-weight: bold; text-align: center; padding: 15px; font-size: 1.1rem; }
        .table-subheader { background-color: #D1DCD6; color: #12261E; font-weight: bold; }
        .table > :not(caption) > * > * { padding: 15px; border-bottom-color: #EEF2F0; }
        .table tbody tr:hover { background-color: #F8F9FA; }
        .aksi-icon { cursor: pointer; transition: 0.2s; font-size: 1.1rem; }
        .aksi-icon:hover { transform: scale(1.2); }
        .modal-content-custom { border-radius: 16px; border: none; background-color: #F8FAF9; }
        .modal-header-custom { background-color: #12261E; color: white; border-radius: 16px 16px 0 0; padding: 20px; border-bottom: none; }
        .modal-title-custom { font-weight: bold; letter-spacing: 0.5px; }
        .form-label-custom { font-weight: 500; color: #333; margin-bottom: 5px; font-size: 0.95rem; }
        .form-control-custom { border-radius: 8px; border: 1px solid #ced4da; padding: 10px 15px; background-color: #fff; }
        .form-control-custom:focus { border-color: #12261E; box-shadow: 0 0 0 0.2rem rgba(18, 38, 30, 0.25); }
        .box-total { background-color: #B9F6CA; border: 2px solid #12261E; border-radius: 8px; padding: 15px; text-align: center; font-weight: bold; font-size: 1.2rem; color: #000; margin-top: 15px; margin-bottom: 15px; transition: 0.3s; }
        .btn-batal { border: 1px solid #12261E; color: #12261E; font-weight: bold; border-radius: 8px; padding: 10px 25px; background-color: transparent; }
        .btn-batal:hover { background-color: #e9ecef; }
        .btn-simpan { background-color: #12261E; color: white; font-weight: bold; border-radius: 8px; padding: 10px 25px; border: none; }
        .btn-simpan:hover { background-color: #1D3A2E; color: white; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-4">
            <h4 class="text-center fw-bold sidebar-brand mb-4 mt-2">SMART-KAS</h4>
            <hr style="border-color: #274D3D;" class="mb-4">
            <p class="sidebar-label mb-3">Menu</p>
            <a href="/admin/dashboard" class="sidebar-link"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
            <div>
                <div class="sidebar-link d-flex justify-content-between align-items-center" id="manajemenKasLink">
                    <div class="d-flex align-items-center"><i class="fa-solid fa-briefcase"></i> Manajemen Kas</div>
                    <i class="fa-solid fa-chevron-down rotate-icon rotated" id="manajemenKasIcon"></i>
                </div>
                <div class="dropdown-menu-custom" id="manajemenKasMenu" style="display: block;">
                    <a href="/admin/pemasukan" class="dropdown-link-custom active"><i class="fa-solid fa-file-import"></i> Catat Pemasukan</a>
                    <a href="{{ route('pengeluaran') }}" class="dropdown-link-custom {{ request()->routeIs('pengeluaran') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-export"></i> Catat Pengeluaran
                    </a>
                </div>
            </div>
            <a href="{{ route('admin.donasi') }}" class="sidebar-link"><i class="fa-solid fa-heart-pulse"></i> Kelola Donasi</a>
            <a href="/admin/laporan" class="sidebar-link"><i class="fa-solid fa-file-contract"></i> Laporan Keuangan</a>
            <hr style="border-color: #274D3D;" class="mt-5 mb-4">
            <form action="/admin/logout" method="POST" class="d-grid mt-auto" id="formLogoutSidebar">
                @csrf
                <button type="button" onclick="konfirmasiLogoutSidebar()" class="btn btn-outline-light btn-sm fw-bold" style="border-color: #dc3545; color: #dc3545; border-radius: 8px;">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </div>

        <div class="col-md-10 p-4 px-5">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div>
                    <span class="badge bg-light text-dark border p-2 px-3 rounded-pill shadow-sm">
                        <i class="fa-solid fa-wallet me-2 text-success"></i> Saldo Kas Saat Ini: <strong class="text-success fs-6">Rp. {{ number_format($saldoKas, 0, ',', '.') }}</strong>
                    </span>
                </div>
            <div class="d-flex justify-content-end mb-4 mt-2">
                <button class="btn-tambah fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPemasukan">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Pemasukan
                </button>
            </div>
            </div>

            <div class="table-container">
                <div class="table-header-custom">Riwayat Pemasukan</div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0">
                        <thead class="table-subheader">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Periode</th>
                                <th style="width: 20%;">Kategori</th>
                                <th style="width: 20%;">Total (Rp)</th>
                                <th style="width: 15%;">Keterangan</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->bulan ?? '-' }} - Minggu {{ $item->minggu_ke ?? '-' }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <i class="fa-solid fa-pen-to-square aksi-icon text-success me-3" title="Edit" 
                                       onclick="bukaModalEdit({{ $item->id_transaksi }}, '{{ $item->kategori }}', {{ $item->nominal }}, '{{ $item->bulan }}', '{{ $item->minggu_ke }}', '{{ $item->keterangan ?? '' }}')"></i>
                                    
                                    <i class="fa-solid fa-trash aksi-icon text-danger" title="Hapus" 
                                       onclick="konfirmasiHapus({{ $item->id_transaksi }})"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-muted">Belum ada data pemasukan tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="formHapus" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<div class="modal fade" id="modalTambahPemasukan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title modal-title-custom">Tambah Pemasukan</h5>
                <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="cekBatal()"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formPemasukan" action="{{ route('pemasukan.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-custom">Bulan</label>
                                <select class="form-select form-control-custom" name="bulan" id="tambah_bulan">
                                    <option value="" selected disabled>-- Pilih Bulan --</option>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Minggu ke-</label>
                                <select class="form-select form-control-custom" name="minggu" id="tambah_minggu">
                                    <option value="" selected disabled>-- Pilih Minggu --</option>
                                    <option value="1">Minggu ke-1</option>
                                    <option value="2">Minggu ke-2</option>
                                    <option value="3">Minggu ke-3</option>
                                    <option value="4">Minggu ke-4</option>
                                    <option value="5">Minggu ke-5</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Infaq Jumat (Rp)</label>
                                <input type="number" class="form-control form-control-custom input-nominal" name="infaq_jumat" placeholder="0" min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Kotak Amal Harian (Rp)</label>
                                <input type="number" class="form-control form-control-custom input-nominal" name="kotak_amal" placeholder="0" min="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-custom">Zakat / Fidyah (Rp)</label>
                                <input type="number" class="form-control form-control-custom input-nominal" name="zakat" placeholder="0" min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Donasi Online (Rp)</label>
                                <input type="number" class="form-control form-control-custom input-nominal" name="donasi_online" placeholder="0" min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Pemasukan Lainnya (Rp)</label>
                                <input type="number" class="form-control form-control-custom input-nominal" name="pemasukan_lainnya" placeholder="0" min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Keterangan (Opsional)</label>
                                <textarea class="form-control form-control-custom" name="keterangan" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-total" id="boxTotalKeseluruhan">
                        TOTAL: Rp <span id="teksTotalNominal">0</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-end p-3" style="border-top: 1px solid #e9ecef;">
                <button type="button" class="btn-batal me-2" onclick="cekBatal()">Batal</button>
                <button type="button" class="btn-simpan" onclick="cekSimpan()">Simpan Pemasukan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPemasukan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title modal-title-custom">Edit Pemasukan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label-custom">Kategori Pemasukan</label>
                        <input type="text" class="form-control form-control-custom" id="edit_kategori" readonly style="background-color: #e9ecef;">
                        <small class="text-muted">Kategori tidak dapat diubah, hapus data jika salah kategori.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Bulan</label>
                            <select class="form-select form-control-custom" name="bulan" id="edit_bulan" required>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Minggu ke-</label>
                            <select class="form-select form-control-custom" name="minggu" id="edit_minggu" required>
                                <option value="1">Minggu ke-1</option>
                                <option value="2">Minggu ke-2</option>
                                <option value="3">Minggu ke-3</option>
                                <option value="4">Minggu ke-4</option>
                                <option value="5">Minggu ke-5</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Nominal (Rp)</label>
                        <input type="number" class="form-control form-control-custom" name="nominal" id="edit_nominal" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Keterangan (Opsional)</label>
                        <textarea class="form-control form-control-custom" name="keterangan" id="edit_keterangan" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-end p-3" style="border-top: 1px solid #e9ecef;">
                <button type="button" class="btn-batal me-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-simpan" onclick="cekUpdate()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // JS Sidebar Dropdown & Logout
    document.getElementById('manajemenKasLink').addEventListener('click', function() {
        let menu = document.getElementById('manajemenKasMenu');
        let icon = document.getElementById('manajemenKasIcon');
        if (menu.style.display === "block") {
            menu.style.display = "none"; icon.classList.remove('rotated');
        } else {
            menu.style.display = "block"; icon.classList.add('rotated');
        }
    });

    function konfirmasiLogoutSidebar() {
        Swal.fire({
            title: 'Yakin ingin keluar?', text: "Anda akan keluar dari sesi SMART-KAS.", icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', cancelButtonColor: '#12261E', confirmButtonText: 'Ya, Keluar!', cancelButtonText: 'Batal', borderRadius: '16px'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('formLogoutSidebar').submit(); }
        })
    }

    // JS Hitung Total
    const inputNominals = document.querySelectorAll('.input-nominal');
    const teksTotal = document.getElementById('teksTotalNominal');
    inputNominals.forEach(input => {
        input.addEventListener('input', function() {
            let total = 0;
            inputNominals.forEach(inp => { total += parseInt(inp.value) || 0; });
            teksTotal.innerText = total.toLocaleString('id-ID');
        });
    });

    // =====================================
    // LOGIKA JS UNTUK TAMBAH, EDIT, HAPUS
    // =====================================
    const modalPemasukan = new bootstrap.Modal(document.getElementById('modalTambahPemasukan'));
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditPemasukan'));

    function cekBatal() {
        let adaIsi = false;
        inputNominals.forEach(inp => { if(parseInt(inp.value) > 0) adaIsi = true; });
        if (adaIsi) {
            Swal.fire({
                title: 'Batalkan Isian?', text: "Data yang sudah Anda masukkan akan hilang.", icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Batalkan!', cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formPemasukan').reset(); teksTotal.innerText = "0"; modalPemasukan.hide();
                }
            })
        } else {
            modalPemasukan.hide();
        }
    }

    function cekSimpan() {
        const bulan = document.getElementById('tambah_bulan').value;
        const minggu = document.getElementById('tambah_minggu').value;
        let adaIsi = false;
        inputNominals.forEach(inp => { if(parseInt(inp.value) > 0) adaIsi = true; });

        if (bulan === "" || minggu === "") {
            Swal.fire('Oops!', 'Mohon pilih Bulan dan Minggu ke- terlebih dahulu.', 'error'); return;
        }
        if (!adaIsi) {
            Swal.fire('Oops!', 'Mohon isi minimal 1 nominal pemasukan.', 'error'); return;
        }

        Swal.fire({
            title: 'Simpan Pemasukan?', text: "Pastikan nominal yang dimasukkan sudah benar.", icon: 'question', showCancelButton: true,
            confirmButtonColor: '#12261E', cancelButtonColor: '#dc3545', confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('formPemasukan').submit(); }
        })
    }

    // FUNGSI BUKA MODAL EDIT DAN LEMPAR DATA
    function bukaModalEdit(id, kategori, nominal, bulan, minggu, keterangan) {
        document.getElementById('formEdit').action = '/admin/pemasukan/' + id;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_nominal').value = nominal;
        document.getElementById('edit_bulan').value = bulan;
        document.getElementById('edit_minggu').value = minggu;
        document.getElementById('edit_keterangan').value = keterangan;
        
        modalEdit.show();
    }

    // FUNGSI KONFIRMASI SIMPAN UPDATE
    function cekUpdate() {
        Swal.fire({
            title: 'Simpan Perubahan?', text: "Data pemasukan akan diperbarui.", icon: 'question', showCancelButton: true,
            confirmButtonColor: '#12261E', cancelButtonColor: '#dc3545', confirmButtonText: 'Ya, Update!', cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('formEdit').submit(); }
        });
    }

    // FUNGSI KONFIRMASI HAPUS
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Hapus Data Ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', 
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('formHapus');
                form.action = '/admin/pemasukan/' + id;
                form.submit();
            }
        });
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#12261E'
    });
</script>
@endif

</body>
</html>