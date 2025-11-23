<?php
require_once 'config.php';

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=" . urlencode("ID tidak valid!"));
    exit();
}

$id = cleanInput($_GET['id']);

try {
    // Cek apakah data dengan ID tersebut ada
    $stmt = $pdo->prepare("SELECT nama_sepatu FROM sepatu WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $sepatu = $stmt->fetch();
    
    if (!$sepatu) {
        header("Location: index.php?error=" . urlencode("Data tidak ditemukan!"));
        exit();
    }
    
    // Hapus data menggunakan prepared statement
    $stmt = $pdo->prepare("DELETE FROM sepatu WHERE id = :id");
    $stmt->execute([':id' => $id]);
    
    // Redirect dengan pesan sukses
    $message = "Data sepatu \"" . $sepatu['nama_sepatu'] . "\" berhasil dihapus!";
    header("Location: index.php?message=" . urlencode($message));
    exit();
    
} catch(PDOException $e) {
    header("Location: index.php?error=" . urlencode("Error: " . $e->getMessage()));
    exit();
}
?>
