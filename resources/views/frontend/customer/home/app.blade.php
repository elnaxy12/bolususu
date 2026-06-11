@extends('frontend.layouts.app')

@section('title', 'Bolu Susu Lembang - Kelembutan di Setiap Gigitan')

@section('content')
    <style>
        :root {
            --navy: #0d1f3c;
            --teal: #1a9e8f;
            --teal-light: #2dd4bf;
            --gold: #c9a84c;
            --gold-light: #e8c96e;
            --cream: #fdf6e3;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
            user-select: none;
        }

        /* ---- NAVBAR ---- */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            background: rgba(13, 31, 60, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.25);
        }

        /* ---- HERO ---- */
        .hero {
            min-height: 100vh;
            background: linear-gradient(170deg, #0d2a4a 0%, #0d3d4a 40%, #0d1f3c 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 70% 40%, rgba(26, 158, 143, 0.18) 0%, transparent 70%);
        }

        .mountain-bg {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 55%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320' preserveAspectRatio='none'%3E%3Cpath fill='%23103a48' d='M0,200 L180,80 L360,160 L480,40 L620,120 L720,20 L860,110 L1000,60 L1140,140 L1280,70 L1440,150 L1440,320 L0,320 Z'/%3E%3Cpath fill='%230d2e3a' d='M0,240 L200,160 L400,200 L560,130 L700,180 L880,110 L1040,170 L1200,120 L1440,190 L1440,320 L0,320 Z'/%3E%3Cpath fill='%230d1f3c' d='M0,280 L300,220 L600,260 L900,210 L1200,250 L1440,220 L1440,320 L0,320 Z'/%3E%3C/svg%3E") no-repeat bottom / cover;
        }

        .grass {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 80px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 80'%3E%3Cpath fill='%23112240' d='M0,60 Q20,20 40,55 Q60,10 80,50 Q100,5 120,48 Q140,15 160,52 Q180,8 200,50 Q220,12 240,55 Q260,20 280,52 Q300,8 320,48 Q340,18 360,55 Q380,10 400,50 Q420,5 440,52 Q460,15 480,48 Q500,8 520,55 Q540,20 560,52 Q580,10 600,50 Q620,5 640,55 Q660,18 680,52 Q700,8 720,48 Q740,15 760,55 Q780,12 800,50 Q820,8 840,52 Q860,18 880,48 Q900,5 920,55 Q940,20 960,50 Q980,10 1000,52 Q1020,15 1040,55 Q1060,8 1080,48 Q1100,18 1120,50 Q1140,5 1160,52 Q1180,20 1200,55 Q1220,10 1240,48 Q1260,18 1280,50 Q1300,8 1320,55 Q1340,20 1360,52 Q1380,10 1400,48 Q1420,15 1440,52 L1440,80 L0,80 Z' /%3E%3C/svg%3E") no-repeat bottom / cover;
        }

        /* ---- SECTION DIVIDER ---- */
        .divider-wave {
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        /* ---- CARDS ---- */
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(13, 31, 60, 0.10);
            transition: transform 0.35s cubic-bezier(.22, .61, .36, 1), box-shadow 0.35s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px rgba(13, 31, 60, 0.18);
        }

        .badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--gold);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 4px 10px;
            border-radius: 99px;
            text-transform: uppercase;
        }

        .add-btn {
            background: var(--navy);
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 12px 28px;
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: 14px;
            transition: background 0.2s, transform 0.15s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            background: var(--teal);
            transform: scale(1.04);
        }

        /* ---- GOLD DIVIDER LINE ---- */
        .gold-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        /* ---- TESTIMONIAL ---- */
        .testi-card {
            background: white;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 4px 24px rgba(13, 31, 60, 0.08);
            border-left: 4px solid var(--gold);
        }

        /* ---- ANIMATIONS ---- */
        @keyframes floatUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        .anim-up {
            animation: floatUp 0.8s ease both;
        }

        .anim-fade {
            animation: fadeIn 1s ease both;
        }

        .anim-scale {
            animation: scaleIn 0.9s ease both;
        }

        .delay-1 {
            animation-delay: 0.15s;
        }

        .delay-2 {
            animation-delay: 0.30s;
        }

        .delay-3 {
            animation-delay: 0.45s;
        }

        .delay-4 {
            animation-delay: 0.60s;
        }

        /* ---- SCROLL REVEAL ---- */
        .reveal {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ---- CART BUTTON FLOAT ---- */
        .cart-float {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 200;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--navy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 8px 32px rgba(13, 31, 60, 0.30);
            transition: transform 0.2s, background 0.2s;
            border: 2px solid var(--gold);
        }

        .cart-float:hover {
            transform: scale(1.1);
            background: var(--teal);
        }

        .cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--gold);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---- MISC ---- */
        .section-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
        }

        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .cinzel {
            font-family: 'Cinzel', serif;
        }

        .star {
            color: var(--gold);
        }

        input,
        textarea {
            font-family: 'DM Sans', sans-serif;
        }

        /* Qty control */
        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            font-weight: 700;
            border: 2px solid #e2e8f0;
            background: white;
            transition: all 0.15s;
        }

        .qty-btn:hover {
            background: var(--navy);
            color: white;
            border-color: var(--navy);
        }

        .toast {
            position: fixed;
            bottom: 100px;
            right: 28px;
            z-index: 300;
            background: var(--navy);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid var(--gold);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s;
            pointer-events: none;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>

    <section class="hero flex items-center pt-16" id="home">
        <div class="mountain-bg"></div>
        <div class="grass"></div>
        <div class="max-w-6xl mx-auto px-6 w-full relative z-10 py-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text -->
                <div>
                    <p class="section-label anim-up mb-4">✦ Original dari Lembang, Bandung</p>
                    <h1 class="playfair text-5xl md:text-7xl text-white leading-tight anim-up delay-1">
                        Kelembutan<br />
                        <em class="text-teal-300">di Setiap</em><br />
                        Gigitan
                    </h1>
                    <p class="text-gray-300 mt-6 text-lg leading-relaxed font-light anim-up delay-2 max-w-md">
                        Bolu susu khas Lembang berbahan susu segar pilihan dari peternakan lokal, dipanggang fresh
                        setiap hari untuk cita rasa terbaik.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-10 anim-up delay-3">
                        <a href="#produk"
                            class="bg-gradient-to-r from-teal-500 to-teal-400 text-white px-8 py-4 rounded-full font-semibold text-base hover:shadow-lg hover:shadow-teal-500/40 transition transform hover:-translate-y-0.5 active:scale-95">
                            Pesan Sekarang →
                        </a>
                        <a href="#tentang"
                            class="border border-white/30 text-white px-8 py-4 rounded-full font-medium text-base hover:bg-white/10 transition">
                            Pelajari Lebih
                        </a>
                    </div>
                    <!-- Stats -->
                    <div class="flex gap-10 mt-14 anim-up delay-4">
                        <div>
                            <p class="playfair text-4xl text-white font-bold">15+</p>
                            <p class="text-gray-400 text-sm mt-1">Tahun Berdiri</p>
                        </div>
                        <div class="w-px bg-white/20"></div>
                        <div>
                            <p class="playfair text-4xl text-white font-bold">50K+</p>
                            <p class="text-gray-400 text-sm mt-1">Pelanggan Puas</p>
                        </div>
                        <div class="w-px bg-white/20"></div>
                        <div>
                            <p class="playfair text-4xl text-white font-bold">100%</p>
                            <p class="text-gray-400 text-sm mt-1">Susu Segar Asli</p>
                        </div>
                    </div>
                </div>
                <!-- Logo / Visual -->
                <div class="flex justify-center anim-scale delay-2 relative">
                    <div
                        class="w-72 h-72 md:w-96 md:h-96 rounded-full bg-white/5 border border-white/10 flex items-center justify-center relative">
                        <div class="absolute inset-4 rounded-full border border-teal-500/20"></div>
                        <!-- Decorative dots -->
                        <div class="absolute top-8 right-8 w-3 h-3 rounded-full bg-gold-400"
                            style="background:var(--gold);opacity:.6"></div>
                        <div class="absolute bottom-12 left-8 w-2 h-2 rounded-full bg-teal-400 opacity-60"></div>
                        <div class="text-center px-8">
                            <div class="object-contain w-64 h-64 bg-no-repeat bg-center bg-contain"
                                style="background-image: url('{{ asset('images/LOGO-BSL-.png') }}');">
                            </div>
                            <div class="gold-line mt-4 mx-8"></div>
                            <p class="text-gray-400 text-xs mt-3 tracking-wide">EST. 2009</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FEATURES STRIP ============ -->
    <div class="bg-navy py-6" style="background:var(--navy)">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-x-12 gap-y-4 text-sm text-gray-300">
                <span class="flex items-center gap-2">🥛 <span>Susu Segar Lokal</span></span>
                <span class="flex items-center gap-2">🔥 <span>Fresh Dipanggang Tiap Hari</span></span>
                <span class="flex items-center gap-2">🚚 <span>Pengiriman Seluruh Indonesia</span></span>
                <span class="flex items-center gap-2">📦 <span>Kemasan Vakum Tahan 7 Hari</span></span>
                <span class="flex items-center gap-2">⭐ <span>4.9/5 Rating Pelanggan</span></span>
            </div>
        </div>
    </div>

    <!-- ============ PRODUK ============ -->
    <section id="produk" class="py-24 bg-cream" style="background:var(--cream)">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <p class="section-label mb-3">✦ Pilihan Terbaik Kami</p>
                <h2 class="playfair text-4xl md:text-5xl text-gray-900 font-bold">Menu Unggulan</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto leading-relaxed">Tersedia dalam berbagai varian rasa,
                    semua menggunakan susu segar pilihan dari Lembang.</p>
                <div class="gold-line mt-6 max-w-xs mx-auto"></div>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8" id="product-grid">
                <!-- Cards injected by JS -->
            </div>
        </div>
    </section>

    <!-- ============ TENTANG ============ -->
    <section id="tentang" class="py-24" style="background: #0d1f3c">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <p class="section-label mb-4">✦ Kisah Kami</p>
                    <h2 class="playfair text-4xl md:text-5xl text-white font-bold leading-tight">
                        Cita Rasa Asli<br /><em class="text-teal-300">dari Kaki Gunung</em>
                    </h2>
                    <p class="text-gray-300 mt-6 leading-relaxed font-light">
                        Bolu Susu Lembang lahir dari tradisi turun-temurun keluarga peternak di dataran tinggi Lembang,
                        Bandung. Dengan ketinggian 1.300 mdpl, susu yang kami gunakan memiliki tekstur lebih kental dan
                        rasa yang lebih kaya.
                    </p>
                    <p class="text-gray-300 mt-4 leading-relaxed font-light">
                        Setiap loyang dibuat dengan tangan, dipanggang dalam oven tradisional, dan dikemas dengan penuh
                        kasih sayang. Tidak ada pengawet, tidak ada bahan artifisial – hanya kesegaran alam Lembang.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-10">
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                            <p class="text-3xl mb-2">🌿</p>
                            <p class="text-white font-semibold">Tanpa Pengawet</p>
                            <p class="text-gray-400 text-sm mt-1">Bahan alami 100%</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                            <p class="text-3xl mb-2">🏔️</p>
                            <p class="text-white font-semibold">Susu Pegunungan</p>
                            <p class="text-gray-400 text-sm mt-1">1.300 mdpl Lembang</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                            <p class="text-3xl mb-2">👨‍🍳</p>
                            <p class="text-white font-semibold">Handmade Daily</p>
                            <p class="text-gray-400 text-sm mt-1">Fresh setiap pagi</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
                            <p class="text-3xl mb-2">📜</p>
                            <p class="text-white font-semibold">Resep Keluarga</p>
                            <p class="text-gray-400 text-sm mt-1">Warisan 3 generasi</p>
                        </div>
                    </div>
                </div>
                <div class="reveal delay-2">
                    <div class="relative">
                        <div class="w-full aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-teal-900 to-navy flex items-center justify-center"
                            style="background: linear-gradient(135deg, #0a3a4a, #0d1f3c)">
                            <div class="text-center">
                                <div class="object-contain w-72 h-72 bg-no-repeat bg-center bg-contain"
                                    style="background-image: url('{{ asset('images/products/product-0.png') }}')"></div>
                                <p class="cinzel text-white text-2xl font-bold">BOLU SUSU</p>
                                <p class="text-teal-300 tracking-widest text-sm mt-2">ORIGINAL LEMBANG</p>
                            </div>
                        </div>
                        <!-- Floating badge -->
                        <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-4 shadow-2xl">
                            <p class="text-xs text-gray-500 font-medium">Rating Pelanggan</p>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="text-2xl font-bold text-gray-900">4.9</span>
                                <div class="flex">
                                    <span class="star text-lg">★★★★★</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">dari 12.400+ ulasan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PROMO BANNER ============ -->
    <div class="py-16 relative overflow-hidden" style="background: linear-gradient(135deg, #1a9e8f, #0d6e62)">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-white" style="transform:translate(40%,-40%)">
            </div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-white" style="transform:translate(-30%,40%)">
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 reveal">
            <p class="text-teal-100 text-sm font-medium tracking-widest uppercase mb-3">Penawaran Spesial</p>
            <h2 class="playfair text-4xl md:text-5xl text-white font-bold">Gratis Ongkir<br />untuk Pembelian Min. 3
                Loyang</h2>
            <p class="text-teal-100 mt-4 text-lg">Berlaku untuk seluruh wilayah Jawa & Bali. Gunakan kode promo.</p>
            <div
                class="mt-8 inline-flex items-center gap-4 bg-white/20 backdrop-blur border border-white/30 rounded-2xl px-8 py-4">
                <span class="text-white text-lg font-light">Kode Promo:</span>
                <span class="cinzel text-white text-2xl font-bold tracking-widest">LEMBANG3</span>
                <button onclick="copyCode()"
                    class="bg-white text-teal-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-teal-50 transition">
                    Salin
                </button>
            </div>
        </div>
    </div>

    <!-- ============ TESTIMONI ============ -->
    <section id="testimoni" class="py-24" style="background:var(--cream)">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <p class="section-label mb-3">✦ Kata Mereka</p>
                <h2 class="playfair text-4xl md:text-5xl text-gray-900 font-bold">Pelanggan Setia Kami</h2>
                <div class="gold-line mt-6 max-w-xs mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="testi-card reveal">
                    <div class="flex gap-1 mb-3"><span class="star">★★★★★</span></div>
                    <p class="text-gray-700 leading-relaxed italic">"Bolu susu terenak yang pernah saya coba! Teksturnya
                        lembut banget, aroma susunya kerasa banget. Udah order berkali-kali, nggak pernah kecewa."</p>
                    <div class="flex items-center gap-3 mt-5">
                        <div
                            class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-sm">
                            SR</div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Sinta Rahayu</p>
                            <p class="text-gray-400 text-xs">Jakarta Selatan</p>
                        </div>
                    </div>
                </div>
                <div class="testi-card reveal delay-1">
                    <div class="flex gap-1 mb-3"><span class="star">★★★★★</span></div>
                    <p class="text-gray-700 leading-relaxed italic">"Selalu jadi pilihan hampers keluarga kami.
                        Kemasannya rapi, tahan lama, dan rasanya konsisten. Rekomended banget buat oleh-oleh dari
                        Bandung!"</p>
                    <div class="flex items-center gap-3 mt-5">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm">
                            BW</div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Budi Wibowo</p>
                            <p class="text-gray-400 text-xs">Surabaya</p>
                        </div>
                    </div>
                </div>
                <div class="testi-card reveal delay-2">
                    <div class="flex gap-1 mb-3"><span class="star">★★★★★</span></div>
                    <p class="text-gray-700 leading-relaxed italic">"Pesan online, datang masih fresh dan rapih. Varian
                        pandan favorit saya! Anak-anak juga suka banget. Harga worth it banget sama kualitasnya."</p>
                    <div class="flex items-center gap-3 mt-5">
                        <div
                            class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-bold text-sm">
                            DR</div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Dewi Ratnasari</p>
                            <p class="text-gray-400 text-xs">Yogyakarta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CARA ORDER ============ -->
    <section class="py-20" style="background: #f0f4f8">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-14 reveal">
                <p class="section-label mb-3">✦ Mudah & Cepat</p>
                <h2 class="playfair text-4xl text-gray-900 font-bold">Cara Pemesanan</h2>
            </div>
            <div class="grid sm:grid-cols-4 gap-8 text-center">
                <div class="reveal">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center text-2xl mx-auto mb-4"
                        style="border:2px solid var(--gold)">1️⃣</div>
                    <p class="font-semibold text-gray-800 mb-1">Pilih Produk</p>
                    <p class="text-gray-500 text-sm">Pilih varian dan jumlah yang diinginkan</p>
                </div>
                <div class="reveal delay-1">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center text-2xl mx-auto mb-4"
                        style="border:2px solid var(--gold)">2️⃣</div>
                    <p class="font-semibold text-gray-800 mb-1">Masukkan Keranjang</p>
                    <p class="text-gray-500 text-sm">Review pesanan sebelum checkout</p>
                </div>
                <div class="reveal delay-2">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center text-2xl mx-auto mb-4"
                        style="border:2px solid var(--gold)">3️⃣</div>
                    <p class="font-semibold text-gray-800 mb-1">Konfirmasi & Bayar</p>
                    <p class="text-gray-500 text-sm">Transfer bank, QRIS, atau COD tersedia</p>
                </div>
                <div class="reveal delay-3">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center text-2xl mx-auto mb-4"
                        style="border:2px solid var(--gold)">4️⃣</div>
                    <p class="font-semibold text-gray-800 mb-1">Terima & Nikmati!</p>
                    <p class="text-gray-500 text-sm">Dikirim fresh dalam 1-3 hari kerja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CART SIDEBAR ============ -->
    <div id="cart-overlay" class="fixed inset-0 bg-black/50 z-300 hidden" onclick="toggleCart()"></div>
    <div id="cart-sidebar"
        class="fixed top-0 right-0 h-full w-full max-w-sm bg-white z-400 transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col"
        style="z-index: 400;">
        <div class="p-6 flex items-center justify-between border-b" style="background:var(--navy)">
            <h3 class="cinzel text-white font-bold text-lg">Keranjang Belanja</h3>
            <button onclick="toggleCart()" class="text-white hover:text-gray-300 text-2xl leading-none">&times;</button>
        </div>
        <div id="cart-items" class="flex-1 overflow-y-auto p-6 space-y-4">
            <p id="cart-empty" class="text-gray-400 text-center py-12">Keranjang masih kosong</p>
        </div>
        <div class="p-6 border-t bg-gray-50">
            <div class="flex justify-between mb-4">
                <span class="font-medium text-gray-700">Total Pembayaran</span>
                <span class="font-bold text-xl" style="color:var(--navy)" id="cart-total">Rp 0</span>
            </div>
            <button onclick="checkout()"
                class="w-full py-4 rounded-xl text-white font-bold text-base transition hover:opacity-90 active:scale-98"
                style="background:var(--teal)">
                Lanjut ke Pembayaran →
            </button>
            <p class="text-center text-xs text-gray-400 mt-3">Transfer Bank · QRIS · COD tersedia</p>
        </div>
    </div>

    <!-- ============ KONTAK ============ -->
    <section id="kontak" class="py-24" style="background:var(--navy)">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-14 reveal">
                <p class="section-label mb-3">✦ Hubungi Kami</p>
                <h2 class="playfair text-4xl text-white font-bold">Ada Pertanyaan?</h2>
                <p class="text-gray-300 mt-4">Kami siap melayani Anda setiap hari pukul 08.00 – 21.00 WIB</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-5 reveal">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="flex items-center gap-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-5 transition group">
                        <div class="text-3xl">💬</div>
                        <div>
                            <p class="text-white font-semibold group-hover:text-teal-300 transition">WhatsApp</p>
                            <p class="text-gray-400 text-sm">+62 812-3456-7890</p>
                        </div>
                    </a>
                    <a href="https://instagram.com/bolulembang" target="_blank"
                        class="flex items-center gap-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-5 transition group">
                        <div class="text-3xl">📸</div>
                        <div>
                            <p class="text-white font-semibold group-hover:text-teal-300 transition">Instagram</p>
                            <p class="text-gray-400 text-sm">@bolulembang</p>
                        </div>
                    </a>
                    <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-5">
                        <div class="text-3xl">📍</div>
                        <div>
                            <p class="text-white font-semibold">Alamat Toko</p>
                            <p class="text-gray-400 text-sm">Jl. Raya Lembang No. 88, Bandung Barat</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 reveal delay-1">
                    <h3 class="text-white font-semibold mb-5">Kirim Pesan</h3>
                    <div class="space-y-4">
                        <input type="text" placeholder="Nama Anda"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 text-sm focus:outline-none focus:border-teal-400 transition" />
                        <input type="text" placeholder="No. WhatsApp / Email"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 text-sm focus:outline-none focus:border-teal-400 transition" />
                        <textarea placeholder="Pesan Anda..." rows="4"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 text-sm focus:outline-none focus:border-teal-400 transition resize-none"></textarea>
                        <button
                            class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90 active:scale-98"
                            style="background:var(--teal)">
                            Kirim Pesan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        @vite('resources/js/frontend/home.js')
    @endpush
@endsection