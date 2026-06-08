<?php
session_start();
if (!isset($_SESSION['admin_imanuel'])) { 
    header("Location: ../login.php"); 
    exit; 
}
include '../../koneksi.php';

if (isset($_POST['update_data_jemaat'])) {
    
    // Ambil Total Anggota Jemaat
    $total_anggota = intval($_POST['jml_anggota']);
    if ($total_anggota <= 0) { $total_anggota = 1; }

    $data_to_update = [
        'Kolom'        => $_POST['jml_kolom'],
        'Keluarga'     => $_POST['jml_keluarga'],
        'Anggota'      => $_POST['jml_anggota'],
        'Laki-laki'    => $_POST['jiwa_pria'],
        'Perempuan'    => $_POST['jiwa_wanita'],
        'Sudah Baptis' => $_POST['jiwa_baptis'],
        'Belum Baptis' => $_POST['jiwa_belum_baptis'],
        'Sudah Sidi'   => $_POST['jiwa_sidi'],
        'Belum Sidi'   => $_POST['jiwa_belum_sidi'],
        'P/KB'         => $_POST['jiwa_pkb'],
        'W/KI'         => $_POST['jiwa_wki'],
        'Pemuda'       => $_POST['jiwa_pemuda'],
        'Remaja'       => $_POST['jiwa_remaja'],
        'ASM'          => $_POST['jiwa_asm'],
        'Lansia'       => $_POST['jiwa_lansia']
    ];

    foreach ($data_to_update as $label => $jumlah) {
        $val = intval($jumlah);
        
        // Hitung persentase baru berdasarkan input terbaru
        // Gunakan IF untuk mengecualikan kolom yang tidak perlu persentase
        if (in_array($label, ['Kolom', 'Keluarga', 'Anggota'])) {
            $persen = 0; // Tidak perlu persentase
        } else {
            $persen = round(($val / $total_anggota) * 100, 1);
        }

        // UPDATE SATU KALI SAJA untuk setiap label agar tidak terjadi selisih
        $stmt = $koneksi->prepare("UPDATE statistik SET jumlah = ?, persentase = ? WHERE label = ?");
        $stmt->bind_param("ids", $val, $persen, $label);
        $stmt->execute();
    }

    header("Location: ../admin_dashboard.php?pesan=sukses_jemaat&tab=edit-data-jemaat");
    exit;
}

// B. Logika Komisi (TAMBAHAN)
elseif (isset($_POST['tambah_anggota_komisi'])) {
    $stmt = $koneksi->prepare("INSERT INTO struktur_organisasi (nama, jabatan, kategori) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['nama'], $_POST['jabatan'], $_POST['kategori']);
    $stmt->execute();
    header("Location: ../data_jemaat.php?pesan=sukses_tambah");
    exit;
}

elseif (isset($_POST['edit_anggota_komisi'])) {
    $stmt = $koneksi->prepare("UPDATE struktur_organisasi SET nama = ?, jabatan = ?, kategori = ? WHERE id = ?");
    $stmt->bind_param("sssi", $_POST['nama'], $_POST['jabatan'], $_POST['kategori'], $_POST['id']);
    $stmt->execute();
    header("Location: ../admin_dashboard.php?tab=data-jemaat&pesan=sukses_edit");
    exit;
}

elseif (isset($_GET['hapus_komisi'])) {
    $stmt = $koneksi->prepare("DELETE FROM struktur_organisasi WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    header("Location: ../admin_dashboard.php?tab=data-jemaat&pesan=sukses_hapus");
    exit;
}

else {
    // Jika file ini diakses langsung tanpa aksi apapun
    header("Location: ../admin_dashboard.php?tab=data-jemaat");
    exit;
}

?>