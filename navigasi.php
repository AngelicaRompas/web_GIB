<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigasi Gedung Interaktif - GMIM Imanuel Bahu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .tour-container { width: 100%; height: 100vh; position: relative; }
        #panorama-viewer { width: 100%; height: 100%; }
        
        .tour-info-card {
            position: absolute; top: 20px; left: 20px; z-index: 1000;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 300px; padding: 15px;
        }

        /* Styling Hotspot Custom */
        .custom-hotspot {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid white;
    }

.custom-hotspot:hover {
    background: #0d6efd;
    color: white;
    transform: scale(1.2);
}
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="tour-container">
    <div class="tour-info-card">
        <h6 class="fw-bold text-primary mb-1"><i class="bi bi-compass-fill me-1"></i> Penjelajahan 360°</h6>
        <p class="small text-muted mb-2">Geser untuk melihat sekeliling. Klik panah untuk berpindah lokasi.</p>
        <div class="badge bg-dark text-white p-2" id="roomLabel">Lokasi: Loading...</div>
    </div>
    <div id="panorama-viewer"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script>
    // 1. Fungsi Hotspot Custom (Harus diletakkan di luar atau sebelum inisialisasi viewer)
    function hotspotCreator(hotSpotDiv, args) {
        hotSpotDiv.classList.add('custom-hotspot');
        hotSpotDiv.innerHTML = '<i class="bi bi-arrow-up-circle-fill"></i>';
    }

    const viewer = pannellum.viewer('panorama-viewer', {
        "default": {
            "firstScene": "halamanDepan",
            "author": "GMIM Imanuel Bahu",
            "autoLoad": true,
            "sceneFadeDuration": 1000 // Transisi halus
        },
        "scenes": {
            "halamanDepan": {
                "title": "Halaman Depan",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/halaman-depan.jpg", 
                "hotSpots": [
                    { 
                        "pitch": -14.20, "yaw": -143.03, 
                        "type": "scene", 
                        "text": "Masuk ke Pintu Utama", 
                        "sceneId": "pintuMasuk",
                        "createTooltipFunc": hotspotCreator 
                    }
                ]
            },
            "pintuMasuk": {
                "title": "Pintu Masuk",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/pintu-masuk.jpg",
                "hotSpots": [
                    { 
                        "pitch": -11.27, "yaw": -129.45, 
                        "type": "scene", 
                        "text": "Masuk Ke Lobby Gereja", 
                        "sceneId": "LobbyGereja",
                        "createTooltipFunc": hotspotCreator 
                    }
                ]
            },
            "LobbyGereja": {
                "title": "Lobby Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Lobby-Gereja.jpg",
                "hotSpots": [
                    { "pitch": -4.51, "yaw": -100.00, "type": "scene", "text": "Naik ke Lantai Dua", "sceneId": "lantaiDua", "createTooltipFunc": hotspotCreator },
                    { "pitch": -6.17, "yaw": -135.60, "type": "scene", "text": "Ke Kantor Jemaat", "sceneId": "kantorJemaat", "createTooltipFunc": hotspotCreator },
                    { "pitch": -6.36, "yaw": -71.95, "type": "scene", "text": "Ke Aula Lantai Satu", "sceneId": "aulaLantaiSatu", "createTooltipFunc": hotspotCreator }
                ]
            },
            "lantaiDua": {
                "title": "Lantai Dua",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/lantai-Dua.jpg",
                "hotSpots": [
                    { "pitch": -11.27, "yaw": -129.45, "type": "scene", "text": "Ke Tangga", "sceneId": "tanggaLantaiDua", "createTooltipFunc": hotspotCreator }
                ]
            },
            "tanggaLantaiDua": {
                "title": "Tangga Lantai Dua",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/tangga-lantai-dua.jpg",
                "hotSpots": [
                    { "pitch": 3.90, "yaw": -141.35, "type": "scene", "text": "Kembali ke Lantai Dua", "sceneId": "lantaiDua", "createTooltipFunc": hotspotCreator }
                ]
            }
        }
    });

    viewer.on('scenechange', function(sceneId) {
        const label = document.getElementById('roomLabel');
        const locations = {
            'halamanDepan': 'Halaman Depan',
            'pintuMasuk': 'Pintu Masuk',
            'LobbyGereja': 'Lobby Gereja',
            'lantaiDua': 'Lantai Dua',
            'tanggaLantaiDua': 'Tangga Lantai Dua'
        };
        label.innerText = "Lokasi: " + (locations[sceneId] || 'Unknown');
    });
</script>
</body>
</html>