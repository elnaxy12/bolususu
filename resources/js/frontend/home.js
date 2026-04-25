// ---- PRODUCTS DATA ----
const products = [
    {
        id: 1,
        name: "Alpukat Coklat",
        desc: "Cobain rasa favorit keluarga dalam varian Alpukat Cokelat, rasa alpukat yang khas berpadu dengan topping coklat lembut dan nikmat.",
        price: 38000,
        image: "/images/products/product-1.webp",
        badge: "Best Seller",
        tag: "alpukat, alpukat cokelat, bolu susu, cokelat, oleh oleh khas bandung, oleh oleh khas lembang",
    },
    {
        id: 2,
        name: "Black Forest",
        desc: "Lapisan bolu full cokelat blackforest dengan tekstur yang lembut dengan lapisan butter cream blueberry dan ditambah taburan cokelat yang lezat dan melimpah, bakal bikin nambah terus!",
        price: 38000,
        image: "/images/products/product-2.webp",
        badge: "Favorit",
        tag: "blackforest, bolu susu, cokelat, oleh oleh khas bandung, oleh oleh khas lembang, susu cokelat",
    },
    {
        id: 3,
        name: "Cheese Cake",
        desc: "Cobain Bolu Susu Lembang varian Cheese Cake. Bolu Susu Lembang dengan lapisan full keju dengan tekstur yang lembut dipenuhi taburan keju yang melimpah.",
        price: 38000,
        image: "/images/products/product-3.webp",
        badge: "New",
        tag: "bolu susu, keju, oleh oleh khas bandung, oleh oleh khas lembang",
    },
    {
        id: 4,
        name: "Bolu Gulung Susu Rasa Coklat",
        desc: "Bolu Gulung Susu yang Lembut dengan Topping Cokelat Parut yang Berlimpah disempurnakan dengan Filling Krim Coklat dan Crumble Biskuit.",
        price: 46000,
        image: "/images/products/product-4.png",
        badge: "Bolu Gulung",
        tag: "bolu, bolu gulung, oleh oleh khas bandung, oleh oleh khas lembang",
    },
    {
        id: 5,
        name: "Bolu Gulung Susu Rasa Keju",
        desc: "Perpaduan bolu yang lembut, rasa susu yang khas, dan full keju luar dalam yang melimpah dijamin bikin kamu mau coba lagi dan lagi!",
        price: 46000,
        image: "/images/products/product-5.png",
        badge: "Bolu Gulung",
        tag: "bolu, bolu gulung, oleh oleh khas bandung, oleh oleh khas lembang",
    },
    {
        id: 6,
        name: "Cokelat Mini Pack",
        desc: "Bolu Susu Lembang varian Cokelat, taburan Keju melimpah berpadu bolu susu rasa cokelat yang lembut nan nikmat dan bikin ketagihan!",
        price: 20000,
        image: "/images/products/product-6.jpg",
        badge: "Paket Hemat",
        tag: "bolu susu, cokelat, oleh oleh khas bandung, oleh oleh khas lembang, susu cokelat",
    },
];

let cart = {};

function formatRp(n) {
    return "Rp " + n.toLocaleString("id-ID");
}

// ---- RENDER PRODUCTS ----
function renderProducts() {
    const grid = document.getElementById("product-grid");
    grid.innerHTML = products
        .map(
            (p, i) => `
                    <div class="product-card reveal flex flex-col h-full" style="animation-delay:${i * 0.1}s">
                    
                    ${p.badge ? `<div class="badge">${p.badge}</div>` : ""}

                    <!-- IMAGE (fix height) -->
                    <div class="h-56 flex items-center justify-center">
                        <img src="${p.image}" class="w-50 h-50 object-contain" alt="${p.name}">
                    </div>

                    <!-- CONTENT -->
                    <div class="p-5 flex flex-col flex-1">
                        
                        <!-- TITLE -->
                        <h3 class="font-bold text-gray-900 text-lg line-clamp-2">
                        ${p.name}
                        </h3>

                        <!-- DESC -->
                        <p class="text-gray-500 text-sm mt-1 leading-relaxed overflow-hidden"
                        style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                        ${p.desc}
                        </p>

                        <!-- PUSH BOTTOM -->
                        <div class="mt-auto"></div>

                        <!-- PRICE + BUTTON -->
                        <div class="flex items-center justify-between mt-5">
                        <div>
                            <p class="font-bold text-xl" style="color:var(--navy)">
                            ${formatRp(p.price)}
                            </p>
                            <p class="text-gray-400 text-xs">/loyang</p>
                        </div>

                        <button class="add-btn" onclick="addToCart(${p.id})">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Pesan
                        </button>
                        </div>

                    </div>
                    </div>
                        `,
        )
        .join("");
    observeReveal();
}

// ---- CART LOGIC ----
window.addToCart = (id) => {
    const p = products.find((x) => x.id === id);
    if (cart[id]) {
        cart[id].qty += 1;
    } else {
        cart[id] = { ...p, qty: 1 };
    }
    updateCartUI();
    showToast(`${p.name} ditambahkan ke keranjang!`);
};

window.changeQty = (id, delta) => {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) delete cart[id];
    updateCartUI();
};

function updateCartUI() {
    const keys = Object.keys(cart);
    const totalQty = keys.reduce((a, k) => a + cart[k].qty, 0);
    const totalPrice = keys.reduce(
        (a, k) => a + cart[k].qty * cart[k].price,
        0,
    );

    document.getElementById("cart-badge").textContent = totalQty;
    document.getElementById("nav-cart-count").textContent = totalQty;
    document.getElementById("cart-total").textContent = formatRp(totalPrice);

    const container = document.getElementById("cart-items");
    const empty = document.getElementById("cart-empty");

    if (keys.length === 0) {
        container.innerHTML =
            '<p id="cart-empty" class="text-gray-400 text-center py-12">Keranjang masih kosong 🛒</p>';
        return;
    }

    container.innerHTML = keys
        .map((k) => {
            const item = cart[k];
            return `
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                <div class="text-3xl">
                                <img src="${item.image}" 
                                    class="w-12 h-12 object-contain mx-auto" 
                                    alt="${item.name}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">${item.name}</p>
                                    <p class="text-xs text-gray-400">${formatRp(item.price)}/loyang</p>
                                    <p class="text-sm font-bold mt-0.5" style="color:var(--navy)">${formatRp(item.price * item.qty)}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="qty-btn" onclick="changeQty(${k}, -1)">−</div>
                                    <span class="w-6 text-center font-bold text-gray-800 text-sm">${item.qty}</span>
                                    <div class="qty-btn" onclick="changeQty(${k}, 1)">+</div>
                                </div>
                            </div>
                          `;
        })
        .join("");
}

window.toggleCart = () => {
    const sidebar = document.getElementById("cart-sidebar");
    const overlay = document.getElementById("cart-overlay");

    if (!sidebar || !overlay) {
        console.error("cart-sidebar atau cart-overlay tidak ditemukan");
        return;
    }

    const isOpen = !sidebar.classList.contains("translate-x-full");

    if (isOpen) {
        sidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
    } else {
        sidebar.classList.remove("translate-x-full");
        overlay.classList.remove("hidden");
    }
};

window.checkout = () => {
    const keys = Object.keys(cart);
    if (keys.length === 0) {
        showToast("Keranjang masih kosong!");
        return;
    }
    const total = keys.reduce((a, k) => a + cart[k].qty * cart[k].price, 0);
    const items = keys.map((k) => `${cart[k].name} x${cart[k].qty}`).join(", ");
    const msg = encodeURIComponent(
        `Halo Bolu Susu Lembang! Saya ingin memesan:\n${items}\nTotal: ${formatRp(total)}\n\nMohon konfirmasi pesanan saya. Terima kasih!`,
    );
    window.open(`https://wa.me/6281234567890?text=${msg}`, "_blank");
};

function showToast(msg) {
    const t = document.getElementById("toast");
    t.textContent = "✓ " + msg;
    t.classList.add("show");
    setTimeout(() => t.classList.remove("show"), 2800);
}

window.copyCode = () => {
    navigator.clipboard
        .writeText("LEMBANG3")
        .then(() => showToast("Kode promo disalin!"));
};

// ---- SCROLL REVEAL ----
function observeReveal() {
    const obs = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add("visible");
                    obs.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12 },
    );
    document.querySelectorAll(".reveal").forEach((el) => obs.observe(el));
}

// ---- INIT ----
renderProducts();
observeReveal();
