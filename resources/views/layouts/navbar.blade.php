<!-- ============ NAVBAR ============ -->
<nav>
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
            <img src="/mnt/user-data/uploads/1776989052530_image.png" onerror="this.style.display='none'"
                class="h-10 w-auto" alt="Logo" />
            <div>
                <p class="cinzel text-white text-sm font-bold leading-none">BOLU SUSU</p>
                <p class="text-xs text-teal-300 tracking-widest leading-none">LEMBANG</p>
            </div>
        </div>
        <div class="hidden md:flex gap-8 text-sm text-gray-300 font-light">
            <a href="#produk" class="hover:text-white transition">Produk</a>
            <a href="#tentang" class="hover:text-white transition">Tentang Kami</a>
            <a href="#testimoni" class="hover:text-white transition">Testimoni</a>
            <a href="#kontak" class="hover:text-white transition">Kontak</a>
        </div>
        <button onclick="toggleCart()"
            class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium transition border border-white/20">
            🛒 <span id="nav-cart-count">0</span> item
        </button>
    </div>
</nav>