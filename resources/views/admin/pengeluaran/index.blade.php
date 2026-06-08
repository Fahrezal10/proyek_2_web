<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-width=1.0">
    <title>Catat Pengeluaran - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #EEF2F0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background-color: #12261E; min-height: 100vh; color: #FFFFFF; box-shadow: 4px 0 10px rgba(0,0,0,0.05); position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; }
        .main-content { margin-left: 16.666667%; }
        @media (max-width: 768px) { .sidebar { position: relative; height: auto; width: 100%; } .main-content { margin-left: 0; } }
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
        .btn-tambah { background-color: #dc3545; color: #fff; border-radius: 8px; padding: 10px 20px; transition: 0.3s; border: none; }
        .btn-tambah:hover { background-color: #b02a37; color: #fff; transform: translateY(-2px); }
        .table-container { background-color: #fff; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .table-header-custom { background-color: #12261E; color: #fff; font-weight: bold; text-align: center; padding: 15px; font-size: 1.1rem; border-bottom: 3px solid #dc3545; }
        .table-subheader { background-color: #D1DCD6; color: #12261E; font-weight: bold; }
        .table > :not(caption) > * > * { padding: 15px; border-bottom-color: #EEF2F0; }
        .table tbody tr:hover { background-color: #F8F9FA; }
        .aksi-icon { cursor: pointer; transition: 0.2s; font-size: 1.1rem; }
        .aksi-icon:hover { transform: scale(1.2); }
        .modal-content-custom { border-radius: 16px; border: none; background-color: #F8FAF9; }
        .modal-header-custom { background-color: #12261E; color: white; border-radius: 16px 16px 0 0; padding: 20px; border-bottom: none; border-top: 5px solid #dc3545;}
        .modal-title-custom { font-weight: bold; letter-spacing: 0.5px; }
        .form-label-custom { font-weight: 500; color: #333; margin-bottom: 5px; font-size: 0.95rem; }
        .form-control-custom { border-radius: 8px; border: 1px solid #ced4da; padding: 10px 15px; background-color: #fff; }
        .form-control-custom:focus { border-color: #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25); }
        .btn-batal { border: 1px solid #12261E; color: #12261E; font-weight: bold; border-radius: 8px; padding: 10px 25px; background-color: transparent; }
        .btn-batal:hover { background-color: #e9ecef; }
        .btn-simpan { background-color: #dc3545; color: white; font-weight: bold; border-radius: 8px; padding: 10px 25px; border: none; }
        .btn-simpan:hover { background-color: #b02a37; color: white; }
        .box-total { background-color: #f8d7da; border: 2px solid #dc3545; border-radius: 8px; padding: 15px; text-align: center; font-weight: bold; font-size: 1.2rem; color: #721c24; margin-top: 15px; transition: 0.3s; }
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
            <a href="/admin/laporan" class="sidebar-link"><i class="fa-solid fa-file-contract"></i> Laporan Keuangan</a>
            
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
                <div>
                    <span class="badge bg-light text-dark border p-2 px-3 rounded-pill shadow-sm">
                        <i class="fa-solid fa-wallet me-2 text-success"></i> Saldo Kas Saat Ini: <strong class="text-success fs-6">Rp. {{ number_format($saldoKas, 0, ',', '.') }}</strong>
                    </span>
                </div>
                <div class="d-flex justify-content-end mb-4 mt-2">
                    <button class="btn-tambah fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengeluaran">
                        <i class="fa-solid fa-plus me-2"></i> Tambah Pengeluaran
                    </button>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header-custom">Riwayat Pengeluaran</div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0">
                        <thead class="table-subheader">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Tanggal & Periode</th>
                                <th style="width: 20%;">Kategori</th>
                                <th style="width: 15%;">Nominal (Rp)</th>
                                <th style="width: 20%;">Keterangan</th>
                                <th style="width: 10%;">Bukti</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</div>
                                    <small class="text-muted">{{ $item->bulan ?? '-' }} (Mg {{ $item->minggu_ke ?? '-' }})</small>
                                </td>
                                <td>{{ $item->kategori }}</td>
                                <td class="text-danger fw-bold">- Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    @if($item->foto_bukti)
                                        <a href="{{ asset('uploads/bukti/'.$item->foto_bukti) }}" target="_blank" class="badge bg-secondary text-decoration-none">
                                            <i class="fa-solid fa-image"></i> Lihat Nota
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fa-solid fa-trash aksi-icon text-danger" title="Hapus" onclick="konfirmasiHapus({{ $item->id_transaksi }})"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-muted">Belum ada data pengeluaran tercatat.</td>
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

<div class="modal fade" id="modalTambahPengeluaran" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title modal-title-custom">Catat Pengeluaran Mingguan</h5>
                <button type="button" class="btn-close btn-close-white" onclick="cekBatal()"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                
                <form id="formPengeluaran" action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-4 bg-white p-3 rounded shadow-sm border">
                        <div class="col-md-6">
                            <label class="form-label-custom">Bulan Laporan</label>
                            <select class="form-select form-control-custom" name="bulan" required>
                                <option value="Januari">Januari</option><option value="Februari">Februari</option><option value="Maret">Maret</option>
                                <option value="April" selected>April</option><option value="Mei">Mei</option><option value="Juni">Juni</option>
                                <option value="Juli">Juli</option><option value="Agustus">Agustus</option><option value="September">September</option>
                                <option value="Oktober">Oktober</option><option value="November">November</option><option value="Desember">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Minggu Ke-</label>
                            <select class="form-select form-control-custom" name="minggu_ke" required>
                                <option value="1">Minggu ke-1</option><option value="2">Minggu ke-2</option><option value="3">Minggu ke-3</option>
                                <option value="4">Minggu ke-4</option><option value="5">Minggu ke-5</option>
                            </select>
                        </div>
                    </div>

                    <div id="wadah-item-pengeluaran">
                        <div class="baris-item border border-danger border-opacity-25 rounded p-3 mb-3 bg-white shadow-sm position-relative">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label-custom">Kategori</label>
                                    <select name="kategori[]" class="form-select form-control-custom" required>
                                        <option value="" selected disabled>-- Pilih Kategori --</option>
                                        <option value="Biaya Listrik">Biaya Listrik</option>
                                        <option value="Biaya Air (PDAM)">Biaya Air (PDAM)</option>
                                        <option value="Honor Penceramah / Imam">Honor Penceramah / Imam</option>
                                        <option value="Kebersihan & Pemeliharaan">Kebersihan & Pemeliharaan</option>
                                        <option value="Pembangunan / Renovasi">Pembangunan / Renovasi</option>
                                        <option value="Santunan Anak Yatim / Dhuafa">Santunan Anak Yatim / Dhuafa</option>
                                        <option value="Kegiatan Hari Besar Islam">Kegiatan Hari Besar Islam (PHBI)</option>
                                        <option value="Lain-lain">Lain-lain</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">Keterangan / Rincian</label>
                                    <input type="text" name="keterangan[]" class="form-control form-control-custom" placeholder="Contoh: Beli Token Listrik" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">Nominal (Rp)</label>
                                    <input type="number" name="nominal[]" class="form-control form-control-custom input-nominal" placeholder="0" required min="1" oninput="hitungTotal()">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">Foto Nota (Opsional)</label>
                                    <input class="form-control form-control-custom input-foto" type="file" name="foto_bukti[]" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-danger btn-sm mb-3 fw-bold" onclick="tambahBarisItem()">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Baris Pengeluaran
                    </button>

                    <div class="box-total">
                        TOTAL PENGELUARAN: Rp <span id="teksTotalNominal">0</span>
                    </div>

                </form>
            </div>
            <div class="modal-footer d-flex justify-content-end p-3 bg-white" style="border-top: 1px solid #e9ecef;">
                <button type="button" class="btn-batal me-2" onclick="cekBatal()">Batal</button>
                <button type="button" class="btn-simpan" onclick="validasiDanSimpan()">Simpan Pengeluaran</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // SCRIPT SIDEBAR
    document.getElementById('manajemenKasLink').addEventListener('click', function() {
        let menu = document.getElementById('manajemenKasMenu');
        let icon = document.getElementById('manajemenKasIcon');
        if (menu.style.display === "block") { menu.style.display = "none"; icon.classList.remove('rotated'); } 
        else { menu.style.display = "block"; icon.classList.add('rotated'); }
    });

    function konfirmasiLogoutSidebar() {
        Swal.fire({ title: 'Yakin ingin keluar?', text: "Anda akan keluar dari sesi SMART-KAS.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#12261E', confirmButtonText: 'Ya, Keluar!', cancelButtonText: 'Batal', borderRadius: '16px' }).then((result) => { if (result.isConfirmed) { document.getElementById('formLogoutSidebar').submit(); } })
    }

    const modalPengeluaran = new bootstrap.Modal(document.getElementById('modalTambahPengeluaran'));

    // SCRIPT TAMBAH BARIS
    let hitungBaris = 1;
    function tambahBarisItem() {
        hitungBaris++;
        const wadah = document.getElementById('wadah-item-pengeluaran');
        const htmlBaris = `
        <div class="baris-item border border-danger border-opacity-25 rounded p-3 mb-3 bg-white shadow-sm position-relative" id="baris-${hitungBaris}">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="hapusBaris('baris-${hitungBaris}')"></button>
            <div class="row g-3 mt-1">
                <div class="col-md-3">
                    <label class="form-label-custom">Kategori</label>
                    <select name="kategori[]" class="form-select form-control-custom" required>
                        <option value="" selected disabled>-- Pilih Kategori --</option>
                        <option value="Biaya Listrik">Biaya Listrik</option>
                        <option value="Biaya Air (PDAM)">Biaya Air (PDAM)</option>
                        <option value="Honor Penceramah / Imam">Honor Penceramah / Imam</option>
                        <option value="Kebersihan & Pemeliharaan">Kebersihan & Pemeliharaan</option>
                        <option value="Pembangunan / Renovasi">Pembangunan / Renovasi</option>
                        <option value="Santunan Anak Yatim / Dhuafa">Santunan Anak Yatim / Dhuafa</option>
                        <option value="Kegiatan Hari Besar Islam">Kegiatan Hari Besar Islam (PHBI)</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Keterangan / Rincian</label>
                    <input type="text" name="keterangan[]" class="form-control form-control-custom" placeholder="Keterangan..." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Nominal (Rp)</label>
                    <input type="number" name="nominal[]" class="form-control form-control-custom input-nominal" placeholder="0" required min="1" oninput="hitungTotal()">
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Foto Nota (Opsional)</label>
                    <input class="form-control form-control-custom input-foto" type="file" name="foto_bukti[]" accept=".jpg,.jpeg,.png">
                </div>
            </div>
        </div>`;
        wadah.insertAdjacentHTML('beforeend', htmlBaris);
    }

    function hapusBaris(id) {
        document.getElementById(id).remove();
        hitungTotal(); 
    }

    // FUNGSI HITUNG OTOMATIS
    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.input-nominal').forEach(inp => {
            total += parseInt(inp.value) || 0;
        });
        document.getElementById('teksTotalNominal').innerText = total.toLocaleString('id-ID');
    }

    // SCRIPT VALIDASI USE CASE SEKALIGUS SUBMIT
    function validasiDanSimpan() {
        // Validasi Skenario Alternatif 1
        let adaNominal = false;
        document.querySelectorAll('.input-nominal').forEach(inp => {
            if(parseInt(inp.value) > 0) adaNominal = true;
        });

        if(!adaNominal) {
            Swal.fire('Peringatan!', 'Harap isi minimal 1 rincian pengeluaran beserta nominalnya!', 'error');
            return;
        }

        // Validasi Skenario Alternatif 2
        let fileError = false;
        document.querySelectorAll('.input-foto').forEach(inp => {
            if(inp.files.length > 0) {
                let file = inp.files[0];
                let tipe = file.type;
                let sizeMB = file.size / (1024 * 1024);

                if(sizeMB > 2 || (tipe !== 'image/jpeg' && tipe !== 'image/png')) {
                    fileError = true;
                }
            }
        });

        if(fileError) {
            Swal.fire('Unggahan Gagal!', 'Format gambar harus JPG/PNG dan maksimal 2MB!', 'error');
            return;
        }

        // Kalau lolos semua, munculin konfirmasi simpan
        Swal.fire({
            title: 'Simpan Data Pengeluaran?', text: "Data yang disimpan akan mengurangi saldo kas masjid.", icon: 'question', showCancelButton: true,
            confirmButtonColor: '#dc3545', cancelButtonColor: '#12261E', confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Cek Lagi'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('formPengeluaran').submit(); }
        })
    }

    function cekBatal() {
        let nominal = 0;
        document.querySelectorAll('.input-nominal').forEach(inp => { nominal += parseInt(inp.value) || 0; });
        if (nominal > 0) {
            Swal.fire({ title: 'Batalkan Isian?', text: "Data yang sudah Anda masukkan akan hilang.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Batalkan!', cancelButtonText: 'Kembali' }).then((result) => {
                if (result.isConfirmed) { document.getElementById('formPengeluaran').reset(); hitungTotal(); modalPengeluaran.hide(); }
            })
        } else {
            document.getElementById('formPengeluaran').reset(); hitungTotal(); modalPengeluaran.hide();
        }
    }

    function konfirmasiHapus(id) {
        Swal.fire({ title: 'Hapus Data Ini?', text: "Nota dan riwayat ini tidak dapat dikembalikan!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('formHapus');
                form.action = '/admin/pengeluaran/' + id;
                form.submit();
            }
        });
    }
</script>

@if(session('success'))
<script> Swal.fire({ title: 'Berhasil!', text: '{{ session('success') }}', icon: 'success', confirmButtonColor: '#12261E' }); </script>
@endif

@if(session('error'))
<script> Swal.fire({ title: 'Gagal!', text: '{{ session('error') }}', icon: 'error', confirmButtonColor: '#dc3545' }); </script>
@endif

</body>
</html>