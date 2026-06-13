<?php
session_start();
// PERBAIKAN PATH: Kembali ke luar folder proses
if (!isset($_SESSION['admin_imanuel'])) {
    header("Location: ../login.php");
    exit;
}
include '../../koneksi.php';

// ========================================================
// 1. PROSES EDIT / UPDATE DATA BPMJ & PENDETA EXISTING
// ========================================================
if (isset($_POST['simpan_edit_bpmj'])) {
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']); // Disesuaikan dengan form HTML
    
    $file_name  = $_FILES['foto_profil']['name'];
    $file_tmp   = $_FILES['foto_profil']['tmp_name'];
    $file_error = $_FILES['foto_profil']['error'];

    if ($file_error === 0) {
        $x = explode('.', $file_name);
        $ekstensi = strtolower(end($x));
        $nama_foto_baru = "profile_" . uniqid() . "." . $ekstensi;
        
        // PERBAIKAN PATH UPLOAD: Naik dua direktori ke root
        $folder_tujuan  = "../../assets/images/" . $nama_foto_baru;

        if (move_uploaded_file($file_tmp, $folder_tujuan)) {
            $query = "UPDATE struktur_organisasi SET nama='$nama', foto='$nama_foto_baru' WHERE jabatan='$jabatan' AND kategori='bpmj'";
        }
    } else {
        $query = "UPDATE struktur_organisasi SET nama='$nama' WHERE jabatan='$jabatan' AND kategori='bpmj'";
    }

    if (mysqli_query($koneksi, $query)) {
        // PERBAIKAN PATH REDIRECT + TAB
        header("Location: ../admin_dashboard.php?pesan=sukses_struktur&tab=edit-struktur");
        exit;
    } else {
        die("Gagal memperbarui database BPMJ: " . mysqli_error($koneksi));
    }
}

// ========================================================
// 2. PROSES EDIT / UPDATE DATA PELSUS PER KOLOM EXISTING
// ========================================================
elseif (isset($_POST['simpan_edit_pelsus'])) {
    $kolom        = intval($_POST['nomor_kolom']);
    $nama_penatua = mysqli_real_escape_string($koneksi, $_POST['nama_penatua']);
    $nama_diaken  = mysqli_real_escape_string($koneksi, $_POST['nama_diaken']);

    $queryPnt = "UPDATE struktur_organisasi SET nama='$nama_penatua' WHERE kolom='$kolom' AND jabatan='Penatua'";
    mysqli_query($koneksi, $queryPnt);

    $queryDkn = "UPDATE struktur_organisasi SET nama='$nama_diaken' WHERE kolom='$kolom' AND jabatan='Diaken'";
    mysqli_query($koneksi, $queryDkn);

    header("Location: ../admin_dashboard.php?pesan=sukses_struktur&tab=edit-struktur");
    exit;
}

// ========================================================
// 3. PROSES TAMBAH JABATAN BARU (TANPA NAMA & FOTO)
// ========================================================
elseif (isset($_POST['simpan_tambah_bpmj'])) {

    $jabatan_baru = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['jabatan_baru'])
    );

    // Cegah jabatan ganda
    $cek = mysqli_query(
        $koneksi,
        "SELECT id FROM struktur_organisasi
         WHERE kategori='bpmj'
         AND jabatan='$jabatan_baru'"
    );

    if(mysqli_num_rows($cek) > 0){
        header("Location: ../admin_dashboard.php?pesan=jabatan_sudah_ada&tab=edit-struktur");
        exit;
    }

    $query = "
        INSERT INTO struktur_organisasi
        (
            kategori,
            jabatan,
            nama,
            foto
        )
        VALUES
        (
            'bpmj',
            '$jabatan_baru',
            '',
            'default-user.jpg'
        )
    ";

    if (mysqli_query($koneksi, $query)) {

        header("Location: ../admin_dashboard.php?pesan=sukses_struktur&tab=edit-struktur");
        exit;

    } else {

        die("Gagal menambah jabatan baru: " . mysqli_error($koneksi));

    }
}

// ========================================================
// 4. FITUR BARU: PROSES TAMBAH EXPANSION KOLOM BARU (PELSUS)
// ========================================================
elseif (isset($_POST['simpan_tambah_kolom'])) {
    $kolom_baru   = intval($_POST['nomor_kolom_baru']);
    $nama_penatua = mysqli_real_escape_string($koneksi, $_POST['nama_penatua_awal']); // Disesuaikan nama form html
    $nama_diaken  = mysqli_real_escape_string($koneksi, $_POST['nama_diaken_awal']); // Disesuaikan nama form html

    $insertPnt = "INSERT INTO struktur_organisasi (kategori, jabatan, nama, kolom) VALUES ('pelsus', 'Penatua', '$nama_penatua', '$kolom_baru')";
    mysqli_query($koneksi, $insertPnt);

    $insertDkn = "INSERT INTO struktur_organisasi (kategori, jabatan, nama, kolom) VALUES ('pelsus', 'Diaken', '$nama_diaken', '$kolom_baru')";
    mysqli_query($koneksi, $insertDkn);

    header("Location: ../admin_dashboard.php?pesan=sukses_struktur&tab=edit-struktur");
    exit;
}

// ========================================================
// JIKA DIAKSES LANGSUNG TANPA POST DARI FORM
// ========================================================
else {
    header("Location: ../admin_dashboard.php?tab=edit-struktur");
    exit;
}
?>