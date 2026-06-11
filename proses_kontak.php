<?php
// proses_kontak.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validasi Input
    $nama  = htmlspecialchars(strip_tags(trim($_POST["nama"])));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $pesan = htmlspecialchars(trim($_POST["pesan"]));

    // 2. Cek apakah ada field kosong
    if (empty($nama) || empty($email) || empty($pesan) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Harap isi semua kolom dengan benar!'); window.history.back();</script>";
        exit;
    }

    // 3. Konfigurasi Email
    $email_tujuan = "angelicarompas026@student.unsrat.ac.id"; //Jangan lupa ganti dengan email gereja
    $subjek = "Pesan Baru dari Website: " . $nama;

    // Menambahkan header agar lebih sopan dan tidak mudah masuk spam
    $isi_email = "Anda menerima pesan baru melalui website.\n\n";
    $isi_email .= "Nama: $nama\n";
    $isi_email .= "Email: $email\n\n";
    $isi_email .= "Pesan:\n$pesan\n\n";
    $isi_email .= "--- Dikirim dari Website GMIM Imanuel Bahu ---";

    // Header untuk email
    $headers = "From: webmaster@imanuelbahu.org" . "\r\n" . 
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // 4. Proses Kirim
    if (mail($email_tujuan, $subjek, $isi_email, $headers)) {
        echo "<script>alert('Terima kasih! Pesan Anda berhasil terkirim.'); window.location='kontak.php';</script>";
    } else {
        // Jika gagal, ini biasanya karena server belum disetting untuk kirim email
        echo "<script>alert('Maaf, sistem gagal mengirim pesan. Pastikan website sudah di-hosting.'); window.location='kontak.php';</script>";
    }
} else {
    // Jika user mengakses file ini secara langsung tanpa kirim form
    header("Location: kontak.php");
    exit;
}
?>