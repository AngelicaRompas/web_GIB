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

<div class="card card-custom p-4 mt-4 shadow-sm">
    <h6 class="fw-bold mb-3 text-primary">Tambah Anggota Komisi Baru</h6>
    <form action="proses/proses_datajemaat.php" method="POST">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan (mis: Ketua)" required>
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="bipra">Komisi BIPRA</option>
                    <option value="komisi_kerja">Komisi Kerja</option>
                    <option value="lansia">Lansia</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" name="tambah_anggota_komisi" class="btn btn-success w-100">Simpan</button>
            </div>
        </div>
    </form>
</div>

<div class="card card-custom p-4 mt-3 shadow-sm">
    <h6 class="fw-bold mb-3">Daftar Anggota Komisi Terinput</h6>
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr><th>Nama</th><th>Jabatan</th><th>Kategori</th><th class="text-center">Aksi</th></tr>
        </thead>
        <tbody>
            <?php 
            $q = mysqli_query($koneksi, "SELECT * FROM struktur_organisasi WHERE kategori IN ('bipra', 'komisi_kerja', 'lansia') ORDER BY kategori, id ASC");
            while($k = mysqli_fetch_assoc($q)): ?>
            <tr>
                <td><?php echo htmlspecialchars($k['nama']); ?></td>
                <td><?php echo htmlspecialchars($k['jabatan']); ?></td>
                <td><span class="badge bg-secondary"><?php echo strtoupper($k['kategori']); ?></span></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-warning" 
                            onclick="bukaEdit('<?php echo $k['id']; ?>', '<?php echo htmlspecialchars($k['nama']); ?>', '<?php echo htmlspecialchars($k['jabatan']); ?>', '<?php echo $k['kategori']; ?>')">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <a href="proses/proses_datajemaat.php?hapus_komisi=1&id=<?php echo $k['id']; ?>" 
                       class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div> 

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Anggota Komisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="proses/proses_datajemaat.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" id="edit_nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" id="edit_jabatan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori" id="edit_kategori" class="form-select">
                                    <?php 
                                    $kat = mysqli_query($koneksi, "SELECT * FROM kategori_komisi");
                                    while($r = mysqli_fetch_assoc($kat)) echo "<option value='".$r['nama_kategori']."'>".strtoupper($r['nama_kategori'])."</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_anggota_komisi" class="btn btn-warning">Update Data</button>
                        </div>
                    </form>
                    </div>
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