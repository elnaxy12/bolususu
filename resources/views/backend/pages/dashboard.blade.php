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
                        <div class="stat-value">Rp 2,4jt</div>
                        <div class="stat-sub"><span class="stat-up">↑ 12%</span> vs kemarin</div>
                    </div>
                    <div class="stat-card gold owner-only">
                        <div class="stat-icon"><i class="fas fa-box"></i></div>
                        <div class="stat-label">Total Transaksi</div>
                        <div class="stat-value">38</div>
                        <div class="stat-sub"><span class="stat-up">↑ 5</span> dari kemarin</div>
                    </div>
                    <div class="stat-card navy owner-only">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-label">Total Karyawan</div>
                        <div class="stat-value">8</div>
                        <div class="stat-sub">3 shift aktif hari ini</div>
                    </div>
                    <div class="stat-card red owner-only">
                        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="stat-label">Stok Hampir Habis</div>
                        <div class="stat-value">3</div>
                        <div class="stat-sub">Produk perlu restock</div>
                    </div>

                    <!-- Karyawan stats -->
                    <div class="stat-card teal karyawan-only">
                        <div class="stat-icon"><i class="fas fa-cash-register"></i></div>
                        <div class="stat-label">Transaksi Hari Ini</div>
                        <div class="stat-value">14</div>
                        <div class="stat-sub">Shift kamu: 08.00–16.00</div>
                    </div>
                    <div class="stat-card gold karyawan-only">
                        <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="stat-label">Item Terjual</div>
                        <div class="stat-value">67</div>
                        <div class="stat-sub">Total loyang hari ini</div>
                    </div>
                    <div class="stat-card red karyawan-only">
                        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="stat-label">Stok Hampir Habis</div>
                        <div class="stat-value">3</div>
                        <div class="stat-sub">Perlu lapor ke owner</div>
                    </div>
                    <div class="stat-card navy karyawan-only">
                        <div class="stat-icon"><i class="fas fa-print"></i></div>
                        <div class="stat-label">Struk Dicetak</div>
                        <div class="stat-value">14</div>
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
                                        <tr>
                                            <td>
                                                <div class="product-cell">
                                                    <div class="product-thumb"><i class="fas fa-bread-slice"></i></div>
                                                    <div>
                                                        <div class="product-name">Bolu Susu Original</div>
                                                        <div class="product-sku">2 loyang</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>09:14</td>
                                            <td><strong>Rp 80.000</strong></td>
                                            <td><span class="badge-status badge-lunas">Lunas</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-cell">
                                                    <div class="product-thumb"><i class="fas fa-leaf"></i></div>
                                                    <div>
                                                        <div class="product-name">Bolu Susu Pandan</div>
                                                        <div class="product-sku">1 loyang</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>09:42</td>
                                            <td><strong>Rp 45.000</strong></td>
                                            <td><span class="badge-status badge-lunas">Lunas</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-cell">
                                                    <div class="product-thumb"><i class="fas fa-cookie"></i></div>
                                                    <div>
                                                        <div class="product-name">Bolu Susu Coklat</div>
                                                        <div class="product-sku">3 loyang</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>10:05</td>
                                            <td><strong>Rp 135.000</strong></td>
                                            <td><span class="badge-status badge-pending">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-cell">
                                                    <div class="product-thumb"><i class="fas fa-seedling"></i></div>
                                                    <div>
                                                        <div class="product-name">Bolu Susu Strawberry</div>
                                                        <div class="product-sku">2 loyang</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>10:31</td>
                                            <td><strong>Rp 90.000</strong></td>
                                            <td><span class="badge-status badge-lunas">Lunas</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-cell">
                                                    <div class="product-thumb"><i class="fas fa-bread-slice"></i></div>
                                                    <div>
                                                        <div class="product-name">Bolu Susu Original</div>
                                                        <div class="product-sku">1 loyang</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>11:00</td>
                                            <td><strong>Rp 40.000</strong></td>
                                            <td><span class="badge-status badge-batal">Batal</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Laporan ringkas (owner only) -->
                        <div class="card owner-only">
                            <div class="card-header">
                                <span class="card-title">Ringkasan Penjualan — 7 Hari</span>
                                <a class="card-action">Export →</a>
                            </div>
                            <div style="padding:20px 22px;">
                                <div style="display:flex; gap:24px; margin-bottom:18px;">
                                    <div>
                                        <p style="font-size:11px;color:#8a9ab5;font-weight:500;">Total Pemasukan</p>
                                        <p
                                            style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--navy)">
                                            Rp 16,8jt</p>
                                    </div>
                                    <div style="width:1px;background:#f0f4f8;"></div>
                                    <div>
                                        <p style="font-size:11px;color:#8a9ab5;font-weight:500;">Loyang Terjual</p>
                                        <p
                                            style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--navy)">
                                            412</p>
                                    </div>
                                    <div style="width:1px;background:#f0f4f8;"></div>
                                    <div>
                                        <p style="font-size:11px;color:#8a9ab5;font-weight:500;">Rata-rata/Hari</p>
                                        <p
                                            style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--navy)">
                                            Rp 2,4jt</p>
                                    </div>
                                </div>
                                <!-- Mini bar chart -->
                                <div style="display:flex; align-items:flex-end; gap:8px; height:70px;">
                                    @php
                                    $bars = [55, 70, 45, 90, 65, 80, 100];
                                    $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                                    @endphp
                                    @foreach($bars as $i => $h)
                                        <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:4px;">
                                            <div style="width:100%; height:{{ $h * 0.6 }}px; background:{{ $h == 100 ? 'var(--teal)' : 'rgba(26,158,143,0.2)' }}; border-radius:6px 6px 0 0; transition:background 0.2s;"
                                                onmouseover="this.style.background='var(--teal)'"
                                                onmouseout="this.style.background='{{ $h == 100 ? 'var(--teal)' : 'rgba(26,158,143,0.2)' }}'">
                                            </div>
                                            <p style="font-size:10px;color:#8a9ab5;">{{ $days[$i] }}</p>
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
                                <a class="qa-btn">
                                    <div class="qa-icon"><i class="fas fa-cash-register"></i></div>
                                    <span class="qa-label">Transaksi Baru</span>
                                </a>
                                <a class="qa-btn">
                                    <div class="qa-icon"><i class="fas fa-print"></i></div>
                                    <span class="qa-label">Cetak Struk</span>
                                </a>
                                <a class="qa-btn owner-only">
                                    <div class="qa-icon"><i class="fas fa-user-plus"></i></div>
                                    <span class="qa-label">Tambah Karyawan</span>
                                </a>
                                <a class="qa-btn owner-only">
                                    <div class="qa-icon"><i class="fas fa-chart-bar"></i></div>
                                    <span class="qa-label">Export Laporan</span>
                                </a>
                                <a class="qa-btn karyawan-only">
                                    <div class="qa-icon"><i class="fas fa-box"></i></div>
                                    <span class="qa-label">Update Stok</span>
                                </a>
                                <a class="qa-btn karyawan-only">
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
                                <div class="stock-item">
                                    <div class="stock-emoji"><i class="fas fa-bread-slice"></i></div>
                                    <div style="flex:1; min-width:0;">
                                        <div class="stock-name">Original</div>
                                        <div class="stock-count">24 loyang tersisa</div>
                                    </div>
                                    <div style="width:80px;">
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar ok" style="width:80%"></div>
                                        </div>
                                    </div>
                                    <span class="stock-tag ok">Aman</span>
                                </div>
                                <div class="stock-item">
                                    <div class="stock-emoji"><i class="fas fa-leaf"></i></div>
                                    <div style="flex:1; min-width:0;">
                                        <div class="stock-name">Pandan</div>
                                        <div class="stock-count">8 loyang tersisa</div>
                                    </div>
                                    <div style="width:80px;">
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar warn" style="width:27%"></div>
                                        </div>
                                    </div>
                                    <span class="stock-tag warn">Menipis</span>
                                </div>
                                <div class="stock-item">
                                    <div class="stock-emoji"><i class="fas fa-cookie"></i></div>
                                    <div style="flex:1; min-width:0;">
                                        <div class="stock-name">Coklat</div>
                                        <div class="stock-count">3 loyang tersisa</div>
                                    </div>
                                    <div style="width:80px;">
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar danger" style="width:10%"></div>
                                        </div>
                                    </div>
                                    <span class="stock-tag danger">Kritis</span>
                                </div>
                                <div class="stock-item">
                                    <div class="stock-emoji"><i class="fas fa-seedling"></i></div>
                                    <div style="flex:1; min-width:0;">
                                        <div class="stock-name">Strawberry</div>
                                        <div class="stock-count">18 loyang tersisa</div>
                                    </div>
                                    <div style="width:80px;">
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar ok" style="width:60%"></div>
                                        </div>
                                    </div>
                                    <span class="stock-tag ok">Aman</span>
                                </div>
                                <div class="stock-item">
                                    <div class="stock-emoji"><i class="fas fa-circle"></i></div>
                                    <div style="flex:1; min-width:0;">
                                        <div class="stock-name">Blueberry</div>
                                        <div class="stock-count">5 loyang tersisa</div>
                                    </div>
                                    <div style="width:80px;">
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar warn" style="width:17%"></div>
                                        </div>
                                    </div>
                                    <span class="stock-tag warn">Menipis</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection