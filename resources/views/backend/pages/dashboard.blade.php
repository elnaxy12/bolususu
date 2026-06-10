@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="mobile-toggle" onclick="toggleMobile()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                    </button>
                    <div class="page-title">
                        <h2>@yield('page_title', 'Dashboard')</h2>
                        <p id="topbarDate">Sabtu, 26 April 2025</p>
                    </div>
                </div>
                <div class="topbar-right">
                    <div class="role-pill">
                        <div class="role-pill-dot"></div>
                        <span id="rolePillText">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                    <button class="top-btn" title="Notifikasi">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <div class="notif-dot"></div>
                    </button>
                </div>
            </div>

            <!-- Page content -->
            <div class="content">

                <!-- ═══ STATS ═══ -->
                <div class="stats-grid" id="statsGrid">
                    <!-- Owner stats -->
                    <div class="stat-card teal owner-only">
                        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="stat-label">Pendapatan Hari Ini</div>
                        <div class="stat-value">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                        <div class="stat-sub">Hari ini</div>
                    </div>
                    <div class="stat-card gold owner-only">
                        <div class="stat-icon"><i class="fas fa-box"></i></div>
                        <div class="stat-label">Total Transaksi</div>
                        <div class="stat-value">{{ $transaksiHariIni }}</div>
                        <div class="stat-sub">Hari ini</div>
                    </div>
                    <div class="stat-card navy owner-only">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-label">Total Karyawan</div>
                        <div class="stat-value">{{ $totalKaryawan }}</div>
                        <div class="stat-sub">Karyawan aktif</div>
                    </div>
                    <div class="stat-card red owner-only">
                        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="stat-label">Stok Hampir Habis</div>
                        <div class="stat-value">{{ $stokHampirHabis }}</div>
                        <div class="stat-sub">Produk perlu restock</div>
                    </div>

                    <!-- Karyawan stats -->
                    <div class="stat-card teal karyawan-only">
                        <div class="stat-icon"><i class="fas fa-cash-register"></i></div>
                        <div class="stat-label">Transaksi Hari Ini</div>
                        <div class="stat-value">{{ $transaksiSaya }}</div>
                        <div class="stat-sub">Transaksi kamu hari ini</div>
                    </div>
                    <div class="stat-card gold karyawan-only">
                        <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="stat-label">Item Terjual</div>
                        <div class="stat-value">{{ $itemTerjualHariIni }}</div>
                        <div class="stat-sub">Total item hari ini</div>
                    </div>
                    <div class="stat-card red karyawan-only">
                        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="stat-label">Stok Hampir Habis</div>
                        <div class="stat-value">{{ $stokHampirHabis }}</div>
                        <div class="stat-sub">Perlu lapor ke owner</div>
                    </div>
                    <div class="stat-card navy karyawan-only">
                        <div class="stat-icon"><i class="fas fa-print"></i></div>
                        <div class="stat-label">Struk Dicetak</div>
                        <div class="stat-value">{{ $strukDicetak }}</div>
                        <div class="stat-sub">Hari ini</div>
                    </div>
                </div>

                <!-- ═══ MAIN GRID ═══ -->
                <div class="content-grid">

                    <!-- Left col -->
                    <div style="display:flex; flex-direction:column; gap:20px;">

                        <!-- Transaksi Terbaru -->
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">Transaksi Terbaru</span>
                                <a class="card-action">Lihat Semua →</a>
                            </div>
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Waktu</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transaksiTerbaru as $t)
                                            <tr>
                                                <td>
                                                    <div class="product-cell">
                                                        <div class="product-thumb"><i class="fas fa-receipt"></i></div>
                                                        <div>
                                                            <div class="product-name">#{{ str_pad($t->id_transaksi, 5, '0', STR_PAD_LEFT) }}</div>
                                                            <div class="product-sku">{{ $t->details->count() }} item</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($t->created_at)->format('H:i') }}</td>
                                                <td><strong>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</strong></td>
                                                <td><span class="badge-status badge-lunas">Lunas</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center" style="padding:20px;color:#8a9ab5;">Belum ada transaksi hari ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Laporan ringkas (owner only) -->
                        <div class="card owner-only">
                            <div class="card-header">
                                <span class="card-title">Ringkasan Penjualan — 7 Hari</span>
                                @if(Auth::user()->role === 'owner')
                                    <a href="{{ route('laporan-penjualan') }}" class="card-action">Export →</a>
                                @endif
                            </div>
                            <div style="padding:20px 22px;">
                                <div style="display:flex; gap:24px; margin-bottom:18px;">
                                    <div>
                                        <p style="font-size:11px;color:#8a9ab5;font-weight:500;">Total Pemasukan</p>
                                        <p style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--navy)">
                                            Rp {{ number_format($grafik7Hari->sum('total'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div style="width:1px;background:#f0f4f8;"></div>
                                    <div>
                                        <p style="font-size:11px;color:#8a9ab5;font-weight:500;">Rata-rata/Hari</p>
                                        <p style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--navy)">
                                            Rp {{ number_format($grafik7Hari->avg('total'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <div style="display:flex; align-items:flex-end; gap:8px; height:70px;">
                                    @foreach($grafik7Hari as $g)
                                        @php $pct = $maxGrafik > 0 ? ($g['total'] / $maxGrafik) * 100 : 0; @endphp
                                        <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:4px;">
                                            <div style="width:100%; height:{{ max(4, $pct * 0.6) }}px; background:{{ $pct >= 100 ? 'var(--teal)' : 'rgba(26,158,143,0.2)' }}; border-radius:6px 6px 0 0;"
                                                onmouseover="this.style.background='var(--teal)'"
                                                onmouseout="this.style.background='{{ $pct >= 100 ? 'var(--teal)' : 'rgba(26,158,143,0.2)' }}'">
                                            </div>
                                            <p style="font-size:10px;color:#8a9ab5;">{{ $g['hari'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right col -->
                    <div style="display:flex; flex-direction:column; gap:20px;">

                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">Aksi Cepat</span>
                            </div>
                            <div class="quick-actions" id="quickActions">
                                <a href="{{ route('proses-transaksi') }}" class="qa-btn">
                                    <div class="qa-icon"><i class="fas fa-cash-register"></i></div>
                                    <span class="qa-label">Transaksi Baru</span>
                                </a>
                                <a href="{{ route('riwayat-transaksi') }}" class="qa-btn">
                                    <div class="qa-icon"><i class="fas fa-print"></i></div>
                                    <span class="qa-label">Lihat Riwayat</span>
                                </a>
                                @if(Auth::user()->role === 'owner')
                                    <a href="{{ route('karyawan.index') }}" class="qa-btn flex">
                                        <div class="qa-icon"><i class="fas fa-user-plus"></i></div>
                                        <span class="qa-label">Tambah Karyawan</span>
                                    </a>
                                    <a href="{{ route('laporan-penjualan') }}" class="qa-btn flex">
                                        <div class="qa-icon"><i class="fas fa-chart-bar"></i></div>
                                        <span class="qa-label">Export Laporan</span>
                                    </a>
                                @endif
                                <a href="{{ route('kelola-stok') }}" class="qa-btn karyawan-only">
                                    <div class="qa-icon"><i class="fas fa-box"></i></div>
                                    <span class="qa-label">Update Stok</span>
                                </a>
                                <a href="{{ route('riwayat-transaksi') }}" class="qa-btn karyawan-only">
                                    <div class="qa-icon"><i class="fas fa-history"></i></div>
                                    <span class="qa-label">Lihat Riwayat</span>
                                </a>
                            </div>
                        </div>

                        <!-- Stok Monitor -->
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">Monitor Stok</span>
                                <a class="card-action">Kelola →</a>
                            </div>
                            <div class="stock-list">
                                @forelse($monitorStok as $p)
                                    @php
                                        $pct = $p->stok_minimum > 0 ? min(100, ($p->jumlah_stok / ($p->stok_minimum * 3)) * 100) : 100;
                                        $tag = $p->jumlah_stok == 0 ? 'danger' : ($p->jumlah_stok <= $p->stok_minimum ? 'warn' : 'ok');
                                        $label = $p->jumlah_stok == 0 ? 'Habis' : ($tag === 'warn' ? 'Menipis' : 'Aman');
                                    @endphp
                                    <div class="stock-item">
                                        <div class="stock-emoji"><i class="fas fa-box"></i></div>
                                        <div style="flex:1; min-width:0;">
                                            <div class="stock-name">{{ $p->nama_produk }}</div>
                                            <div class="stock-count">{{ $p->jumlah_stok }} {{ $p->satuan }} tersisa</div>
                                        </div>
                                        <div style="width:80px;">
                                            <div class="stock-bar-wrap">
                                                <div class="stock-bar {{ $tag }}" style="width:{{ $pct }}%"></div>
                                            </div>
                                        </div>
                                        <span class="stock-tag {{ $tag }}">{{ $label }}</span>
                                    </div>
                                @empty
                                    <p style="text-align:center;color:#8a9ab5;padding:20px;font-size:13px;">Belum ada produk.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection