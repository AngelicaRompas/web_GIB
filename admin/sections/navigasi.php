<h4 class="section-header"><i class="bi bi-compass-fill me-2 text-primary"></i>Manajemen Tur Virtual 360°</h4>

<div class="card card-custom p-4 shadow-sm">
    <h5 class="fw-bold mb-3 text-dark">Tambah Titik Lokasi Baru (Node)</h5>
    <p class="text-muted small">Upload panorama baru dan tentukan koordinat titik navigasi untuk sistem 360° Anda.</p>
    
    <form action="proses/proses_navigasi.php" method="POST" enctype="multipart/form-data">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nama Lokasi/Ruangan</label>
                <input type="text" name="nama_lokasi" class="form-control" placeholder="Contoh: Ruang Konsistori" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">File Gambar Panorama (360°)</label>
                <input type="file" name="file_panorama" class="form-control" required>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Koordinat X</label>
                <input type="number" step="any" name="coord_x" class="form-control" placeholder="0.00" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Koordinat Y</label>
                <input type="number" step="any" name="coord_y" class="form-control" placeholder="0.00" required>
            </div>
        </div>
        <button type="submit" name="simpan_navigasi" class="btn btn-primary btn-pill px-5 shadow-sm">
            <i class="bi bi-plus-circle-fill me-2"></i> Tambahkan Titik Navigasi
        </button>
    </form>
</div>