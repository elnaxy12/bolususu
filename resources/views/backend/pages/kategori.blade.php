@extends('backend.layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">

            <div id="toast-container" class="fixed bottom-6 right-6 z-[99999] flex flex-col gap-2"></div>

            {{-- Header --}}
            <div class="topbar" style="margin-bottom: 24px;">
                <div class="topbar-left">
                    <div class="page-title">
                        <h2>Kelola Kategori</h2>
                        <p>Tambah, edit, dan hapus data kategori</p>
                    </div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="flex flex-wrap gap-4 mb-6 mx-2">
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalKategori }}</div>
                        <div class="text-xs text-slate-500 mt-1">Total Kategori</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalDenganProduk }}</div>
                        <div class="text-xs text-slate-500 mt-1">Ada Produk</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalKosong }}</div>
                        <div class="text-xs text-slate-500 mt-1">Belum Ada Produk</div>
                    </div>
                </div>
            </div>

            {{-- Table Card --}}
            <div
                class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mx-2 flex flex-col min-h-[calc(100vh-200px)]">
                <div class="flex items-center justify-between flex-wrap gap-3 px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800 m-0">
                        <i class="fas fa-table text-blue-700 mr-1.5"></i>Daftar Kategori
                    </h2>
                    <div class="flex flex-wrap gap-2 items-center">
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            <input type="text" id="searchInput" placeholder="Cari kategori…" oninput="filterTable()"
                                class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none w-48 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                        </div>
                        <button onclick="openModal('modal-kategori')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                            <i class="fas fa-plus text-xs"></i> Tambah
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full border-collapse" id="kategoriTable">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left w-10">
                                    #</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Nama Kategori</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Deskripsi</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center">
                                    Jumlah Produk</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Dibuat</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center w-24">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($kategoris as $i => $k)
                                <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 text-xs text-slate-400">{{ $kategoris->firstItem() + $i }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                                <i class="fas fa-tag text-blue-500 text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-slate-900 text-sm">{{ $k->nama_kategori }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-500">{{ $k->deskripsi ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                    {{ $k->produks_count > 0 ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-400' }}">
                                            {{ $k->produks_count }} produk
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-500">{{ $k->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <button onclick='editKategori(@json($k))'
                                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all cursor-pointer"
                                                title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button onclick='confirmDelete({{ $k->id_kategori }}, "{{ $k->nama_kategori }}")'
                                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all cursor-pointer"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="h-64 text-center align-middle text-slate-400">
                                        <i class="fas fa-tags text-4xl block mb-3"></i>
                                        <p class="text-sm">Belum ada kategori.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($kategoris->hasPages())
                    <div
                        class="flex items-center justify-between flex-wrap gap-2.5 px-5 py-3.5 border-t border-slate-100 text-xs text-slate-500">
                        <span>Menampilkan {{ $kategoris->firstItem() }}–{{ $kategoris->lastItem() }} dari
                            {{ $kategoris->total() }} kategori</span>
                        <div class="flex gap-1">
                            @if($kategoris->onFirstPage())
                                <button disabled
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @else
                                <a href="{{ $kategoris->previousPageUrl() }}"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif
                            @foreach($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="w-7 h-7 rounded-lg border flex items-center justify-center text-xs font-semibold transition-colors {{ $kategoris->currentPage() === $page ? 'bg-blue-700 text-white border-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">
                                    {{ $page }}
                                </a>
                            @endforeach
                            @if($kategoris->hasMorePages())
                                <a href="{{ $kategoris->nextPageUrl() }}"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <button disabled
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Modal Tambah/Edit Kategori --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-kategori" onclick="closeOnBackdrop(event,'modal-kategori')">
                <div
                    class="bg-white rounded-2xl w-full max-w-md shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <span class="font-bold text-slate-900 text-base" id="modalKategoriTitle">Tambah Kategori</span>
                        <button onclick="closeModal('modal-kategori')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form method="POST" id="kategoriForm">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kategori <span
                                        class="text-red-600">*</span></label>
                                <input type="text" name="nama_kategori" id="fNamaKategori" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" id="fDeskripsi" rows="3" placeholder="Opsional…"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all resize-none"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                            <button type="button" onclick="closeModal('modal-kategori')"
                                class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">Batal</button>
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal Konfirmasi Hapus --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-hapus" onclick="closeOnBackdrop(event,'modal-hapus')">
                <div
                    class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-trash text-red-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-1">Hapus Kategori?</h3>
                        <p class="text-sm text-slate-500 mb-5">Kategori <span id="hapusNama"
                                class="font-semibold text-slate-800"></span> akan dihapus permanen.</p>
                        <div class="flex gap-2.5 justify-center">
                            <button onclick="closeModal('modal-hapus')"
                                class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">Batal</button>
                            <form id="hapusForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            el.classList.remove('opacity-0', 'pointer-events-none');
            el.querySelector('div')?.classList.remove('translate-y-4', 'scale-[.98]');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            const el = document.getElementById(id);
            el.classList.add('opacity-0', 'pointer-events-none');
            el.querySelector('div')?.classList.add('translate-y-4', 'scale-[.98]');
            document.body.style.overflow = '';
        }
        function closeOnBackdrop(e, id) { if (e.target === document.getElementById(id)) closeModal(id); }

        function showToast(msg, type = 'success') {
            const tc = document.getElementById('toast-container');
            const ic = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            const border = type === 'success' ? 'border-l-4 border-teal-500' : 'border-l-4 border-red-500';
            const t = document.createElement('div');
            t.className = `flex items-center gap-3 bg-slate-900 text-white px-4 py-3 rounded-xl text-sm shadow-lg min-w-[240px] ${border} animate-[slideUp_.25s_ease]`;
            t.innerHTML = `<i class="fas ${ic} shrink-0"></i><span>${msg}</span>`;
            tc.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }
            @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error'))   showToast("{{ session('error') }}", 'error'); @endif

            function editKategori(k) {
                document.getElementById('modalKategoriTitle').textContent = `Edit Kategori: ${k.nama_kategori}`;
                document.getElementById('kategoriForm').action = `/kelola-kategori/${k.id_kategori}`;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('fNamaKategori').value = k.nama_kategori;
                document.getElementById('fDeskripsi').value = k.deskripsi ?? '';
                openModal('modal-kategori');
            }

        function confirmDelete(id, nama) {
            document.getElementById('hapusNama').textContent = nama;
            document.getElementById('hapusForm').action = `/kelola-kategori/${id}`;
            openModal('modal-hapus');
        }

        // Reset form saat modal tambah dibuka
        document.querySelector('[onclick="openModal(\'modal-kategori\')"]').addEventListener('click', function () {
            document.getElementById('modalKategoriTitle').textContent = 'Tambah Kategori';
            document.getElementById('kategoriForm').action = '/kelola-kategori';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('kategoriForm').reset();
        });

        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeModal('modal-kategori');
                closeModal('modal-hapus');
            }
        });

        const style = document.createElement('style');
        style.textContent = `@keyframes slideUp { from { transform:translateY(20px); opacity:0 } to { transform:translateY(0); opacity:1 } }`;
        document.head.appendChild(style);
    </script>
@endsection