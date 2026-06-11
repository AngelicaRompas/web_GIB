<?php

include 'koneksi.php';

$keyword = isset($_POST['keyword'])
    ? mysqli_real_escape_string($koneksi,$_POST['keyword'])
    : '';

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM renungan_tematik
     WHERE keyword='$keyword'
     ORDER BY RAND()
     LIMIT 1"
);

if(mysqli_num_rows($query) > 0){

    $data = mysqli_fetch_assoc($query);

    echo '

    <div class="text-start">

        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">
            <i class="bi bi-bookmark-heart me-2"></i>'.$data['keyword'].'
        </span>

        <h5 class="fw-bold text-dark mb-2">
            '.$data['judul'].'
        </h5>

        <p class="text-primary fw-semibold mb-3">
            '.$data['ayat'].'
        </p>

        <div class="text-secondary mb-3" style="line-height:1.9;">
            '.nl2br(htmlspecialchars($data['isi'])).'
        </div>

        <div class="small text-muted">
            <i class="bi bi-stars me-1"></i>
            Renungan ditampilkan secara acak
        </div>

    </div>

    ';

}else{

    echo '

    <div class="text-center py-5">

        <i class="bi bi-journal-x fs-1 text-muted mb-3 d-block"></i>

        <h6 class="fw-bold">
            Renungan Belum Tersedia
        </h6>

        <p class="text-muted mb-0">
            Topik ini belum memiliki data renungan.
        </p>

    </div>

    ';
}

?>