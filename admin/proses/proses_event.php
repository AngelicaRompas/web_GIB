<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_imanuel'])) { header("Location: ../login.php"); exit; }

if (isset($_POST['simpan_event'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori_acara']);
    mysqli_query($koneksi, "INSERT INTO events (judul, deskripsi, tanggal, poster, lokasi, kategori_acara) VALUES ('$judul', '$deskripsi', '$tanggal', 'default.jpg', '$lokasi', '$kategori')");
    header("Location: ../admin_dashboard.php?pesan=sukses_event&tab=edit-event");
    exit;
}

if (isset($_POST['edit_event'])) {
    $id = $_POST['id_event'];
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    mysqli_query($koneksi, "UPDATE events SET judul='$judul', deskripsi='$deskripsi', tanggal='$tanggal', lokasi='$lokasi' WHERE id='$id'");
    header("Location: ../admin_dashboard.php?pesan=sukses_event&tab=edit-event");
    exit;
}

if (isset($_GET['hapus_event'])) {
    $id_hapus = intval($_GET['hapus_event']);
    mysqli_query($koneksi, "DELETE FROM events WHERE id='$id_hapus'");
    header("Location: ../admin_dashboard.php?pesan=sukses_hapus_event&tab=edit-event");
    exit;
}
?>