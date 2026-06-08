<?php 
// Memastikan session dimulai untuk logika Login Admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
?>

<style>
/* CSS Utama (Desktop & Mobile) */
.animate {
    animation-duration: 0.3s;
    animation-fill-mode: both;
}

@keyframes slideIn {
    0% { transform: translateY(1rem); opacity: 0; }
    100% { transform: translateY(0rem); opacity: 1; }
}

.slideIn { animation-name: slideIn; }

/* =========================================================
   PENTING: Khusus untuk Tampilan Mobile (Max 991px)
   Ini membuat menu muncul sebagai POP-UP MELAYANG
   ========================================================= */
@media (max-width: 991px) {
    /* Logo: Sesuaikan ukuran teks */
    .navbar-brand { font-size: 1.1rem; }
    
    /* Tombol 3 Garis (Hamburger): Pastikan di kanan */
    .navbar-toggler {
        order: 2;
        margin-right: -10px; /* Sedikit mepet kanan */
    }

    /* KONTEN MENU POP-UP: Tampilan utama Pop-up */
    .navbar-collapse {
        position: absolute;
        top: 100%; /* Pas di bawah navbar */
        right: 15px; /* Sedikit geser dari tepi */
        background: rgba(255, 255, 255, 0.98); /* Putih bersih transparan */
        width: 250px; /* Lebar Pop-up */
        border-radius: 15px; /* Sudut membulat aesthetic */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Bayangan Pop-up */
        padding: 20px;
        z-index: 1050; /* Pastikan di atas konten lain */
        border: 1px solid rgba(0, 0, 0, 0.05);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease-in-out;
    }

    /* Saat Menu Aktif (Buka): Efek transisi */
    .navbar-collapse.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(10px); /* Efek sedikit melayang */
    }

    /* List Menu Mobile */
    .navbar-nav {
        display: flex;
        flex-direction: column;
        align-items: flex-start !important; /* Menu rata kiri di dalam pop-up */
        width: 100%;
        margin: 0 !important;
    }

    /* Menu Utama Mobile */
    .navbar-nav .nav-item {
        width: 100%;
        margin-bottom: 5px;
    }

    .navbar-nav .nav-link {
        color: #6f42c1 !important; /* Warna ungu teks */
        font-weight: 600 !important;
        padding: 10px 15px !important;
        border-radius: 8px;
        transition: background 0.2s;
        text-align: left;
    }

    /* Efek hover menu mobile */
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
        background-color: rgba(111, 66, 193, 0.1);
    }

    /* Dropdown Inner Mobile (Sub-menu) */
    .dropdown-menu {
        position: static !important; /* Di mobile, dropdown ikut list */
        float: none;
        width: 100%;
        margin-top: 5px;
        border: none !important;
        box-shadow: none !important;
        background: rgba(111, 66, 193, 0.05) !important; /* Latar sub-menu */
        border-radius: 8px;
        padding-left: 15px !important;
    }

    .dropdown-item {
        color: #555 !important;
        padding: 8px 15px !important;
    }

    /* Merapikan Tombol Admin/Login di Mobile */
    .navbar-nav .nav-item.ms-lg-3 {
        width: 100%;
        margin-top: 15px !important;
        margin-left: 0 !important;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        padding-top: 15px;
    }

    /* Tombol Admin/Login Mobile */
    .navbar-nav .btn {
        width: 100% !important;
        justify-content: center !important;
        display: flex !important;
        align-items: center;
        padding: 12px !important;
    }

    /* Menu Dropdown Admin Mobile */
    .dropdown-menu-end {
        right: 0;
        left: auto;
        transform: none !important;
        margin-top: 5px !important;
        width: 100% !important;
        position: relative !important;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm" style="background-color: #6f42c1;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
            <img src="assets/images/logo-gmim.png" alt="Logo GMIM" width="55" height="55" class="me-3">
            <div class="brand-container">
                <span class="brand-text d-block" style="letter-spacing: 1px;">GMIM IMANUEL BAHU</span>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item"><a class="nav-link px-3 fw-bold text-white" href="index.php">Beranda</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 fw-bold text-white" href="#" role="button" data-bs-toggle="dropdown">Profil</a>
                    <ul class="dropdown-menu shadow border-0 animate slideIn">
                        <li><a class="dropdown-item fw-semibold" href="visi-misi.php">Visi Misi</a></li>
                        <li><a class="dropdown-item fw-semibold" href="sejarah.php">Sejarah Gereja</a></li>
                        <li><a class="dropdown-item fw-semibold" href="data-jemaat.php">Data Jemaat</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link px-3 fw-bold text-white" href="event.php">Event</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 fw-bold text-white" href="#" role="button" data-bs-toggle="dropdown">Warta</a>
                    <ul class="dropdown-menu shadow border-0 animate slideIn">
                        <li><a class="dropdown-item fw-semibold" href="warta-keuangan.php">Laporan Keuangan</a></li>
                        <li><a class="dropdown-item fw-semibold" href="warta-jemaat.php">Warta Jemaat</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link px-3 fw-bold text-white" href="renungan.php">Renungan</a></li>
                
                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <?php if (isset($_SESSION['admin_imanuel'])): ?>
                        <div class="dropdown d-inline">
                            <a class="btn btn-light rounded-pill px-4 fw-bold text-primary dropdown-toggle shadow-sm" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-check-fill me-1"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item fw-semibold" href="admin/admin_dashboard.php">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="admin/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-outline-light rounded-pill px-4 fw-bold shadow-sm" href="login.php">Login Admin</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>