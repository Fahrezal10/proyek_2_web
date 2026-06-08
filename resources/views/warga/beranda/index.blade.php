<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --gold-accent: #E5C05C;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --dark-green: #12261E;
        }

        body, html {
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #0f1c16; 
        }

        /* HERO SECTION DENGAN BACKGROUND MASJID */
        .hero-section {
            position: relative; min-height: 100vh;
            background-image: url("{{ asset('assets/img/fotomasjid.png') }}");
            background-size: cover; background-position: center; background-attachment: fixed;
            display: flex; flex-direction: column;
        }

        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15, 28, 22, 0.95) 0%, rgba(20, 45, 35, 0.8) 100%);
            z-index: 1;
        }

        .content-wrapper { position: relative; z-index: 2; flex: 1; display: flex; flex-direction: column; }

        /* NAVBAR GLASSMORPHISM */
        .navbar-custom {
            background: var(--glass-bg); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border); border-radius: 50px; padding: 10px 30px; margin-top: 30px;
        }
        
        .logo-img { height: 55px; width: auto; object-fit: contain; }

        .nav-link {
            color: #ffffff !important; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; margin: 0 15px; transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: var(--gold-accent) !important; }

        /* TYPOGRAPHY HERO */
        .welcome-text { color: var(--gold-accent); text-transform: uppercase; letter-spacing: 3px; font-weight: 600; font-size: 1rem; margin-bottom: 15px; }
        .main-title { font-family: 'Playfair Display', serif; font-size: 4rem; font-weight: 700; color: #ffffff; line-height: 1.1; margin-bottom: 0; }
        .location-text { font-family: 'Great Vibes', cursive; color: var(--gold-accent); font-size: 3rem; margin-top: -5px; margin-bottom: 25px; }
        .desc-text { color: #e0e0e0; font-size: 1.1rem; line-height: 1.8; max-width: 90%; margin-bottom: 35px; }

        /* TOMBOL GLASSMORPHISM */
        .btn-glass {
            background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff; border-radius: 50px; padding: 12px 35px;
            font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; transition: 0.3s; cursor: pointer;
        }
        .btn-glass:hover { background: rgba(255, 255, 255, 0.3); color: #ffffff; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

        .logo-beranda { width: 100%; max-width: 450px; height: auto; object-fit: contain; margin: auto; display: block; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.3)); transition: transform 0.5s ease; }
        .logo-beranda:hover { transform: scale(1.03); }

        /* KUSTOMISASI MODAL BIAR ELEGAN */
        .modal-content-custom { border-radius: 16px; border: none; overflow: hidden; }
        .modal-header-custom { background: linear-gradient(135deg, var(--dark-green) 0%, #1a3a2d 100%); color: white; border-bottom: none; padding: 20px 25px; }
        .modal-body-custom { padding: 30px 25px; background-color: #F8F9FA; }
        .form-control, .form-select { border-radius: 8px; padding: 12px 15px; border: 1px solid #dee2e6; }
        .form-control:focus, .form-select:focus { border-color: var(--dark-green); box-shadow: 0 0 0 0.25rem rgba(18, 38, 30, 0.2); }
    </style>
</head>
<body>

    <div class="hero-section">
        <div class="hero-overlay"></div>
        
        <div class="content-wrapper container">
            <nav class="navbar navbar-expand-lg navbar-custom d-flex justify-content-between align-items-center mb-5">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/img/logoproyek2.png') }}" alt="Logo" class="logo-img">
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="fa-solid fa-bars text-white"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('warga.informasi') }}">Informasi</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Layanan</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('warga.pemasukan') }}">Pemasukan</a></li>
                                <li><a class="dropdown-item" href="{{ route('warga.pengeluaran') }}">Pengeluaran</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('warga.donasi') }}">Donasi</a></li>
                    </ul>
                </div>
                <div class="d-none d-lg-block" style="width: 55px;"></div> 
            </nav>

            <div class="row align-items-center flex-grow-1 pb-5">
                <div class="col-lg-7">
                    <div class="welcome-text">Selamat Datang</div>
                    <h1 class="main-title">Masjid Besar Al Istiqomah</h1>
                    <div class="location-text">Lohbener, Indramayu</div>
                    <p class="desc-text">
                        Simbol kebersamaan dan tata kelola umat yang transparan di Lohbener. Menjaga amanah, merajut kepedulian, demi kesejahteraan bersama.
                    </p>
                    
                    <button type="button" class="btn-glass" data-bs-toggle="modal" data-bs-target="#modalKritikSaran">
                        Kritik & Saran <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>

                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <img src="{{ asset('assets/img/logoproyek2.png') }}" alt="Logo" class="logo-beranda">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKritikSaran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-regular fa-comment-dots me-2 text-warning"></i>Kirim Kritik & Saran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="formKritikSaran" action="{{ route('warga.kritik_saran.store') }}" method="POST">
                    @csrf
                    <div class="modal-body modal-body-custom text-dark">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Nama / Hamba Allah (Opsional)</label>
                            <input type="text" name="nama_pengirim" class="form-control" placeholder="Boleh dikosongkan...">
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label fw-bold text-muted small">Isi Pesan / Saran <span class="text-danger">*</span></label>
                            <textarea id="isi_pesan" name="isi_pesan" class="form-control" rows="5" placeholder="Tuliskan kritik, saran, atau pertanyaan Anda di sini..."></textarea>
                        </div>

                    </div>
                    
                    <div class="modal-footer bg-white border-top-0 pt-0 pb-3 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn fw-bold px-4" style="background-color: var(--dark-green); color: var(--gold-accent);">
                            <i class="fa-solid fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('formKritikSaran').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            // Cek isi pesan sesuai ID baru
            let pesanValue = document.getElementById('isi_pesan').value.trim();

            // SKENARIO ALTERNATIF: Pesan Kosong
            if (pesanValue === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pesan Kosong!',
                    text: 'Harap isi pesan kritik atau saran Anda terlebih dahulu!',
                    confirmButtonColor: '#12261E',
                    confirmButtonText: 'Baik, mengerti'
                });
                return false;
            }

            // SKENARIO AWAL: Kirim ke Controller
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json()) // Parsing hasil JSON dari controller
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Terkirim!',
                    text: 'Terima kasih! Kritik dan saran Anda telah berhasil dikirim dan akan menjadi bahan evaluasi pengurus masjid.',
                    confirmButtonColor: '#E5C05C',
                    confirmButtonText: 'Selesai'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var modalObj = bootstrap.Modal.getInstance(document.getElementById('modalKritikSaran'));
                        modalObj.hide();
                        document.getElementById('formKritikSaran').reset();
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengirim pesan. Pastikan rute sudah di-set up.',
                });
            });
        });
    </script>
</body>
</html>