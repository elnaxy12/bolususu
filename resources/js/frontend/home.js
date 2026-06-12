// ---- PRODUCTS DATA ----
const products = (window.__PRODUCTS__ || []).map((p) => ({
    id: p.id_produk,
    name: p.nama_produk,
    desc: p.deskripsi ?? "",
    price: parseFloat(p.harga),
    image: p.foto ? `/storage/${p.foto}` : "/images/products/product-0.png",
    badge: null,
}));

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
const isLoggedIn = () => window.__AUTH__ === true;

// cart sebagai object { id: { id, name, price, image, qty } }
let cart = {};

async function loadCartFromDB() {
    if (!isLoggedIn()) return;

    const res = await fetch("/keranjang/data");
    const items = await res.json();

    items.forEach((item) => {
        const product = products.find((p) => p.id === item.produk_id);
        if (!product) return;
        cart[item.produk_id] = {
            id: item.produk_id,
            name: product.name,
            price: product.price,
            image: product.image,
            qty: item.quantity,
        };
    });

    updateCartUI();
}

window.addToCart = async function (productId) {
    const product = products.find((p) => p.id === productId);
    if (!product) return;

    if (isLoggedIn()) {
        const res = await fetch("/keranjang/tambah", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({ produk_id: product.id, quantity: 1 }),
        });

        if (res.ok) {
            // Sync cart local juga biar UI update
            if (cart[product.id]) {
                cart[product.id].qty += 1;
            } else {
                cart[product.id] = {
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    qty: 1,
                };
            }
        }
    } else {
        if (cart[product.id]) {
            cart[product.id].qty += 1;
        } else {
            cart[product.id] = {
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                qty: 1,
            };
        }

        // Simpan ke localStorage
        const localCart = Object.values(cart).map((i) => ({
            produk_id: i.id,
            nama: i.name,
            harga: i.price,
            quantity: i.qty,
        }));
        localStorage.setItem("cart", JSON.stringify(localCart));
    }

    showToast(`${product.name} ditambahkan ke keranjang!`);
    updateCartUI();
};

// Load cart dari localStorage saat pertama buka (guest)
function loadLocalCart() {
    if (isLoggedIn()) return; // skip kalau sudah login
    const localCart = JSON.parse(localStorage.getItem("cart") || "[]");
    localCart.forEach((item) => {
        const product = products.find((p) => p.id === item.produk_id);
        if (!product) return;
        cart[item.produk_id] = {
            id: item.produk_id,
            name: product.name,
            price: product.price,
            image: product.image,
            qty: item.quantity,
        };
    });
    updateCartUI();
}

window.changeQty = async (id, delta) => {
    id = parseInt(id);
    if (!cart[id]) return;

    cart[id].qty += delta;

    if (isLoggedIn()) {
        if (cart[id].qty <= 0) {
            await fetch(`/keranjang/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            });
            delete cart[id];
        } else {
            await fetch(`/keranjang/${id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({ quantity: cart[id].qty }),
            });
        }
    } else {
        if (cart[id].qty <= 0) delete cart[id];
        localStorage.setItem(
            "cart",
            JSON.stringify(
                Object.values(cart).map((i) => ({
                    produk_id: i.id,
                    nama: i.name,
                    harga: i.price,
                    quantity: i.qty,
                })),
            ),
        );
    }

    updateCartUI();
};

// Merge localStorage → DB setelah login
async function mergeCartAfterLogin() {
    const localCart = JSON.parse(localStorage.getItem("cart") || "[]");
    if (localCart.length === 0) return;

    await fetch("/keranjang/merge", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({ items: localCart }),
    });

    localStorage.removeItem("cart");
}

function updateCartUI() {
    const keys = Object.keys(cart);
    const totalQty = keys.reduce((a, k) => a + cart[k].qty, 0);
    const totalPrice = keys.reduce(
        (a, k) => a + cart[k].qty * cart[k].price,
        0,
    );

    const badge = document.getElementById("cart-badge");
    const navCount = document.getElementById("nav-cart-count");
    if (badge) badge.textContent = totalQty;
    if (navCount) navCount.textContent = totalQty;
    document.getElementById("cart-total").textContent = formatRp(totalPrice);

    const container = document.getElementById("cart-items");

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
                <img src="${item.image}" class="w-12 h-12 object-contain" alt="${item.name}">
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
    if (!window.__AUTH__) {
        showToast("Silakan login terlebih dahulu untuk checkout");
        setTimeout(() => {
            window.location.href = window.__LOGIN_URL__;
        }, 1000);
        return;
    }

    const keys = Object.keys(cart);
    if (keys.length === 0) {
        showToast("Keranjang masih kosong!");
        return;
    }

    localStorage.setItem("checkout_cart", JSON.stringify(cart));
    window.location.href = window.__CHECKOUT_URL__;
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

if (isLoggedIn()) {
    loadCartFromDB();
} else {
    loadLocalCart();
}