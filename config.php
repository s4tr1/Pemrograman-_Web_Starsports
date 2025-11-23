<?php
// config.php - File konfigurasi database

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'starsports');

// Membuat koneksi menggunakan PDO dengan Prepared Statement untuk keamanan
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("ERROR: Tidak dapat terhubung ke database. " . $e->getMessage());
}

// Fungsi untuk format Rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Fungsi untuk validasi input
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk upload gambar
function uploadImage($file, $oldImage = null) {
    $targetDir = "uploads/";
    
    // Buat folder uploads jika belum ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Validasi file
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        return ['success' => false, 'message' => 'Format file tidak valid. Hanya JPG, PNG, GIF, WEBP yang diperbolehkan.'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 2MB.'];
    }
    
    // Generate nama file unik
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = 'sepatu_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
    $targetFile = $targetDir . $fileName;
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Hapus gambar lama jika ada dan bukan default
        if ($oldImage && $oldImage != 'default.jpg' && file_exists($targetDir . $oldImage)) {
            unlink($targetDir . $oldImage);
        }
        return ['success' => true, 'filename' => $fileName];
    } else {
        return ['success' => false, 'message' => 'Gagal mengupload file.'];
    }
}

// Fungsi untuk get setting dari database
function getSetting($pdo, $key, $default = '') {
    try {
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = :key");
        $stmt->execute([':key' => $key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : $default;
    } catch(PDOException $e) {
        return $default;
    }
}

// Fungsi untuk get all settings
function getAllSettings($pdo) {
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
        $settings = [];
        while($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    } catch(PDOException $e) {
        return [];
    }
}

// Fungsi untuk update setting
function updateSetting($pdo, $key, $value) {
    try {
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");
        $stmt->execute([':value' => $value, ':key' => $key]);
        return true;
    } catch(PDOException $e) {
        return false;
    }
}
?>
