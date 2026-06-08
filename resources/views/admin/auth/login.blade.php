<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-width=1.0">
    <title>Login Pengurus - SmartKas</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body, html {
            height: 100%;
            font-family: 'Inter', sans-serif;
        }

        /* Latar Belakang & Overlay Gelap */
        .bg-image {
            /* TEMPAT GAMBAR BACKGROUND MASJID */
            background-image: url(''); 
            background-color: #2c3e35; 
            background-size: cover;
            background-position: center;
            height: 100%;
            width: 100%;
            position: absolute;
            z-index: -2;
        }

        .bg-overlay {
            background-color: rgba(21, 42, 32, 0.7); 
            height: 100%;
            width: 100%;
            position: absolute;
            z-index: -1;
        }

        /* Container & Card Login */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
        }

        .login-card {
            background-color: #152A20; 
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Bagian Logo */
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            gap: 12px;
        }

        .logo-img {
            /* TEMPAT GAMBAR LOGO MASJID */
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .logo-text {
            color: #D4B856; 
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
        }

        /* Form Input */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            color: #FFFFFF;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            background-color: #0B1812; 
            border: 1px solid #917C3F; 
            border-radius: 6px;
            padding: 14px 16px;
            padding-right: 45px; /* Tambahan ruang biar teks gak nabrak ikon mata */
            color: #FFFFFF;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            border-color: #D4B856; 
            box-shadow: 0 0 5px rgba(212, 184, 86, 0.3);
        }

        /* --- PERBAIKAN IKON MATA (Toggle Password) --- */
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px;
            height: 20px;
            color: #917C3F; /* Sekarang ikonnya warna emas gelap */
            transition: 0.3s;
        }

        .toggle-password:hover {
            color: #D4B856; /* Berubah jadi emas terang pas disorot mouse */
        }

        /* Tombol Login */
        .btn-login {
            width: 100%;
            background-color: #917C3F; 
            color: #D4B856;
            border: none;
            border-radius: 6px;
            padding: 14px;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #A38C48;
            color: #FFFFFF;
        }

        /* Pesan Error */
        .alert-error {
            background-color: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: center;
            border: 1px solid rgba(220, 53, 69, 0.5);
        }
    </style>
</head>
<body>

    <div class="bg-image"></div>
    <div class="bg-overlay"></div>

    <div class="login-wrapper">
        <div class="login-card">
            
            <div class="logo-section">
                <img src="{{ asset('assets/img/logoproyek2.png') }}" alt="Logo" class="logo-img">
                <div class="logo-text">SmartKas</div>
            </div>

            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/admin/login" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" class="form-input" placeholder="Masukan username" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="form-input" placeholder="Masukan kata sandi" required>
                        
                        <svg class="toggle-password" id="toggleIcon" onclick="togglePasswordVisibility()" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                            <line x1="3" y1="3" x2="21" y2="21" id="strike-line" style="display:none;"></line>
                        </svg>
                    </div>
                </div>

                <button type="submit" class="btn-login">LOGIN</button>
            </form>

        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const strikeLine = document.getElementById("strike-line");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                strikeLine.style.display = "block"; // Munculkan garis coret
            } else {
                passwordInput.type = "password";
                strikeLine.style.display = "none"; // Hilangkan garis coret
            }
        }
    </script>

</body>
</html>