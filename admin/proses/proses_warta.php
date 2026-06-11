<?php
session_start();
if (!isset($_SESSION['admin_imanuel'])) {
    header("Location: ../login.php"); // Perbaiki path redirect login
    exit;
}
include '../../koneksi.php';

if (isset($_POST['upload_warta'])) {
    // Amankan data teks
    $nomor_warta        = mysqli_real_escape_string($koneksi, $_POST['nomor_warta']);
    $tanggal            = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $tema_mingguan      = mysqli_real_escape_string($koneksi, $_POST['tema_mingguan']);
    $pembacaan_alkitab  = mysqli_real_escape_string($koneksi, $_POST['pembacaan_alkitab']);
    $isi_warta          = mysqli_real_escape_string($koneksi, $_POST['isi_warta']);
    
    // Ambil data file
    $file_name  = $_FILES['file_pdf']['name'];
    $file_tmp   = $_FILES['file_pdf']['tmp_name'];
    $file_size  = $_FILES['file_pdf']['size'];
    $file_error = $_FILES['file_pdf']['error'];

    $ekstensi_diperbolehkan = ['pdf', 'jpg', 'jpeg', 'png'];
    $x = explode('.', $file_name);
    $ekstensi = strtolower(end($x));

    if ($file_error === 0) {
        if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
            if ($file_size < 10485760) { 
                
                $nama_file_baru = "doc_warta_" . $tanggal . "_" . uniqid() . "." . $ekstensi;
                
                // PERBAIKAN: Gunakan ../../ untuk menunjuk folder assets di root website
                // Ubah path ini sesuai struktur folder riil jika assets ada di root
                $folder_tujuan = $_SERVER['DOCUMENT_ROOT'] . "/gereja_imanuel/assets/document_warta/" . $nama_file_baru;

                // Periksa apakah folder benar-benar ada, jika belum otomatis dibuat
                if(!is_dir($_SERVER['DOCUMENT_ROOT'] . "/gereja_imanuel/assets/document_warta/")) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . "/gereja_imanuel/assets/document_warta/", 0777, true);
                }

                if (move_uploaded_file($file_tmp, $folder_tujuan)) {
                    $query = "INSERT INTO warta_jemaat (nomor_warta, tanggal, tema_mingguan, pembacaan_alkitab, isi_warta, file_pdf) 
                              VALUES ('$nomor_warta', '$tanggal', '$tema_mingguan', '$pembacaan_alkitab', '$isi_warta', '$nama_file_baru')";
                    
                    if (mysqli_query($koneksi, $query)) {
                        header("Location: ../admin_dashboard.php?pesan=sukses_warta&tab=edit-warta");
                        exit;
                    } else {
                        echo "Error Database: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "Gagal memindahkan berkas. Pastikan folder tujuan dapat diakses.";
                }
            } else {
                echo "Ukuran file terlalu besar (Maksimal 10MB).";
            }
        } else {
            echo "Format ekstensi file wajib PDF atau Gambar.";
        }
    } else {
        echo "Gagal mengunggah berkas warta, kode error: " . $file_error;
    }
} else {
    header("Location: ../admin_dashboard.php?tab=edit-warta");
    exit;
}
?>