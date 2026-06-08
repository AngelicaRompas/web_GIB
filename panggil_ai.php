<?php
// Mengizinkan request data dari halaman yang sama di localhost
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_user'])) {
    
    $request_user = trim($_POST['request_user']);
    
    if (empty($request_user)) {
        echo "Pertanyaan tidak boleh kosong.";
        exit;
    }

    // 1. API KEY MILIK ANDA
    $api_key = "AIzaSyB-5Cw34aUKkdQHYKEy9YLOmCcKytRrOZs";

    // 2. SISTEM PROMPT KUSTOM PASTORAL
    $system_prompt = "Anda adalah seorang Pendeta teolog Kristen yang bijaksana dan penuh kasih pastoral dari gereja jemaat. "
                   . "Berdasarkan pertanyaan, pergumulan, atau nas Alkitab berikut: '" . $request_user . "', "
                   . "buatlah sebuah tanggapan rohani yang menguatkan, menyejukkan hati, dan berdasar pada kebenaran Alkitab. "
                   . "Tuliskan jawaban Anda secara ringkas dalam 2-3 paragraf pendek agar pas dibaca di area sidebar website, "
                   . "lalu akhiri dengan 1 kalimat doa penutup yang menguatkan jemaat.";

    // 3. JALUR MUTLAK: Menggunakan nama model presisi sesuai UI Google AI Studio Anda
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=" . $api_key;

    // 4. PAYLOAD JSON TERSTRUKTUR
    $data_payload = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $system_prompt]
                ]
            ]
        ]
    ];

    $json_payload = json_encode($data_payload);

    // 5. Eksekusi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
    
    // PERBAIKAN: Tambah batas waktu tunggu menjadi 60 detik karena server Google sedang padat
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);        
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_payload)
    ]);

    $response = curl_exec($ch);
    
    // PERBAIKAN: Cetak detail error cURL yang sebenarnya agar ketahuan masalah jaringannya
    if (curl_errno($ch)) {
        $pesan_error_jaringan = curl_error($ch);
        echo "Gangguan Jaringan Internal: " . htmlspecialchars($pesan_error_jaringan);
        curl_close($ch);
        exit;
    }
    
    curl_close($ch);

    // 6. Parsing Data Balasan JSON
    $response_data = json_decode($response, true);
    $hasil_raw = "";

    // Ambil teks balasan
    if (isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
        $hasil_raw = $response_data['candidates'][0]['content']['parts'][0]['text'];
    } 

    if (!empty($hasil_raw)) {
        // Bersihkan tanda bintang markdown
        $hasil_bersih = str_replace(['**', '*'], '', $hasil_raw);
        echo $hasil_bersih;
    } else {
        // Jika masih ada error, tampilkan detailnya
        if (isset($response_data['error']['message'])) {
            echo "Google AI Error: " . htmlspecialchars($response_data['error']['message']);
        } else {
            echo "Maaf, sistem tidak dapat membaca struktur respon AI.";
        }
    }

} else {
    echo "Akses ilegal diblokir.";
}
?>