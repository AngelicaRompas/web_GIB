<?php 
include 'koneksi.php'; 

// Proteksi jika ID tidak ada di URL
if(!isset($_GET['id'])) {
    header("Location: event.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM events WHERE id = '$id'");
$d = mysqli_fetch_assoc($query);

// Jika ID tidak ditemukan di database
if (!$d) {
    echo "<script>alert('Acara tidak ditemukan!'); window.location='event.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $d['judul']; ?> - GMIM Imanuel Bahu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .detail-poster { width: 100%; max-height: 500px; object-fit: contain; background: #000; border-radius: 15px; }
        .content-area { text-align: justify; line-height: 1.8; font-size: 1.1rem; }
    </style>
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Tombol Kembali -->
            <a href="event.php" class="btn btn-link text-decoration-none mb-3 p-0">← Kembali ke Daftar Acara</a>

            <div class="card shadow-sm border-0 p-4 rounded-4">
                <!-- Poster Acara -->
                <img src="assets/images/<?php echo $d['poster']; ?>" class="detail-poster mb-4" alt="Poster Detail" onerror="this.src='https://via.placeholder.com/800x400?text=Poster+Acara'">
                
                <div class="row">
                    <div class="col-md-8">
                        <span class="badge bg-primary mb-2 px-3 py-2"><?php echo $d['kategori_acara']; ?></span>
                        <h1 class="fw-bold display-5 mb-3"><?php echo $d['judul']; ?></h1>
                        
                        <div class="d-flex flex-wrap gap-4 mb-4 text-muted border-bottom pb-3">
                            <div>📍 <strong>Lokasi:</strong> <?php echo $d['lokasi']; ?></div>
                            <div>📅 <strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($d['tanggal'])); ?></div>
                        </div>

                        <div class="content-area">
                            <?php echo nl2br($d['deskripsi']); ?>
                        </div>
                    </div>
                    
                    <!-- Sidebar info singkat -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0 p-3 mt-4 mt-md-0">
                            <h5 class="fw-bold border-bottom pb-2">Informasi Jemaat</h5>
                            <p class="small text-muted">Pastikan Anda hadir tepat waktu sesuai dengan jadwal yang tertera. Tuhan Yesus memberkati.</p>
                            <button class="btn btn-primary w-100 mb-2" onclick="window.print()">Cetak Warta</button>
                            <button class="btn btn-outline-secondary w-100" onclick="navigator.share({title: '<?php echo $d['judul']; ?>', url: window.location.href})">Bagikan Acara</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>