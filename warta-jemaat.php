<?php 
include 'koneksi.php'; 

// Query menggunakan kolom 'tanggal' hasil pembaruan database Anda
$query = mysqli_query($koneksi, "SELECT * FROM warta_jemaat ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warta Jemaat - GMIM Imanuel Bahu</title>
    
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
    
    /* Modifikasi Card Warta dengan Glassmorphism Ungu */
    .warta-card-glass {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 1);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
    .warta-card-glass:hover {
        transform: translateY(-5px);
        /* Shadow ungu saat hover */
        box-shadow: 0 15px 30px rgba(111, 66, 193, 0.12) !important;
    }
    
    .icon-circle {
        width: 50px; height: 50px;
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        /* Warna ungu transparan */
        background: rgba(111, 66, 193, 0.1); 
        color: #6f42c1;
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
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 small mb-3 fw-bold tracking-widest" style="letter-spacing: 2px;">
                <i class="bi bi-journal-text me-2"></i>DOKUMEN JEMAAT
            </span>
        </div>
        <h1 class="main-title-aesthetic mb-3" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="100">
            Warta Jemaat
        </h1>
        <p class="text-muted fw-medium mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            Informasi Pelayanan, Jadwal Ibadah, dan Kegiatan Mimbar GMIM Imanuel Bahu
        </p>
    </div>
</section>

<div class="container pb-5 mb-5 position-relative z-2">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up" data-aos-delay="300">
                <h4 class="fw-bold text-dark m-0"><i class="bi bi-archive-fill text-primary me-2"></i>Arsip Warta Mingguan</h4>
            </div>
            
            <div class="row g-4">
                <?php 
                if(mysqli_num_rows($query) > 0):
                    $delay = 400;
                    while($data = mysqli_fetch_assoc($query)): 
                        $tgl_format = date('d F Y', strtotime($data['tanggal']));
                ?>
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="warta-card-glass shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-circle"><i class="bi bi-file-pdf-fill text-danger"></i></div>
                                <span class="badge bg-white text-secondary border border-secondary border-opacity-25 px-3 py-2 rounded-pill fw-bold">Edisi <?php echo htmlspecialchars($data['nomor_warta']); ?></span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Ibadah Minggu, <?php echo $tgl_format; ?></h5>
                            <p class="text-primary small fw-semibold mb-3">Tema: "<?php echo htmlspecialchars($data['tema_mingguan']); ?>"</p>
                            <p class="text-muted small mb-0" style="font-size: 0.88rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                <strong>Nas:</strong> <?php echo htmlspecialchars($data['pembacaan_alkitab']); ?><br>
                                <?php echo substr(strip_tags($data['isi_warta']), 0, 120) . '...'; ?>
                            </p>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="admin/assets/document_warta/<?php echo htmlspecialchars($data['file_pdf']); ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold">
                                <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh / Baca PDF
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                    $delay += 100;
                    endwhile; 
                else:
                ?>
                <div class="col-12 text-center py-5" data-aos="zoom-in">
                    <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
                        <i class="bi bi-folder-x text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-dark fw-bold">Belum Ada Dokumen</h5>
                        <p class="text-muted small mb-0">Belum ada dokumen warta jemaat yang diterbitkan oleh tim redaksi.</p>
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