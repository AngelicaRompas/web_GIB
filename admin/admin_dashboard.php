<?php
session_start();
if (!isset($_SESSION['admin_imanuel'])) { header("Location: ../login.php"); exit; }
include '../koneksi.php';

// Logika data dasar
$queryStat = mysqli_query($koneksi, "SELECT label, jumlah, persentase FROM statistik");
$stats = []; if($queryStat) { while($row = mysqli_fetch_assoc($queryStat)) { $stats[$row['label']] = $row; } }

$dataSejarah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT konten FROM profil WHERE jenis='sejarah'"));

// Menambahkan variabel yang sempat tertinggal agar tidak error di sections/keuangan.php atau struktur.php
$dataSaldo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT saldo_akhir FROM warta_keuangan ORDER BY id DESC LIMIT 1"));
$saldoSebelumnya = $dataSaldo['saldo_akhir'] ?? 0;
$kolomBerikutnya = (mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MAX(kolom) as max_kolom FROM struktur_organisasi WHERE kategori='pelsus'"))['max_kolom'] ?? 28) + 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <?php include 'partials/header.php'; ?>
    <style>
        .tab-content { transition: opacity 0.3s ease; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'partials/sidebar.php'; ?>
        <div class="col-md-9 col-lg-10 p-4 p-md-5">
            <?php include 'partials/alert.php'; ?>

            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade" id="edit-data-jemaat" role="tabpanel"><?php include 'sections/data_jemaat.php'; ?></div>
                <div class="tab-pane fade" id="edit-profil" role="tabpanel"><?php include 'sections/profil.php'; ?></div>
                <div class="tab-pane fade" id="edit-warta" role="tabpanel"><?php include 'sections/warta_jemaat.php'; ?></div>
                <div class="tab-pane fade" id="edit-event" role="tabpanel"><?php include 'sections/event.php'; ?></div>
                <div class="tab-pane fade" id="edit-keuangan" role="tabpanel"><?php include 'sections/keuangan.php'; ?></div>
                <div class="tab-pane fade" id="edit-struktur" role="tabpanel"><?php include 'sections/struktur.php'; ?></div>
                <div class="tab-pane fade" id="edit-renungan" role="tabpanel"><?php include 'sections/renungan.php'; ?></div>
                <div class="tab-pane fade" id="edit-navigasi" role="tabpanel"><?php include 'sections/navigasi.php'; ?></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tabId = urlParams.get('tab') || 'edit-data-jemaat'; 
        
        // Aktifkan tab berdasarkan ID
        const targetPane = document.getElementById(tabId);
        // Mencari tombol yang memiliki data-bs-target yang sesuai dengan tabId
        const targetBtn = document.querySelector(`[data-bs-target="#${tabId}"]`);
        
        if (targetPane && targetBtn) {
            // Bersihkan status aktif sebelumnya
            document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('show', 'active'));
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            
            // Pasang status aktif ke target
            targetPane.classList.add('show', 'active');
            targetBtn.classList.add('active');
        }
    });
</script>
</body>
</html>