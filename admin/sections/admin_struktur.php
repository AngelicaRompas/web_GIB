<h4 class="section-header mb-4">
    <i class="bi bi-diagram-3-fill me-2 text-primary"></i>Manajemen Komponen Struktur Organisasi
</h4>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-custom p-4 shadow-sm h-100 border-0">
            <h5 class="fw-bold mb-4 text-dark border-bottom pb-3">
                <i class="bi bi-pencil-square text-primary me-2"></i>Edit Jajaran BPMJ & Pendeta
            </h5>
            
            <form action="proses/proses_struktur.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="jenis_update" value="edit_bpmj">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Pilih Jabatan Struktural</label>
                    <select name="jabatan" class="form-select" required>
                        <?php 
                        // Mengambil list jabatan BPMJ dari database
                        $q_bpmj = mysqli_query($koneksi, "SELECT jabatan FROM struktur_organisasi WHERE kategori='bpmj' ORDER BY id ASC");
                        while($b = mysqli_fetch_assoc($q_bpmj)):
                        ?>
                            <option value="<?php echo $b['jabatan']; ?>"><?php echo $b['jabatan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap & Gelar Baru</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Pdt. John Doe, M.Th" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold">Ganti Berkas Foto Profil</label>
                    <input type="file" name="foto_profil" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" name="simpan_edit_bpmj" class="btn btn-primary w-100 fw-bold rounded-3 py-2 shadow-sm">
                    Perbarui Pelayan Inti
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-custom p-4 shadow-sm h-100 border-0">
            <h5 class="fw-bold mb-4 text-dark border-bottom pb-3">
                <i class="bi bi-pencil-square text-success me-2"></i>Edit Penatua & Diaken per Kolom
            </h5>
            
            <form action="proses/proses_struktur.php" method="POST">
                <input type="hidden" name="jenis_update" value="edit_pelsus">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Pilih Target Kolom Pelayanan</label>
                    <select name="nomor_kolom" class="form-select" required>
                        <?php 
                        // Menggunakan variabel $kolomBerikutnya dari admin_dashboard.php
                        $jumlah_kolom_riil = (isset($kolomBerikutnya) ? $kolomBerikutnya - 1 : 28); 
                        for($i = 1; $i <= $jumlah_kolom_riil; $i++):
                        ?>
                            <option value="<?php echo $i; ?>">Kolom <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap Penatua</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light fw-bold text-muted border-end-0">Pnt.</span>
                        <input type="text" name="nama_penatua" class="form-control" placeholder="Nama Penatua Baru" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold">Nama Lengkap Diaken</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light fw-bold text-muted border-end-0">Dkn.</span>
                        <input type="text" name="nama_diaken" class="form-control" placeholder="Nama Diaken Baru" required>
                    </div>
                </div>
                
                <button type="submit" name="simpan_edit_pelsus" class="btn btn-success w-100 fw-bold rounded-3 py-2 shadow-sm">
                    Simpan Pelayan Kolom
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-custom p-4 shadow-sm h-100 border-0" style="background-color: #f8fbff; border: 1px solid #e2e8f0 !important;">
            <h6 class="fw-bold mb-2 text-dark">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Posisi Jabatan Inti Baru
            </h6>
            <p class="small text-muted mb-4">Gunakan form ini untuk menambah personil pelayan baru di luar struktur utama.</p>
            
            <form action="proses/proses_struktur.php" method="POST">
                <input type="hidden" name="jenis_update" value="tambah_bpmj">

                <div class="mb-4">
                    <label class="form-label small fw-bold">Nama Jabatan Baru</label>
                    <input
                        type="text"
                        name="jabatan_baru"
                        class="form-control bg-light"
                        placeholder="Contoh: Anggota BPMJ"
                        required>
                </div>

                <button
                    type="submit"
                    name="simpan_tambah_bpmj"
                    class="btn btn-outline-primary rounded-pill w-100 fw-bold py-2">
                    <i class="bi bi-plus-circle-fill me-2"></i>Daftarkan Jabatan Baru
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-custom p-4 shadow-sm h-100 border-0" style="background-color: #f8fff9; border: 1px solid #e2e8f0 !important;">
            <h6 class="fw-bold mb-2 text-dark">
                <i class="bi bi-node-plus-fill text-success me-2"></i>Ekspansi Wilayah Kolom Baru
            </h6>
            <p class="small text-muted mb-4">Sistem mendeteksi kolom tertinggi saat ini. Klik tombol di bawah untuk membuka wilayah kolom pelayanan baru.</p>
            
            <form action="proses/proses_struktur.php" method="POST">
                <input type="hidden" name="jenis_update" value="tambah_kolom">
                <input type="hidden" name="nomor_kolom_baru" value="<?php echo $kolomBerikutnya; ?>">
                
                <div class="mb-3">
                    <label class="small text-muted mb-1 d-block">Nomor Wilayah Kolom yang Akan Dibuat:</label>
                    <input type="text" class="form-control bg-light fw-bold text-success fs-5 text-center" value="KOLOM <?php echo $kolomBerikutnya; ?>" readonly>
                </div>
                
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <input type="text" name="nama_penatua_awal" class="form-control" placeholder="Nama Penatua Awal" required>
                    </div>
                    <div class="col-6">
                        <input type="text" name="nama_diaken_awal" class="form-control" placeholder="Nama Diaken Awal" required>
                    </div>
                </div>
                
                <button type="submit" name="simpan_tambah_kolom" class="btn btn-outline-success rounded-pill w-100 fw-bold py-2">
                    <i class="bi bi-plus-circle-fill me-2"></i>Resmikan Kolom <?php echo $kolomBerikutnya; ?>
                </button>
            </form>
        </div>
    </div>

</div>