<?php 
include 'navbar.php';
include 'koneksi.php'; 

// 1. Ambil SEMUA data statistik sekali saja
$queryAll = mysqli_query($koneksi, "SELECT label, jumlah, kategori FROM statistik");
$stats = [];
// Kita kelompokkan data per kategori agar fungsi lebih mudah bekerja
$dataPerKategori = []; 

while($row = mysqli_fetch_assoc($queryAll)) {
    $stats[$row['label']] = $row['jumlah'];
    $dataPerKategori[$row['kategori']][] = $row; 
}

$totalAnggota = isset($stats['Anggota']) && $stats['Anggota'] > 0 ? $stats['Anggota'] : 1;

// 2. Fungsi hitung tanpa query ulang
function getDataChart($kategori, $dataPerKategori, $total) {
    $labels = []; $data = [];
    
    // Pastikan kategori ada di dalam array
    if(isset($dataPerKategori[$kategori])) {
        foreach($dataPerKategori[$kategori] as $item) {
            $labels[] = $item['label'];
            // Pastikan data yang diambil benar-benar angka jiwa
            $data[] = (int)$item['jumlah']; 
        }
    }
    
    // Jika data kosong, kirim angka 0 agar tidak ambil data lain
    if(empty($data)) { return [[], [0, 0]]; }
    
    return [$labels, $data];
}

// 3. Panggil fungsi dengan argumen yang benar (tanpa $koneksi)
list($labelsGender, $dataGender) = getDataChart('gender', $dataPerKategori, $totalAnggota);
list($labelsBaptis, $dataBaptis) = getDataChart('baptis', $dataPerKategori, $totalAnggota);
list($labelsSidi, $dataSidi) = getDataChart('sidi', $dataPerKategori, $totalAnggota);
list($labelsBipra, $dataBipra) = getDataChart('bipra', $dataPerKategori, $totalAnggota);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik & Struktur Jemaat - GMIM Imanuel Bahu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style-beranda.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            /* Perubahan utama: Gradient dan warna utama jadi Ungu */
            --primary-gradient: linear-gradient(135deg, #6f42c1 0%, #4a2c85 100%);
            --church-blue: #6f42c1; 
            --slate-dark: #1e293b;
            --soft-slate: #64748b;
            --bg-canvas: #f8fafc;
        }

        body { 
            background-color: var(--bg-canvas); 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-dark);
        }

        /* Navbar diatur agar mengikuti navbar.php (tidak perlu background-color di sini jika sudah di navbar.php) */
        .navbar {
            z-index: 10000 !important;
            position: relative;
        }

        .hero-stat {
            background: var(--primary-gradient);
            color: white;
            padding: 70px 0 130px 0;
            border-radius: 0 0 35px 35px;
            position: relative;
            z-index: 1;
        }

        .container-stats {
            margin-top: -80px;
            position: relative;
            z-index: 5;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }

        .digital-grid { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }
        .aurora-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; overflow: hidden; }

        .stat-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 10px 25px rgba(111, 66, 193, 0.1); 
        }

        .icon-box {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* Warna Light diubah ke nuansa Ungu agar serasi */
        .bg-blue-light { background: #f3effb; color: #6f42c1; }
        .bg-green-light { background: #f0fdf4; color: #16a34a; }
        .bg-orange-light { background: #fff7ed; color: #ea580c; }
        
        .chart-container { 
            position: relative; 
            height: 200px; 
            width: 100%; 
            padding: 5px; 
        }
        
        .card-header-digital {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 14px 18px;
            font-weight: 700;
            color: var(--slate-dark);
            font-size: 0.92rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-pills-custom {
            background: #ffffff;
            padding: 6px;
            border-radius: 50px;
            display: inline-flex;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }
        
        .nav-pills-custom .nav-link {
            color: var(--soft-slate);
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 50px;
            padding: 10px 24px;
            transition: all 0.2s ease;
        }
        
        .nav-pills-custom .nav-link.active {
            background-color: var(--church-blue) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.2);
        }

        .profile-img-container {
            position: relative;
            display: inline-block;
            border-radius: 50%;
            background: #ffffff;
            padding: 4px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .pendeta-pelayan-card img {
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .pendeta-pelayan-card:hover img {
            transform: scale(1.05);
        }

        @media (max-width: 1199.98px) {
            .card-header-digital { font-size: 0.85rem; padding: 12px; }
            .chart-container { height: 180px; }
        }

        @media (max-width: 767.98px) {
            .hero-stat { padding: 50px 0 100px 0; }
            .container-stats { margin-top: -60px; }
            .chart-container { height: 200px; }
            .table-responsive { border-radius: 12px; }
        }
    </style>
</head>
<body>

<div class="digital-grid"></div>
    <div class="aurora-container">
        <div class="aurora-blob blob-blue"></div>
        <div class="aurora-blob blob-soft"></div>
    </div>

<section class="py-5 text-center position-relative z-2" style="padding-top: 6rem; padding-bottom: 3rem;">
    <div class="container">
        <h1 class="fw-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(3rem, 5vw, 4rem); color: #0f172a;">
            Statistik & Struktur Jemaat
        </h1>
        <p class="text-muted fw-medium">Sinkronisasi Terakhir: <?php echo date('d F Y, H:i'); ?></p>
    </div>
</section>

<div class="container container-stats px-4">
    
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold small text-uppercase tracking-wider mb-1">Total Kolom</h6>
                        <h2 class="fw-extrabold mb-0 text-dark"><?php echo number_format($stats['Kolom'] ?? 0, 0, ',', '.'); ?></h2>
                    </div>
                    <div class="icon-box bg-blue-light"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold small text-uppercase tracking-wider mb-1">Total Keluarga</h6>
                        <h2 class="fw-extrabold mb-0 text-dark"><?php echo number_format($stats['Keluarga'] ?? 0, 0, ',', '.'); ?></h2>
                    </div>
                    <div class="icon-box bg-green-light"><i class="bi bi-house-door-fill"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold small text-uppercase tracking-wider mb-1">Anggota Jemaat</h6>
                        <h2 class="fw-extrabold mb-0 text-dark"><?php echo number_format($stats['Anggota'] ?? 0, 0, ',', '.'); ?></h2>
                    </div>
                    <div class="icon-box bg-orange-light"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-header-digital"><i class="bi bi-gender-ambiguous me-2 text-primary"></i>Komposisi Jenis Kelamin</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container"><canvas id="chartGender"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-header-digital"><i class="bi bi-water me-2 text-success"></i>Presentasi Status Baptis</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container"><canvas id="chartBaptis"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-header-digital"><i class="bi bi-patch-check me-2 text-info"></i>Presentasi Status Sidi</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container"><canvas id="chartSidi"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card h-100">
                <div class="card-header-digital"><i class="bi bi-diagram-3 me-2 text-warning"></i>Proporsi Kategorial (BIPRA)</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container"><canvas id="chartBipra"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 pb-5">
        <div class="col-12">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-1"><i class="bi bi-diagram-3-fill text-primary me-2"></i>Struktur Organisasi Jemaat</h3>
                <p class="text-muted small mb-0">Susunan pelayan tata laksana administrasi jemaat aktif</p>
            </div>
            
            <div class="text-center mb-5">
                <ul class="nav nav-pills nav-pills-custom" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-bpmj-tab" data-bs-toggle="pill" data-bs-target="#pills-bpmj" type="button" role="tab">BPMJ & Pendeta</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-pelsus-tab" data-bs-toggle="pill" data-bs-target="#pills-pelsus" type="button" role="tab">Pelayan Khusus Kolom</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-komisi-tab" data-bs-toggle="pill" data-bs-target="#pills-komisi" type="button" role="tab">Komisi Gereja</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-bpmj" role="tabpanel">
                    <?php
                    $getKetua = mysqli_query($koneksi, "SELECT * FROM struktur_organisasi WHERE jabatan='Ketua BPMJ' AND kategori='bpmj' LIMIT 1");
                    $ketua = mysqli_fetch_assoc($getKetua);
                    ?>
                    <div class="row g-4 justify-content-center text-center mb-5">
                        <div class="col-sm-8 col-md-6 col-lg-4">
                            <div class="card stat-card p-4 border-top border-primary border-4 shadow-sm">
                                <div class="profile-img-container mb-3">
                                    <img src="<?php 
                                        if (!empty($ketua['foto']) && file_exists("assets/images/" . $ketua['foto'])) {
                                            echo "assets/images/" . $ketua['foto'];
                                        } else {
                                            echo "assets/images/default-user.jpg";
                                        }
                                    ?>" class="rounded-circle border border-2 border-muted" alt="Ketua BPMJ" style="width: 110px; height: 110px; object-fit: cover;">
                                </div>
                                <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem;"><?php echo $getKetua && $ketua ? htmlspecialchars($ketua['nama']) : 'Pdt. [Belum Diatur], M.Th'; ?></h5>
                                <p class="text-primary small fw-bold text-uppercase mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Ketua BPMJ</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center text-center mb-5">
                        <?php
                        $getPerangkat = mysqli_query($koneksi, "SELECT * FROM struktur_organisasi WHERE kategori='bpmj' AND jabatan != 'Ketua BPMJ' AND jabatan NOT LIKE '%Pendeta%' AND jabatan NOT LIKE '%Pdt%' ORDER BY id ASC");
                        while($p = mysqli_fetch_assoc($getPerangkat)):
                        ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card stat-card p-4 h-100 shadow-sm">
                                <div class="profile-img-container mb-3">
                                    <img src="<?php 
                                        if (!empty($p['foto']) && file_exists("assets/images/" . $p['foto'])) {
                                            echo "assets/images/" . $p['foto'];
                                        } else {
                                            echo "assets/images/default-user.jpg";
                                        }
                                    ?>" class="rounded-circle border border-2 border-primary border-opacity-25" alt="<?php echo $p['jabatan']; ?>" style="width: 90px; height: 90px; object-fit: cover;">
                                </div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($p['nama']); ?></h6>
                                <p class="text-muted small mb-0 fw-semibold" style="font-size: 0.8rem;"><?php echo htmlspecialchars($p['jabatan']); ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="row g-4 justify-content-center text-center">
                        <?php
                        $getPendeta = mysqli_query($koneksi, "SELECT * FROM struktur_organisasi WHERE kategori='bpmj' AND (jabatan LIKE '%Pendeta%' OR jabatan LIKE '%Pdt%') AND jabatan != 'Ketua BPMJ' ORDER BY id ASC");
                        while($pd = mysqli_fetch_assoc($getPendeta)):
                        ?>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card stat-card p-3 h-100 border-0 bg-transparent shadow-none pendeta-pelayan-card">
                                <img src="<?php 
                                    if (!empty($pd['foto']) && file_exists("assets/images/" . $pd['foto'])) {
                                        echo "assets/images/" . $pd['foto'];
                                    } else {
                                        echo "assets/images/default-user.jpg";
                                    }
                                ?>" class="rounded-circle mx-auto mb-2 border border-2 border-slate" style="width: 80px; height: 80px; object-fit: cover;" alt="Pendeta Pelayan">
                                <p class="small fw-bold mb-0 text-dark" style="font-size: 0.85rem;"><?php echo htmlspecialchars($pd['nama']); ?></p>
                                <span class="text-muted d-block mt-1" style="font-size: 11px;"><?php echo htmlspecialchars($pd['jabatan']); ?></span>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-pelsus" role="tabpanel">
                    <div class="card stat-card p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                            <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;"><i class="bi bi-people-fill me-2 text-primary"></i>Daftar Pelayan Khusus Jemaat</h5>
                            <div class="input-group" style="max-width: 280px;">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" id="cariKolom" class="form-control bg-light border-start-0 text-sm" placeholder="Cari nomor wilayah kolom...">
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border-0 mb-0" id="tabelPelsus">
                                <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <tr>
                                        <th style="width: 20%; padding: 15px;">Kolom ID</th>
                                        <th style="padding: 15px;">Pelayan Struktural (Penatua)</th>
                                        <th style="padding: 15px;">Pelayan Diakonia (Diaken)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark" style="font-size: 0.9rem;">
                                    <?php 
                                    $getJumlahKolomAktif = mysqli_query($koneksi, "SELECT DISTINCT kolom FROM struktur_organisasi WHERE kategori='pelsus' ORDER BY kolom ASC");
                                    while($kRow = mysqli_fetch_assoc($getJumlahKolomAktif)):
                                        $i = $kRow['kolom']; 

                                        $getPnt = mysqli_query($koneksi, "SELECT nama FROM struktur_organisasi WHERE kategori='pelsus' AND kolom='$i' AND jabatan='Penatua' LIMIT 1");
                                        $pnt = mysqli_fetch_assoc($getPnt);
                                        
                                        $getDkn = mysqli_query($koneksi, "SELECT nama FROM struktur_organisasi WHERE kategori='pelsus' AND kolom='$i' AND jabatan='Diaken' LIMIT 1");
                                        $dkn = mysqli_fetch_assoc($getDkn);
                                    ?>
                                    <tr>
                                        <td class="fw-bold text-primary" style="padding: 15px;">Kolom <?php echo $i; ?></td>
                                        <td style="padding: 15px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-patch-check-fill text-success fs-5"></i>
                                                <span class="fw-semibold">Pnt. <?php echo !empty($pnt['nama']) ? htmlspecialchars($pnt['nama']) : '[Belum Diinput]'; ?></span>
                                            </div>
                                        </td>
                                        <td style="padding: 15px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-patch-check text-info fs-5"></i>
                                                <span class="fw-semibold">Dkn. <?php echo !empty($dkn['nama']) ? htmlspecialchars($dkn['nama']) : '[Belum Diinput]'; ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-komisi" role="tabpanel">
    <div class="row g-4">
        <?php 
        // Daftar kategori dan judulnya
        $kategori_list = [
            'bipra' => 'Komisi BIPRA', 
            'komisi_kerja' => 'Komisi Kerja', 
            'lansia' => 'Lansia'
        ];

        foreach($kategori_list as $cat => $title): ?>
        <div class="col-md-4">
            <div class="card stat-card p-4 h-100 shadow-sm border-0" style="background: rgba(255, 255, 255, 0.9);">
                <h5 class="fw-bold text-primary mb-4 text-center border-bottom pb-2"><?php echo $title; ?></h5>
                <div class="d-flex flex-column gap-2">
                    <?php 
                    $q = mysqli_query($koneksi, "SELECT * FROM struktur_organisasi WHERE kategori='$cat' ORDER BY id ASC");
                    if(mysqli_num_rows($q) > 0):
                        while($r = mysqli_fetch_assoc($q)): ?>
                            <div class="p-2 border-bottom border-light">
                                <span class="fw-bold text-dark d-block"><?php echo htmlspecialchars($r['nama']); ?></span>
                                <span class="text-muted" style="font-size: 0.85rem;"><?php echo htmlspecialchars($r['jabatan']); ?></span>
                            </div>
                        <?php endwhile; 
                    else: ?>
                        <p class="text-muted text-center small">Data belum tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
            </div>
        </div>
    </div>
</div>

<script>
    Chart.defaults.font.family = "'Plus Jakarta Sans', -apple-system, sans-serif";
    Chart.defaults.plugins.legend.display = false; 
    Chart.defaults.plugins.tooltip.enabled = true; 

    // OPSI TOOLTIP KUSTOM
    const opsiTooltipKustom = {
        padding: 12,
        cornerRadius: 10,
        callbacks: {
            label: function(context) {
                return context.label + ': ' + context.raw + ' Jiwa';
            }
        }
    };

    // 1. CHART GENDER (Hanya deklarasikan SEKALI)
    new Chart(document.getElementById('chartGender'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labelsGender); ?>,
            datasets: [{
                data: <?php echo json_encode($dataGender); ?>, 
                backgroundColor: ['#2563eb', '#f59e0b'],
                borderWidth: 0, hoverOffset: 6
            }]
        },
        options: { 
            maintainAspectRatio: false, 
            cutout: '75%',
            plugins: { tooltip: opsiTooltipKustom } 
        }
    });

    // 2. CHART BAPTIS
    new Chart(document.getElementById('chartBaptis'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labelsBaptis); ?>,
            datasets: [{
                data: <?php echo json_encode($dataBaptis); ?>,
                backgroundColor: ['#16a34a', '#cbd5e1'],
                borderWidth: 0, hoverOffset: 6
            }]
        },
        options: { 
            maintainAspectRatio: false, 
            cutout: '75%',
            plugins: { tooltip: opsiTooltipKustom }
        }
    });

    // 3. CHART SIDI
    new Chart(document.getElementById('chartSidi'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labelsSidi); ?>,
            datasets: [{
                data: <?php echo json_encode($dataSidi); ?>,
                backgroundColor: ['#0dcaf0', '#6c757d'],
                borderWidth: 0, hoverOffset: 6
            }]
        },
        options: { 
            maintainAspectRatio: false, 
            cutout: '75%',
            plugins: { tooltip: opsiTooltipKustom }
        }
    });

    // 4. CHART BIPRA
    new Chart(document.getElementById('chartBipra'), {
        type: 'polarArea',
        data: {
            labels: <?php echo json_encode($labelsBipra); ?>,
            datasets: [{
                data: <?php echo json_encode($dataBipra); ?>,
                backgroundColor: ['rgba(0, 86, 179, 0.85)', 'rgba(25, 135, 84, 0.85)', 'rgba(214, 51, 132, 0.85)', 'rgba(102, 16, 242, 0.85)', 'rgba(255, 193, 7, 0.85)', 'rgba(108, 117, 125, 0.85)'],
                borderWidth: 1
            }]
        },
        options: { 
            maintainAspectRatio: false,
            plugins: { tooltip: opsiTooltipKustom }
        }
    });
    
    // 5. Live Search Table Kolom Pelsus
    document.getElementById('cariKolom').addEventListener('keyup', function(){
        let filter = this.value.toUpperCase();
        let rows = document.getElementById('tabelPelsus').getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            let td = rows[i].getElementsByTagName('td')[0];
            if (td) {
                let text = td.textContent || td.innerText;
                rows[i].style.display = text.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>