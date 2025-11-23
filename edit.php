<?php
require_once 'config.php';

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=" . urlencode("ID tidak valid!"));
    exit();
}

$id = cleanInput($_GET['id']);

// Ambil data sepatu berdasarkan ID menggunakan prepared statement
try {
    $stmt = $pdo->prepare("SELECT * FROM sepatu WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $sepatu = $stmt->fetch();
    
    if (!$sepatu) {
        header("Location: index.php?error=" . urlencode("Data sepatu tidak ditemukan!"));
        exit();
    }
} catch(PDOException $e) {
    header("Location: index.php?error=" . urlencode("Error: " . $e->getMessage()));
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sepatu - StarSports</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-running"></i> <span class="brand-text">Star</span><span class="brand-highlight">Sports</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"><i class="fas fa-edit"></i> Edit Produk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg animate-fade-in" style="border-radius: 20px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0; padding: 1.5rem;">
                        <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Data Sepatu</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Anda sedang mengedit data: <strong><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></strong>
                        </div>

                        <form action="update.php" method="POST" id="editForm" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $sepatu['id']; ?>">
                            <input type="hidden" name="gambar_lama" value="<?php echo $sepatu['gambar']; ?>">
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Gambar Sepatu</label>
                                    <div class="mb-2">
                                        <img src="<?php echo file_exists('uploads/' . $sepatu['gambar']) ? 'uploads/' . $sepatu['gambar'] : 'uploads/default.jpg'; ?>" 
                                             alt="Current Image" 
                                             id="preview-edit"
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 200px;">
                                    </div>
                                    <input type="file" class="form-control" name="gambar" accept="image/*" onchange="previewImage(this, 'preview-edit')">
                                    <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 2MB) - Kosongkan jika tidak ingin mengganti</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Sepatu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_sepatu" 
                                           value="<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Merk <span class="text-danger">*</span></label>
                                    <select class="form-control" name="merk" required>
                                        <option value="">Pilih Merk</option>
                                        <?php
                                        $merks = ['Nike', 'Adidas', 'Puma', 'Ortuseight', 'Specs', 'New Balance', 'Mills', 'Mizuno', 'Vans'];
                                        foreach($merks as $merk_option) {
                                            $selected = ($sepatu['merk'] == $merk_option) ? 'selected' : '';
                                            echo "<option value='$merk_option' $selected>$merk_option</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php
                                        $kategoris = ['Running', 'Football', 'Futsal', 'Training', 'Casual', 'Hiking'];
                                        foreach($kategoris as $kategori_option) {
                                            $selected = ($sepatu['kategori'] == $kategori_option) ? 'selected' : '';
                                            echo "<option value='$kategori_option' $selected>$kategori_option</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ukuran <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ukuran" required>
                                        <option value="">Pilih Ukuran</option>
                                        <?php 
                                        for($i = 36; $i <= 46; $i++) {
                                            $selected = ($sepatu['ukuran'] == $i) ? 'selected' : '';
                                            echo "<option value='$i' $selected>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Warna <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="warna" 
                                           value="<?php echo htmlspecialchars($sepatu['warna']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="harga" 
                                           value="<?php echo $sepatu['harga']; ?>" required min="0" step="1000">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stok" 
                                           value="<?php echo $sepatu['stok']; ?>" required min="0">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="4"><?php echo htmlspecialchars($sepatu['deskripsi']); ?></textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2 justify-content-end mt-4">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 StarSports - Toko Sepatu Olahraga. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Preview image before upload
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Form validation
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const harga = document.querySelector('input[name="harga"]').value;
            const stok = document.querySelector('input[name="stok"]').value;
            
            if (harga < 0) {
                e.preventDefault();
                alert('Harga tidak boleh negatif!');
                return false;
            }
            
            if (stok < 0) {
                e.preventDefault();
                alert('Stok tidak boleh negatif!');
                return false;
            }
        });
    </script>
</body>
</html>
