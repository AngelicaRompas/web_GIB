<?php
session_start();
// Pastikan koneksi ke database benar
include '../../koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_imanuel'])) {
    header("Location: ../login.php");
    exit;
}

// Mengambil aksi dari form (POST) atau link (GET)
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// --- 1. PROSES SEJARAH ---
if ($aksi == 'update_sejarah') {
    $konten = $_POST['konten_sejarah'] ?? '';
    $stmt = $koneksi->prepare("UPDATE profil SET konten = ? WHERE jenis = 'sejarah'");
    $stmt->bind_param("s", $konten);
    if ($stmt->execute()) {
        header("Location: ../admin_dashboard.php?tab=edit-profil&pesan=sukses_sejarah");
    } else {
        echo "Error Update Sejarah: " . $koneksi->error;
    }
    exit;
}

// --- 2. PROSES TAMBAH / EDIT KETUA ---
elseif ($aksi == 'save_ketua') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'] ?? '';
    $mulai = $_POST['tahun_mulai'] ?? '';
    $selesai = $_POST['tahun_selesai'] ?? '';
    $foto_lama = $_POST['foto_lama'] ?? '';
    $foto = $foto_lama;

    // Proses upload foto
    if (!empty($_FILES['foto']['name'])) {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $nama_file = $_FILES['foto']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $foto = time() . '_' . basename($nama_file);
            $target_dir = "../../assets/images/";
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto)) {
                // Hapus foto lama jika ada
                if (!empty($foto_lama) && file_exists($target_dir . $foto_lama)) {
                    unlink($target_dir . $foto_lama);
                }
            }
        }
    }

    if ($id) {
        // Mode Edit
        $stmt = $koneksi->prepare("UPDATE ketua_jemaat SET nama=?, tahun_mulai=?, tahun_selesai=?, foto=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $mulai, $selesai, $foto, $id);
    } else {
        // Mode Tambah
        $stmt = $koneksi->prepare("INSERT INTO ketua_jemaat (nama, tahun_mulai, tahun_selesai, foto) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $mulai, $selesai, $foto);
    }
    
    if ($stmt->execute()) {
        header("Location: ../admin_dashboard.php?tab=edit-profil&pesan=sukses_ketua");
    } else {
        echo "Error Database: " . $koneksi->error;
    }
    exit;
}

// --- 3. PROSES HAPUS KETUA ---
elseif ($aksi == 'hapus_ketua') {
    $id = $_GET['id'] ?? 0;
    
    // Ambil data foto untuk dihapus dari server
    $res = mysqli_query($koneksi, "SELECT foto FROM ketua_jemaat WHERE id='$id'");
    $d = mysqli_fetch_assoc($res);
    
    if ($d && !empty($d['foto'])) {
        $path_foto = "../../assets/images/" . $d['foto'];
        if (file_exists($path_foto)) {
            unlink($path_foto);
        }
    }
    
    // Hapus dari database
    if (mysqli_query($koneksi, "DELETE FROM ketua_jemaat WHERE id='$id'")) {
        header("Location: ../admin_dashboard.php?tab=edit-profil&pesan=hapus_sukses");
    } else {
        echo "Error Hapus: " . mysqli_error($koneksi);
    }
    exit;
}

// Jika tidak ada aksi yang cocok
header("Location: ../admin_dashboard.php?tab=edit-profil");
exit;
?>