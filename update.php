<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input
    $id = cleanInput($_POST['id']);
    $nama_sepatu = cleanInput($_POST['nama_sepatu']);
    $merk = cleanInput($_POST['merk']);
    $kategori = cleanInput($_POST['kategori']);
    $ukuran = cleanInput($_POST['ukuran']);
    $warna = cleanInput($_POST['warna']);
    $harga = cleanInput($_POST['harga']);
    $stok = cleanInput($_POST['stok']);
    $deskripsi = cleanInput($_POST['deskripsi']);
    $gambar_lama = cleanInput($_POST['gambar_lama']);
    $gambar = $gambar_lama; // default ke gambar lama
    
    // Validasi field wajib
    if (empty($id) || empty($nama_sepatu) || empty($merk) || empty($kategori) || 
        empty($ukuran) || empty($warna) || empty($harga) || empty($stok)) {
        header("Location: edit.php?id=$id&error=" . urlencode("Semua field wajib diisi!"));
        exit();
    }
    
    // Validasi harga dan stok harus angka positif
    if (!is_numeric($harga) || $harga < 0) {
        header("Location: edit.php?id=$id&error=" . urlencode("Harga harus berupa angka positif!"));
        exit();
    }
    
    if (!is_numeric($stok) || $stok < 0) {
        header("Location: edit.php?id=$id&error=" . urlencode("Stok harus berupa angka positif!"));
        exit();
    }
    
    // Handle upload gambar jika ada file baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['gambar'], $gambar_lama);
        if ($uploadResult['success']) {
            $gambar = $uploadResult['filename'];
        } else {
            header("Location: edit.php?id=$id&error=" . urlencode($uploadResult['message']));
            exit();
        }
    }
    
    try {
        // Cek apakah data dengan ID tersebut ada
        $stmt = $pdo->prepare("SELECT id FROM sepatu WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
        if (!$stmt->fetch()) {
            header("Location: index.php?error=" . urlencode("Data tidak ditemukan!"));
            exit();
        }
        
        // Prepared statement untuk update data
        $sql = "UPDATE sepatu SET 
                nama_sepatu = :nama_sepatu,
                merk = :merk,
                kategori = :kategori,
                ukuran = :ukuran,
                warna = :warna,
                harga = :harga,
                stok = :stok,
                deskripsi = :deskripsi,
                gambar = :gambar
                WHERE id = :id";
        
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
            ':gambar' => $gambar,
            ':id' => $id
        ]);
        
        // Redirect dengan pesan sukses
        header("Location: index.php?message=" . urlencode("Data sepatu berhasil diupdate!"));
        exit();
        
    } catch(PDOException $e) {
        header("Location: edit.php?id=$id&error=" . urlencode("Error: " . $e->getMessage()));
        exit();
    }
} else {
    // Jika bukan POST request, redirect ke index
    header("Location: index.php");
    exit();
}
?>
