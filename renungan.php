<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Renungan Jemaat - GMIM Imanuel Bahu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400;1,700;1,900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style-beranda.css?v=<?php echo time(); ?>">
    
    <style>
        .page-header-premium {
            padding-top: 6rem;
            padding-bottom: 3rem;
            position: relative;
        }
        .main-title-aesthetic {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 5vw, 4rem);
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -1px;
        }
        
        /* Desain Card RHK Glassmorphism */
        .rhk-card-glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        }
        .rhk-card-glass:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 15px 35px rgba(13,110,253,0.12) !important;
        }
        .rhk-img-container {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            position: relative;
            overflow: hidden;
        }
        /* Ornamen corak pada kotak gambar RHK */
        .rhk-img-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        }
        .rhk-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(255, 0, 0, 0.85);
            padding: 4px 12px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
        }
        
        /* Styling Modal (Kotak Muncul) */
        .modal-content { 
            border-radius: 25px; 
            border: none; 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
        }
        .detail-label { 
            color: #0d6efd; 
            font-weight: 800; 
            text-transform: uppercase; 
            font-size: 0.85rem;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Modifikasi UI Asisten AI Glassmorphism */
        .ai-glass-container {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        }
        .chat-input-container {
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(13, 110, 253, 0.2);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.02);
            transition: border-color 0.3s;
        }
        .chat-input-container:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13,110,253,0.1);
        }
        .chat-textarea {
            resize: none;
            overflow-y: hidden;
            min-height: 65px; 
            max-height: 150px;
            padding: 18px 20px; 
            line-height: 1.5;
            box-shadow: none !important;
            background: transparent;
        }
        
        /* Tombol Topik Cepat */
        .prompt-badge {
            transition: all 0.2s ease;
            font-weight: 600;
            font-size: 0.8rem;
            user-select: none;
            background: rgba(255,255,255,0.8) !important;
            border: 1px solid rgba(13, 110, 253, 0.15) !important;
            color: #475569 !important;
        }
        .prompt-badge:hover {
            background-color: #0d6efd !important;
            color: white !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13,110,253,0.2);
            border-color: #0d6efd !important;
        }
        
        /* Animasi Loading AI */
        .ai-loader {
            display: inline-block;
            width: 1.2rem;
            height: 1.2rem;
            border: 3px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }
        
        #aiRes {
            background: rgba(255,255,255,0.9) !important;
            border: 1px solid rgba(13, 110, 253, 0.1) !important;
        }
    </style>
</head>
<body>

<div class="digital-grid"></div>
<div class="aurora-container">
    <div class="aurora-blob blob-blue"></div>
    <div class="aurora-blob blob-soft"></div>
</div>

<?php include 'navbar.php'; include 'koneksi.php'; ?>

<section class="page-header-premium text-center z-2">
    <div class="container">
        <div data-aos="fade-down" data-aos-duration="800">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 small mb-3 fw-bold tracking-widest" style="letter-spacing: 2px;">
                <i class="bi bi-book-half me-2"></i>SANTAPAN ROHANI
            </span>
        </div>
        <h1 class="main-title-aesthetic mb-3" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="100">
            Renungan Jemaat
        </h1>
        <p class="text-muted fw-medium mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            Pembinaan Iman melalui Arsip Khotbah dan Konsultasi Teologi AI
        </p>
    </div>
</section>

<div class="container pb-5 mb-5 position-relative z-2">
    <div class="row g-5">
        
        <div class="col-lg-6">
            <div class="d-flex align-items-center justify-content-between mb-4" data-aos="fade-right">
                <h4 class="fw-bold text-dark m-0"><i class="bi bi-archive-fill text-primary me-2"></i>Arsip RHK Terbit</h4>
            </div>
            
            <div class="row g-4">
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM renungan_harian ORDER BY tanggal DESC");
                $modals = []; 
                if(mysqli_num_rows($query) > 0):
                    $delay = 100;
                    while($data = mysqli_fetch_assoc($query)):
                        $modals[] = $data;
                        $tgl_formatted = date('D, d M Y', strtotime($data['tanggal']));
                ?>
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="rhk-card-glass h-100" data-bs-toggle="modal" data-bs-target="#detailMdl<?php echo $data['id']; ?>">
                        <div class="rhk-img-container">
                            <img src="assets/images/logo-gmim.png" width="45" class="mb-2 z-1" alt="Logo GMIM" onerror="this.style.display='none'">
                            <h2 class="fw-bold mb-0 z-1" style="font-family: 'Playfair Display', serif;">RHK</h2>
                            <small class="z-1 fw-medium tracking-widest" style="letter-spacing: 2px; font-size: 0.65rem;">RENUNGAN HARIAN KELUARGA</small>
                            <div class="rhk-badge">BACA SEKARANG</div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h6 class="fw-bold text-dark mb-2">Edisi <?php echo $tgl_formatted; ?></h6>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 small fw-bold">
                                <?php echo htmlspecialchars($data['nas_alkitab']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php 
                    $delay += 100;
                    endwhile; 
                else:
                ?>
                <div class="col-12 text-center py-5">
                    <div class="glass-card p-5 mx-auto">
                        <i class="bi bi-journal-x text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-dark fw-bold">Belum Ada Renungan</h5>
                        <p class="text-muted small mb-0">Admin belum menerbitkan arsip renungan harian.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-5 offset-lg-1">
            <div class="ai-glass-container p-4 sticky-top" style="top: 100px;" data-aos="fade-left" data-aos-delay="200">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-robot" style="font-size: 1.8rem;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Pendeta AI</h4>
                    <p class="text-muted small mb-0">Teman diskusi dan konseling rohani pribadi Anda.</p>
                </div>
                
                <div class="input-group mb-2 chat-input-container">
                    <textarea id="aiInput" class="form-control border-0 chat-textarea" placeholder="Ketik pertanyaan atau pergumulan Anda di sini..." rows="2"></textarea>
                    <button class="btn btn-primary px-4 fw-bold border-0 text-uppercase tracking-wider" id="btnAisearch" onclick="tanyaAI()">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-keyboard me-1"></i>Tekan <strong>Enter</strong> untuk mengirim.</div>
                </div>

                <div class="mb-4 d-flex flex-wrap gap-2 justify-content-center">
                    <span class="badge rounded-pill prompt-badge cursor-pointer px-3 py-2" onclick="setPrompt('Bagaimana mengatasi rasa khawatir tentang masa depan menurut pandangan Kristen?')"><i class="bi bi-lightning-charge-fill text-warning me-1"></i> Mengatasi Khawatir</span>
                    <span class="badge rounded-pill prompt-badge cursor-pointer px-3 py-2" onclick="setPrompt('Saya butuh renungan penghiburan dan doa untuk anggota keluarga yang sedang sakit.')"><i class="bi bi-heart-pulse-fill text-danger me-1"></i> Doa Kesembuhan</span>
                    <span class="badge rounded-pill prompt-badge cursor-pointer px-3 py-2" onclick="setPrompt('Tolong jelaskan secara sederhana, apa makna keselamatan di dalam Yesus Kristus?')"><i class="bi bi-book-half text-info me-1"></i> Makna Keselamatan</span>
                </div>
                
                <div id="aiRes" class="small d-none p-4 rounded-4 text-secondary position-relative shadow-sm" 
                     style="line-height: 1.8; min-height: 350px; max-height: 550px; overflow-y: auto; font-size: 0.95rem;">
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach($modals as $data): ?>
<div class="modal fade" id="detailMdl<?php echo $data['id']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg px-2 px-md-4 pb-4">
            <div class="modal-header border-0 pt-4 pb-0">
                <button type="button" class="btn-close bg-light rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="row g-5">
                    <div class="col-lg-8 pe-lg-5">
                        <div class="detail-label mb-2"><i class="bi bi-bookmark-star-fill"></i> TEMA RENUNGAN HARI INI</div>
                        <h2 class="fw-bold mb-4 text-dark" style="font-family: 'Playfair Display', serif;"><?php echo htmlspecialchars($data['judul']); ?></h2>
                        
                        <div class="detail-label mb-2"><i class="bi bi-book-half"></i> NAS PEMBACAAN</div>
                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 fw-bold fs-5 mb-4 border-start border-primary border-4">
                            <?php echo htmlspecialchars($data['nas_alkitab']); ?>
                        </div>
                        
                        <div class="detail-label mb-3"><i class="bi bi-chat-quote-fill"></i> URAIAN FIRMAN TUHAN</div>
                        <div class="text-secondary" style="line-height: 1.9; font-size: 1.1rem; text-align: justify;">
                            <?php echo nl2br(htmlspecialchars($data['isi_renungan'])); ?>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 border-start">
                        <div class="p-4 bg-light rounded-4 mb-4 border border-secondary border-opacity-10">
                            <div class="detail-label mb-2 text-muted"><i class="bi bi-calendar3"></i> EDISI TANGGAL</div>
                            <h5 class="fw-bold text-dark mb-0"><?php echo date('l, d F Y', strtotime($data['tanggal'])); ?></h5>
                        </div>
                        
                        <div class="p-4 rounded-4" style="background: linear-gradient(to bottom right, #fffde7, #fff9c4); border: 1px solid #fff59d; box-shadow: inset 0 2px 10px rgba(0,0,0,0.02);">
                            <div class="detail-label text-warning mb-3" style="color: #f57f17 !important;"><i class="bi bi-hands"></i> DOA PENUTUP</div>
                            <p class="fst-italic text-dark mb-0" style="line-height: 1.8; font-family: 'Playfair Display', serif; font-size: 1.1rem;">
                                "<?php echo nl2br(htmlspecialchars($data['doa'])); ?>"
                            </p>
                            <div class="text-end mt-3 text-warning"><i class="bi bi-stars"></i> Amin.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php include 'footer.php'; ?>

<script>
let typeInterval;
let rawAiResponse = "";

window.addEventListener('DOMContentLoaded', () => {
    const savedQuery = localStorage.getItem('savedAiQuery');
    const savedResponse = localStorage.getItem('savedAiResponse');
    
    if(savedQuery && savedResponse) {
        const resBox = document.getElementById('aiRes');
        resBox.classList.remove('d-none');
        rawAiResponse = savedResponse;
        
        // PERBAIKAN: Menghapus class text-truncate, menambahkan text-break, gap-3, dan align-items-start
        resBox.innerHTML = `
            <div class="fw-bold text-dark pb-3 mb-3 border-bottom d-flex justify-content-between align-items-start gap-3">
                <span class="text-break" style="line-height: 1.5;"><i class="bi bi-person-circle text-primary me-2"></i>${savedQuery}</span>
                <button class="btn btn-sm btn-light border text-primary fw-bold rounded-pill px-3 shadow-sm flex-shrink-0" onclick="copyText()" id="copyBtn"><i class="bi bi-clipboard"></i> Salin</button>
            </div>
            <div id="aiTextContent" class="ai-text-content text-secondary" style="white-space: pre-line;">${savedResponse}</div>
        `;
    }
});

function setPrompt(text) {
    const aiInput = document.getElementById('aiInput');
    aiInput.value = text;
    aiInput.style.height = 'auto'; 
    aiInput.style.height = (aiInput.scrollHeight) + 'px';
    tanyaAI(); 
}

function copyText() {
    if(rawAiResponse) {
        navigator.clipboard.writeText(rawAiResponse).then(() => {
            const copyBtn = document.getElementById('copyBtn');
            const originalHTML = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="bi bi-check2-all"></i> Tersalin!';
            copyBtn.classList.replace('text-primary', 'text-success');
            copyBtn.classList.replace('btn-light', 'btn-success');
            copyBtn.classList.replace('text-success', 'text-white');
            
            setTimeout(() => {
                copyBtn.innerHTML = originalHTML;
                copyBtn.classList.replace('btn-success', 'btn-light');
                copyBtn.classList.replace('text-white', 'text-primary');
            }, 2000);
        });
    }
}

const aiInput = document.getElementById('aiInput');
aiInput.addEventListener('input', function() {
    this.style.height = 'auto'; 
    this.style.height = (this.scrollHeight) + 'px'; 
});

aiInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); 
        tanyaAI();
    }
});

function tanyaAI() {
    const btnElement = document.getElementById('btnAisearch');
    const resBox = document.getElementById('aiRes');
    const queryText = aiInput.value.trim();
    
    if(!queryText) {
        alert("Silakan ketik pertanyaan atau pergumulan Anda terlebih dahulu!");
        aiInput.focus();
        return;
    }
    
    clearInterval(typeInterval);
    
    resBox.classList.remove('d-none');
    resBox.innerHTML = '<div class="text-center mt-5 pt-4"><span class="ai-loader text-primary"></span><br><em class="text-muted mt-3 d-block">Asisten AI sedang merenungkan jawaban dari perspektif teologis...</em></div>';
    
    btnElement.disabled = true;
    aiInput.disabled = true;

    const targetUrl = window.location.origin + window.location.pathname.replace('renungan.php', 'panggil_ai.php') + '?cache=' + new Date().getTime();

    fetch(targetUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'request_user=' + encodeURIComponent(queryText)
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP status ' + response.status);
        return response.text();
    })
    .then(data => {
        btnElement.disabled = false;
        aiInput.disabled = false;
        aiInput.value = '';
        aiInput.style.height = 'auto'; 
        
        rawAiResponse = data.trim();
        
        // PERBAIKAN: Menghapus class text-truncate, menambahkan text-break, gap-3, dan align-items-start
        resBox.innerHTML = `
            <div class="fw-bold text-dark pb-3 mb-3 border-bottom d-flex justify-content-between align-items-start gap-3">
                <span class="text-break" style="line-height: 1.5;"><i class="bi bi-person-circle text-primary me-2 mt-1"></i>${queryText}</span>
                <button class="btn btn-sm btn-light border text-primary fw-bold rounded-pill px-3 shadow-sm flex-shrink-0" onclick="copyText()" id="copyBtn" style="display:none;"><i class="bi bi-clipboard"></i> Salin</button>
            </div>
            <div id="aiTextContent" class="ai-text-content text-secondary" style="white-space: pre-line;"></div>
        `;
        
        let i = 0;
        const textContainer = document.getElementById('aiTextContent');
        
        typeInterval = setInterval(() => {
            if (i < rawAiResponse.length) {
                textContainer.innerHTML += rawAiResponse.charAt(i);
                resBox.scrollTop = resBox.scrollHeight; 
                i++;
            } else {
                clearInterval(typeInterval);
                document.getElementById('copyBtn').style.display = 'block'; 
                
                localStorage.setItem('savedAiQuery', queryText);
                localStorage.setItem('savedAiResponse', rawAiResponse);
            }
        }, 15); 
        
    })
    .catch(error => {
        btnElement.disabled = false;
        aiInput.disabled = false;
        // Penyesuaian juga untuk tampilan error
        resBox.innerHTML = `<div class="fw-bold text-dark pb-3 mb-3 border-bottom d-flex"><i class="bi bi-person-circle text-primary me-2"></i><span class="text-break">${queryText}</span></div><div class="alert alert-danger d-flex align-items-center rounded-3"><i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i><div><strong>Koneksi Terputus</strong><br><small>${error.message}</small></div></div>`;
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 80 });
</script>
</body>
</html>