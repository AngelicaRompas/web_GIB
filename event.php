<?php ob_start(); ?>
<?php 
include 'koneksi.php'; 

// Mengambil tanggal hari ini untuk logika kategori
$today = date('Y-m-d');

// Ambil acara mendatang (Upcoming)
$queryNext = mysqli_query($koneksi, "SELECT * FROM events WHERE tanggal >= '$today' ORDER BY tanggal ASC");

// Ambil acara lampau (Past/News)
$queryPast = mysqli_query($koneksi, "SELECT * FROM events WHERE tanggal < '$today' ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acara Kita - GMIM Imanuel Bahu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400;1,700;1,900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style-beranda.css?v=<?php echo time(); ?>">
    
    <style>
        .page-header-premium {
            padding-top: 6rem;
            padding-bottom: 3rem;
            position: relative;
        }
        .main-title-aesthetic {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 5vw, 4rem);
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -1px;
        }
        
        /* Modifikasi Event Card dengan Glassmorphism */
        .event-card-glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        .event-card-glass:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.12);
        }
        
        .badge-kategori { 
            position: absolute; 
            top: 15px; 
            left: 15px; 
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .img-event { 
            height: 220px; 
            object-fit: cover; 
            transition: transform 0.5s ease;
        }
        .event-card-glass:hover .img-event {
            transform: scale(1.05); /* Efek zoom halus saat di-hover */
        }
        
        /* Kustomisasi Tab Navigasi agar Premium */
        .nav-pills .nav-link {
            border-radius: 50rem;
            padding: 10px 30px;
            color: #475569;
            font-weight: 600;
            transition: all 0.3s;
            background: rgba(255,255,255,0.6);
            border: 1px solid rgba(13, 110, 253, 0.1);
            margin: 0 5px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .nav-pills .nav-link:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px);
        }
        .nav-pills .nav-link.active {
            background: #6f42c1;
            color: white;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25);
            border-color: #6f42c1;
        }
    </style>
</head>
<body>

<div class="digital-grid"></div>
<div class="aurora-container">
    <div class="aurora-blob blob-blue"></div>
    <div class="aurora-blob blob-soft"></div>
</div>

<?php include 'navbar.php'; ?>

<section class="page-header-premium text-center z-2">
    <div class="container">
        <div data-aos="fade-down" data-aos-duration="800">
            <span class="badge rounded-pill px-3 py-2 small mb-3 fw-bold tracking-widest" 
             style="letter-spacing: 2px; background-color: rgba(111, 66, 193, 0.1); color: #6f42c1;">
             <i class="bi bi-calendar-event me-2"></i>AGENDA JEMAAT
            </span>     
        </div>
        <h1 class="main-title-aesthetic mb-3" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="100">
            Acara Kita
        </h1>
        <p class="text-muted fw-medium mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            Informasi kegiatan, ibadah, dan persekutuan di lingkungan GMIM Imanuel Bahu
        </p>
    </div>
</section>

<div class="container pb-5 mb-5 position-relative z-2">
    
    <div class="d-flex justify-content-center mb-5" data-aos="zoom-in" data-aos-delay="300">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#upcoming" type="button" role="tab" aria-selected="true">
                    <i class="bi bi-clock-history me-2"></i>Akan Datang
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-past-tab" data-bs-toggle="pill" data-bs-target="#past" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-check-all me-2"></i>Terlaksana (Arsip)
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            <div class="row g-4">
                <?php if(mysqli_num_rows($queryNext) > 0): ?>
                    <?php $delay = 100; while($row = mysqli_fetch_assoc($queryNext)): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="event-card-glass h-100 d-flex flex-column">
                            <div class="position-relative overflow-hidden">
                                <span class="badge bg-primary badge-kategori style="background-color: #6f42c1; rounded-pill px-3 py-2"><?php echo htmlspecialchars($row['kategori_acara']); ?></span>
                                <img src="assets/images/<?php echo htmlspecialchars($row['poster']); ?>" class="w-100 img-event" alt="Poster" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                            </div>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <h5 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($row['judul']); ?></h5>
                                <div class="mb-3 text-primary fw-medium small">
                                    <i class="bi bi-calendar-event me-2"></i><?php echo date('d F Y', strtotime($row['tanggal'])); ?>
                                </div>
                                <p class="text-muted small text-truncate mb-4"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                <div class="mt-auto">
                                    <a href="detail-event.php?id=<?php echo $row['id']; ?>" class="btn btn-primary rounded-pill w-100 fw-bold">
                                        Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $delay += 100; endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5" data-aos="fade-up">
                        <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
                            <i class="bi bi-calendar-x text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-dark fw-bold">Belum Ada Agenda</h5>
                            <p class="text-muted small mb-0">Belum ada acara mendatang yang dijadwalkan.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="past" role="tabpanel">
            <div class="row g-4">
                <?php if(mysqli_num_rows($queryPast) > 0): ?>
                    <?php $delay = 100; while($row = mysqli_fetch_assoc($queryPast)): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" style="opacity: 0.9;">
                        <div class="event-card-glass h-100 d-flex flex-column border-0">
                            <div class="position-relative overflow-hidden">
                                <span class="badge bg-secondary badge-kategori" style="background-color: #6f42c1;" rounded-pill px-3 py-2">Selesai</span>
                                <img src="assets/images/<?php echo htmlspecialchars($row['poster']); ?>" class="w-100 img-event" alt="Poster" style="filter: grayscale(40%);" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                            </div>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <h5 class="fw-bold text-secondary mb-3"><?php echo htmlspecialchars($row['judul']); ?></h5>
                                <div class="mb-3 text-muted fw-medium small">
                                    <i class="bi bi-calendar-check me-2"></i><?php echo date('d F Y', strtotime($row['tanggal'])); ?>
                                </div>
                                <div class="mt-auto">
                                    <a href="detail-event.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-secondary rounded-pill w-100 fw-bold">
                                        Baca Dokumentasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $delay += 100; endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
                            <i class="bi bi-archive text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-dark fw-bold">Belum Ada Arsip</h5>
                            <p class="text-muted small mb-0">Belum ada dokumentasi acara terdahulu.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 80 });
</script>
</body>
</html>