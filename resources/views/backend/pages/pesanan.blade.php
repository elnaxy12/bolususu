@extends('backend.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">

            <div id="toast-container" class="fixed bottom-6 right-6 z-[99999] flex flex-col gap-2"></div>

            {{-- Header --}}
            <div class="topbar" style="margin-bottom: 24px;">
                <div class="topbar-left">
                    <div class="page-title">
                        <h2>Daftar Pesanan</h2>
                        <p>Kelola dan ubah status pesanan pelanggan</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mx-2">

                {{-- Filter / Search --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800 m-0">
                        <i class="fas fa-receipt text-blue-700 mr-1.5"></i>Semua Pesanan
                    </h2>
                    <div class="flex gap-2">
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            <input type="text" id="searchPesanan" placeholder="Cari kode / nama pelanggan…"
                                oninput="filterPesanan()"
                                class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none w-56 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                        </div>
                        <select id="filterStatus" onchange="filterPesanan()"
                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                <th class="px-5 py-3">Kode Pesanan</th>
                                <th class="px-5 py-3">Pelanggan</th>
                                <th class="px-5 py-3">Tanggal</th>
                                <th class="px-5 py-3">Total</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="pesananBody">
                            @forelse($pesanan as $p)
                                <tr class="pesanan-row hover:bg-slate-50/60 transition-colors"
                                    data-kode="{{ strtolower($p->id_pesanan) }}"
                                    data-pelanggan="{{ strtolower($p->user->nama ?? '') }}"
                                    data-status="{{ $p->status_pesanan }}">
                                    <td class="px-5 py-3 font-semibold text-slate-800">#{{ $p->id_pesanan }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $p->user->nama ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-500">
                                        {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-5 py-3 font-semibold text-blue-700">Rp
                                        {{ number_format($p->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @php
                                            $badge = match ($p->status_pesanan) {
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'diproses' => 'bg-blue-100 text-blue-700',
                                                'dikirim' => 'bg-indigo-100 text-indigo-700',
                                                'selesai' => 'bg-emerald-100 text-emerald-700',
                                                'dibatalkan' => 'bg-red-100 text-red-700',
                                                default => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp
                                        <span
                                            class="status-badge inline-block px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ ucfirst($p->status_pesanan) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button onclick='lihatDetail(@json($p))'
                                                class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-slate-500 hover:bg-slate-100 transition-all">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button
                                                onclick="bukaUbahStatus('{{ $p->id_pesanan }}', '{{ $p->status_pesanan }}', '{{ $p->id_pesanan }}')"
                                                class="w-8 h-8 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-xs text-blue-700 hover:bg-blue-50 hover:border-blue-300 transition-all">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="pesananEmptyRow">
                                    <td colspan="6" class="py-10 text-center text-slate-400">
                                        <i class="fas fa-inbox text-3xl block mb-2"></i>
                                        <p class="text-xs">Belum ada pesanan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <p id="pesananNotFound" class="hidden py-10 text-center text-slate-400 text-xs">
                        <i class="fas fa-search text-3xl block mb-2"></i>
                        Pesanan tidak ditemukan
                    </p>
                </div>

                {{-- Pagination --}}
                @if(method_exists($pesanan, 'links'))
                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $pesanan->links() }}
                    </div>
                @endif
            </div>

            {{-- Modal Ubah Status --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-status" onclick="closeOnBackdrop(event,'modal-status')">
                <div
                    class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <span class="font-bold text-slate-900 text-base">Ubah Status Pesanan</span>
                        <button onclick="closeModal('modal-status')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="px-5 py-6">
                        <p class="text-sm text-slate-600 mb-4">
                            Kode Pesanan: <span class="font-semibold text-slate-800" id="statusKodePesanan">—</span>
                        </p>

                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Baru</label>
                        <select id="selectStatusBaru"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="closeModal('modal-status')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                            Batal
                        </button>
                        <button onclick="simpanStatus()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                            <i class="fas fa-check"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal Detail Pesanan --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-detail" onclick="closeOnBackdrop(event,'modal-detail')">
                <div
                    class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <span class="font-bold text-slate-900 text-base">Detail Pesanan</span>
                        <button onclick="closeModal('modal-detail')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-5" id="detailContent">
                        {{-- diisi JS --}}
                    </div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="closeModal('modal-detail')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let currentPesananId = null;

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

        function formatRp(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function filterPesanan() {
            const q = document.getElementById('searchPesanan').value.toLowerCase();
            const status = document.getElementById('filterStatus').value;
            let visibleCount = 0;

            document.querySelectorAll('.pesanan-row').forEach(row => {
                const matchSearch = row.dataset.kode.includes(q) || row.dataset.pelanggan.includes(q);
                const matchStatus = !status || row.dataset.status === status;
                const show = matchSearch && matchStatus;
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            document.getElementById('pesananNotFound').classList.toggle('hidden', visibleCount !== 0);
        }

        function bukaUbahStatus(id, statusSekarang, kodePesanan) {
            currentPesananId = id;
            document.getElementById('statusKodePesanan').textContent = '#' + kodePesanan;
            document.getElementById('selectStatusBaru').value = statusSekarang;
            openModal('modal-status');
        }

        async function simpanStatus() {
            const status = document.getElementById('selectStatusBaru').value;

            try {
                const res = await fetch(`{{ url('/proses-pesanan') }}/${currentPesananId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ status }),
                });

                const data = await res.json();
                if (data.success) {
                    closeModal('modal-status');
                    showToast('Status pesanan berhasil diubah!');

                    // Update badge & data-status di baris tabel tanpa reload
                    const row = document.querySelector(`tr[onclick] , .pesanan-row`);
                    const targetRow = [...document.querySelectorAll('.pesanan-row')].find(r =>
                        r.querySelector('button[onclick^="bukaUbahStatus("]')
                            ?.getAttribute('onclick')?.includes(`bukaUbahStatus('${currentPesananId}',`)
                    );

                    if (targetRow) {
                        targetRow.dataset.status = status;
                        const badge = targetRow.querySelector('.status-badge');
                        const colorMap = {
                            pending: 'bg-amber-100 text-amber-700',
                            diproses: 'bg-blue-100 text-blue-700',
                            dikirim: 'bg-indigo-100 text-indigo-700',
                            selesai: 'bg-emerald-100 text-emerald-700',
                            dibatalkan: 'bg-red-100 text-red-700',
                        };
                        badge.className = `status-badge inline-block px-2.5 py-1 rounded-full text-xs font-semibold ${colorMap[status] || 'bg-slate-100 text-slate-600'}`;
                        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    }

                    filterPesanan();
                } else {
                    showToast('Gagal mengubah status!', 'error');
                }
            } catch (e) {
                showToast('Terjadi kesalahan!', 'error');
            }
        }

        function lihatDetail(p) {
            const items = (p.detail_pesanan || []).map(d => `
                    <div class="py-1.5 flex justify-between text-xs">
                        <span>${d.produk?.nama_produk ?? '-'} x${d.jumlah}</span>
                        <span>${formatRp(d.subtotal)}</span>
                    </div>
                `).join('');

            document.getElementById('detailContent').innerHTML = `
                    <div class="mb-3">
                        <div class="font-bold text-base">#${p.id_pesanan}</div>
                        <div class="text-xs text-slate-500">${p.user?.nama ?? '-'}</div>
                        <div class="text-xs text-slate-400">${p.created_at ?? ''}</div>
                    </div>
                    <div class="divide-y divide-dashed divide-slate-200 mb-3">
                        ${items || '<p class="text-xs text-slate-400">Tidak ada item</p>'}
                    </div>
                    <div class="space-y-1 text-sm border-t border-slate-200 pt-3">
                        <div class="flex justify-between font-bold"><span>Total</span><span>${formatRp(p.total_harga)}</span></div>
                        <div class="flex justify-between text-slate-500 text-xs"><span>Status</span><span class="font-semibold capitalize">${p.status_pesanan}</span></div>
                    </div>
                `;
            openModal('modal-detail');
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') ['modal-status', 'modal-detail'].forEach(closeModal);
        });

        const style = document.createElement('style');
        style.textContent = `@keyframes slideUp { from { transform:translateY(20px); opacity:0 } to { transform:translateY(0); opacity:1 } }`;
        document.head.appendChild(style);
    </script>
@endsection