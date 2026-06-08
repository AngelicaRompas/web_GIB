<?php
session_start();

// Tambahan: Keamanan agar tidak bisa diakses orang tanpa login
if (!isset($_SESSION['admin_imanuel'])) {
    header("Location: ../login.php");
    exit;
}

include '../../koneksi.php';

if (isset($_POST['simpan_renungan'])) {
    // Amankan input dari karakter berbahaya
    $tanggal      = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $tema         = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pembacaan    = mysqli_real_escape_string($koneksi, $_POST['nas_alkitab']);
    $renungan     = mysqli_real_escape_string($koneksi, $_POST['isi_renungan']);
    $doa          = mysqli_real_escape_string($koneksi, $_POST['doa']);

    // Query simpan ke database
    $sql = "INSERT INTO renungan_harian (tanggal, judul, nas_alkitab, isi_renungan, doa) 
            VALUES ('$tanggal', '$tema', '$pembacaan', '$renungan', '$doa')";

    if (mysqli_query($koneksi, $sql)) {
        // PERBAIKAN: Jalur header harus mundur satu folder (../) dan membuka tab renungan
        header("Location: ../admin_dashboard.php?pesan=sukses_renungan&tab=edit-renungan");
        exit;
    } else {
        die("Error Database: " . mysqli_error($koneksi));
    }
} else {
    // Jika file diakses langsung tanpa lewat form
    header("Location: ../admin_dashboard.php?tab=edit-renungan");
    exit;
}
?>