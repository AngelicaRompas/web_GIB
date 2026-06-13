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
    <link rel="stylesheet" href="assets/css/event.css">
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
                                <span class="badge bg-secondary badge-kategori" style="background-color: #6f42c1;">Selesai</span>
                                <img src="assets/gallery/<?php echo htmlspecialchars($row['poster']); ?>" class="w-100 img-event" alt="Poster" style="filter: grayscale(40%);" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                            </div>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <h5 class="fw-bold text-secondary mb-3"><?php echo htmlspecialchars($row['judul']); ?></h5>
                                <div class="mb-3 text-muted fw-medium small">
                                    <i class="bi bi-calendar-check me-2"></i><?php echo date('d F Y', strtotime($row['tanggal'])); ?>
                                </div>
                                <div class="mt-auto">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#modalNews<?php echo $row['id']; ?>">
                                        Baca Dokumentasi
                                    </button>
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

<?php
// Pastikan tidak ada karakter spasi atau baris kosong sebelum <?php
mysqli_data_seek($queryPast, 0); 
while($row = mysqli_fetch_assoc($queryPast)): ?>

<div class="modal fade" id="modalNews<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modalNewsLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="fw-bold" id="modalNewsLabel<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['judul']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="assets/gallery/<?php echo htmlspecialchars($row['poster']); ?>" class="img-fluid rounded mb-3 w-100" onerror="this.src='https://via.placeholder.com/800x400'">
                
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                
                <hr class="my-4">
                
                <h6 class="fw-bold mb-3"><i class="bi bi-images me-2"></i>Galeri Foto:</h6>
                <div class="row g-2">
                    <?php 
                    $galeri = mysqli_query($koneksi, "SELECT * FROM event_gallery WHERE event_id = '".$row['id']."'");
                    if(mysqli_num_rows($galeri) > 0):
                        while($g = mysqli_fetch_assoc($galeri)): ?>
                            <div class="col-6 col-md-4">
                                <img src="assets/gallery/<?php echo $g['foto_path']; ?>" class="img-fluid rounded border shadow-sm" style="width:100%; height:150px; object-fit:cover;">
                            </div>
                        <?php endwhile; 
                    else: ?>
                        <p class="text-muted small">Tidak ada foto dokumentasi tambahan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 80 });
</script>
</body>
</html>