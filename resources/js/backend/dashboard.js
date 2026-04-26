// ── Sidebar collapse ──
let collapsed = false;
window.toggleSidebar = function () {
    collapsed = !collapsed;
    const sidebar = document.getElementById("sidebar");
    const main = document.getElementById("mainContent");
    sidebar.classList.toggle("collapsed", collapsed);
    main.classList.toggle("sidebar-collapsed", collapsed);
};

// ── Mobile ──
window.toggleMobile = function () {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const isOpen = sidebar.classList.toggle("mobile-open");
    overlay.classList.toggle("active", isOpen);
    document.body.classList.toggle("sidebar-open", isOpen);
};

// ── Date + Avatar ──
document.addEventListener("DOMContentLoaded", function () {
    const days = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];
    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    const now = new Date();

    const topbarDate = document.getElementById("topbarDate");
    if (topbarDate) {
        topbarDate.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    }

    const userAvatar = document.getElementById("userAvatar");
    const userName = document.getElementById("userName");
    if (userAvatar && userName) {
        const name = userName.textContent.trim();
        const initials = name
            .split(" ")
            .map((w) => w[0])
            .join("")
            .substring(0, 2)
            .toUpperCase();
        userAvatar.textContent = initials;
    }
});
