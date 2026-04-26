// ── Role Switcher ──
window.switchRole = function (role) {
    const body = document.getElementById("appBody");
    const btnOwner = document.getElementById("btnOwner");
    const btnKaryawan = document.getElementById("btnKaryawan");
    const rolePill = document.getElementById("rolePillText");
    const userRole = document.getElementById("userRole");

    if (role === "owner") {
        body.classList.remove("role-karyawan");
        btnOwner.classList.add("active");
        btnKaryawan.classList.remove("active");
        rolePill.textContent = "Owner";
        userRole.textContent = "Owner";
    } else {
        body.classList.add("role-karyawan");
        btnKaryawan.classList.add("active");
        btnOwner.classList.remove("active");
        rolePill.textContent = "Karyawan";
        userRole.textContent = "Karyawan";
    }
};

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

// ── Date ──
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
    document.getElementById("topbarDate").textContent =
        `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

    // ── User avatar initials ──
    const name = document.getElementById("userName").textContent.trim();
    const initials = name
        .split(" ")
        .map((w) => w[0])
        .join("")
        .substring(0, 2)
        .toUpperCase();
    document.getElementById("userAvatar").textContent = initials;
});
