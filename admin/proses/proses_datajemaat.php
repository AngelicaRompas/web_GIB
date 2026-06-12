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
// ======================================================
// B. MANAJEMEN ANGGOTA KOMISI
// ======================================================

elseif (isset($_POST['tambah_anggota_komisi'])) {

    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $kategori = trim($_POST['kategori']);

    $stmt = $koneksi->prepare(
        "INSERT INTO struktur_organisasi
        (nama, jabatan, kategori)
        VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "sss",
        $nama,
        $jabatan,
        $kategori
    );

    $stmt->execute();

    header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=sukses_tambah");
    exit;
}

elseif (isset($_POST['edit_anggota_komisi'])) {

    $id = intval($_POST['id']);
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $kategori = trim($_POST['kategori']);

    $stmt = $koneksi->prepare(
        "UPDATE struktur_organisasi
         SET nama = ?, jabatan = ?, kategori = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "sssi",
        $nama,
        $jabatan,
        $kategori,
        $id
    );

    $stmt->execute();

    header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=sukses_edit");
    exit;
}

elseif (isset($_GET['hapus_komisi'])) {

    $id = intval($_GET['id']);

    $stmt = $koneksi->prepare(
        "DELETE FROM struktur_organisasi
         WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../admin_dashboard.php?tab=data-jemaat&pesan=sukses_hapus");
    exit;
}


// ======================================================
// C. MANAJEMEN KATEGORI KOMISI
// ======================================================

elseif (isset($_POST['tambah_kategori'])) {

    $namaKategori = trim($_POST['nama_kategori']);

    if (empty($namaKategori)) {

        header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=kategori_kosong");
        exit;
    }

    // cek duplikat
    $cek = $koneksi->prepare(
        "SELECT id
         FROM kategori_komisi
         WHERE nama_kategori = ?"
    );

    $cek->bind_param("s", $namaKategori);
    $cek->execute();

    if ($cek->get_result()->num_rows > 0) {

        header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=kategori_sudah_ada");
        exit;
    }

    $stmt = $koneksi->prepare(
        "INSERT INTO kategori_komisi
        (nama_kategori)
        VALUES (?)"
    );

    $stmt->bind_param(
        "s",
        $namaKategori
    );

    $stmt->execute();

    header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=sukses_kategori");
    exit;
}

elseif (isset($_POST['edit_kategori'])) {

    $id = intval($_POST['id']);

    $nama_lama = trim($_POST['nama_lama']);
    $nama_baru = trim($_POST['nama_kategori']);

    if (empty($nama_baru)) {

        header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=kategori_kosong");
        exit;
    }

    // cek duplikat kecuali dirinya sendiri
    $cek = $koneksi->prepare(
        "SELECT id
         FROM kategori_komisi
         WHERE nama_kategori = ?
         AND id != ?"
    );

    $cek->bind_param(
        "si",
        $nama_baru,
        $id
    );

    $cek->execute();

    if ($cek->get_result()->num_rows > 0) {

        header("Location: ../admin_dashboard.php?tab=data-jemaat&pesan=kategori_sudah_ada");
        exit;
    }

    // update kategori
    $stmt = $koneksi->prepare(
        "UPDATE kategori_komisi
         SET nama_kategori = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $nama_baru,
        $id
    );

    $stmt->execute();

    // sinkronkan semua anggota
    $stmt2 = $koneksi->prepare(
        "UPDATE struktur_organisasi
         SET kategori = ?
         WHERE kategori = ?"
    );

    $stmt2->bind_param(
        "ss",
        $nama_baru,
        $nama_lama
    );

    $stmt2->execute();

    header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=sukses_edit_kategori");
    exit;
}

elseif (isset($_GET['hapus_kategori'])) {

    $id = intval($_GET['id']);

    // ambil nama kategori
    $cekKategori = $koneksi->prepare(
        "SELECT nama_kategori
         FROM kategori_komisi
         WHERE id = ?"
    );

    $cekKategori->bind_param("i", $id);
    $cekKategori->execute();

    $result = $cekKategori->get_result();

    if ($result->num_rows == 0) {

        header("Location: ../admin_dashboard.php?tab=edit-data-jemaat");
        exit;
    }

    $kategori = $result->fetch_assoc();
    $namaKategori = $kategori['nama_kategori'];

    // cek apakah masih digunakan anggota
    $cekAnggota = $koneksi->prepare(
        "SELECT COUNT(*) AS total
         FROM struktur_organisasi
         WHERE kategori = ?"
    );

    $cekAnggota->bind_param(
        "s",
        $namaKategori
    );

    $cekAnggota->execute();

    $jumlah = $cekAnggota
        ->get_result()
        ->fetch_assoc();

    if ($jumlah['total'] > 0) {

        header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=kategori_dipakai");
        exit;
    }

    $hapus = $koneksi->prepare(
        "DELETE FROM kategori_komisi
         WHERE id = ?"
    );

    $hapus->bind_param(
        "i",
        $id
    );

    $hapus->execute();

    header("Location: ../admin_dashboard.php?tab=edit-data-jemaat&pesan=sukses_hapus_kategori");
    exit;
}

else {

    header("Location: ../admin_dashboard.php?tab=edit-data-jemaat");
    exit;
}
?>