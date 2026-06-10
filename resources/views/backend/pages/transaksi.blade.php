@extends('backend.layouts.app')

@section('title', 'Proses Transaksi')

@section('content')
    <div id="appBody">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobile()"></div>
        <div class="main" id="mainContent">

            <div id="toast-container" class="fixed bottom-6 right-6 z-[99999] flex flex-col gap-2"></div>

            {{-- Header --}}
            <div class="topbar" style="margin-bottom: 24px;">
                <div class="topbar-left">
                    <div class="page-title">
                        <h2>Proses Transaksi</h2>
                        <p>Input item belanja dan proses pembayaran</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mx-2 flex-col lg:flex-row">

                {{-- Kiri: Daftar Produk --}}
                <div class="flex-1 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <h2 class="text-sm font-semibold text-slate-800 m-0">
                            <i class="fas fa-box text-blue-700 mr-1.5"></i>Pilih Produk
                        </h2>
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            <input type="text" id="searchProduk" placeholder="Cari produk…" oninput="filterProduk()"
                                class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-sm outline-none w-48 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4" id="produkGrid">
                        @foreach($produks as $p)
                            <div class="produk-card border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all select-none"
                                data-nama="{{ strtolower($p->nama_produk) }}" onclick='tambahItem(@json($p))'>
                                <div
                                    class="w-full h-20 rounded-lg bg-slate-100 flex items-center justify-center mb-2 overflow-hidden">
                                    @if($p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-box text-slate-300 text-2xl"></i>
                                    @endif
                                </div>
                                <div class="font-semibold text-slate-800 text-xs leading-tight mb-1">{{ $p->nama_produk }}</div>
                                <div class="text-blue-700 font-bold text-sm">Rp {{ number_format($p->harga, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Stok: {{ $p->jumlah_stok }} {{ $p->satuan }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Kanan: Keranjang --}}
                <div class="w-full lg:w-80 flex flex-col gap-4">
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <h2 class="text-sm font-semibold text-slate-800 m-0">
                                <i class="fas fa-shopping-cart text-blue-700 mr-1.5"></i>Keranjang
                            </h2>
                            <button onclick="clearKeranjang()"
                                class="text-xs text-red-500 hover:text-red-700 font-semibold transition-colors">
                                <i class="fas fa-trash mr-1"></i>Kosongkan
                            </button>
                        </div>

                        <div id="keranjangList" class="flex-1 overflow-y-auto max-h-72 divide-y divide-slate-100 px-4">
                            <div id="keranjangEmpty" class="py-10 text-center text-slate-400">
                                <i class="fas fa-shopping-basket text-3xl block mb-2"></i>
                                <p class="text-xs">Belum ada item</p>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="px-5 py-4 border-t border-slate-100 space-y-3">
                            <div class="flex justify-between text-sm font-bold text-slate-900">
                                <span>Total</span>
                                <span id="totalHarga">Rp 0</span>
                            </div>

                            {{-- Metode Bayar --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Metode Bayar</label>
                                <div class="flex gap-2">
                                    @foreach(['tunai' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'QRIS'] as $val => $label)
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="metode_bayar" value="{{ $val }}" class="peer hidden" {{ $val === 'tunai' ? 'checked' : '' }}>
                                            <div
                                                class="text-center py-1.5 text-xs font-semibold border border-slate-200 rounded-lg peer-checked:bg-blue-700 peer-checked:text-white peer-checked:border-blue-700 transition-all">
                                                {{ $label }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Bayar --}}
                            <div id="bayarSection">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Bayar</label>
                                <input type="number" id="inputBayar" placeholder="0" min="0" oninput="hitungKembalian()"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                                <div class="flex justify-between text-xs mt-1.5">
                                    <span class="text-slate-500">Kembalian</span>
                                    <span id="kembalian" class="font-semibold text-emerald-600">Rp 0</span>
                                </div>
                            </div>

                            <button onclick="prosesTransaksi()"
                                class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                                <i class="fas fa-cash-register"></i> Proses Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Konfirmasi --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-konfirmasi" onclick="closeOnBackdrop(event,'modal-konfirmasi')">
                <div
                    class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <span class="font-bold text-slate-900 text-base">Konfirmasi Transaksi</span>
                        <button onclick="closeModal('modal-konfirmasi')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="px-5 py-6 text-center">
                        <div
                            class="w-14 h-14 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl mx-auto mb-3.5">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <p class="text-sm text-slate-600 mb-3">Pastikan data transaksi sudah benar.</p>
                        <div class="bg-slate-50 rounded-xl p-4 text-left space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Item</span>
                                <span class="font-semibold text-slate-800" id="konfirmasiItem">—</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Harga</span>
                                <span class="font-bold text-blue-700" id="konfirmasiTotal">—</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Metode Bayar</span>
                                <span class="font-semibold text-slate-800" id="konfirmasiMetode">—</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Jumlah Bayar</span>
                                <span class="font-semibold text-slate-800" id="konfirmasiBayar">—</span>
                            </div>
                            <div class="flex justify-between border-t border-slate-200 pt-2">
                                <span class="text-slate-500">Kembalian</span>
                                <span class="font-bold text-emerald-600" id="konfirmasiKembalian">—</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="closeModal('modal-konfirmasi')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                            Batal
                        </button>
                        <button onclick="konfirmasiProses()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all active:scale-95">
                            <i class="fas fa-check"></i> Ya, Proses
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal Struk --}}
            <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-[9999] p-4 opacity-0 pointer-events-none transition-opacity duration-200"
                id="modal-struk" onclick="closeOnBackdrop(event,'modal-struk')">
                <div
                    class="bg-white rounded-2xl w-full max-w-sm shadow-2xl translate-y-4 scale-[.98] transition-transform duration-200">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <span class="font-bold text-slate-900 text-base">Struk Transaksi</span>
                        <button onclick="closeModal('modal-struk')"
                            class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="p-5" id="strukContent">
                        {{-- diisi JS --}}
                    </div>
                    <div class="flex justify-end gap-2.5 px-5 py-4 border-t border-slate-100">
                        <button onclick="cetakStruk()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg transition-all">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                        <button onclick="closeModal('modal-struk'); resetTransaksi()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-all">
                            <i class="fas fa-plus"></i> Transaksi Baru
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let keranjang = [];
        let totalNominal = 0;

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

        function tambahItem(p) {
            const existing = keranjang.find(i => i.id_produk === p.id_produk);
            if (existing) {
                if (existing.jumlah >= p.jumlah_stok) {
                    showToast('Stok tidak mencukupi!', 'error'); return;
                }
                existing.jumlah++;
                existing.subtotal = existing.jumlah * existing.harga;
            } else {
                keranjang.push({
                    id_produk: p.id_produk,
                    nama: p.nama_produk,
                    harga: parseFloat(p.harga),
                    jumlah: 1,
                    stok: p.jumlah_stok,
                    subtotal: parseFloat(p.harga),
                });
            }
            renderKeranjang();
        }

        function renderKeranjang() {
            const list = document.getElementById('keranjangList');
            const empty = document.getElementById('keranjangEmpty');

            if (keranjang.length === 0) {
                list.innerHTML = '';
                // Kembalikan empty ke list
                empty.classList.remove('hidden');
                list.appendChild(empty);
                document.getElementById('totalHarga').textContent = 'Rp 0';
                totalNominal = 0;
                hitungKembalian();
                return;
            }

            // Sembunyikan empty tapi jangan hapus dari DOM
            empty.classList.add('hidden');
            // Hapus semua child kecuali empty
            Array.from(list.children).forEach(child => {
                if (child.id !== 'keranjangEmpty') child.remove();
            });

            totalNominal = keranjang.reduce((s, i) => s + i.subtotal, 0);

            keranjang.forEach((item, idx) => {
                const row = document.createElement('div');
                row.className = 'py-2.5 border-b border-slate-100 last:border-0';
                row.innerHTML = `
                        <div class="flex items-center gap-2">
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-slate-800 truncate">${item.nama}</div>
                                <div class="text-xs text-slate-400">${formatRp(item.harga)} / pcs</div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button class="w-6 h-6 rounded border border-slate-200 bg-white flex items-center justify-center text-xs hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all btn-min" data-idx="${idx}">−</button>
                                <span class="w-7 text-center text-sm font-bold">${item.jumlah}</span>
                                <button class="w-6 h-6 rounded border border-slate-200 bg-white flex items-center justify-center text-xs hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all btn-plus" data-idx="${idx}">+</button>
                                <button class="w-6 h-6 rounded border border-slate-200 bg-white flex items-center justify-center text-xs hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all ml-1 btn-del" data-idx="${idx}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="text-right text-xs font-semibold text-blue-700 mt-1">${formatRp(item.subtotal)}</div>
                    `;
                list.appendChild(row);
            });

            list.querySelectorAll('.btn-min').forEach(btn => {
                btn.addEventListener('click', () => ubahJumlah(parseInt(btn.dataset.idx), -1));
            });
            list.querySelectorAll('.btn-plus').forEach(btn => {
                btn.addEventListener('click', () => ubahJumlah(parseInt(btn.dataset.idx), 1));
            });
            list.querySelectorAll('.btn-del').forEach(btn => {
                btn.addEventListener('click', () => hapusItem(parseInt(btn.dataset.idx)));
            });

            document.getElementById('totalHarga').textContent = formatRp(totalNominal);
            hitungKembalian();
        }

        function ubahJumlah(idx, delta) {
            const item = keranjang[idx];
            const newJumlah = item.jumlah + delta;
            if (newJumlah < 1) { hapusItem(idx); return; }
            if (newJumlah > item.stok) { showToast('Stok tidak mencukupi!', 'error'); return; }
            item.jumlah = newJumlah;
            item.subtotal = item.jumlah * item.harga;
            renderKeranjang();
        }

        function hapusItem(idx) {
            keranjang.splice(idx, 1);
            renderKeranjang();
        }

        function clearKeranjang() {
            keranjang = [];
            renderKeranjang();
        }

        function hitungKembalian() {
            const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
            const kembalian = bayar - totalNominal;
            document.getElementById('kembalian').textContent = formatRp(Math.max(0, kembalian));
            document.getElementById('kembalian').className = kembalian < 0
                ? 'font-semibold text-red-500'
                : 'font-semibold text-emerald-600';
        }

        function filterProduk() {
            const q = document.getElementById('searchProduk').value.toLowerCase();
            document.querySelectorAll('.produk-card').forEach(card => {
                card.style.display = card.dataset.nama.includes(q) ? '' : 'none';
            });
        }

        function prosesTransaksi() {
            if (keranjang.length === 0) { showToast('Keranjang masih kosong!', 'error'); return; }
            const metode = document.querySelector('input[name="metode_bayar"]:checked')?.value;
            const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
            if (metode === 'tunai' && bayar < totalNominal) {
                showToast('Jumlah bayar kurang!', 'error'); return;
            }

            // Isi data konfirmasi
            const totalItem = keranjang.reduce((s, i) => s + i.jumlah, 0);
            const kembalian = Math.max(0, bayar - totalNominal);

            document.getElementById('konfirmasiItem').textContent = totalItem + ' item';
            document.getElementById('konfirmasiTotal').textContent = formatRp(totalNominal);
            document.getElementById('konfirmasiMetode').textContent = metode.charAt(0).toUpperCase() + metode.slice(1);
            document.getElementById('konfirmasiBayar').textContent = formatRp(bayar);
            document.getElementById('konfirmasiKembalian').textContent = formatRp(kembalian);

            openModal('modal-konfirmasi');
        }

        // Tambah fungsi baru ini
        async function konfirmasiProses() {
            closeModal('modal-konfirmasi');
            const metode = document.querySelector('input[name="metode_bayar"]:checked')?.value;
            const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;

            try {
                const res = await fetch('{{ route("transaksi.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        items: keranjang.map(i => ({ id_produk: i.id_produk, jumlah: i.jumlah })),
                        metode_bayar: metode,
                        bayar: bayar,
                    }),
                });

                const data = await res.json();
                if (data.success) {
                    await tampilStruk(data.transaksi_id);
                } else {
                    showToast('Transaksi gagal!', 'error');
                }
            } catch (e) {
                showToast('Terjadi kesalahan!', 'error');
            }
        }
        async function tampilStruk(id) {
            const res = await fetch(`/proses-transaksi/struk/${id}`);
            const data = await res.json();
            const t = data;

            document.getElementById('strukContent').innerHTML = `
                                <div class="text-center mb-4">
                                    <div class="font-bold text-lg">Bolu Susu Lembang</div>
                                    <div class="text-xs text-slate-500">${t.tanggal}</div>
                                    <div class="text-xs text-slate-400">No: #${String(t.id_transaksi).padStart(5, '0')}</div>
                                </div>
                                <div class="divide-y divide-dashed divide-slate-200 mb-3">
                                    ${t.details.map(d => `
                                        <div class="py-1.5 flex justify-between text-xs">
                                            <span>${d.produk.nama_produk} x${d.jumlah}</span>
                                            <span>${formatRp(d.subtotal)}</span>
                                        </div>
                                    `).join('')}
                                </div>
                                <div class="space-y-1 text-sm border-t border-slate-200 pt-3">
                                    <div class="flex justify-between font-bold"><span>Total</span><span>${formatRp(t.total_harga)}</span></div>
                                    <div class="flex justify-between text-slate-500 text-xs"><span>Bayar (${t.metode_bayar})</span><span>${formatRp(t.bayar)}</span></div>
                                    <div class="flex justify-between text-emerald-600 font-semibold text-xs"><span>Kembalian</span><span>${formatRp(t.kembalian)}</span></div>
                                </div>
                            `;
            openModal('modal-struk');
        }

        function cetakStruk() {
            const content = document.getElementById('strukContent').innerHTML;
            const w = window.open('', '_blank', 'width=400,height=600');
            w.document.write(`
                                <html><head><title>Struk</title>
                                <style>body{font-family:monospace;padding:20px;font-size:12px} .flex{display:flex} .justify-between{justify-content:space-between}</style>
                                </head><body>${content}</body></html>
                            `);
            w.document.close();
            w.print();
        }

        function resetTransaksi() {
            clearKeranjang();
            document.getElementById('inputBayar').value = '';
            document.getElementById('kembalian').textContent = 'Rp 0';
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') ['modal-konfirmasi', 'modal-struk'].forEach(closeModal);
        });

        const style = document.createElement('style');
        style.textContent = `@keyframes slideUp { from { transform:translateY(20px); opacity:0 } to { transform:translateY(0); opacity:1 } }`;
        document.head.appendChild(style);
    </script>
@endsection