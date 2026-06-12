@extends('frontend.layouts.app')

@section('title', 'Checkout - Bolu Susu Lembang')

@section('content')
    <style>
        :root {
            --navy: #0d1f3c;
            --teal: #1a9e8f;
            --teal-light: #2dd4bf;
            --gold: #c9a84c;
            --gold-light: #e8c96e;
            --cream: #fdf6e3;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
        }

        /* ---- NAVBAR ---- */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            background: rgba(13, 31, 60, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.25);
        }

        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .cinzel {
            font-family: 'Cinzel', serif;
        }

        .section-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
        }

        .gold-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(13, 31, 60, 0.08);
        }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 0;
            border-bottom: 1px solid #f0ece0;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-thumb {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0a3a4a, #0d1f3c);
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
        }

        input[type="radio"] {
            accent-color: var(--teal);
        }

        .pay-option {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .pay-option:hover {
            border-color: var(--teal);
        }

        .pay-option.active {
            border-color: var(--teal);
            background: rgba(26, 158, 143, 0.06);
        }

        textarea,
        input[type="text"] {
            font-family: 'DM Sans', sans-serif;
        }

        .submit-btn {
            background: var(--teal);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }

        .submit-btn:hover {
            opacity: 0.92;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .badge-total {
            background: var(--navy);
            color: white;
            font-weight: 700;
            border-radius: 99px;
            padding: 4px 14px;
            font-size: 14px;
        }
    </style>

    <section class="pt-32 pb-24" style="background:var(--cream); min-height: 100vh;">
        <div class="max-w-5xl mx-auto px-6">

            <div class="mb-10">
                <p class="section-label mb-2">✦ Selangkah Lagi</p>
                <h1 class="playfair text-4xl md:text-5xl text-gray-900 font-bold">Checkout Pesanan</h1>
                <div class="gold-line mt-4 max-w-xs"></div>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-3 gap-8">

                    <!-- Kiri: Ringkasan + Alamat + Pembayaran -->
                    <div class="md:col-span-2 space-y-6">

                        <!-- Ringkasan Pesanan -->
                        <div class="card p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="cinzel text-xl font-bold" style="color:var(--navy)">Ringkasan Pesanan</h2>
                                <span class="badge-total">{{ $items->count() }} item</span>
                            </div>

                            <div>
                                @foreach($items as $item)
                                    <div class="item-row">
                                        <div class="flex items-center gap-4">
                                            <div class="item-thumb" @if($item->produk->foto)
                                                style="background-image:url('{{ asset('storage/' . $item->produk->foto) }}')"
                                            @endif></div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $item->produk->nama_produk }}</p>
                                                <p class="text-gray-400 text-sm">{{ $item->quantity }} x Rp
                                                    {{ number_format($item->produk->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="font-bold text-gray-900">
                                            Rp {{ number_format($item->quantity * $item->produk->harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Alamat Pengiriman -->
                        <div class="card p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="cinzel text-xl font-bold" style="color:var(--navy)">Alamat Pengiriman</h2>
                                <button type="button" id="btn-edit-alamat" onclick="toggleEditAlamat()"
                                    class="text-sm px-4 py-1.5 rounded-full border-2 border-teal-500 text-teal-600 hover:bg-teal-500 hover:text-white transition font-medium">
                                    ✏️ Edit
                                </button>
                            </div>

                            <textarea name="alamat_pengiriman" id="textarea-alamat" rows="4" required readonly
                                placeholder="Tulis alamat lengkap: nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, kode pos..."
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-teal-500 transition resize-none disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed">{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>

                            <button type="button" id="btn-simpan-alamat" onclick="toggleEditAlamat()"
                                class="hidden mt-3 text-sm px-4 py-1.5 rounded-full bg-teal-500 text-white hover:bg-teal-600 transition font-medium">
                                Simpan
                            </button>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="card p-6">
                            <h2 class="cinzel text-xl font-bold mb-4" style="color:var(--navy)">Metode Pembayaran</h2>
                            <div class="grid sm:grid-cols-3 gap-4">
                                <label class="pay-option">
                                    <input type="radio" name="metode_bayar" value="transfer" required>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Transfer Bank</p>
                                        <p class="text-gray-400 text-xs">BCA / Mandiri / BNI</p>
                                    </div>
                                </label>
                                <label class="pay-option">
                                    <input type="radio" name="metode_bayar" value="qris" required>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">QRIS</p>
                                        <p class="text-gray-400 text-xs">Scan & bayar</p>
                                    </div>
                                </label>
                                <label class="pay-option">
                                    <input type="radio" name="metode_bayar" value="cod" required>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">COD</p>
                                        <p class="text-gray-400 text-xs">Bayar di tempat</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Kanan: Total & Submit -->
                    <div>
                        <div class="card p-6 sticky top-28">
                            <h2 class="cinzel text-xl font-bold mb-5" style="color:var(--navy)">Total Pembayaran</h2>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkos Kirim</span>
                                    <span class="text-teal-600 font-medium">Gratis</span>
                                </div>
                                <div class="gold-line my-2"></div>
                                <div class="flex justify-between text-lg font-bold" style="color:var(--navy)">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn mt-6">
                                Buat Pesanan →
                            </button>

                            <p class="text-center text-xs text-gray-400 mt-4">
                                Dengan melanjutkan, kamu menyetujui syarat & ketentuan toko kami.
                            </p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    <script>
        function toggleEditAlamat() {
            const textarea = document.getElementById('textarea-alamat');
            const btnEdit = document.getElementById('btn-edit-alamat');
            const btnSimpan = document.getElementById('btn-simpan-alamat');
            const isReadOnly = textarea.readOnly;

            if (isReadOnly) {
                textarea.readOnly = false;
                btnEdit.classList.add('hidden');
                btnSimpan.classList.remove('hidden');
                textarea.focus();
            } else {
                fetch('{{ route('update-alamat') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ alamat: textarea.value })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            textarea.readOnly = true;
                            btnEdit.classList.remove('hidden');
                            btnSimpan.classList.add('hidden');
                        }
                    })
                    .catch(() => alert('Gagal menyimpan alamat.'));
            }
        }
    </script>

    <script>
        // styling pilihan pembayaran aktif
        document.querySelectorAll('input[name="metode_bayar"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.pay-option').forEach(el => el.classList.remove('active'));
                radio.closest('.pay-option').classList.add('active');
            });
        });
    </script>
@endsection