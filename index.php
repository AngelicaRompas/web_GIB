<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIM Imanuel Bahu - Beranda</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400;1,700;1,900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style-beranda.css?v=<?php echo time(); ?>">
    
    <style>
        /* CSS GLOBAL UNTUK TEMA UNGU */
        :root { --bs-primary: #6f42c1; }
        .bg-primary { background-color: #6f42c1 !important; }
        .text-primary { color: #6f42c1 !important; }
        .btn-primary { background-color: #6f42c1 !important; border-color: #6f42c1 !important; }
        .btn-outline-primary { border-color: #6f42c1 !important; color: #6f42c1 !important; }
        .btn-outline-primary:hover { background-color: #6f42c1 !important; color: white !important; }
        .border-primary { border-color: #6f42c1 !important; }
        .bg-opacity-10 { background-color: rgba(111, 66, 193, 0.1) !important; }
        
        /* Memperbaiki ikon glow ungu */
        .icon-pulse {
            display: inline-flex; align-items: center; justify-content: center;
            width: 70px; height: 70px; border-radius: 50%;
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
            box-shadow: 0 0 0 0 rgba(111, 66, 193, 0.4);
            animation: pulse 2s infinite;
        }

        .zoom-img:hover {
        transform: scale(1.1); /* Foto membesar 10% saat kursor di atasnya */
        }

        /* CSS KHUSUS MOBILE */
    @media (max-width: 767px) {
        .hero-title {
            font-size: 1.8rem !important; /* Ukuran teks "Selamat Datang di" */
            margin-bottom: 1rem !important;
            padding: 0 10px; /* Menambah ruang di samping agar tidak mepet */
        }
        .church-name-aesthetic {
            font-size: 2.1rem !important; /* Ukuran font gereja agar muat 1 baris */
            white-space: nowrap;          /* Memaksa teks tetap 1 baris */
            display: block;               /* Memastikan dia punya ruang sendiri */
            margin-top: 5px;
        }
        /* Mengurangi py-5 pada hero-section agar lebih ringkas di mobile */
        .hero-section {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
        }
    </style>
</head>
<body>

<div class="digital-grid"></div>
<div class="aurora-container">
    <div class="aurora-blob blob-blue"></div>
    <div class="aurora-blob blob-soft"></div>
</div>

<?php 
include 'koneksi.php'; 
include 'navbar.php'; 
?>

<section class="hero-section py-5">
    <div class="container text-center position-relative">
        <div data-aos="fade-down" data-aos-duration="1000">
            <h1 class="hero-title fw-bolder mb-5 mt-3">
                Selamat Datang di <br>
                <span class="church-name-aesthetic fst-italic" style="font-size: 4.5rem;">"GMIM Imanuel Bahu"</span>
            </h1>
        </div>

        <div class="glass-card p-4 mx-auto" style="max-width: 320px;" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">
            <div class="mb-3">
                <div class="icon-pulse">
                    <i class="bi bi-camera-fill" style="font-size: 1.8rem;"></i>
                </div>
            </div>
            <h5 class="fw-bold mb-4 text-dark">Navigasi Gedung 360°</h5>
            <a href="navigasi.php" class="btn btn-primary rounded-pill w-100 fw-bold shadow-sm" style="font-size: 0.95rem;">
                <i class="bi bi-compass-fill me-2"></i> Mulai Penjelajahan
            </a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid px-5">
        <h2 class="fw-bold mb-5 text-dark text-center" data-aos="fade-up">Struktur Pelayanan</h2>
        <div class="row g-4 justify-content-center"> 
            <?php
            $profil_items = [
                ["foto" => "pendeta.jpg", "title" => "Pendeta", "desc" => "Pelayan Firman & Sakramen", "link" => "data-jemaat.php#pills-bpmj"],
                ["foto" => "pelsus.jpg", "title" => "Pelayan Khusus", "desc" => "Penatua & Diaken Kolom", "link" => "data-jemaat.php#pills-pelsus"],
                ["foto" => "bpmj.jpg", "title" => "Badan Pekerja", "desc" => "Majelis Jemaat", "link" => "data-jemaat.php#pills-bpmj"]
            ];
            foreach($profil_items as $item):
                $path_foto = "assets/images/" . $item['foto'];
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="glass-card h-100 border-0 d-flex flex-column shadow-sm" style="overflow: hidden; border-radius: 20px;">
                    
                    <div style="width: 100%; height: 320px; overflow: hidden; background: #f8f9fa; cursor: pointer;" 
                         onclick="openModal('<?php echo $path_foto; ?>')">
                        <?php if(file_exists($path_foto)): ?>
                            <img src="<?php echo $path_foto; ?>" 
                                 alt="<?php echo $item['title']; ?>" 
                                 class="zoom-img"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted small">Foto tidak ditemukan</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-4 text-center d-flex flex-column flex-grow-1">
                        <h5 class="fw-bold text-dark mb-1"><?php echo $item['title']; ?></h5>
                        <p class="text-muted small mb-4"><?php echo $item['desc']; ?></p>
                        <a href="<?php echo $item['link']; ?>" 
                           class="btn btn-sm rounded-pill px-4 py-2 fw-bold mt-auto" 
                           style="border: 2px solid #6f42c1; color: #6f42c1; background: transparent; transition: 0.3s;"
                           onmouseover="this.style.backgroundColor='#6f42c1'; this.style.color='white';"
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6f42c1';">
                           Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0">
        <img id="modalImg" src="" class="img-fluid w-100 rounded-4">
      </div>
    </div>
  </div>
</div>

<section class="schedule-section py-5">
    <div class="container text-center py-4">
        <h2 class="fw-bold mb-2 text-dark" data-aos="fade-up">Jadwal Ibadah Minggu</h2>
        <p class="text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Mari bertumbuh bersama dalam persekutuan jemaat Imanuel Bahu</p>
        
        <div class="row g-4 justify-content-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
                <div class="glass-card p-4 h-100 text-center border-0">
                    <div class="d-inline-block p-3 rounded-circle mb-3" style="background-color: #f3effb; color: #6f42c1;">
                        <i class="bi bi-sunrise-fill" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Ibadah Subuh</h5>
                    <h3 class="fw-bolder mb-2" style="color: #6f42c1;">06:00 WITA</h3>
                    <p class="small text-muted mb-0">Gedung Gereja Utama</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="250">
                <div class="glass-card p-4 h-100 text-center border-0" style="background: rgba(111, 66, 193, 0.05); border: 1px solid rgba(111, 66, 193, 0.2);">
                    <div class="d-inline-block bg-primary text-white p-3 rounded-circle mb-3 shadow-sm">
                        <i class="bi bi-sun-fill" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Ibadah Pagi</h5>
                    <h3 class="fw-bolder mb-2" style="color: #6f42c1;">09:00 WITA</h3>
                    <p class="small text-muted mb-0">Gedung Gereja Utama</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="350">
                <div class="glass-card p-4 h-100 text-center border-0">
                    <div class="d-inline-block bg-dark bg-opacity-10 p-3 rounded-circle text-dark mb-3">
                        <i class="bi bi-moon-stars-fill" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Ibadah Malam</h5>
                    <h3 class="fw-bolder mb-2" style="color: #6f42c1;">18:00 WITA</h3>
                    <p class="small text-muted mb-0">Gedung Gereja Utama</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="info-section py-5">
    <div class="container text-center py-4">
        <h2 class="fw-bold mb-5 text-dark" data-aos="fade-up">Layanan Informasi Digital</h2>
        <div class="row g-4 justify-content-center text-start">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-4 h-100 border-0 d-flex flex-column">
                    <div class="text-primary mb-3"><i class="bi bi-calendar3-event" style="font-size: 2.3rem;"></i></div>
                    <h5 class="fw-bold text-dark mb-4">Agenda Terdekat</h5>
                    <?php
                    $query_event = @mysqli_query($koneksi, "SELECT * FROM events WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 1");
                    $event_terdekat = $query_event ? mysqli_fetch_assoc($query_event) : null;
                    if($event_terdekat): 
                        $timestamp = strtotime($event_terdekat['tanggal']);
                        $bulan_singkat = date('M', $timestamp);
                        $tanggal_angka = date('d', $timestamp);
                    ?>
                        <div class="d-flex align-items-center bg-white bg-opacity-75 p-2 rounded-4 mb-4 border border-primary border-opacity-25 shadow-sm">
                            <div class="event-calendar-badge me-3 border border-primary border-opacity-10">
                                <div class="event-calendar-month" style="background-color: #6f42c1; color: white;"><?php echo $bulan_singkat; ?></div>
                                <div class="event-calendar-date" style="color: #6f42c1;"><?php echo $tanggal_angka; ?></div>
                            </div>
                            <div class="overflow-hidden">
                                <div class="fw-bold text-dark mb-1 text-truncate"><?php echo htmlspecialchars($event_terdekat['judul']); ?></div>
                                <div class="small text-muted text-truncate"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?php echo htmlspecialchars($event_terdekat['lokasi']); ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-light bg-opacity-50 p-3 rounded-4 mb-4 border border-secondary border-opacity-25 text-center">
                            <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Belum ada agenda.</p>
                        </div>
                    <?php endif; ?>
                    <a href="event.php" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold mt-auto">Lihat Agenda</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-4 h-100 border-0 d-flex flex-column">
                    <div class="text-info mb-3" style="color: #6f42c1 !important;"><i class="bi bi-file-earmark-text" style="font-size: 2.3rem;"></i></div>
                    <h5 class="fw-bold text-dark mb-3">Warta Minggu Berjalan</h5>
                    <p class="text-muted small mb-3">Akses warta jemaat resmi.</p>
                    <a href="warta-jemaat.php" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold mt-auto">Buka Warta</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card p-4 h-100 border-0 d-flex flex-column">
                    <div class="text-success mb-3" style="color: #6f42c1 !important;"><i class="bi bi-wallet2" style="font-size: 2.3rem;"></i></div>
                    <h5 class="fw-bold text-dark mb-3">Transparansi Keuangan</h5>
                    <p class="text-muted small mb-3">Laporan kas dan persembahan jemaat.</p>
                    <a href="warta-keuangan.php" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold mt-auto">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="reflection-section py-5 mb-5">
    <div class="container text-center">
        <div class="glass-card p-5 mx-auto" style="max-width: 800px;" data-aos="fade-up" data-aos-duration="1000">
            <div class="text-primary mb-3 opacity-50"><i class="bi bi-quote" style="font-size: 2.5rem;"></i></div>
            <?php 
            $ayat_hari_ini = ["teks" => "Segala perkara dapat kutanggung di dalam Dia yang memberi kekuatan kepadaku.", "kitab" => "Filipi 4:13"];
            ?>
            <p class="verse-text px-md-4 mb-4">"<?php echo $ayat_hari_ini['teks']; ?>"</p>
            <span class="text-primary fw-bold small text-uppercase tracking-wider">— <?php echo $ayat_hari_ini['kitab']; ?></span>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 80 });

    function openModal(src) {
        document.getElementById('modalImg').src = src;
        new bootstrap.Modal(document.getElementById('fotoModal')).show();
    }
</script>
</body>
</html>