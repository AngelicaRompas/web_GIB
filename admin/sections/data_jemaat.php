<h4 class="section-header mb-4"><i class="bi bi-people-fill me-2 text-primary"></i>Pengaturan Analisis Data Jemaat & Statistik</h4>

<form action="proses/proses_datajemaat.php" method="POST">
    <div class="card card-custom p-4 mb-4 shadow-sm">
        <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>Statistik Utama Jemaat</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Jumlah Total Kolom</label>
                <input type="number" name="jml_kolom" class="form-control" value="<?php echo $stats['Kolom']['jumlah'] ?? 0; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Jumlah Total Keluarga</label>
                <input type="number" name="jml_keluarga" class="form-control" value="<?php echo $stats['Keluarga']['jumlah'] ?? 0; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-primary">Jumlah Total Anggota Jemaat (Total Jiwa)</label>
                <input type="number" name="jml_anggota" class="form-control fw-bold border-primary" value="<?php echo $stats['Anggota']['jumlah'] ?? 0; ?>" required>
            </div>
        </div>
    </div>

    <div class="card card-custom p-4 shadow-sm">
        <h5 class="fw-bold mb-1 text-dark"><i class="bi bi-pie-chart-fill me-2 text-success"></i>Komposisi Elemen Grafik Kuantitatif</h5>
        <p class="text-muted small mb-4">*Cukup ketik jumlah jiwa riil saat ini. Nilai presentase (%) halaman pengunjung akan dikalkulasi otomatis oleh server.</p>
        
        <div class="row g-3">
            <div class="col-xl-3 col-md-6 border-end">
                <h6 class="text-primary border-bottom pb-2"><i class="bi bi-gender-ambiguous me-1"></i>Rasio Jenis Kelamin</h6>
                <div class="mb-2">
                    <label class="small fw-bold">Jiwa Laki-laki</label>
                    <input type="number" name="jiwa_pria" class="form-control" value="<?php echo $stats['Laki-laki']['jumlah'] ?? 0; ?>" required>
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Jiwa Perempuan</label>
                    <input type="number" name="jiwa_wanita" class="form-control" value="<?php echo $stats['Perempuan']['jumlah'] ?? 0; ?>" required>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 border-end">
                <h6 class="text-success border-bottom pb-2"><i class="bi bi-water me-1"></i>Sakramen Baptis</h6>
                <div class="mb-2">
                    <label class="small fw-bold">Sudah Baptis (Jiwa)</label>
                    <input type="number" name="jiwa_baptis" class="form-control" value="<?php echo $stats['Sudah Baptis']['jumlah'] ?? 0; ?>" required>
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Belum Baptis (Jiwa)</label>
                    <input type="number" name="jiwa_belum_baptis" class="form-control" value="<?php echo $stats['Belum Baptis']['jumlah'] ?? 0; ?>" required>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 border-end">
                <h6 class="text-info border-bottom pb-2"><i class="bi bi-patch-check-fill me-1"></i>Peneguhan Sidi</h6>
                <div class="mb-2">
                    <label class="small fw-bold">Sudah Sidi (Jiwa)</label>
                    <input type="number" name="jiwa_sidi" class="form-control" value="<?php echo $stats['Sudah Sidi']['jumlah'] ?? 0; ?>" required>
                </div>
                <div class="mb-2">
                    <label class="small fw-bold">Belum Sidi (Jiwa)</label>
                    <input type="number" name="jiwa_belum_sidi" class="form-control" value="<?php echo $stats['Belum Sidi']['jumlah'] ?? 0; ?>" required>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <h6 class="text-warning border-bottom pb-2"><i class="bi bi-diagram-3-fill me-1"></i>BIPRA & Lansia</h6>
                <div class="row g-2">
                    <div class="col-6"><label class="small fw-bold">P/KB</label><input type="number" name="jiwa_pkb" class="form-control" value="<?php echo $stats['P/KB']['jumlah'] ?? 0; ?>" required></div>
                    <div class="col-6"><label class="small fw-bold">W/KI</label><input type="number" name="jiwa_wki" class="form-control" value="<?php echo $stats['W/KI']['jumlah'] ?? 0; ?>" required></div>
                    <div class="col-6"><label class="small fw-bold">Pemuda</label><input type="number" name="jiwa_pemuda" class="form-control" value="<?php echo $stats['Pemuda']['jumlah'] ?? 0; ?>" required></div>
                    <div class="col-6"><label class="small fw-bold">Remaja</label><input type="number" name="jiwa_remaja" class="form-control" value="<?php echo $stats['Remaja']['jumlah'] ?? 0; ?>" required></div>
                    <div class="col-6"><label class="small fw-bold">ASM</label><input type="number" name="jiwa_asm" class="form-control" value="<?php echo $stats['ASM']['jumlah'] ?? 0; ?>" required></div>
                    <div class="col-6"><label class="small fw-bold">Lansia</label><input type="number" name="jiwa_lansia" class="form-control" value="<?php echo $stats['Lansia']['jumlah'] ?? 0; ?>" required></div>
                </div>
            </div>
        </div>

        <hr class="my-4">
        <div class="text-end">
            <button type="submit" name="update_data_jemaat" class="btn btn-primary px-5 shadow-sm">Simpan & Hitung Persentase</button>
        </div>
    </div>
</form>

<!-- ========================= -->
<!-- MANAJEMEN KATEGORI KOMISI -->
<!-- ========================= -->
<div class="card card-custom p-4 mt-3 shadow-sm">
    <h6 class="fw-bold mb-3 text-primary">Manajemen Kategori Komisi</h6>

    <form action="proses/proses_datajemaat.php" method="POST" class="row g-3 mb-4">
        <div class="col-md-9">
            <input type="text"
                   name="nama_kategori"
                   class="form-control"
                   placeholder="Nama Kategori Baru"
                   required>
        </div>
        <div class="col-md-3">
            <button type="submit"
                    name="tambah_kategori"
                    class="btn btn-primary w-100">
                Tambah Kategori
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Kategori</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $kat = mysqli_query(
                    $koneksi,
                    "SELECT * FROM kategori_komisi ORDER BY nama_kategori ASC"
                );

                while($r = mysqli_fetch_assoc($kat)):
                ?>
                <tr>

                    <td>
                        <?php echo htmlspecialchars($r['nama_kategori']); ?>
                    </td>

                    <td class="text-center">

                        <!-- EDIT -->
                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editKategori<?php echo $r['id']; ?>">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <!-- HAPUS -->
                        <a href="proses/proses_datajemaat.php?hapus_kategori=1&id=<?php echo $r['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus kategori ini?')">

                            <i class="bi bi-trash"></i>
                        </a>

                    </td>
                </tr>

                <!-- MODAL EDIT KATEGORI -->
                <div class="modal fade"
                     id="editKategori<?php echo $r['id']; ?>"
                     tabindex="-1">

                    <div class="modal-dialog">

                        <form action="proses/proses_datajemaat.php"
                              method="POST">

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Kategori
                                    </h5>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden"
                                           name="id"
                                           value="<?php echo $r['id']; ?>">

                                    <input type="hidden"
                                           name="nama_lama"
                                           value="<?php echo htmlspecialchars($r['nama_kategori']); ?>">

                                    <label class="form-label">
                                        Nama Kategori
                                    </label>

                                    <input type="text"
                                           name="nama_kategori"
                                           class="form-control"
                                           value="<?php echo htmlspecialchars($r['nama_kategori']); ?>"
                                           required>

                                </div>

                                <div class="modal-footer">

                                    <button type="submit"
                                            name="edit_kategori"
                                            class="btn btn-warning text-white">

                                        Update
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================= -->
<!-- TAMBAH ANGGOTA KOMISI -->
<!-- ========================= -->
<div class="card card-custom p-4 mt-4 shadow-sm">

    <h6 class="fw-bold mb-3 text-primary">
        Tambah Anggota Komisi Baru
    </h6>

    <form action="proses/proses_datajemaat.php" method="POST">

        <div class="row g-3">

            <div class="col-md-3">
                <input type="text"
                       name="nama"
                       class="form-control"
                       placeholder="Nama Lengkap"
                       required>
            </div>

            <div class="col-md-3">
                <input type="text"
                       name="jabatan"
                       class="form-control"
                       placeholder="Jabatan"
                       required>
            </div>

            <div class="col-md-3">

                <select name="kategori"
                        class="form-select"
                        required>

                    <option value="">
                        Pilih Kategori
                    </option>

                    <?php
                    $kat = mysqli_query(
                        $koneksi,
                        "SELECT * FROM kategori_komisi
                         ORDER BY nama_kategori ASC"
                    );

                    while($r = mysqli_fetch_assoc($kat)):
                    ?>

                    <option value="<?php echo htmlspecialchars($r['nama_kategori']); ?>">
                        <?php echo htmlspecialchars($r['nama_kategori']); ?>
                    </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="col-md-3">
                <button type="submit"
                        name="tambah_anggota_komisi"
                        class="btn btn-success w-100">

                    <i class="bi bi-plus-circle me-1"></i>
                    Simpan Anggota
                </button>
            </div>

        </div>

    </form>

</div>

<!-- ========================= -->
<!-- DAFTAR ANGGOTA KOMISI -->
<!-- ========================= -->
<div class="card card-custom p-4 mt-4 shadow-sm">

    <h6 class="fw-bold mb-3 text-primary">
        Daftar Anggota Komisi
    </h6>

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Kategori</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $anggota = mysqli_query(
                    $koneksi,
                    "SELECT so.*
                     FROM struktur_organisasi so
                     INNER JOIN kategori_komisi kk
                     ON so.kategori = kk.nama_kategori
                     ORDER BY so.kategori, so.id"
                );

                while($a = mysqli_fetch_assoc($anggota)):
                ?>

                <tr>

                    <td><?php echo htmlspecialchars($a['nama']); ?></td>

                    <td><?php echo htmlspecialchars($a['jabatan']); ?></td>

                    <td><?php echo htmlspecialchars($a['kategori']); ?></td>

                    <td class="text-center">

                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editAnggota<?php echo $a['id']; ?>">

                            <i class="bi bi-pencil"></i>
                        </button>

                        <a href="proses/proses_datajemaat.php?hapus_komisi=1&id=<?php echo $a['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus anggota komisi ini?')">

                            <i class="bi bi-trash"></i>
                        </a>

                    </td>

                </tr>

                <!-- MODAL EDIT ANGGOTA -->
                <div class="modal fade"
                     id="editAnggota<?php echo $a['id']; ?>"
                     tabindex="-1">

                    <div class="modal-dialog">

                        <form action="proses/proses_datajemaat.php"
                              method="POST">

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Anggota Komisi
                                    </h5>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden"
                                           name="id"
                                           value="<?php echo $a['id']; ?>">

                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text"
                                               name="nama"
                                               class="form-control"
                                               value="<?php echo htmlspecialchars($a['nama']); ?>"
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Jabatan</label>
                                        <input type="text"
                                               name="jabatan"
                                               class="form-control"
                                               value="<?php echo htmlspecialchars($a['jabatan']); ?>"
                                               required>
                                    </div>

                                    <div class="mb-3">

                                        <label>Kategori</label>

                                        <select name="kategori"
                                                class="form-select"
                                                required>

                                            <?php
                                            $kategoriEdit = mysqli_query(
                                                $koneksi,
                                                "SELECT * FROM kategori_komisi
                                                 ORDER BY nama_kategori ASC"
                                            );

                                            while($k = mysqli_fetch_assoc($kategoriEdit)):
                                            ?>

                                            <option
                                                value="<?php echo htmlspecialchars($k['nama_kategori']); ?>"
                                                <?php echo ($a['kategori'] == $k['nama_kategori']) ? 'selected' : ''; ?>>

                                                <?php echo htmlspecialchars($k['nama_kategori']); ?>

                                            </option>

                                            <?php endwhile; ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="submit"
                                            name="edit_anggota_komisi"
                                            class="btn btn-warning text-white">

                                        Update
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<script>
// Fungsi untuk memicu modal
function bukaEdit(id, nama, jabatan, kategori) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_jabatan').value = jabatan;
    document.getElementById('edit_kategori').value = kategori;
    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
}
</script>