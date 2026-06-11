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

    // 2. Fungsi Hotspot Info (PENTING: Harus ditambah agar tidak error)
    function infoHotspotCreator(hotSpotDiv, args) {
        hotSpotDiv.classList.add('info-hotspot');
        hotSpotDiv.innerHTML = '<i class="bi bi-info-circle-fill"></i>';
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
                    { "pitch": 5.11, "yaw": -39.09, "type": "scene", "text": "Masuk ke Pintu Utama", "sceneId": "LobbyGereja", "createTooltipFunc": hotspotCreator },
                    { "pitch": 0.47, "yaw": 13.42, "type": "scene", "text": "Masuk ke aula lantai satu", "sceneId": "aulaLantaiSatu", "createTooltipFunc": hotspotCreator },
                ]
            },
            "LobbyGereja": {
                "title": "Lobby Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Lobby-Gereja.jpg",
                "hotSpots": [
                    { "pitch": 9.84, "yaw": 0.58, "type": "scene", "text": "Naik ke Lantai Dua", "sceneId": "tanggaLantaiSatu", "createTooltipFunc": hotspotCreator },
                    { "pitch": 6.13, "yaw": -31.48, "type": "scene", "text": "Ke Kantor Jemaat", "sceneId": "kantorJemaat", "createTooltipFunc": hotspotCreator },
                    { "pitch": 6.59, "yaw": 26.62, "type": "scene", "text": "Ke Aula Lantai Satu", "sceneId": "aulaLantaiSatu", "createTooltipFunc": hotspotCreator },
                    { "pitch": -10.21, "yaw": 141.70, "type": "scene", "text": "Pintu Keluar", "sceneId": "exitLobby", "createTooltipFunc": hotspotCreator }
                ]
            },
            "exitLobby": {
                "title": "halaman depan",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/luar-lobby.jpg",
                "hotSpots": [
                    { "pitch": 1.64, "yaw": -1.91, "type": "scene", "text": "Pintu Keluar", "sceneId": "LobbyGereja", "createTooltipFunc": hotspotCreator },
                ]
            },
            "aulaLantaiSatu": {
                "title": "Aula Lantai Satu",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/aula-lantai1.jpg",
                "hotSpots": [
                    { "pitch": 3.48, "yaw": -53.22, "type": "scene", "text": "Masuk Ke Lobby Gereja", "sceneId": "LobbyGereja", "createTooltipFunc": hotspotCreator },
                    { "pitch": -10.86, "yaw": -176.95, "type": "scene", "text": "Pintu Keluar", "sceneId": "exitAula", "createTooltipFunc": hotspotCreator },
                ]
            },
            "exitAula": {
                "title": "halaman depan",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/luar-lobby.jpg",
                "hotSpots": [
                    { "pitch": -10.86, "yaw": -176.95, "type": "scene", "text": "Pintu Keluar", "sceneId": "aulaLantaiSatu", "createTooltipFunc": hotspotCreator }, // BLUM EDIT
                ]
            },
            "tanggaLantaiSatu": {
                "title": "Tangga Lantai Satu",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/tangga-lantai1.jpg",
                "hotSpots": [
                    { "pitch": -0.47, "yaw": -3.09, "type": "scene", "text": "Naik Ke Lantai Dua", "sceneId": "tanggaLantaiDua", "createTooltipFunc": hotspotCreator }
                ]
            },
            "tanggaLantaiDua": {
                "title": "Tangga Lantai Dua",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/naik-lantai2.jpg",
                "hotSpots": [
                    { "pitch": 6.06, "yaw": 0.08, "type": "scene", "text": "Naik Ke Lantai Dua", "sceneId": "LantaiDua", "createTooltipFunc": hotspotCreator }
                ]
            },
            "LantaiDua": {
                "title": "Tangga Lantai Dua",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Lantai-Dua.jpg",
                "hotSpots": [
                    { "pitch": -1.20, "yaw": -126.45, "type": "scene", "text": "Ruang Aula Lantai Dua", "sceneId": "AulaLantaiDua", "createTooltipFunc": hotspotCreator },
                    { "pitch": -14.81, "yaw": 121.85, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "NaikLantaiTiga", "createTooltipFunc": hotspotCreator }
                ]
            },
            "AulaLantaiDua": {
                "title": "Aula Lantai Dua",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/aula-lantai-dua.jpg",
                "hotSpots": [
                    { "pitch": 4.62, "yaw": -10.03, "type": "scene", "text": "Ruang Aula Lantai Dua", "sceneId": "AulaDua", "createTooltipFunc": hotspotCreator },
                    { "pitch": -2.44, "yaw": -109.97, "type": "scene", "text": "Ruang Aula Lantai Dua", "sceneId": "NaikLantaiTiga", "createTooltipFunc": hotspotCreator }
                ]
            },
            "AulaDua": {
                "title": "Aula Lantai Dua",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Aula-Dua.jpg",
                "hotSpots": [
                    { "pitch": 10.18, "yaw": 3.77, "type": "scene", "text": "Ruang Aula Lantai Dua", "sceneId": "AulaLantaiDua", "createTooltipFunc": hotspotCreator },
                    { "pitch": -3.07, "yaw": 87.87, "type": "info", "text": "Ini adalah Aula Lantai Dua, tempat pertemuan rutin jemaat.", "createTooltipFunc": infoHotspotCreator } // Fungsi khusus untuk info
                ]
            },
            "NaikLantaiTiga": {
                "title": "Naik Ke Lantai Tiga",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Naik-lantai3.jpg",
                "hotSpots": [
                    { "pitch": 4.52, "yaw": -1.57, "type": "scene", "text": "Ruang Aula Lantai Dua", "sceneId": "TanggaLantaiTiga", "createTooltipFunc": hotspotCreator }
                ]
            },
            "TanggaLantaiTiga": {
                "title": "Tangga Lantai Tiga",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Tangga-Lantai-Tiga.jpg",
                "hotSpots": [
                    { "pitch": 4.44, "yaw": -0.39, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "TanggaGereja", "createTooltipFunc": hotspotCreator }
                ]
            },
            "TanggaGereja": {
                "title": "Tangga Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/Tangga-Gereja.jpg",
                "hotSpots": [
                    { "pitch": 1.24, "yaw": -2.56, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "Gereja", "createTooltipFunc": hotspotCreator }
                ]
            },
            "Gereja": {
                "title": "Masuk Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/gereja.jpg",
                "hotSpots": [
                    { "pitch": -1.19, "yaw": 58.99, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "SisiUtamaGereja", "createTooltipFunc": hotspotCreator },
                    { "pitch": 3.86, "yaw": -56.50, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "SisiSampingGereja", "createTooltipFunc": hotspotCreator }
                ]
            },
            "SisiUtamaGereja": {
                "title": "Masuk Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/utama-gereja.jpg",
                "hotSpots": [
                    { "pitch": 0, "yaw": 0, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "BelakangGereja", "createTooltipFunc": hotspotCreator },
                    { "pitch": 0.54, "yaw": 93.25, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "SisiSampingGereja", "createTooltipFunc": hotspotCreator }
                ]
            },
            "SisiSampingGereja": {
                "title": "Masuk Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/samping-gereja.jpg",
                "hotSpots": [
                    { "pitch": 0, "yaw": 0, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "SisiUtamaGereja", "createTooltipFunc": hotspotCreator }
                ]
            },
            "BelakangGereja": {
                "title": "Belakang Gereja",
                "type": "equirectangular",
                "panorama": "public/assets/virtual-tour/belakang-gereja.jpg",
                "hotSpots": [
                    { "pitch": 0, "yaw": 0, "type": "scene", "text": "Naik Ke Lantai Tiga", "sceneId": "SisiUtamaGereja", "createTooltipFunc": hotspotCreator }
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
            'LantaiDua': 'Lantai Dua',
            'tanggaLantaiSatu': 'Tangga Lantai Satu',
            'tanggaLantaiDua': 'Tangga Lantai Dua'
        };
        label.innerText = "Lokasi: " + (locations[sceneId] || 'Unknown');
    });
</script>
</body>
</html>