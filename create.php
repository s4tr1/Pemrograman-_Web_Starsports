<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input
    $nama_sepatu = cleanInput($_POST['nama_sepatu']);
    $merk = cleanInput($_POST['merk']);
    $kategori = cleanInput($_POST['kategori']);
    $ukuran = cleanInput($_POST['ukuran']);
    $warna = cleanInput($_POST['warna']);
    $harga = cleanInput($_POST['harga']);
    $stok = cleanInput($_POST['stok']);
    $deskripsi = cleanInput($_POST['deskripsi']);
    $gambar = 'default.jpg'; // default
    
    // Validasi field wajib
    if (empty($nama_sepatu) || empty($merk) || empty($kategori) || empty($ukuran) || 
        empty($warna) || empty($harga) || empty($stok)) {
        header("Location: index.php?error=" . urlencode("Semua field wajib diisi!"));
        exit();
    }
    
    // Validasi harga dan stok harus angka positif
    if (!is_numeric($harga) || $harga < 0) {
        header("Location: index.php?error=" . urlencode("Harga harus berupa angka positif!"));
        exit();
    }
    
    if (!is_numeric($stok) || $stok < 0) {
        header("Location: index.php?error=" . urlencode("Stok harus berupa angka positif!"));
        exit();
    }
    
    // Handle upload gambar jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['gambar']);
        if ($uploadResult['success']) {
            $gambar = $uploadResult['filename'];
        } else {
            header("Location: index.php?error=" . urlencode($uploadResult['message']));
            exit();
        }
    }
    
    try {
        // Prepared statement untuk keamanan
        $sql = "INSERT INTO sepatu (nama_sepatu, merk, kategori, ukuran, warna, harga, stok, deskripsi, gambar) 
                VALUES (:nama_sepatu, :merk, :kategori, :ukuran, :warna, :harga, :stok, :deskripsi, :gambar)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nama_sepatu' => $nama_sepatu,
            ':merk' => $merk,
            ':kategori' => $kategori,
            ':ukuran' => $ukuran,
            ':warna' => $warna,
            ':harga' => $harga,
            ':stok' => $stok,
            ':deskripsi' => $deskripsi,
            ':gambar' => $gambar
        ]);
        
        // Redirect dengan pesan sukses
        header("Location: index.php?message=" . urlencode("Data sepatu berhasil ditambahkan!"));
        exit();
        
    } catch(PDOException $e) {
        header("Location: index.php?error=" . urlencode("Error: " . $e->getMessage()));
        exit();
    }
} else {
    // Jika bukan POST request, redirect ke index
    header("Location: index.php");
    exit();
}
?>
