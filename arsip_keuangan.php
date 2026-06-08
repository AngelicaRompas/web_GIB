<?php 
include 'koneksi.php'; 

// Cek apakah dipanggil via modal
$is_modal = isset($_GET['is_modal']);

$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

$query = mysqli_query($koneksi, "SELECT * FROM warta_keuangan WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal ASC");
$nama_bulan = date('F', mktime(0, 0, 0, $bulan, 1));
?>

<?php if(!$is_modal): ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Arsip Laporan Keuangan <?php echo $nama_bulan . ' ' . $tahun; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    /* Styling Dasar */
    .table-glass-container { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); }
    .table-bordered th, .table-bordered td { border: 1px solid #dee2e6 !important; }
    
    /* PENGATURAN CETAK (PRINT) AGAR RAPI */
    @media print {
        /* Sembunyikan semua elemen selain container utama */
        body * { visibility: hidden; }
        .table-glass-container, .table-glass-container * { visibility: visible; }
        
        /* Posisikan tabel di pojok kiri atas saat print */
        .table-glass-container { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%; 
            padding: 0;
            background: #ffffff !important; 
        }

        /* Hilangkan tombol agar tidak ikut tercetak */
        .btn, .d-flex div { display: none !important; }

        /* Pastikan tabel memenuhi lebar kertas */
        .table { width: 100% !important; border-collapse: collapse !important; }
        .table th, .table td { border: 1px solid #000 !important; padding: 8px !important; }
        
        /* Judul laporan */
        h3 { color: #000 !important; font-size: 18px !important; margin-bottom: 20px !important; }
    }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5 pt-5">
<?php endif; ?>

    <div class="table-glass-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold"><i class="bi bi-archive me-2"></i>Arsip: <?php echo $nama_bulan . ' ' . $tahun; ?></h3>
            
            <div>
                <a href="cetak_pdf.php?bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-danger" target="_blank">
                    <i class="bi bi-file-pdf"></i> Download PDF
                </a>
                <?php if(!$is_modal): ?>
                    <a href="warta-keuangan.php" class="btn btn-outline-primary ms-2"><i class="bi bi-arrow-left"></i> Kembali</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle table-custom">
                <thead>
                    <tr class="text-center bg-light">
                        <th>Tanggal</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                        <th>Saldo</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0): while($data = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="text-center"><?php echo date('d/m/Y', strtotime($data['tanggal'])); ?></td>
                        <td class="text-end text-success fw-bold">Rp <?php echo number_format($data['total_pemasukan'], 0, ',', '.'); ?></td>
                        <td class="text-end text-danger fw-bold">Rp <?php echo number_format($data['total_pengeluaran'], 0, ',', '.'); ?></td>
                        <td class="text-end fw-bold">Rp <?php echo number_format($data['saldo_akhir'], 0, ',', '.'); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($data['keterangan'])); ?></td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data untuk periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php if(!$is_modal): ?>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php endif; ?>