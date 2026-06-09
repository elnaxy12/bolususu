@extends('backend.layouts.app')

@section('title', 'Kelola Stok')

@section('content')
        <div id="appBody">
            <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
            <div class="main" id="mainContent">

                <div id="toast-container" class="fixed bottom-6 right-6 z-[99999] flex flex-col gap-2"></div>

                {{-- Header --}}
                <div class="topbar" style="margin-bottom: 24px;">
                    <div class="topbar-left">
                        <div class="page-title">
                            <h2>Kelola Stok</h2>
                            <p>Monitor dan update stok produk</p>
                        </div>
                    </div>
                </div>

                {{-- Stat Cards --}}
                <div class="flex flex-wrap gap-4 mb-6 mx-2">
                    <div
                        class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                        <div
                            class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalProduk }}</div>
                            <div class="text-xs text-slate-500 mt-1">Total Produk</div>
                        </div>
                    </div>
                    <div
                        class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                        <div
                            class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-slate-900 leading-none">{{ $stokRendah }}</div>
                            <div class="text-xs text-slate-500 mt-1">Stok Rendah</div>
                        </div>
                    </div>
                    <div
                        class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                        <div
                            class="w-11 h-11 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalStokHabis }}</div>
                            <div class="text-xs text-slate-500 mt-1">Stok Habis</div>
                        </div>
                    </div>
                </div>

                {{-- Table Card --}}
    <div
        class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mx-2 flex flex-col min-h-[calc(100vh-200px)]">                <div class="flex items-center justify-between flex-wrap gap-3 px-5 py-4 border-b border-slate-100">
                        <h2 class="text-sm font-semibold text-slate-800 m-0">
                            <i class="fas fa-table text-blue-700 mr-1.5"></i>Daftar Stok Produk
                        </h2>
                        <div class="flex flex-wrap gap-2 items-center">
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                                <input type="text" id="searchInput" placeholder="Cari produk…" oninput="filterTable()"
                                    class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none w-48 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                            </div>
                            <select id="filterStatus" onchange="filterTable()"
                                class="px-2.5 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-700 bg-white outline-none focus:border-blue-600 cursor-pointer">
                                <option value="">Semua</option>
                                <option value="rendah">Stok Rendah</option>
                                <option value="habis">Stok Habis</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="w-full border-collapse" id="stokTable">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left w-10">
                                        #</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                        Produk</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                        Kategori</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center">
                                        Stok Saat Ini</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center">
                                        Stok Minimum</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                        Status</th>
                                    <th
                                        class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center w-20">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @forelse($produks as $i => $p)
                                    <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors"
                                        data-stok="{{ $p->jumlah_stok }}" data-min="{{ $p->stok_minimum }}">
                                        <td class="px-4 py-3 text-xs text-slate-400">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 overflow-hidden">
                                                    @if($p->foto)
                                                        <img src="{{ asset('storage/' . $p->foto) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fas fa-box text-slate-400 text-sm"></i>
                                                    @endif
                                                </div>
                                                <div class="font-semibold text-slate-900 text-sm">{{ $p->nama_produk }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $p->kategori->nama_kategori ?? '—' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span
                                                class="font-bold text-lg {{ $p->jumlah_stok <= $p->stok_minimum ? 'text-red-600' : 'text-slate-900' }}">
                                                {{ $p->jumlah_stok }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-slate-500">{{ $p->stok_minimum }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $p->satuan }}</td>
                                        <td class="px-4 py-3">
                                            @if($p->jumlah_stok == 0)
                                                <span
                                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Habis</span>
                                            @elseif($p->jumlah_stok <= $p->stok_minimum)
                                                <span
                                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>Rendah
                                                </span>
                                            @else
                                                <span
                                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Aman</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button onclick='editStok(@json($p))'
                                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all cursor-pointer mx-auto">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="h-64 text-center align-middle text-slate-400">
                                            <i class="fas fa-box-open text-4xl block mb-3"></i>
                                            <p class="text-sm">Belum ada produk.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($produks->hasPages())
                        <div
                            class="flex items-center justify-between flex-wrap gap-2.5 px-5 py-3.5 border-t border-slate-100 text-xs text-slate-500">
                            <span>Menampilkan {{ $produks->firstItem() }}–{{ $produks->lastItem() }} dari {{ $produks->total() }}
                                produk</span>
                            <div class="flex gap-1">
                                @if($produks->onFirstPage())
                                    <button disabled
                                        class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i
                                            class="fas fa-chevron-left"></i></button>
                                @else
                                    <a href="{{ $produks->previousPageUrl() }}"
                                        class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100"><i
                                            class="fas fa-chevron-left"></i></a>
                                @endif
                                @foreach($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                                    <a href="{{ $url }}"
                                        class="w-7 h-7 rounded-lg border flex items-center justify-center text-xs font-semibold transition-colors {{ $produks->currentPage() === $page ? 'bg-blue-700 text-white border-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">{{ $page }}</a>
                                @endforeach
                                @if($produks->hasMorePages())
                                    <a href="{{ $produks->nextPageUrl() }}"
                                        class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100"><i
                                            class="fas fa-chevron-right"></i></a>
                                @else
                                    <button disabled
                                        class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i
                                            class="fas fa-chevron-right"></i></button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Modal Edit Stok --}}
                <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                    id="modal-stok" onclick="closeOnBackdrop(event,'modal-stok')">
                    <div
                        class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <span class="font-bold text-slate-900 text-base" id="modalStokTitle">Update Stok</span>
                            <button onclick="closeModal('modal-stok')"
                                class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100"><i
                                    class="fas fa-times"></i></button>
                        </div>
                        <form method="POST" id="stokForm">
                            @csrf
                            @method('PUT')
                            <div class="p-5 space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Stok <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" name="jumlah_stok" id="fJumlahStok" min="0" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Stok Minimum <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" name="stok_minimum" id="fStokMinimum" min="0" required
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                                    <p class="text-xs text-slate-400 mt-1">Notifikasi muncul jika stok ≤ nilai ini</p>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                                <button type="button" onclick="closeModal('modal-stok')"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">Batal</button>
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
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

                function editStok(p) {
                    document.getElementById('modalStokTitle').textContent = `Update Stok: ${p.nama_produk}`;
                    document.getElementById('stokForm').action = `/kelola-stok/${p.id_produk}`;
                    document.getElementById('fJumlahStok').value = p.jumlah_stok;
                    document.getElementById('fStokMinimum').value = p.stok_minimum;
                    openModal('modal-stok');
                }

            function filterTable() {
                const q = document.getElementById('searchInput').value.toLowerCase();
                const status = document.getElementById('filterStatus').value;
                const rows = document.querySelectorAll('#tableBody tr[data-stok]');
                let visible = 0;
                rows.forEach(row => {
                    const stok = parseInt(row.dataset.stok);
                    const min = parseInt(row.dataset.min);
                    const matchQ = row.textContent.toLowerCase().includes(q);
                    const matchS = status === ''
                        ? true
                        : status === 'habis' ? stok === 0
                            : status === 'rendah' ? stok <= min && stok > 0
                                : true;
                    const show = matchQ && matchS;
                    row.style.display = show ? '' : 'none';
                    if (show) visible++;
                });
            }

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeModal('modal-stok');
            });

            const style = document.createElement('style');
            style.textContent = `@keyframes slideUp { from { transform:translateY(20px); opacity:0 } to { transform:translateY(0); opacity:1 } }`;
            document.head.appendChild(style);
        </script>
@endsection