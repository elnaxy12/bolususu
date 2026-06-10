@extends('backend.layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">

            <div id="toast-container" class="fixed bottom-6 right-6 z-[99999] flex flex-col gap-2"></div>

            {{-- Header --}}
            <div class="topbar" style="margin-bottom: 24px;">
                <div class="topbar-left">
                    <div class="page-title">
                        <h2>Riwayat Transaksi</h2>
                        <p>Daftar seluruh transaksi penjualan</p>
                    </div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="flex flex-wrap gap-4 mb-6 mx-2">
                <div class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalTransaksi }}</div>
                        <div class="text-xs text-slate-500 mt-1">Total Transaksi</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-slate-900 leading-none">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500 mt-1">Total Pendapatan</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-slate-900 leading-none">Rp {{ number_format($hariIni, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500 mt-1">Pendapatan Hari Ini</div>
                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm mx-2 mb-4 px-5 py-4">
                <form method="GET" action="{{ route('riwayat-transaksi') }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Cari No. Transaksi</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="#00001"
                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all w-40">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Metode Bayar</label>
                        <select name="metode" class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm bg-white outline-none focus:border-blue-600 cursor-pointer">
                            <option value="">Semua</option>
                            <option value="tunai" {{ request('metode') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="qris" {{ request('metode') === 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ request('dari') }}"
                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ request('sampai') }}"
                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'metode', 'dari', 'sampai']))
                        <a href="{{ route('riwayat-transaksi') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div
                class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mx-2 flex flex-col min-h-[calc(100vh-200px)]">
                <div class="flex items-center px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800 m-0">
                        <i class="fas fa-table text-blue-700 mr-1.5"></i>Daftar Transaksi
                    </h2>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">No. Transaksi</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">Tanggal</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">Kasir</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">Metode</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-right">Total</th>
                                <th class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $t)
                                <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600">
                                        #{{ str_pad($t->id_transaksi, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-700">
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-700">
                                        {{ $t->user->nama ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
    $metodeClass = match ($t->metode_bayar) {
        'tunai' => 'bg-emerald-100 text-emerald-800',
        'transfer' => 'bg-blue-100 text-blue-700',
        'qris' => 'bg-purple-100 text-purple-700',
        default => 'bg-slate-100 text-slate-600',
    };
                                        @endphp
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $metodeClass }}">
                                            {{ ucfirst($t->metode_bayar) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-slate-900 text-sm">
                                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick='lihatDetail(@json($t->load("details.produk")))'
                                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-emerald-50 hover:border-emerald-300 hover:text-emerald-700 transition-all mx-auto">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="h-64 text-center align-middle text-slate-400">
                                        <i class="fas fa-receipt text-4xl block mb-3"></i>
                                        <p class="text-sm">Belum ada transaksi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($transaksis->hasPages())
                    <div class="flex items-center justify-between flex-wrap gap-2.5 px-5 py-3.5 border-t border-slate-100 text-xs text-slate-500">
                        <span>Menampilkan {{ $transaksis->firstItem() }}–{{ $transaksis->lastItem() }} dari {{ $transaksis->total() }} transaksi</span>
                        <div class="flex gap-1">
                            @if($transaksis->onFirstPage())
                                <button disabled class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i class="fas fa-chevron-left"></i></button>
                            @else
                                <a href="{{ $transaksis->previousPageUrl() }}" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100"><i class="fas fa-chevron-left"></i></a>
                            @endif
                            @foreach($transaksis->getUrlRange(1, $transaksis->lastPage()) as $page => $url)
                                <a href="{{ $url }}" class="w-7 h-7 rounded-lg border flex items-center justify-center text-xs font-semibold transition-colors {{ $transaksis->currentPage() === $page ? 'bg-blue-700 text-white border-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">{{ $page }}</a>
                            @endforeach
                            @if($transaksis->hasMorePages())
                                <a href="{{ $transaksis->nextPageUrl() }}" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100"><i class="fas fa-chevron-right"></i></a>
                            @else
                                <button disabled class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i class="fas fa-chevron-right"></i></button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Modal Detail --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-detail" onclick="closeOnBackdrop(event,'modal-detail')">
                <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl max-h-[90vh] overflow-y-auto translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
                        <span class="font-bold text-slate-900 text-base" id="detailTitle">Detail Transaksi</span>
                        <button onclick="closeModal('modal-detail')" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="p-5" id="detailContent"></div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="cetakDariDetail()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                            <i class="fas fa-print"></i> Cetak Struk
                        </button>
                        <button onclick="closeModal('modal-detail')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let _currentDetail = null;

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

        function formatRp(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function lihatDetail(t) {
            _currentDetail = t;
            document.getElementById('detailTitle').textContent = `Detail #${String(t.id_transaksi).padStart(5, '0')}`;

            const metodeClass = { tunai: 'bg-emerald-100 text-emerald-800', transfer: 'bg-blue-100 text-blue-700', qris: 'bg-purple-100 text-purple-700' };
            const mc = metodeClass[t.metode_bayar] || 'bg-slate-100 text-slate-600';

            document.getElementById('detailContent').innerHTML = `
                <div class="text-center mb-4">
                    <div class="text-xs text-slate-400 mb-1">${t.tanggal}</div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold ${mc}">${t.metode_bayar.charAt(0).toUpperCase() + t.metode_bayar.slice(1)}</span>
                </div>
                <div class="divide-y divide-slate-100 mb-4">
                    ${t.details.map(d => `
                        <div class="py-2.5 flex justify-between items-center">
                            <div>
                                <div class="text-sm font-semibold text-slate-800">${d.produk.nama_produk}</div>
                                <div class="text-xs text-slate-400">${formatRp(d.harga_satuan)} × ${d.jumlah}</div>
                            </div>
                            <div class="text-sm font-bold text-slate-900">${formatRp(d.subtotal)}</div>
                        </div>
                    `).join('')}
                </div>
                <div class="border-t border-slate-200 pt-3 space-y-1.5">
                    <div class="flex justify-between text-sm font-bold"><span>Total</span><span>${formatRp(t.total_harga)}</span></div>
                    <div class="flex justify-between text-xs text-slate-500"><span>Bayar</span><span>${formatRp(t.bayar)}</span></div>
                    <div class="flex justify-between text-xs font-semibold text-emerald-600"><span>Kembalian</span><span>${formatRp(t.kembalian)}</span></div>
                </div>
            `;
            openModal('modal-detail');
        }

        function cetakDariDetail() {
            if (!_currentDetail) return;
            const content = document.getElementById('detailContent').innerHTML;
            const w = window.open('', '_blank', 'width=400,height=600');
            w.document.write(`
                <html><head><title>Struk #${String(_currentDetail.id_transaksi).padStart(5,'0')}</title>
                <style>body{font-family:monospace;padding:20px;font-size:12px}</style>
                </head><body><h3 style="text-align:center">Bolu Susu Lembang</h3>${content}</body></html>
            `);
            w.document.close();
            w.print();
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal('modal-detail');
        });

        const style = document.createElement('style');
        style.textContent = `@keyframes slideUp { from { transform:translateY(20px); opacity:0 } to { transform:translateY(0); opacity:1 } }`;
        document.head.appendChild(style);
    </script>
@endsection