<h4 class="section-header"><i class="bi bi-file-earmark-text-fill me-2 text-primary"></i>Pengaturan Manajemen Warta Jemaat</h4>

<div class="card card-custom p-4">
    <h5 class="fw-bold mb-3 text-dark">Input Ragam Informasi Warta Jemaat</h5>
    <form action="proses/proses_warta.php" method="POST" enctype="multipart/form-data">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nomor Surat Warta</label>
                <input type="text" name="nomor_warta" class="form-control" placeholder="Contoh: Warta/05/V/2026" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Tanggal Pelaksanaan Ibadah</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Tema Mingguan</label>
                <input type="text" name="tema_mingguan" class="form-control" placeholder="Masukkan tema ibadah minggu" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nas Pembacaan Alkitab</label>
                <input type="text" name="pembacaan_alkitab" class="form-control" placeholder="Contoh: 1 Yohanes 2:18-21" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Isi Ringkasan Warta Jemaat</label>
            <textarea name="isi_warta" class="form-control" rows="6" placeholder="Tulis rincian pengumuman, jadwal pelsus, atau mutasi jemaat..." required></textarea>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-bold">Lampiran Berkas Warta (PDF Lengkap / Hasil Scan Gambar)</label>
            <input type="file" name="file_pdf" class="form-control" required>
        </div>
        <button type="submit" name="upload_warta" class="btn btn-primary btn-pill px-5 shadow-sm">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i>Publikasikan Dokumen Warta
        </button>
    </form>
</div>