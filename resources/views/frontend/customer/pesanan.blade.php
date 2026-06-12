@extends('frontend.layouts.app')

@section('title', 'Pesanan Saya - Bolu Susu Lembang')

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

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
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

        .pesanan-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(13, 31, 60, 0.07);
            padding: 20px 24px;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .pesanan-card:hover {
            box-shadow: 0 8px 32px rgba(13, 31, 60, 0.13);
            transform: translateY(-2px);
        }

        .detail-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 99px;
            border: 2px solid var(--teal);
            color: var(--teal);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .detail-btn:hover {
            background: var(--teal);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
        }

        .shop-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 99px;
            background: var(--teal);
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: opacity 0.2s;
            margin-top: 16px;
        }

        .shop-btn:hover {
            opacity: 0.88;
        }

        .divider {
            height: 1px;
            background: #f1f5f9;
            margin: 12px 0;
        }
    </style>

    <!-- PAGE HEADER -->
    <div style="background: linear-gradient(170deg, #0d2a4a 0%, #0d3d4a 40%, #0d1f3c 100%); padding-top: 80px;">
        <div class="max-w-4xl mx-auto px-6 py-12">
            <p class="text-teal-300 text-xs font-medium tracking-widest uppercase mb-3">✦ Riwayat Transaksi</p>
            <h1 class="playfair text-4xl text-white font-bold">Pesanan Saya</h1>
            <p class="text-gray-400 mt-2 text-sm">Daftar seluruh pesanan yang pernah kamu buat</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-10">

        @if($pesanan->isEmpty())
            <div class="card empty-state">
                <div class="empty-icon">📦</div>
                <h2 class="cinzel text-xl font-bold mb-2" style="color:var(--navy)">Belum Ada Pesanan</h2>
                <p class="text-gray-500 text-sm">Kamu belum pernah melakukan pemesanan. Yuk mulai belanja!</p>
                <a href="{{ route('home') }}" class="shop-btn">🛍️ Mulai Belanja</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pesanan as $item)
                    @php
        $statusMap = [
            'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'status-pending', 'icon' => '🕐'],
            'diproses' => ['label' => 'Sedang Diproses', 'class' => 'status-diproses', 'icon' => '⚙️'],
            'dikirim' => ['label' => 'Dalam Pengiriman', 'class' => 'status-dikirim', 'icon' => '🚚'],
            'selesai' => ['label' => 'Pesanan Selesai', 'class' => 'status-selesai', 'icon' => '✅'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'status-dibatalkan', 'icon' => '❌'],
        ];
        $status = $statusMap[$item->status_pesanan] ?? ['label' => $item->status_pesanan, 'class' => 'status-pending', 'icon' => '📦'];
                    @endphp

                    <div class="pesanan-card">
                        <!-- Header row -->
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <span class="cinzel font-bold text-sm" style="color:var(--navy)">
                                    Pesanan #{{ $item->id_pesanan }}
                                </span>
                                <span class="text-gray-400 text-xs ml-2">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pesan)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <span class="status-badge {{ $status['class'] }}">
                                {{ $status['icon'] }} {{ $status['label'] }}
                            </span>
                        </div>

                        <div class="divider"></div>

                        <!-- Item preview -->
                        <div class="flex items-center gap-3 mb-3">
                            @if($item->detailPesanan->isNotEmpty())
                                @php $firstItem = $item->detailPesanan->first(); @endphp
                                <div style="
                                                    width: 52px; height: 52px; border-radius: 10px; flex-shrink: 0;
                                                    background: #f1f5f9 center/cover no-repeat;
                                                    {{ $firstItem->produk->foto ? 'background-image:url(\'' . asset('storage/' . $firstItem->produk->foto) . '\')' : '' }}
                                                "></div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">
                                        {{ $firstItem->produk->nama_produk }}
                                    </p>
                                    @if($item->detailPesanan->count() > 1)
                                        <p class="text-gray-400 text-xs">
                                            +{{ $item->detailPesanan->count() - 1 }} produk lainnya
                                        </p>
                                    @endif
                                </div>
                            @endif

                            <div class="text-right ml-auto">
                                <p class="text-xs text-gray-400">Total</p>
                                <p class="font-bold text-base" style="color:var(--teal)">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-1">
                            <p class="text-xs text-gray-400">
                                {{ $item->detailPesanan->sum('jumlah') }} item
                                &bull; {{ ucfirst($item->metode_bayar) }}
                            </p>
                            <a href="{{ route('pesanan.show', $item->id_pesanan) }}" class="detail-btn">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection