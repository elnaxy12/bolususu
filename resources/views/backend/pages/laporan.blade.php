@extends('backend.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">

            {{-- Header --}}
            <div class="topbar" style="margin-bottom: 24px;">
                <div class="topbar-left">
                    <div class="page-title">
                        <h2>Laporan Penjualan</h2>
                        <p>Analisis dan rekap penjualan</p>
                    </div>
                </div>
                <div class="topbar-right">
                    <a href="{{ route('laporan.export', ['dari' => $dari, 'sampai' => $sampai]) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm mx-2 mb-4 px-5 py-4">
                <form method="GET" action="{{ route('laporan-penjualan') }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ $dari }}"
                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ $sampai }}"
                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </form>
            </div>

            {{-- Stat Cards --}}
            <div class="flex flex-wrap gap-4 mb-6 mx-2">
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-slate-900 leading-none">Rp
                            {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500 mt-1">Total Pendapatan</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 leading-none">{{ $totalTransaksi }}</div>
                        <div class="text-xs text-slate-500 mt-1">Total Transaksi</div>
                    </div>
                </div>
                <div
                    class="flex-1 min-w-[160px] bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3.5">
                    <div
                        class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-slate-900 leading-none">Rp
                            {{ number_format($rataRata, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500 mt-1">Rata-rata / Transaksi</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 mx-2 mb-4">
                {{-- Grafik Harian --}}
                <div class="flex-1 bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-slate-800 mb-4"><i
                            class="fas fa-chart-bar text-blue-700 mr-1.5"></i>Pendapatan Harian</h3>
                    <canvas id="grafikHarian" height="120"></canvas>
                </div>

                {{-- Rekap Metode --}}
                <div class="w-full lg:w-64 bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-slate-800 mb-4"><i
                            class="fas fa-pie-chart text-blue-700 mr-1.5"></i>Metode Bayar</h3>
                    @forelse($rekapMetode as $m)
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-semibold text-slate-700">{{ ucfirst($m->metode_bayar) }}</span>
                                <span class="text-slate-500">{{ $m->jumlah }}x</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full {{ $m->metode_bayar === 'tunai' ? 'bg-emerald-500' : ($m->metode_bayar === 'transfer' ? 'bg-blue-500' : 'bg-purple-500') }}"
                                    style="width: {{ $totalTransaksi > 0 ? round($m->jumlah / $totalTransaksi * 100) : 0 }}%">
                                </div>
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">Rp {{ number_format($m->total, 0, ',', '.') }}</div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Tidak ada data</p>
                    @endforelse
                </div>
            </div>

            {{-- Produk Terlaris --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm mx-2 mb-4 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-800 m-0"><i
                            class="fas fa-trophy text-amber-500 mr-1.5"></i>Produk Terlaris</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left w-10">
                                    #</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Produk</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-center">
                                    Terjual</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-right">
                                    Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produkTerlaris as $i => $p)
                                <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50">
                                    <td class="px-4 py-3 text-xs text-slate-400">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                                        {{ $p->produk->nama_produk ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-700">{{ $p->total_terjual }}</td>
                                    <td class="px-4 py-3 text-right font-bold text-slate-900 text-sm">Rp
                                        {{ number_format($p->total_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="h-24 text-center text-slate-400 text-sm">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Transaksi --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mx-2">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-800 m-0"><i
                            class="fas fa-table text-blue-700 mr-1.5"></i>Detail Transaksi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    No.</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Tanggal</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Kasir</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-left">
                                    Metode</th>
                                <th
                                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-500 bg-slate-50 border-b border-slate-200 text-right">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $t)
                                <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600">
                                        #{{ str_pad($t->id_transaksi, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $t->user->nama ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        @php $mc = match ($t->metode_bayar) { 'tunai' => 'bg-emerald-100 text-emerald-800', 'transfer' => 'bg-blue-100 text-blue-700', 'qris' => 'bg-purple-100 text-purple-700', default => 'bg-slate-100 text-slate-600'}; @endphp
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $mc }}">{{ ucfirst($t->metode_bayar) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-slate-900 text-sm">Rp
                                        {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="h-24 text-center text-slate-400 text-sm">Tidak ada transaksi pada
                                        periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($transaksis->hasPages())
                    <div
                        class="flex items-center justify-between flex-wrap gap-2.5 px-5 py-3.5 border-t border-slate-100 text-xs text-slate-500">
                        <span>Menampilkan {{ $transaksis->firstItem() }}–{{ $transaksis->lastItem() }} dari
                            {{ $transaksis->total() }} transaksi</span>
                        <div class="flex gap-1">
                            @if($transaksis->onFirstPage())
                                <button disabled
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-400 opacity-40 cursor-not-allowed"><i
                                        class="fas fa-chevron-left"></i></button>
                            @else
                                <a href="{{ $transaksis->previousPageUrl() }}"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-600 hover:bg-slate-100"><i
                                        class="fas fa-chevron-left"></i></a>
                            @endif
                            @foreach($transaksis->getUrlRange(1, $transaksis->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="w-7 h-7 rounded-lg border flex items-center justify-center text-xs font-semibold transition-colors {{ $transaksis->currentPage() === $page ? 'bg-blue-700 text-white border-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">{{ $page }}</a>
                            @endforeach
                            @if($transaksis->hasMorePages())
                                <a href="{{ $transaksis->nextPageUrl() }}"
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

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($grafikHarian->pluck('tanggal'));
        const data = @json($grafikHarian->pluck('total'));

        new Chart(document.getElementById('grafikHarian'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: data,
                    backgroundColor: 'rgba(29, 78, 216, 0.15)',
                    borderColor: 'rgba(29, 78, 216, 0.8)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        ticks: {
                            callback: val => 'Rp ' + Number(val).toLocaleString('id-ID'),
                            font: { size: 10 }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: { ticks: { font: { size: 10 } }, grid: { display: false } }
                }
            }
        });
    </script>
@endsection