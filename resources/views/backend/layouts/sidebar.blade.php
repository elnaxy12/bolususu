<!-- ═══════════════════ SIDEBAR ═══════════════════ -->
<aside class="sidebar" id="sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-logo">
            <img src="{{ asset('images/LOGO-BSL-.png') }}" alt="BSL" />
        </div>
        <div class="brand-text">
            <h1>Bolu Susu Lembang</h1>
            <p>Management Portal</p>
        </div>
        <button class="collapse-btn hidden md:flex" onclick="toggleSidebar()" title="Collapse sidebar">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </button>
    </div>

    <!-- Nav -->
    <nav class="sidebar-nav">

        <!-- Umum -->
        <div class="nav-section-label">Umum</div>
        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <div class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
            </div>
            <span class="nav-label">Dashboard</span>
        </a>

        <!-- Owner only -->
        @if (Auth::check() && Auth::user()->role === 'owner')
            <div class="nav-section owner-only">
                <div class="nav-section-label">Manajemen</div>
                <a class="nav-item {{ request()->routeIs('karyawan.index') ? 'active' : '' }}"
                    href="{{ route('karyawan.index') }}">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <span class="nav-label">Kelola Karyawan</span>
                </a>
                <a class="nav-item {{ request()->routeIs('laporan-penjualan') ? 'active' : '' }}"
                    href='{{ route('laporan-penjualan') }}'>
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <line x1="18" y1="20" x2="18" y2="10" />
                            <line x1="12" y1="20" x2="12" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="14" />
                        </svg>
                    </div>
                    <span class="nav-label">Laporan Penjualan</span>
                </a>
            </div>
        @endif

        <!-- Produk & Stok -->
        <div class="nav-section-label">Produk & Stok</div>
        <a class="nav-item {{ request()->routeIs('kelola-produk') ? 'active' : '' }}"
            href='{{ route('kelola-produk') }}'>
            <div class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
            </div>
            <span class="nav-label">Kelola Produk</span>
        </a>
        <a class="nav-item {{ request()->routeIs('kelola-stok') ? 'active' : '' }}" href='{{ route('kelola-stok') }}'>
            <div class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
            </div>
            <span class="nav-label">Kelola Stok</span>
            <span class="nav-badge">3</span>
        </a>
        <a class="nav-item {{ request()->routeIs('kelola-kategori') ? 'active' : '' }}"
            href='{{ route('kelola-kategori') }}'>
            <div class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <line x1="8" y1="6" x2="21" y2="6" />
                    <line x1="8" y1="12" x2="21" y2="12" />
                    <line x1="8" y1="18" x2="21" y2="18" />
                    <line x1="3" y1="6" x2="3.01" y2="6" />
                    <line x1="3" y1="12" x2="3.01" y2="12" />
                    <line x1="3" y1="18" x2="3.01" y2="18" />
                </svg>
            </div>
            <span class="nav-label">Kelola Kategori</span>
        </a>

        <!-- Transaksi -->
        <div class="nav-section-label">Transaksi</div>
        <a class="nav-item {{ request()->routeIs('proses-transaksi') ? 'active' : '' }}"
            href='{{ route('proses-transaksi') }}'>
            <div class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                </svg>
            </div>
            <span class="nav-label">Proses Transaksi</span>
        </a>
        <a class="nav-item {{ request()->routeIs('riwayat-transaksi') ? 'active' : '' }}"
            href='{{ route('riwayat-transaksi') }}'>
            <div class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
            </div>
            <span class="nav-label">Riwayat Transaksi</span>
        </a>

    </nav>

    <!-- Footer / User -->
    <div class="sidebar-footer">
        <div class="user-card mx-1">
            <div class="user-avatar" id="userAvatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="user-info">
                <p id="userName">{{ Auth::user()->name ?? 'Admin BSL' }}</p>
                <span id="userRole">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-left:auto;">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>