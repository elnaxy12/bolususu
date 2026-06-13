@extends('frontend.layouts.app')

@section('title', 'Detail Pesanan - Bolu Susu Lembang')

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

            body {
                background: var(--cream);
                font-family: 'DM Sans', sans-serif;
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

            .playfair {
                font-family: 'Playfair Display', serif;
            }

            .cinzel {
                font-family: 'Cinzel', serif;
            }

            .gold-line {
                height: 2px;
                background: linear-gradient(90deg, transparent, var(--gold), transparent);
            }

            .card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 8px 40px rgba(13, 31, 60, 0.08);
            }

            .item-thumb {
                width: 64px;
                height: 64px;
                border-radius: 12px;
                background: #f1f5f9 center/cover no-repeat;
                flex-shrink: 0;
            }

            .item-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .item-row:last-child {
                border-bottom: none;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 14px;
                border-radius: 99px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .status-pending {
                background: #fef9c3;
                color: #854d0e;
            }

            .status-diproses {
                background: #dbeafe;
                color: #1e40af;
            }

            .status-dikirim {
                background: #e0f2fe;
                color: #0369a1;
            }

            .status-selesai {
                background: #dcfce7;
                color: #15803d;
            }

            .status-dibatalkan {
                background: #fee2e2;
                color: #b91c1c;
            }

            .info-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 10px 0;
                border-bottom: 1px solid #f1f5f9;
                font-size: 14px;
            }

            .info-row:last-child {
                border-bottom: none;
            }

            .info-label {
                color: #6b7280;
            }

            .info-value {
                color: #111827;
                font-weight: 500;
                text-align: right;
                max-width: 60%;
            }

            .step-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: relative;
                padding: 0 8px;
            }

            .step-bar::before {
                content: '';
                position: absolute;
                top: 20px;
                left: 8%;
                right: 8%;
                height: 2px;
                background: #e5e7eb;
                z-index: 0;
            }

            .step-bar .progress-line {
                position: absolute;
                top: 20px;
                left: 8%;
                height: 2px;
                background: var(--teal);
                z-index: 1;
                transition: width 0.5s ease;
            }

            .step {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
                z-index: 2;
            }

            .step-dot {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                background: #e5e7eb;
                border: 2px solid #e5e7eb;
                transition: all 0.3s;
            }

            .step.active .step-dot {
                background: var(--teal);
                border-color: var(--teal);
            }

            .step.done .step-dot {
                background: var(--teal);
                border-color: var(--teal);
            }

            .step-label {
                font-size: 11px;
                color: #9ca3af;
                font-weight: 500;
                text-align: center;
                white-space: nowrap;
            }

            .step.active .step-label,
            .step.done .step-label {
                color: var(--teal);
            }

            .back-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: var(--navy);
                font-weight: 500;
                font-size: 14px;
                text-decoration: none;
                padding: 8px 16px;
                border-radius: 99px;
                border: 2px solid #e5e7eb;
                transition: all 0.2s;
                background: white;
            }

            .back-btn:hover {
                border-color: var(--teal);
                color: var(--teal);
            }
        </style>

        <!-- PAGE HEADER -->
        <div style="background: linear-gradient(170deg, #0d2a4a 0%, #0d3d4a 40%, #0d1f3c 100%); padding-top: 80px;">
            <div class="max-w-4xl mx-auto px-6 py-12">
                <p class="text-teal-300 text-xs font-medium tracking-widest uppercase mb-3">✦ Detail Transaksi</p>
                <h1 class="playfair text-4xl text-white font-bold">Pesanan #{{ $pesanan->id_pesanan }}</h1>
                <p class="text-gray-400 mt-2 text-sm">
                    Dipesan pada {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-6 py-10">
            <div class="mb-6">
                <a href="{{ route('home') }}" class="back-btn">← Kembali ke Beranda</a>
            </div>

            <!-- STATUS TRACKER -->
            <div class="card p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="cinzel text-lg font-bold" style="color:var(--navy)">Status Pesanan</h2>
                    @php
    $statusMap = [
        'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'status-pending', 'icon' => '🕐'],
        'diproses' => ['label' => 'Sedang Diproses', 'class' => 'status-diproses', 'icon' => '⚙️'],
        'dikirim' => ['label' => 'Dalam Pengiriman', 'class' => 'status-dikirim', 'icon' => '🚚'],
        'selesai' => ['label' => 'Pesanan Selesai', 'class' => 'status-selesai', 'icon' => '✅'],
        'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'status-dibatalkan', 'icon' => '❌'],
    ];
    $current = $statusMap[$pesanan->status_pesanan] ?? ['label' => $pesanan->status_pesanan, 'class' => 'status-pending', 'icon' => '📦'];

    $steps = ['pending', 'diproses', 'dikirim', 'selesai'];
    $currentIdx = array_search($pesanan->status_pesanan, $steps);
    $progressPct = match ($pesanan->status_pesanan) {
        'pending' => '0%',
        'diproses' => '33%',
        'dikirim' => '66%',
        'selesai' => '90%',
        default => '0%',
    };
                    @endphp
                    <span class="status-badge {{ $current['class'] }}">
                        {{ $current['icon'] }} {{ $current['label'] }}
                    </span>
                </div>

                @if($pesanan->status_pesanan !== 'dibatalkan')
                    <div class="step-bar mt-4">
                        <div class="progress-line" style="width: {{ $progressPct }}"></div>
                        @foreach(['pending' => ['🕐', 'Menunggu'], 'diproses' => ['⚙️', 'Diproses'], 'dikirim' => ['🚚', 'Dikirim'], 'selesai' => ['✅', 'Selesai']] as $key => $info)
                            @php
            $idx = array_search($key, $steps);
            $cls = $idx < $currentIdx ? 'done' : ($idx == $currentIdx ? 'active' : '');
                            @endphp
                            <div class="step {{ $cls }}">
                                <div class="step-dot">{{ $info[0] }}</div>
                                <span class="step-label">{{ $info[1] }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- ITEMS -->
                <div class="md:col-span-2 space-y-6">
                    <div class="card p-6">
                        <h2 class="cinzel text-lg font-bold mb-2" style="color:var(--navy)">Item Pesanan</h2>
                        <div class="gold-line mb-4"></div>
                        @foreach($pesanan->detailPesanan as $detail)
                            <div class="item-row">
                                <div class="flex items-center gap-4">
                                    <div class="item-thumb" @if($detail->produk->foto)
                                    style="background-image:url('{{ asset('storage/' . $detail->produk->foto) }}')" @endif>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $detail->produk->nama_produk }}</p>
                                        <p class="text-gray-400 text-sm">{{ $detail->jumlah }} x Rp
                                            {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- ALAMAT -->
                    <div class="card p-6">
                        <h2 class="cinzel text-lg font-bold mb-2" style="color:var(--navy)">Alamat Pengiriman</h2>
                        <div class="gold-line mb-4"></div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">📍</span>
                            <p class="text-gray-700 leading-relaxed text-sm">{{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                    </div>
                </div>

                <!-- RINGKASAN -->
                <div class="space-y-6">
                    <div class="card p-6">
                        <h2 class="cinzel text-lg font-bold mb-2" style="color:var(--navy)">Ringkasan</h2>
                        <div class="gold-line mb-4"></div>

                        <div class="info-row">
                            <span class="info-label">No. Pesanan</span>
                            <span class="info-value">#{{ $pesanan->id_pesanan }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal</span>
                            <span
                                class="info-value">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Metode Bayar</span>
                            <span class="info-value">{{ ucfirst($pesanan->metode_bayar) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Item</span>
                            <span class="info-value">{{ $pesanan->detailPesanan->sum('jumlah') }} item</span>
                        </div>

                        <div class="mt-4 pt-4 border-t-2 border-gray-100 flex justify-between items-center">
                            <span class="font-bold text-gray-900">Total Bayar</span>
                            <span class="font-bold text-xl" style="color:var(--teal)">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- BANTUAN -->
                    <div class="card p-6" style="background: var(--navy)">
                        <h3 class="text-white font-semibold mb-3">Butuh Bantuan?</h3>
                        <p class="text-gray-400 text-sm mb-4">Hubungi kami jika ada pertanyaan tentang pesanan ini.</p>
                        <a href="https://wa.me/6285694576569?text=Halo, saya ingin bertanya tentang pesanan %23{{ $pesanan->id_pesanan }}"
                            target="_blank"
                            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-white font-semibold text-sm transition hover:opacity-90"
                            style="background: var(--teal)">
                            💬 Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
@endsection