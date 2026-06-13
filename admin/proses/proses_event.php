<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_imanuel'])) { header("Location: ../login.php"); exit; }

// FOLDER PENYIMPANAN: Berada satu tingkat di atas folder 'proses'
$upload_path = "../assets/gallery/";

// 1. SIMPAN EVENT BARU
if (isset($_POST['simpan_event'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori_acara']);

    $poster = "default.jpg";
    if (!empty($_FILES['poster']['name'])) {
        $poster = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $_FILES['poster']['name']);
        move_uploaded_file($_FILES['poster']['tmp_name'], $upload_path . $poster);
    }

    mysqli_query($koneksi, "INSERT INTO events (judul, deskripsi, tanggal, poster, lokasi, kategori_acara) VALUES ('$judul', '$deskripsi', '$tanggal', '$poster', '$lokasi', '$kategori')");
    $event_id = mysqli_insert_id($koneksi);

    if (!empty($_FILES['galeri']['name'][0])) {
        foreach ($_FILES['galeri']['tmp_name'] as $key => $tmp_name) {
            $nama_galeri = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $_FILES['galeri']['name'][$key]);
            if (move_uploaded_file($tmp_name, $upload_path . $nama_galeri)) {
                mysqli_query($koneksi, "INSERT INTO event_gallery (event_id, foto_path) VALUES ('$event_id', '$nama_galeri')");
            }
        }
    }
    header("Location: ../admin_dashboard.php?pesan=sukses&tab=edit-event");
    exit;
}

// 2. EDIT EVENT
if (isset($_POST['edit_event'])) {
    $id = intval($_POST['id_event']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);

    mysqli_query($koneksi, "UPDATE events SET judul='$judul', deskripsi='$deskripsi', tanggal='$tanggal', lokasi='$lokasi' WHERE id='$id'");

    // Update Poster
    if (!empty($_FILES['poster']['name'])) {
        $old = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT poster FROM events WHERE id='$id'"));
        if ($old['poster'] != 'default.jpg' && file_exists($upload_path . $old['poster'])) {
            unlink($upload_path . $old['poster']);
        }
        $poster_baru = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $_FILES['poster']['name']);
        move_uploaded_file($_FILES['poster']['tmp_name'], $upload_path . $poster_baru);
        mysqli_query($koneksi, "UPDATE events SET poster='$poster_baru' WHERE id='$id'");
    }

    // Tambah Galeri
    if (!empty($_FILES['galeri']['name'][0])) {
        foreach ($_FILES['galeri']['tmp_name'] as $key => $tmp_name) {
            $nama_galeri = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $_FILES['galeri']['name'][$key]);
            if (move_uploaded_file($tmp_name, $upload_path . $nama_galeri)) {
                mysqli_query($koneksi, "INSERT INTO event_gallery (event_id, foto_path) VALUES ('$id', '$nama_galeri')");
            }
        }
    }
    header("Location: ../admin_dashboard.php?pesan=update_sukses&tab=edit-event");
    exit;
}

// 3. HAPUS EVENT
if (isset($_GET['hapus_event'])) {
    $id_hapus = intval($_GET['hapus_event']);
    
    $data_event = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT poster FROM events WHERE id='$id_hapus'"));
    if ($data_event && $data_event['poster'] != 'default.jpg' && file_exists($upload_path . $data_event['poster'])) {
        unlink($upload_path . $data_event['poster']);
    }
    
    $galeri = mysqli_query($koneksi, "SELECT foto_path FROM event_gallery WHERE event_id='$id_hapus'");
    while ($g = mysqli_fetch_assoc($galeri)) {
        if (file_exists($upload_path . $g['foto_path'])) {
            unlink($upload_path . $g['foto_path']);
        }
    }
    
    mysqli_query($koneksi, "DELETE FROM events WHERE id='$id_hapus'");
    mysqli_query($koneksi, "DELETE FROM event_gallery WHERE event_id='$id_hapus'");
    
    header("Location: ../admin_dashboard.php?pesan=hapus_sukses&tab=edit-event");
    exit;
}
?>