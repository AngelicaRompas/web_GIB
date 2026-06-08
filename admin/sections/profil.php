<h4 class="section-header"><i class="bi bi-person-gear me-2 text-primary"></i>Pengaturan Menu Profil & Sejarah</h4>

<div class="card card-custom p-4 mb-5">
    <h5 class="fw-bold mb-3 text-dark">Narasi Sejarah Pendirian Jemaat</h5>
    <form action="proses/proses_profil.php" method="POST">
        <input type="hidden" name="aksi" value="update_sejarah">
        <div class="mb-4">
            <textarea name="konten_sejarah" class="form-control" rows="10"><?php echo htmlspecialchars($dataSejarah['konten'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan Narasi</button>
    </form>
</div>

<div class="card card-custom p-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark m-0">Daftar Ketua Jemaat</h5>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKetua">
            <i class="bi bi-plus-lg me-1"></i> Tambah Ketua
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Tahun Menjabat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM ketua_jemaat ORDER BY tahun_mulai ASC");
                while ($k = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td>
                        <img src="../assets/images/<?php echo !empty($k['foto']) ? $k['foto'] : 'default.jpg'; ?>" 
                             width="50" class="rounded-circle shadow-sm">
                    </td>
                    <td><?php echo htmlspecialchars($k['nama']); ?></td>
                    <td><?php echo htmlspecialchars($k['tahun_mulai']) . ' - ' . htmlspecialchars($k['tahun_selesai']); ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditKetua<?php echo $k['id']; ?>">
                            <i class="bi bi-pencil-square text-white"></i>
                        </button>
                        <a href="proses/proses_profil.php?aksi=hapus_ketua&id=<?php echo $k['id']; ?>" 
                           class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                           <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahKetua" tabindex="-1">
    <div class="modal-dialog">
        <form action="proses/proses_profil.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="save_ketua">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Ketua Jemaat</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Nama</label><input type="text" name="nama" class="form-control" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label>Mulai</label><input type="text" name="tahun_mulai" class="form-control" required></div>
                        <div class="col-6 mb-3"><label>Selesai</label><input type="text" name="tahun_selesai" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><label>Foto</label><input type="file" name="foto" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Ketua</button></div>
            </div>
        </form>
    </div>
</div>

<?php
$queryEdit = mysqli_query($koneksi, "SELECT * FROM ketua_jemaat");
while ($row = mysqli_fetch_assoc($queryEdit)):
?>
<div class="modal fade" id="modalEditKetua<?php echo $row['id']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <form action="proses/proses_profil.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="save_ketua">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="foto_lama" value="<?php echo $row['foto']; ?>">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit Ketua</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Nama</label><input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($row['nama']); ?>" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label>Mulai</label><input type="text" name="tahun_mulai" class="form-control" value="<?php echo htmlspecialchars($row['tahun_mulai']); ?>" required></div>
                        <div class="col-6 mb-3"><label>Selesai</label><input type="text" name="tahun_selesai" class="form-control" value="<?php echo htmlspecialchars($row['tahun_selesai']); ?>" required></div>
                    </div>
                    <div class="mb-3"><label>Ganti Foto (Opsional)</label><input type="file" name="foto" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-warning text-white">Update Data</button></div>
            </div>
        </form>
    </div>
</div>
<?php endwhile; ?>