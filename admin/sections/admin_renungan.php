<h4 class="section-header mb-4">
    <i class="bi bi-book-half me-2 text-primary"></i>Manajemen Renungan Harian Jemaat
</h4>

<div class="card card-custom p-4 shadow-sm border-0">
    <h5 class="fw-bold mb-3 text-dark">Input Teks Renungan Harian Baru</h5>
    <form action="proses/proses_renungan.php" method="POST">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Tanggal Renungan</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nas Pembacaan Alkitab</label>
                <input type="text" name="nas_alkitab" class="form-control" placeholder="Contoh: Efesus 6:10-18" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Judul Renungan</label>
            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul tema renungan" required>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Isi Lengkap Renungan Firman Tuhan</label>
            <textarea name="isi_renungan" class="form-control" rows="6" placeholder="Tuliskan rincian khotbah pembinaan, poin perenungan, dan aplikasi kehidupan praktis jemaat..." required></textarea>
        </div>
        
        <div class="mb-4">
            <label class="form-label small fw-bold">Teks Doa Penutup</label>
            <textarea name="doa" class="form-control" rows="3" placeholder="Tuliskan pokok doa penutup renungan..." required></textarea>
        </div>

        <button type="submit" name="simpan_renungan" class="btn btn-primary btn-pill px-5 shadow-sm">
            <i class="bi bi-journal-check me-2"></i>Publikasikan Renungan Hari Ini
        </button>
    </form>
</div>