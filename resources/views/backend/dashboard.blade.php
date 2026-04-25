<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard — Bolu Susu Lembang</title>
    <link rel="icon" href="{{ asset('images/LOGO-BSL-.png') }}" type="image/png">
    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css', 'resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&family=Cinzel:wght@500;600&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --navy: #0d1f3c;
            --navy-mid: #112240;
            --navy-light: #1a2f52;
            --teal: #1a9e8f;
            --teal-light: #2dd4bf;
            --gold: #c9a84c;
            --gold-light: #e8c96e;
            --cream: #fdf6e3;
            --white: #ffffff;
            --sidebar-w: 260px;
            --sidebar-collapsed: 68px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4f8;
            color: var(--navy);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: width 0.3s cubic-bezier(.22, .61, .36, 1);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 16px 18px;
            border-bottom: 1px solid rgba(201, 168, 76, 0.15);
            min-height: 72px;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(26, 158, 143, 0.15);
            border: 1.5px solid rgba(26, 158, 143, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .brand-logo img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .brand-text {
            overflow: hidden;
            white-space: nowrap;
        }

        .brand-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 13px;
            font-weight: 900;
            color: #fff;
            line-height: 1.2;
        }

        .brand-text p {
            font-family: 'Cinzel', serif;
            font-size: 8.5px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Role switcher */
        .role-switcher {
            margin: 14px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 4px;
            display: flex;
            gap: 3px;
            flex-shrink: 0;
        }

        .role-btn {
            flex: 1;
            padding: 7px 6px;
            border-radius: 9px;
            border: none;
            background: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            text-align: center;
        }

        .role-btn.active {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 2px 12px rgba(26, 158, 143, 0.35);
        }

        .role-btn:not(.active):hover {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 8px 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .nav-section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.25);
            padding: 12px 18px 6px;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            margin: 1px 8px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
            position: relative;
            white-space: nowrap;
            text-decoration: none;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-item.active {
            background: rgba(26, 158, 143, 0.18);
            border: 1px solid rgba(26, 158, 143, 0.25);
        }

        .nav-item.active .nav-icon {
            color: var(--teal-light);
        }

        .nav-item.active .nav-label {
            color: #fff;
            font-weight: 600;
        }

        .nav-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.45);
            font-size: 16px;
        }

        .nav-label {
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
            overflow: hidden;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 99px;
            flex-shrink: 0;
        }

        /* Sidebar bottom */
        .sidebar-footer {
            padding: 12px 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            cursor: pointer;
            transition: background 0.2s;
            overflow: hidden;
        }

        .user-card:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), #0d6e62);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info {
            overflow: hidden;
        }

        .user-info p {
            font-size: 12.5px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
        }

        .user-info span {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
            white-space: nowrap;
        }

        .logout-btn {
            margin-left: auto;
            flex-shrink: 0;
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.3);
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .logout-btn:hover {
            color: #f4a0a0;
        }

        /* Collapse toggle */
        .collapse-btn {
            position: absolute;
            top: 22px;
            right: -12px;
            width: 24px;
            height: 24px;
            background: var(--navy);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.2s, background 0.2s;
            z-index: 101;
        }

        .collapse-btn:hover {
            background: var(--teal);
            color: #fff;
            border-color: var(--teal);
        }

        .collapse-btn svg {
            transition: transform 0.3s;
        }

        .sidebar.collapsed .collapse-btn svg {
            transform: rotate(180deg);
        }

        /* ═══════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(.22, .61, .36, 1);
        }

        .main.sidebar-collapsed {
            margin-left: var(--sidebar-collapsed);
        }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8edf3;
            padding: 0 28px;
            min-height: 75px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 8px rgba(13, 31, 60, 0.05);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
        }

        .page-title p {
            font-size: 12px;
            color: #8a9ab5;
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f0f4f8;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5a7090;
            transition: background 0.2s, color 0.2s;
            position: relative;
        }

        .top-btn:hover {
            background: var(--navy);
            color: #fff;
        }

        .notif-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 7px;
            height: 7px;
            background: var(--gold);
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .role-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(26, 158, 143, 0.1);
            border: 1px solid rgba(26, 158, 143, 0.25);
            border-radius: 99px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--teal);
        }

        .role-pill-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal);
        }

        /* ═══════════════════════════════════════
           PAGE CONTENT
        ═══════════════════════════════════════ */
        .content {
            padding: 28px;
            flex: 1;
        }

        /* Stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 22px;
            border: 1px solid #e8edf3;
            position: relative;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.10s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.20s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card.teal::before {
            background: linear-gradient(90deg, var(--teal), var(--teal-light));
        }

        .stat-card.gold::before {
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
        }

        .stat-card.navy::before {
            background: linear-gradient(90deg, var(--navy), #2a4f8a);
        }

        .stat-card.red::before {
            background: linear-gradient(90deg, #e05c5c, #f4a0a0);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .stat-card.teal .stat-icon {
            background: rgba(26, 158, 143, 0.1);
        }

        .stat-card.gold .stat-icon {
            background: rgba(201, 168, 76, 0.1);
        }

        .stat-card.navy .stat-icon {
            background: rgba(13, 31, 60, 0.07);
        }

        .stat-card.red .stat-icon {
            background: rgba(220, 80, 80, 0.1);
        }

        .stat-label {
            font-size: 11.5px;
            color: #8a9ab5;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--navy);
        }

        .stat-sub {
            font-size: 11px;
            color: #8a9ab5;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-up {
            color: #22c55e;
            font-weight: 600;
        }

        .stat-down {
            color: #ef4444;
            font-weight: 600;
        }

        /* Content grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
        }

        @media (max-width: 1100px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card base */
        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e8edf3;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
            animation-delay: 0.25s;
        }

        .card-header {
            padding: 18px 22px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f0f4f8;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
        }

        .card-action {
            font-size: 12px;
            font-weight: 600;
            color: var(--teal);
            cursor: pointer;
            text-decoration: none;
            transition: color 0.2s;
        }

        .card-action:hover {
            color: #0d6e62;
        }

        /* Table */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 11px 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #8a9ab5;
            background: #f8fafc;
            text-align: left;
            white-space: nowrap;
        }

        tbody tr {
            border-top: 1px solid #f0f4f8;
            transition: background 0.15s;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody td {
            padding: 13px 20px;
            font-size: 13.5px;
            color: var(--navy);
            white-space: nowrap;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-thumb {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(26, 158, 143, 0.15), rgba(13, 31, 60, 0.08));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .product-name {
            font-weight: 600;
            font-size: 13px;
        }

        .product-sku {
            font-size: 11px;
            color: #8a9ab5;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-status::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .badge-lunas {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .badge-lunas::before {
            background: #22c55e;
        }

        .badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #b45309;
        }

        .badge-pending::before {
            background: #f59e0b;
        }

        .badge-batal {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .badge-batal::before {
            background: #ef4444;
        }

        /* Stock list */
        .stock-list {
            padding: 8px 0;
        }

        .stock-item {
            display: flex;
            align-items: center;
            padding: 12px 22px;
            gap: 12px;
            border-top: 1px solid #f0f4f8;
            transition: background 0.15s;
        }

        .stock-item:first-child {
            border-top: none;
        }

        .stock-item:hover {
            background: #f8fafc;
        }

        .stock-emoji {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f0f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .stock-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
        }

        .stock-count {
            font-size: 12px;
            color: #8a9ab5;
            margin-top: 2px;
        }

        .stock-bar-wrap {
            flex: 1;
            height: 5px;
            background: #f0f4f8;
            border-radius: 99px;
            overflow: hidden;
        }

        .stock-bar {
            height: 100%;
            border-radius: 99px;
            transition: width 0.6s ease;
        }

        .stock-bar.ok {
            background: var(--teal);
        }

        .stock-bar.warn {
            background: var(--gold);
        }

        .stock-bar.danger {
            background: #ef4444;
        }

        .stock-tag {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            flex-shrink: 0;
        }

        .stock-tag.ok {
            background: rgba(26, 158, 143, 0.1);
            color: var(--teal);
        }

        .stock-tag.warn {
            background: rgba(201, 168, 76, 0.1);
            color: #8a6a1a;
        }

        .stock-tag.danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        /* Quick action buttons */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 16px;
        }

        .qa-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 16px 12px;
            background: #f8fafc;
            border: 1.5px solid #e8edf3;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .qa-btn:hover {
            background: var(--navy);
            border-color: var(--navy);
        }

        .qa-btn:hover .qa-icon {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .qa-btn:hover .qa-label {
            color: #fff;
        }

        .qa-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: #fff;
            border: 1px solid #e8edf3;
            transition: all 0.2s;
        }

        .qa-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--navy);
            text-align: center;
            transition: color 0.2s;
        }

        /* ═══════════════════════════════════════
           OWNER-ONLY / KARYAWAN-ONLY
        ═══════════════════════════════════════ */
        .owner-only {
            display: block;
        }

        .karyawan-only {
            display: none;
        }

        body.role-karyawan .owner-only {
            display: none;
        }

        body.role-karyawan .karyawan-only {
            display: block;
        }

        /* Gold divider */
        .gold-line {
            height: 1.5px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 6px 0 12px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #c8d5e8;
            border-radius: 99px;
        }

        /* Hidden nav section */
        .nav-section {
            transition: opacity 0.25s;
        }

        .nav-section.hidden {
            display: none;
        }

        /* Mobile overlay */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
                width: var(--sidebar-w) !important;
            }

            .main {
                margin-left: 0 !important;
            }

            .mobile-toggle {
                display: flex !important;
            }

            .content-grid {
                grid-template-columns: 1fr !important;
            }
        }

        .mobile-toggle {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f0f4f8;
            border: none;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            color: var(--navy);
        }

        /* Saat sidebar collapse */
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .nav-section-label,
        .sidebar.collapsed .role-switcher,
        .sidebar.collapsed .user-info {
            display: none;
        }

        /* Center icon saat collapse */
        .sidebar.collapsed .nav-item {
            justify-content: center;
        }

        /* Hilangin badge biar rapi */
        .sidebar.collapsed .nav-badge {
            display: none;
        }

        /* Footer user jadi tengah */
        .sidebar.collapsed .user-card {
            justify-content: center;
        }

        /* Footer saat sidebar collapse */
        .sidebar.collapsed .sidebar-footer {
            padding: 12px 0;
        }

        /* Hide text user */
        .sidebar.collapsed .user-info {
            display: none;
        }

        /* Card jadi center */
        .sidebar.collapsed .user-card {
            justify-content: center;
            gap: 8px;
        }

        /* Hilangin margin kiri logout */
        .sidebar.collapsed .logout-btn {
            margin-left: 0;
        }

        /* Optional: kecilin avatar biar proporsional */
        .sidebar.collapsed .user-avatar {
            width: 30px;
            height: 30px;
            font-size: 11px;
        }
    </style>
</head>

<body id="appBody">

    <!-- ═══════════════════ SIDEBAR ═══════════════════ -->
    <aside class="sidebar" id="sidebar">
        <button class="collapse-btn" onclick="toggleSidebar()" title="Collapse sidebar">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </button>

        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="brand-logo">
                <img src="{{ asset('images/LOGO-BSL-.png') }}" alt="BSL" />
            </div>
            <div class="brand-text">
                <h1>Bolu Susu Lembang</h1>
                <p>Management Portal</p>
            </div>
        </div>

        <!-- Role Switcher -->
        <div class="role-switcher" id="roleSwitcher">
            <button class="role-btn active" id="btnOwner" onclick="switchRole('owner')">👑 Owner</button>
            <button class="role-btn" id="btnKaryawan" onclick="switchRole('karyawan')">🧑‍💼 Karyawan</button>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <!-- Umum -->
            <div class="nav-section-label">Umum</div>
            <a class="nav-item active" onclick="setActive(this)">
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
            <div class="nav-section owner-only">
                <div class="nav-section-label">Manajemen</div>
                <a class="nav-item" onclick="setActive(this)">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <span class="nav-label">Kelola Karyawan</span>
                </a>
                <a class="nav-item" onclick="setActive(this)">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <line x1="18" y1="20" x2="18" y2="10" />
                            <line x1="12" y1="20" x2="12" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="14" />
                        </svg>
                    </div>
                    <span class="nav-label">Laporan Penjualan</span>
                </a>
            </div>

            <!-- Produk & Stok -->
            <div class="nav-section-label">Produk & Stok</div>
            <a class="nav-item" onclick="setActive(this)">
                <div class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    </svg>
                </div>
                <span class="nav-label">Kelola Produk</span>
            </a>
            <a class="nav-item" onclick="setActive(this)">
                <div class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </div>
                <span class="nav-label">Kelola Stok</span>
                <span class="nav-badge">3</span>
            </a>
            <a class="nav-item" onclick="setActive(this)">
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
            <a class="nav-item" onclick="setActive(this)">
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
            <a class="nav-item" onclick="setActive(this)">
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
                <div class="user-avatar" id="userAvatar">AD</div>
                <div class="user-info">
                    <p id="userName">{{ Auth::user()->name ?? 'Admin BSL' }}</p>
                    <span id="userRole">Owner</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-left:auto;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ═══════════════════ MAIN ═══════════════════ -->
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
                    <h2>Dashboard</h2>
                    <p id="topbarDate">Sabtu, 26 April 2025</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="role-pill">
                    <div class="role-pill-dot"></div>
                    <span id="rolePillText">Owner</span>
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
                    <div class="stat-icon">💰</div>
                    <div class="stat-label">Pendapatan Hari Ini</div>
                    <div class="stat-value">Rp 2,4jt</div>
                    <div class="stat-sub"><span class="stat-up">↑ 12%</span> vs kemarin</div>
                </div>
                <div class="stat-card gold owner-only">
                    <div class="stat-icon">📦</div>
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value">38</div>
                    <div class="stat-sub"><span class="stat-up">↑ 5</span> dari kemarin</div>
                </div>
                <div class="stat-card navy owner-only">
                    <div class="stat-icon">👥</div>
                    <div class="stat-label">Total Karyawan</div>
                    <div class="stat-value">8</div>
                    <div class="stat-sub">3 shift aktif hari ini</div>
                </div>
                <div class="stat-card red owner-only">
                    <div class="stat-icon">⚠️</div>
                    <div class="stat-label">Stok Hampir Habis</div>
                    <div class="stat-value">3</div>
                    <div class="stat-sub">Produk perlu restock</div>
                </div>

                <!-- Karyawan stats -->
                <div class="stat-card teal karyawan-only">
                    <div class="stat-icon">🛒</div>
                    <div class="stat-label">Transaksi Hari Ini</div>
                    <div class="stat-value">14</div>
                    <div class="stat-sub">Shift kamu: 08.00–16.00</div>
                </div>
                <div class="stat-card gold karyawan-only">
                    <div class="stat-icon">📋</div>
                    <div class="stat-label">Item Terjual</div>
                    <div class="stat-value">67</div>
                    <div class="stat-sub">Total loyang hari ini</div>
                </div>
                <div class="stat-card red karyawan-only">
                    <div class="stat-icon">⚠️</div>
                    <div class="stat-label">Stok Hampir Habis</div>
                    <div class="stat-value">3</div>
                    <div class="stat-sub">Perlu lapor ke owner</div>
                </div>
                <div class="stat-card navy karyawan-only">
                    <div class="stat-icon">🖨️</div>
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
                                                <div class="product-thumb">🍞</div>
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
                                                <div class="product-thumb">🟢</div>
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
                                                <div class="product-thumb">🍫</div>
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
                                                <div class="product-thumb">🍓</div>
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
                                                <div class="product-thumb">🍞</div>
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
                                <div class="qa-icon">🛒</div>
                                <span class="qa-label">Transaksi Baru</span>
                            </a>
                            <a class="qa-btn">
                                <div class="qa-icon">🖨️</div>
                                <span class="qa-label">Cetak Struk</span>
                            </a>
                            <a class="qa-btn owner-only">
                                <div class="qa-icon">👤</div>
                                <span class="qa-label">Tambah Karyawan</span>
                            </a>
                            <a class="qa-btn owner-only">
                                <div class="qa-icon">📊</div>
                                <span class="qa-label">Export Laporan</span>
                            </a>
                            <a class="qa-btn karyawan-only">
                                <div class="qa-icon">📦</div>
                                <span class="qa-label">Update Stok</span>
                            </a>
                            <a class="qa-btn karyawan-only">
                                <div class="qa-icon">📋</div>
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
                                <div class="stock-emoji">🍞</div>
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
                                <div class="stock-emoji">🟢</div>
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
                                <div class="stock-emoji">🍫</div>
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
                                <div class="stock-emoji">🍓</div>
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
                                <div class="stock-emoji">🫐</div>
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

    <script>
        // ── Role Switcher ──
        function switchRole(role) {
            const body = document.getElementById('appBody');
            const btnOwner = document.getElementById('btnOwner');
            const btnKaryawan = document.getElementById('btnKaryawan');
            const rolePill = document.getElementById('rolePillText');
            const userRole = document.getElementById('userRole');

            if (role === 'owner') {
                body.classList.remove('role-karyawan');
                btnOwner.classList.add('active');
                btnKaryawan.classList.remove('active');
                rolePill.textContent = 'Owner';
                userRole.textContent = 'Owner';
            } else {
                body.classList.add('role-karyawan');
                btnKaryawan.classList.add('active');
                btnOwner.classList.remove('active');
                rolePill.textContent = 'Karyawan';
                userRole.textContent = 'Karyawan';
            }
        }

        // ── Sidebar collapse ──
        let collapsed = false;
        function toggleSidebar() {
            collapsed = !collapsed;
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed', collapsed);
            main.classList.toggle('sidebar-collapsed', collapsed);
        }

        // ── Mobile ──
        function toggleMobile() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        }

        // ── Active nav ──
        function setActive(el) {
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            el.classList.add('active');
        }

        // ── Date ──
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        document.getElementById('topbarDate').textContent =
            `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

        // ── User avatar initials ──
        const name = document.getElementById('userName').textContent.trim();
        const initials = name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
        document.getElementById('userAvatar').textContent = initials;
    </script>

</body>

</html>