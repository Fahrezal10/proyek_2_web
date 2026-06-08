<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kegiatan->nama_kegiatan }} - SMART-KAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
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

        /* HEADER MELENGKUNG UDAH FIX MARGINNYA */
        .header-curved {
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--darker-green) 100%);
            padding-top: 30px; /* Fix celah putih atas */
            padding-bottom: 80px; 
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
            /* margin-top dihapus biar gak nabrak ke atas */
        }
        
        .logo-img { height: 55px; width: auto; object-fit: contain; }

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

        /* KONTEN ARTIKEL */
        .article-container {
            margin-top: -30px; 
            position: relative;
            z-index: 10;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            padding: 40px;
            margin-bottom: 80px;
        }

        .article-title {
            font-family: 'Playfair Display', serif;
            color: var(--darker-green);
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .article-meta span i {
            color: var(--gold-accent);
            margin-right: 8px;
        }

        .article-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .article-content {
            font-size: 1.1rem;
            color: #495057;
            line-height: 1.8;
            text-align: justify;
            white-space: pre-line;
        }

        .btn-back {
            color: var(--dark-green);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: 0.3s;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            color: var(--gold-accent);
            transform: translateX(-5px);
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
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="article-container">
                    
                    <a href="{{ route('warga.informasi') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Informasi
                    </a>

                    <h1 class="article-title">{{ $kegiatan->nama_kegiatan }}</h1>
                    
                    <div class="article-meta">
                        <span><i class="fa-solid fa-calendar-days"></i> {{ date('d F Y', strtotime($kegiatan->tanggal_pelaksanaan)) }}</span>
                        <span><i class="fa-solid fa-location-dot"></i> {{ $kegiatan->lokasi }}</span>
                    </div>

                    @if($kegiatan->poster)
                        <img src="{{ asset('uploads/kegiatan/' . $kegiatan->poster) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="article-image">
                    @endif

                    <div class="article-content">{{ $kegiatan->deskripsi }}</div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>