<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar — Bolu Susu Lembang</title>
    <link rel="icon" href="{{ asset('images/LOGO-BSL-.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&family=Cinzel:wght@600&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --navy: #0d1f3c;
            --teal: #1a9e8f;
            --teal-light: #2dd4bf;
            --gold: #c9a84c;
            --gold-light: #e8c96e;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(170deg, #0d2a4a 0%, #0d3d4a 40%, #0d1f3c 100%);
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 70% 40%, rgba(26, 158, 143, 0.18) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .mountain-bg {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 55%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320' preserveAspectRatio='none'%3E%3Cpath fill='%23103a48' d='M0,200 L180,80 L360,160 L480,40 L620,120 L720,20 L860,110 L1000,60 L1140,140 L1280,70 L1440,150 L1440,320 L0,320 Z'/%3E%3Cpath fill='%230d2e3a' d='M0,240 L200,160 L400,200 L560,130 L700,180 L880,110 L1040,170 L1200,120 L1440,190 L1440,320 L0,320 Z'/%3E%3Cpath fill='%230d1f3c' d='M0,280 L300,220 L600,260 L900,210 L1200,250 L1440,220 L1440,320 L0,320 Z'/%3E%3C/svg%3E") no-repeat bottom / cover;
            pointer-events: none;
            z-index: 0;
        }

        .grass {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 80px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 80'%3E%3Cpath fill='%23112240' d='M0,60 Q20,20 40,55 Q60,10 80,50 Q100,5 120,48 Q140,15 160,52 Q180,8 200,50 Q220,12 240,55 Q260,20 280,52 Q300,8 320,48 Q340,18 360,55 Q380,10 400,50 Q420,5 440,52 Q460,15 480,48 Q500,8 520,55 Q540,20 560,52 Q580,10 600,50 Q620,5 640,55 Q660,18 680,52 Q700,8 720,48 Q740,15 760,55 Q780,12 800,50 Q820,8 840,52 Q860,18 880,48 Q900,5 920,55 Q940,20 960,50 Q980,10 1000,52 Q1020,15 1040,55 Q1060,8 1080,48 Q1100,18 1120,50 Q1140,5 1160,52 Q1180,20 1200,55 Q1220,10 1240,48 Q1260,18 1280,50 Q1300,8 1320,55 Q1340,20 1360,52 Q1380,10 1400,48 Q1420,15 1440,52 L1440,80 L0,80 Z' /%3E%3C/svg%3E") no-repeat bottom / cover;
            pointer-events: none;
            z-index: 0;
        }

        .dot {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .dot-gold {
            width: 10px;
            height: 10px;
            background: var(--gold);
            opacity: .5;
            top: 18%;
            right: 18%;
        }

        .dot-teal {
            width: 7px;
            height: 7px;
            background: var(--teal-light);
            opacity: .5;
            bottom: 22%;
            left: 14%;
        }

        .dot-gold2 {
            width: 6px;
            height: 6px;
            background: var(--gold);
            opacity: .35;
            top: 60%;
            right: 12%;
        }

        .card {
            background: rgba(13, 31, 60, 0.55);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 24px;
            padding: 2.4rem 2.2rem 2.2rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.06);
            animation: fadeUp 0.65s cubic-bezier(.22, .61, .36, 1) both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .logo-ring {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(26, 158, 143, 0.1);
            border: 1.5px solid rgba(26, 158, 143, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            position: relative;
        }

        .logo-ring::before {
            content: '';
            position: absolute;
            inset: 6px;
            border-radius: 50%;
            border: 1px solid rgba(201, 168, 76, 0.2);
        }

        .logo-ring img {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 900;
            color: #fff;
            text-align: center;
            margin-bottom: 4px;
        }

        .brand-tagline {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 3px;
            text-transform: uppercase;
            text-align: center;
        }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.2rem 0 1.5rem;
        }

        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.35), transparent);
        }

        .section-divider span {
            color: var(--gold);
            font-size: 11px;
            opacity: .8;
        }

        .alert {
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 14px;
        }

        .alert-error {
            background: rgba(220, 80, 80, 0.12);
            border: 1px solid rgba(220, 80, 80, 0.35);
            color: #f4a0a0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 7px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        input[type="tel"] {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            padding: 0 14px;
            height: 48px;
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        input:focus {
            border-color: rgba(26, 158, 143, 0.65);
            background: rgba(26, 158, 143, 0.08);
            box-shadow: 0 0 0 3px rgba(26, 158, 143, 0.12);
        }

        input.is-invalid {
            border-color: rgba(220, 80, 80, 0.65) !important;
            box-shadow: 0 0 0 3px rgba(220, 80, 80, 0.1) !important;
        }

        .invalid-feedback {
            font-size: 12px;
            color: #f4a0a0;
            margin-top: 5px;
        }

        .pass-wrap {
            position: relative;
        }

        .pass-wrap input {
            padding-right: 46px;
        }

        .pass-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            padding: 0;
            transition: color .2s;
        }

        .pass-toggle:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-register {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, var(--teal) 0%, #0d6e62 100%);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
            cursor: pointer;
            margin-bottom: 1.2rem;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            position: relative;
            overflow: hidden;
        }

        .btn-register::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0);
            transition: background .2s;
        }

        .btn-register:hover::after {
            background: rgba(255, 255, 255, 0.07);
        }

        .btn-register:hover {
            box-shadow: 0 8px 32px rgba(26, 158, 143, 0.35);
        }

        .btn-register:active {
            transform: scale(0.984);
        }

        .btn-register:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .login-row {
            text-align: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.35);
        }

        .login-row a {
            color: var(--gold);
            font-weight: 600;
            text-decoration: none;
            transition: color .2s;
        }

        .login-row a:hover {
            color: var(--gold-light);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            /* IE dan Edge lama */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body>

    <div class="mountain-bg"></div>
    <div class="grass"></div>
    <div class="dot dot-gold"></div>
    <div class="dot dot-teal"></div>
    <div class="dot dot-gold2"></div>

    <div class="card overflow-y-scroll scrollbar-hide" style="max-height: 90vh;">

        <div class="logo-area">
            <div class="logo-ring">
                <img src="{{ asset('images/LOGO-BSL-.png') }}" alt="Logo Bolu Susu Lembang" />
            </div>
            <h1 class="brand-name">Bolu Susu Lembang</h1>
            <p class="brand-tagline">Daftar Akun Baru</p>
        </div>

        <div class="section-divider"><span>✦</span></div>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama kamu"
                        class="{{ $errors->has('nama') ? 'is-invalid' : '' }}" />
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                        class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}" />
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@kamu.com"
                    autocomplete="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Pengiriman</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}"
                    placeholder="Jl. Contoh No. 1, Kota" class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}" />
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="pass-wrap">
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter"
                        autocomplete="new-password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" />
                    <button type="button" class="pass-toggle" onclick="togglePass('password', 'eye1')"
                        aria-label="Lihat password">
                        <svg id="eye1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="pass-wrap">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password" autocomplete="new-password" />
                    <button type="button" class="pass-toggle" onclick="togglePass('password_confirmation', 'eye2')"
                        aria-label="Lihat konfirmasi password">
                        <svg id="eye2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-register" id="submitBtn">Buat Akun</button>
        </form>

        <div class="login-row">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</div>
    </div>

    </div>

    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2"/>`
                : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        }

        document.getElementById('registerForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.textContent = 'Memproses...';
        });
    </script>

</body>

</html>