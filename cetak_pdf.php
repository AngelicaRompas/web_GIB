<?php
include 'koneksi.php';
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');
$nama_bulan = date('F', mktime(0, 0, 0, $bulan, 1));
$query = mysqli_query($koneksi, "SELECT * FROM warta_keuangan WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - <?php echo $nama_bulan; ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        @media print {
            .no-print { display: none; }
            @page { size: A4 portrait; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Laporan Keuangan Jemaat</h2>
        <h3>GMIM Imanuel Bahu - <?php echo $nama_bulan . ' ' . $tahun; ?></h3>
    </div>
    <table>
        <thead>
            <tr><th>Tanggal</th><th>Pemasukan</th><th>Pengeluaran</th><th>Saldo</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
            <?php while($data = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($data['tanggal'])); ?></td>
                <td class="text-right">Rp <?php echo number_format($data['total_pemasukan'], 0, ',', '.'); ?></td>
                <td class="text-right">Rp <?php echo number_format($data['total_pengeluaran'], 0, ',', '.'); ?></td>
                <td class="text-right">Rp <?php echo number_format($data['saldo_akhir'], 0, ',', '.'); ?></td>
                <td style="text-align: left;"><?php echo htmlspecialchars($data['keterangan']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <button class="no-print" onclick="window.print()">Cetak Ulang / Simpan PDF</button>
    <a href="warta-keuangan.php" class="no-print">Kembali</a>
</body>
</html>