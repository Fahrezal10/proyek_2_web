<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gold-accent: #E5C05C;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --dark-green: #23342D;
            --darker-green: #15221D;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA;
        }

        /* HEADER MELENGKUNG */
        .header-curved {
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--darker-green) 100%);
            padding-top: 1px;
            padding-bottom: 120px;
            border-bottom-left-radius: 50% 15%;
            border-bottom-right-radius: 50% 15%;
            position: relative;
        }

        /* NAVBAR GLASSMORPHISM */
        .navbar-custom {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            padding: 10px 30px;
            margin-top: 30px;
        }
        
        .logo-img {
            height: 55px; 
            width: auto;
            object-fit: contain;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            margin: 0 15px;
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--gold-accent) !important;
        }

        /* TYPOGRAPHY JUDUL HALAMAN */
        .page-title {
            font-family: 'Playfair Display', serif;
            color: #FFFFFF;
            font-weight: 800;
            font-size: 3.5rem;
            letter-spacing: 2px;
            margin-top: 60px;
            margin-bottom: 10px;
        }
        .page-subtitle {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* CSS CARD INFORMASI NGEMBANG */
        .info-card {
            display: block;
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            height: 320px;
            text-decoration: none;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .info-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 30px rgba(0,0,0,0.2);
        }

        .info-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .info-card:hover img {
            transform: scale(1.05);
        }

        .card-overlay {
            position: absolute;
            bottom: 0; left: 0; width: 100%; height: 65%;
            background: linear-gradient(to top, rgba(21, 34, 29, 1) 0%, rgba(21, 34, 29, 0.7) 50%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 25px;
        }

        .text-line {
            width: 40px;
            height: 4px;
            background-color: #FFFFFF;
            margin-bottom: 15px;
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .info-card:hover .text-line {
            width: 60px;
        }

        .card-title-text {
            color: #FFFFFF;
            font-weight: 700;
            font-size: 1.1rem;
            line-height: 1.4;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="header-curved">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-custom d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/img/logoproyek2.png') }}" alt="Logo" class="logo-img">
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="fa-solid fa-bars text-white"></i>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('warga.informasi') }}">Informasi</a></li>
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

            <div class="text-center">
                <h1 class="page-title">INFORMASI</h1>
                <p class="page-subtitle">Masjid Besar Al Istiqomah</p>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -50px; margin-bottom: 80px; position: relative; z-index: 10;">
        <div class="row g-4">
            @forelse($informasiKegiatan as $item)
                <div class="col-md-4">
                    <a href="{{ route('warga.informasi.detail', $item->id_kegiatan) }}" class="info-card">
                        <img src="{{ asset('uploads/kegiatan/' . $item->poster) }}" alt="{{ $item->nama_kegiatan }}">
                        <div class="card-overlay">
                            <div class="text-line"></div>
                            <h3 class="card-title-text">{{ $item->nama_kegiatan }}</h3>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada informasi kegiatan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>