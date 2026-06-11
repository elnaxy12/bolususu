<nav class="w-full px-6 flex items-center justify-between h-16">
    <!-- Logo -->
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/LOGO-BSL-.png') }}" onerror="this.style.display='none'"
            class="h-10 w-auto" alt="Logo" />

        <div>
            <p class="cinzel text-white text-sm font-bold leading-none">
                BOLU SUSU
            </p>
            <p class="text-xs text-teal-300 tracking-widest leading-none">
                LEMBANG
            </p>
        </div>
    </div>

    <!-- Menu -->
    <div class="hidden md:flex gap-8 text-sm text-gray-300 font-light">
        <a href="#produk" class="hover:text-white transition">Produk</a>
        <a href="#tentang" class="hover:text-white transition">Tentang Kami</a>
        <a href="#testimoni" class="hover:text-white transition">Testimoni</a>
        <a href="#kontak" class="hover:text-white transition">Kontak</a>
    </div>

    <!-- Right Side -->
    <div class="flex items-center gap-3">
        <button onclick="toggleCart()"
            class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium transition border border-white/20">
            <span id="nav-cart-count">0</span> item
        </button>

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium transition">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</nav>