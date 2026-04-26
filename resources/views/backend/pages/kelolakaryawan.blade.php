@extends('backend.layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')

    <style>
        :root {
            --primary: #1a56db;
            --primary-dark: #1340a8;
            --primary-light: #e8f0ff;
            --success: #0d9488;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --warning: #d97706;
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-400: #94a3b8;
            --neutral-500: #64748b;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;
            --radius: 10px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, .08), 0 1px 2px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .10);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, .14);
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--neutral-900);
            margin: 0;
        }

        .page-subtitle {
            font-size: .875rem;
            color: var(--neutral-500);
            margin: 2px 0 0;
        }

        /* ── Stat Cards ── */
        .stat-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1 1 160px;
            background: #fff;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius);
            padding: 16px 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-icon.green {
            background: #d1fae5;
            color: #065f46;
        }

        .stat-icon.amber {
            background: #fef3c7;
            color: #92400e;
        }

        .stat-icon.rose {
            background: #ffe4e6;
            color: #9f1239;
        }

        .stat-val {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--neutral-900);
            line-height: 1;
        }

        .stat-lbl {
            font-size: .75rem;
            color: var(--neutral-500);
            margin-top: 3px;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--neutral-100);
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-title {
            font-weight: 600;
            color: var(--neutral-800);
            font-size: .95rem;
            margin: 0;
        }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--neutral-400);
            font-size: .85rem;
            pointer-events: none;
        }

        .search-wrap input {
            padding: 7px 12px 7px 32px;
            border: 1px solid var(--neutral-200);
            border-radius: 8px;
            font-size: .85rem;
            color: var(--neutral-800);
            outline: none;
            width: 220px;
            transition: border .2s, box-shadow .2s;
        }

        .search-wrap input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .12);
        }

        select.filter-select {
            padding: 7px 28px 7px 10px;
            border: 1px solid var(--neutral-200);
            border-radius: 8px;
            font-size: .85rem;
            color: var(--neutral-700);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 8px center;
            appearance: none;
            outline: none;
            cursor: pointer;
        }

        select.filter-select:focus {
            border-color: var(--primary);
        }

        /* ── Button ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: .85rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background .15s, transform .1s, box-shadow .15s;
            text-decoration: none;
        }

        .btn:active {
            transform: scale(.97);
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 2px 8px rgba(26, 86, 219, .3);
        }

        .btn-outline {
            background: #fff;
            color: var(--neutral-700);
            border: 1px solid var(--neutral-200);
        }

        .btn-outline:hover {
            background: var(--neutral-50);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: .78rem;
            gap: 4px;
            border-radius: 6px;
        }

        /* ── Table ── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 10px 16px;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--neutral-500);
            background: var(--neutral-50);
            border-bottom: 1px solid var(--neutral-200);
            white-space: nowrap;
        }

        thead th.sortable {
            cursor: pointer;
            user-select: none;
        }

        thead th.sortable:hover {
            color: var(--primary);
        }

        tbody tr {
            border-bottom: 1px solid var(--neutral-100);
            transition: background .12s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--neutral-50);
        }

        tbody td {
            padding: 12px 16px;
            font-size: .875rem;
            color: var(--neutral-700);
            vertical-align: middle;
        }

        /* ── Avatar ── */
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .8rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name {
            font-weight: 600;
            color: var(--neutral-900);
        }

        .user-email {
            font-size: .75rem;
            color: var(--neutral-400);
        }

        /* ── Badge ── */
        .badge {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: var(--danger-light);
            color: var(--danger);
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-gray {
            background: var(--neutral-100);
            color: var(--neutral-600);
        }

        /* ── Action Btns ── */
        .action-group {
            display: flex;
            gap: 6px;
        }

        .btn-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid var(--neutral-200);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            cursor: pointer;
            transition: background .15s, border-color .15s, color .15s;
            color: var(--neutral-600);
        }

        .btn-icon:hover.edit {
            background: #dbeafe;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .btn-icon:hover.view {
            background: #d1fae5;
            border-color: #6ee7b7;
            color: #065f46;
        }

        .btn-icon:hover.del {
            background: var(--danger-light);
            border-color: #fca5a5;
            color: var(--danger);
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--neutral-100);
            font-size: .8rem;
            color: var(--neutral-500);
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-btns {
            display: flex;
            gap: 4px;
        }

        .page-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid var(--neutral-200);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            cursor: pointer;
            color: var(--neutral-600);
            transition: background .15s;
        }

        .page-btn:hover {
            background: var(--neutral-100);
        }

        .page-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            font-weight: 700;
        }

        .page-btn:disabled {
            opacity: .4;
            pointer-events: none;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--neutral-400);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
        }

        .empty-state p {
            font-size: .9rem;
        }

        /* ── Modal Overlay ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 16px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal {
            background: #fff;
            border-radius: 14px;
            width: 100%;
            max-width: 560px;
            box-shadow: var(--shadow-lg);
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(16px) scale(.98);
            transition: transform .2s;
        }

        .modal-overlay.open .modal {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--neutral-100);
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 1;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--neutral-900);
        }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid var(--neutral-200);
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: var(--neutral-500);
            transition: background .15s;
        }

        .modal-close:hover {
            background: var(--neutral-100);
        }

        .modal-body {
            padding: 22px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 22px;
            border-top: 1px solid var(--neutral-100);
        }

        /* ── Form ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-grid .full {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label.form-label {
            font-size: .8rem;
            font-weight: 600;
            color: var(--neutral-700);
        }

        label.form-label .req {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control {
            padding: 8px 12px;
            border: 1px solid var(--neutral-200);
            border-radius: 8px;
            font-size: .875rem;
            color: var(--neutral-800);
            outline: none;
            transition: border .2s, box-shadow .2s;
            background: #fff;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: .75rem;
            color: var(--danger);
        }

        .form-hint {
            font-size: .72rem;
            color: var(--neutral-400);
        }

        /* Photo preview */
        .photo-upload {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .photo-preview {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px dashed var(--neutral-300);
            background: var(--neutral-50);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            cursor: pointer;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-preview i {
            font-size: 1.3rem;
            color: var(--neutral-300);
        }

        /* ── Delete Confirm Modal ── */
        .confirm-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--danger-light);
            color: var(--danger);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 14px;
        }

        .confirm-body {
            text-align: center;
            padding: 24px 22px 10px;
        }

        .confirm-body p {
            font-size: .875rem;
            color: var(--neutral-600);
            margin-top: 8px;
        }

        /* ── Toast ── */
        #toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--neutral-900);
            color: #fff;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: .85rem;
            box-shadow: var(--shadow-md);
            min-width: 240px;
            animation: slideUp .25s ease;
        }

        .toast.success {
            border-left: 4px solid var(--success);
        }

        .toast.error {
            border-left: 4px solid var(--danger);
        }

        .toast i {
            flex-shrink: 0;
            font-size: 1rem;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* ── Detail Modal ── */
        .detail-row {
            display: flex;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--neutral-100);
            align-items: flex-start;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 130px;
            font-size: .78rem;
            font-weight: 600;
            color: var(--neutral-500);
            flex-shrink: 0;
            padding-top: 2px;
        }

        .detail-value {
            font-size: .875rem;
            color: var(--neutral-800);
            flex: 1;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .stat-row {
                flex-wrap: wrap;
            }
        }
    </style>

    {{-- ── Toast Container ── --}}
    <div id="toast-container"></div>

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Karyawan</h1>
            <p class="page-subtitle">Manajemen data seluruh karyawan perusahaan</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('modal-form')">
            <i class="fas fa-plus"></i> Tambah Karyawan
        </button>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-val" id="stat-total">{{ $karyawans->total() ?? 0 }}</div>
                <div class="stat-lbl">Total Karyawan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="stat-val" id="stat-aktif">{{ $karyawans->where('status', 'aktif')->count() ?? 0 }}</div>
                <div class="stat-lbl">Aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-briefcase"></i></div>
            <div>
                <div class="stat-val">{{ $departements->count() ?? 0 }}</div>
                <div class="stat-lbl">Departemen</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon rose"><i class="fas fa-user-times"></i></div>
            <div>
                <div class="stat-val" id="stat-nonaktif">{{ $karyawans->where('status', 'nonaktif')->count() ?? 0 }}</div>
                <div class="stat-lbl">Nonaktif</div>
            </div>
        </div>
    </div>

    {{-- ── Main Table Card ── --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-table" style="color:var(--primary);margin-right:6px"></i>Daftar Karyawan
            </h2>
            <div class="toolbar">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari nama / NIP…" oninput="filterTable()">
                </div>
                <select class="filter-select" id="filterDept" onchange="filterTable()">
                    <option value="">Semua Departemen</option>
                    @foreach($departements ?? [] as $d)
                        <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
                <select class="filter-select" id="filterStatus" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <button class="btn btn-outline btn-sm" onclick="exportData()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table id="karyawanTable">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th class="sortable" onclick="sortTable(1)">Karyawan <i class="fas fa-sort" style="opacity:.4"></i>
                        </th>
                        <th>NIP</th>
                        <th class="sortable" onclick="sortTable(3)">Departemen <i class="fas fa-sort"
                                style="opacity:.4"></i></th>
                        <th>Jabatan</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th style="width:110px;text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($karyawans ?? [] as $i => $k)
                        <tr data-dept="{{ $k->departemen }}" data-status="{{ $k->status }}">
                            <td style="color:var(--neutral-400);font-size:.8rem">{{ $i + 1 }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar" data-initials="{{ strtoupper(substr($k->nama, 0, 1)) }}">
                                        @if($k->foto)
                                            <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}">
                                        @else
                                            {{ strtoupper(substr($k->nama, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $k->nama }}</div>
                                        <div class="user-email">{{ $k->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-family:monospace;font-size:.8rem;color:var(--neutral-500)">{{ $k->nip }}</td>
                            <td><span class="badge badge-blue">{{ $k->departemen }}</span></td>
                            <td>{{ $k->jabatan }}</td>
                            <td style="font-size:.8rem;color:var(--neutral-500)">
                                {{ \Carbon\Carbon::parse($k->tanggal_masuk)->format('d M Y') }}</td>
                            <td>
                                @if($k->status === 'aktif')
                                    <span class="badge badge-success"><i class="fas fa-circle"
                                            style="font-size:.5rem;vertical-align:middle;margin-right:4px"></i>Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group" style="justify-content:center">
                                    <button class="btn-icon view" title="Detail" onclick='viewKaryawan(@json($k))'>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-icon edit" title="Edit" onclick='editKaryawan(@json($k))'>
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn-icon del" title="Hapus"
                                        onclick="confirmDelete({{ $k->id }}, '{{ $k->nama }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-user-slash"></i>
                                    <p>Belum ada data karyawan.<br>Klik <strong>Tambah Karyawan</strong> untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Empty filter state --}}
            <div id="emptyFilter" class="empty-state" style="display:none">
                <i class="fas fa-filter"></i>
                <p>Tidak ada karyawan yang cocok dengan filter.</p>
            </div>
        </div>

        {{-- Pagination --}}
        @if(isset($karyawans) && $karyawans->hasPages())
            <div class="pagination">
                <span>Menampilkan {{ $karyawans->firstItem() }}–{{ $karyawans->lastItem() }} dari {{ $karyawans->total() }}
                    karyawan</span>
                <div class="page-btns">
                    @if($karyawans->onFirstPage())
                        <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $karyawans->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif
                    @foreach($karyawans->getUrlRange(1, $karyawans->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="page-btn {{ $karyawans->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($karyawans->hasMorePages())
                        <a href="{{ $karyawans->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
            </div>
        @endif
    </div>


    {{-- ══════════════════════════════════════════
    MODAL: TAMBAH / EDIT KARYAWAN
    ══════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-form" onclick="closeOnBackdrop(event,'modal-form')">
        <div class="modal" role="dialog" aria-modal="true">
            <div class="modal-header">
                <span class="modal-title" id="formModalTitle">Tambah Karyawan</span>
                <button class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
            </div>

            <form method="POST" id="karyawanForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="formId">

                <div class="modal-body">
                    {{-- Foto Upload --}}
                    <div class="form-group full" style="margin-bottom:16px">
                        <label class="form-label">Foto Karyawan</label>
                        <div class="photo-upload">
                            <div class="photo-preview" onclick="document.getElementById('fotoInput').click()">
                                <img id="fotoPreview" src="" alt="" style="display:none">
                                <i class="fas fa-camera" id="fotoIcon"></i>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline btn-sm"
                                    onclick="document.getElementById('fotoInput').click()">
                                    <i class="fas fa-upload"></i> Pilih Foto
                                </button>
                                <p class="form-hint" style="margin-top:4px">JPG, PNG maks 2MB</p>
                            </div>
                            <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none"
                                onchange="previewFoto(this)">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama" id="fNama" class="form-control"
                                placeholder="Nama lengkap karyawan" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIP <span class="req">*</span></label>
                            <input type="text" name="nip" id="fNip" class="form-control" placeholder="Nomor Induk Pegawai"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="req">*</span></label>
                            <input type="email" name="email" id="fEmail" class="form-control"
                                placeholder="email@perusahaan.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" id="fTelepon" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Departemen <span class="req">*</span></label>
                            <select name="departemen" id="fDepartemen" class="form-control" required>
                                <option value="">— Pilih Departemen —</option>
                                @foreach($departements ?? [] as $d)
                                    <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jabatan <span class="req">*</span></label>
                            <input type="text" name="jabatan" id="fJabatan" class="form-control"
                                placeholder="Jabatan / posisi" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Masuk <span class="req">*</span></label>
                            <input type="date" name="tanggal_masuk" id="fTglMasuk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status <span class="req">*</span></label>
                            <select name="status" id="fStatus" class="form-control" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="fAlamat" class="form-control" rows="2"
                                placeholder="Alamat lengkap"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('modal-form')">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
    MODAL: DETAIL KARYAWAN
    ══════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-detail" onclick="closeOnBackdrop(event,'modal-detail')">
        <div class="modal" role="dialog" aria-modal="true">
            <div class="modal-header">
                <span class="modal-title">Detail Karyawan</span>
                <button class="modal-close" onclick="closeModal('modal-detail')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div style="text-align:center;margin-bottom:20px">
                    <div class="avatar" id="detailAvatar"
                        style="width:72px;height:72px;font-size:1.4rem;margin:0 auto 10px;overflow:hidden;border-radius:50%">
                    </div>
                    <div style="font-weight:700;font-size:1.05rem;color:var(--neutral-900)" id="detailNama"></div>
                    <div style="font-size:.8rem;color:var(--neutral-400)" id="detailJabatan"></div>
                </div>
                <div id="detailRows"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-detail')">Tutup</button>
                <button class="btn btn-primary" id="btnEditFromDetail"><i class="fas fa-pen"></i> Edit</button>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════
    MODAL: KONFIRMASI HAPUS
    ══════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-delete" onclick="closeOnBackdrop(event,'modal-delete')">
        <div class="modal" style="max-width:420px" role="dialog" aria-modal="true">
            <div class="modal-header">
                <span class="modal-title">Konfirmasi Hapus</span>
                <button class="modal-close" onclick="closeModal('modal-delete')"><i class="fas fa-times"></i></button>
            </div>
            <div class="confirm-body">
                <div class="confirm-icon"><i class="fas fa-trash-alt"></i></div>
                <strong id="deleteNama" style="font-size:1rem;color:var(--neutral-900)"></strong>
                <p>Data karyawan ini akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-delete')">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        /* ─────────────────── Modal helpers ─────────────────── */
        function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
        function closeOnBackdrop(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }

        /* ─────────────────── Toast ─────────────────── */
        function showToast(msg, type = 'success') {
            const tc = document.getElementById('toast-container');
            const t = document.createElement('div');
            const ic = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            t.className = `toast ${type}`;
            t.innerHTML = `<i class="fas ${ic}"></i><span>${msg}</span>`;
            tc.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }

    // Show flash messages from Laravel session
    @if(session('success'))  showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error'))    showToast("{{ session('error') }}", 'error'); @endif

        /* ─────────────────── Form: Tambah ─────────────────── */
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        // Override for tambah — reset form
        document.querySelector('[onclick="openModal(\'modal-form\')"]').addEventListener('click', function () {
            resetForm();
            document.getElementById('formModalTitle').textContent = 'Tambah Karyawan';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('karyawanForm').action = '{{ route("karyawan.store") }}';
            openModal('modal-form');
        });

        function resetForm() {
            document.getElementById('karyawanForm').reset();
            document.getElementById('formId').value = '';
            document.getElementById('fotoPreview').style.display = 'none';
            document.getElementById('fotoIcon').style.display = '';
        }

        /* ─────────────────── Form: Edit ─────────────────── */
        function editKaryawan(k) {
            document.getElementById('formModalTitle').textContent = 'Edit Karyawan';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('karyawanForm').action = `/karyawan/${k.id}`;
            document.getElementById('formId').value = k.id;
            document.getElementById('fNama').value = k.nama || '';
            document.getElementById('fNip').value = k.nip || '';
            document.getElementById('fEmail').value = k.email || '';
            document.getElementById('fTelepon').value = k.telepon || '';
            document.getElementById('fDepartemen').value = k.departemen || '';
            document.getElementById('fJabatan').value = k.jabatan || '';
            document.getElementById('fTglMasuk').value = k.tanggal_masuk ? k.tanggal_masuk.substring(0, 10) : '';
            document.getElementById('fStatus').value = k.status || 'aktif';
            document.getElementById('fAlamat').value = k.alamat || '';

            if (k.foto) {
                document.getElementById('fotoPreview').src = `/storage/${k.foto}`;
                document.getElementById('fotoPreview').style.display = 'block';
                document.getElementById('fotoIcon').style.display = 'none';
            } else {
                document.getElementById('fotoPreview').style.display = 'none';
                document.getElementById('fotoIcon').style.display = '';
            }
            openModal('modal-form');
        }

        /* ─────────────────── Foto Preview ─────────────────── */
        function previewFoto(input) {
            if (!input.files || !input.files[0]) return;
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('fotoPreview').src = e.target.result;
                document.getElementById('fotoPreview').style.display = 'block';
                document.getElementById('fotoIcon').style.display = 'none';
            };
            r.readAsDataURL(input.files[0]);
        }

        /* ─────────────────── Detail ─────────────────── */
        let _currentKaryawan = null;
        function viewKaryawan(k) {
            _currentKaryawan = k;
            // Avatar
            const av = document.getElementById('detailAvatar');
            if (k.foto) {
                av.innerHTML = `<img src="/storage/${k.foto}" style="width:100%;height:100%;object-fit:cover">`;
            } else {
                av.textContent = k.nama.substring(0, 2).toUpperCase();
            }
            document.getElementById('detailNama').textContent = k.nama;
            document.getElementById('detailJabatan').textContent = `${k.jabatan} · ${k.departemen}`;

            const fields = [
                ['NIP', k.nip],
                ['Email', k.email],
                ['Telepon', k.telepon || '—'],
                ['Departemen', k.departemen],
                ['Jabatan', k.jabatan],
                ['Tanggal Masuk', k.tanggal_masuk ? k.tanggal_masuk.substring(0, 10) : '—'],
                ['Alamat', k.alamat || '—'],
                ['Status', k.status === 'aktif'
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-danger">Nonaktif</span>'],
            ];
            document.getElementById('detailRows').innerHTML = fields.map(([l, v]) =>
                `<div class="detail-row"><span class="detail-label">${l}</span><span class="detail-value">${v}</span></div>`
            ).join('');

            document.getElementById('btnEditFromDetail').onclick = () => { closeModal('modal-detail'); editKaryawan(k); };
            openModal('modal-detail');
        }

        /* ─────────────────── Delete ─────────────────── */
        function confirmDelete(id, nama) {
            document.getElementById('deleteNama').textContent = nama;
            document.getElementById('deleteForm').action = `/karyawan/${id}`;
            openModal('modal-delete');
        }

        /* ─────────────────── Filter / Search ─────────────────── */
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const dept = document.getElementById('filterDept').value.toLowerCase();
            const status = document.getElementById('filterStatus').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            let visible = 0;

            rows.forEach(row => {
                if (!row.dataset.dept) return; // empty row
                const text = row.textContent.toLowerCase();
                const rDept = row.dataset.dept.toLowerCase();
                const rStat = row.dataset.status.toLowerCase();
                const show = text.includes(q)
                    && (dept === '' || rDept === dept)
                    && (status === '' || rStat === status);
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            document.getElementById('emptyFilter').style.display = visible === 0 ? 'block' : 'none';
        }

        /* ─────────────────── Sort ─────────────────── */
        function sortTable(col) {
            const tbody = document.getElementById('tableBody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-dept]'));
            let asc = tbody.dataset.sortCol == col ? tbody.dataset.sortDir !== 'asc' : true;
            tbody.dataset.sortCol = col;
            tbody.dataset.sortDir = asc ? 'asc' : 'desc';

            rows.sort((a, b) => {
                const va = a.cells[col]?.textContent.trim() || '';
                const vb = b.cells[col]?.textContent.trim() || '';
                return asc ? va.localeCompare(vb) : vb.localeCompare(va);
            });
            rows.forEach(r => tbody.appendChild(r));
        }

        /* ─────────────────── Export CSV (simple) ─────────────────── */
        function exportData() {
            const headers = ['Nama', 'NIP', 'Departemen', 'Jabatan', 'Tanggal Masuk', 'Status'];
            const rows = document.querySelectorAll('#tableBody tr[data-dept]');
            let csv = headers.join(',') + '\n';
            rows.forEach(r => {
                if (r.style.display === 'none') return;
                const c = r.cells;
                csv += [
                    `"${c[1].querySelector('.user-name')?.textContent.trim() || ''}"`,
                    `"${c[2].textContent.trim()}"`,
                    `"${c[3].textContent.trim()}"`,
                    `"${c[4].textContent.trim()}"`,
                    `"${c[5].textContent.trim()}"`,
                    `"${c[6].textContent.trim()}"`,
                ].join(',') + '\n';
            });

            const a = document.createElement('a');
            const blob = new Blob([csv], { type: 'text/csv' });
            a.href = URL.createObjectURL(blob);
            a.download = 'karyawan.csv';
            a.click();
            showToast('Data berhasil diekspor ke CSV');
        }

        /* ─────────────────── Keyboard: Esc close modal ─────────────────── */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                ['modal-form', 'modal-detail', 'modal-delete'].forEach(closeModal);
            }
        });
    </script>

@endsection