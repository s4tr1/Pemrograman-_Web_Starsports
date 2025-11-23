<?php
require_once 'config.php';

// Load current settings
$settings = getAllSettings($pdo);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_settings'])) {
    try {
        // Update all settings
        updateSetting($pdo, 'site_name', cleanInput($_POST['site_name']));
        updateSetting($pdo, 'site_tagline', cleanInput($_POST['site_tagline']));
        updateSetting($pdo, 'primary_color', cleanInput($_POST['primary_color']));
        updateSetting($pdo, 'secondary_color', cleanInput($_POST['secondary_color']));
        updateSetting($pdo, 'accent_color', cleanInput($_POST['accent_color']));
        updateSetting($pdo, 'show_statistics', isset($_POST['show_statistics']) ? '1' : '0');
        updateSetting($pdo, 'show_hero', isset($_POST['show_hero']) ? '1' : '0');
        updateSetting($pdo, 'logo_icon', cleanInput($_POST['logo_icon']));
        
        // Reload settings
        $settings = getAllSettings($pdo);
        $successMessage = "Settings berhasil disimpan!";
    } catch(Exception $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo htmlspecialchars($settings['site_name'] ?? 'StarSports'); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    
    <style>
        .color-preview {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            border: 2px solid #ddd;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
        .icon-preview {
            font-size: 3rem;
            color: var(--primary-color);
            margin: 1rem 0;
        }
        .settings-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .preview-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cog"></i> <span class="brand-text">Admin</span><span class="brand-highlight">Panel</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Kembali ke Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 text-white"><i class="fas fa-cog"></i> Pengaturan Tampilan Website</h2>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if(isset($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="admin.php">
            <div class="row">
                <!-- Left Column: Settings -->
                <div class="col-lg-8">
                    <!-- General Settings -->
                    <div class="settings-card animate-fade-in">
                        <h4 class="mb-4"><i class="fas fa-info-circle"></i> Informasi Situs</h4>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Situs</label>
                            <input type="text" class="form-control" name="site_name" 
                                   value="<?php echo htmlspecialchars($settings['site_name'] ?? 'StarSports'); ?>" required>
                            <small class="text-muted">Nama utama website Anda</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tagline / Slogan</label>
                            <input type="text" class="form-control" name="site_tagline" 
                                   value="<?php echo htmlspecialchars($settings['site_tagline'] ?? ''); ?>" required>
                            <small class="text-muted">Slogan yang muncul di hero section</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon Logo (Font Awesome Class)</label>
                            <input type="text" class="form-control" name="logo_icon" id="logoIcon"
                                   value="<?php echo htmlspecialchars($settings['logo_icon'] ?? 'fa-running'); ?>" 
                                   placeholder="fa-running">
                            <small class="text-muted">Cari icon di <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a></small>
                            <div class="icon-preview">
                                <i class="fas <?php echo htmlspecialchars($settings['logo_icon'] ?? 'fa-running'); ?>" id="iconPreview"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Color Settings -->
                    <div class="settings-card animate-fade-in" style="animation-delay: 0.1s;">
                        <h4 class="mb-4"><i class="fas fa-palette"></i> Skema Warna</h4>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Warna Primer</label>
                                <div class="d-flex align-items-center">
                                    <input type="color" class="form-control form-control-color" 
                                           name="primary_color" id="primaryColor"
                                           value="<?php echo htmlspecialchars($settings['primary_color'] ?? '#667eea'); ?>">
                                    <div class="color-preview" id="primaryPreview" 
                                         style="background-color: <?php echo htmlspecialchars($settings['primary_color'] ?? '#667eea'); ?>"></div>
                                </div>
                                <small class="text-muted">Warna utama navbar & buttons</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Warna Sekunder</label>
                                <div class="d-flex align-items-center">
                                    <input type="color" class="form-control form-control-color" 
                                           name="secondary_color" id="secondaryColor"
                                           value="<?php echo htmlspecialchars($settings['secondary_color'] ?? '#764ba2'); ?>">
                                    <div class="color-preview" id="secondaryPreview"
                                         style="background-color: <?php echo htmlspecialchars($settings['secondary_color'] ?? '#764ba2'); ?>"></div>
                                </div>
                                <small class="text-muted">Warna gradient kedua</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Warna Aksen</label>
                                <div class="d-flex align-items-center">
                                    <input type="color" class="form-control form-control-color" 
                                           name="accent_color" id="accentColor"
                                           value="<?php echo htmlspecialchars($settings['accent_color'] ?? '#f59e0b'); ?>">
                                    <div class="color-preview" id="accentPreview"
                                         style="background-color: <?php echo htmlspecialchars($settings['accent_color'] ?? '#f59e0b'); ?>"></div>
                                </div>
                                <small class="text-muted">Warna highlight & emphasis</small>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> <strong>Tips:</strong> Gunakan warna yang kontras untuk hasil terbaik. Perubahan warna akan terlihat setelah refresh halaman.
                        </div>
                    </div>

                    <!-- Display Settings -->
                    <div class="settings-card animate-fade-in" style="animation-delay: 0.2s;">
                        <h4 class="mb-4"><i class="fas fa-eye"></i> Pengaturan Tampilan</h4>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="showHero" 
                                   name="show_hero" <?php echo ($settings['show_hero'] ?? '1') == '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="showHero">
                                <strong>Tampilkan Hero Section</strong><br>
                                <small class="text-muted">Banner besar di bagian atas halaman</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="showStats" 
                                   name="show_statistics" <?php echo ($settings['show_statistics'] ?? '1') == '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="showStats">
                                <strong>Tampilkan Statistics Cards</strong><br>
                                <small class="text-muted">Kartu statistik (Total Produk, Stok, Merk)</small>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="settings-card animate-fade-in" style="animation-delay: 0.3s;">
                        <button type="submit" name="save_settings" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <!-- Right Column: Preview -->
                <div class="col-lg-4">
                    <div class="settings-card animate-fade-in" style="animation-delay: 0.4s; position: sticky; top: 100px;">
                        <h4 class="mb-4"><i class="fas fa-desktop"></i> Live Preview</h4>
                        
                        <!-- Preview Navbar -->
                        <div class="preview-section" id="navbarPreview">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="fas <?php echo htmlspecialchars($settings['logo_icon'] ?? 'fa-running'); ?>" id="previewIcon"></i>
                                    <span id="previewSiteName" style="font-size: 1.2rem; font-weight: 700;">
                                        <?php echo htmlspecialchars($settings['site_name'] ?? 'StarSports'); ?>
                                    </span>
                                </div>
                                <div>
                                    <i class="fas fa-bars"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Hero -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>Hero Section:</h5>
                                <p class="mb-0"><strong>Selamat Datang di <span id="previewHeroName">
                                    <?php echo htmlspecialchars($settings['site_name'] ?? 'StarSports'); ?>
                                </span></strong></p>
                                <p class="text-muted mb-0" id="previewTagline">
                                    <?php echo htmlspecialchars($settings['site_tagline'] ?? ''); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Color Preview -->
                        <div class="card">
                            <div class="card-body">
                                <h5>Skema Warna:</h5>
                                <div class="d-flex gap-2 mb-2">
                                    <div style="flex: 1; height: 40px; border-radius: 5px;" 
                                         id="colorBar1" 
                                         class="d-flex align-items-center justify-content-center text-white">
                                        Primer
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <div style="flex: 1; height: 40px; border-radius: 5px;" 
                                         id="colorBar2" 
                                         class="d-flex align-items-center justify-content-center text-white">
                                        Sekunder
                                    </div>
                                    <div style="flex: 1; height: 40px; border-radius: 5px;" 
                                         id="colorBar3" 
                                         class="d-flex align-items-center justify-content-center text-white">
                                        Aksen
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Catatan:</strong> Preview ini hanya perkiraan. Untuk melihat perubahan sebenarnya, simpan pengaturan dan kembali ke halaman utama.
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 <?php echo htmlspecialchars($settings['site_name'] ?? 'StarSports'); ?> - Admin Panel</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Live preview updates
        document.getElementById('site_name').addEventListener('input', function() {
            document.getElementById('previewSiteName').textContent = this.value;
            document.getElementById('previewHeroName').textContent = this.value;
        });

        document.getElementById('site_tagline').addEventListener('input', function() {
            document.getElementById('previewTagline').textContent = this.value;
        });

        document.getElementById('logoIcon').addEventListener('input', function() {
            const iconClass = this.value || 'fa-running';
            document.getElementById('iconPreview').className = 'fas ' + iconClass;
            document.getElementById('previewIcon').className = 'fas ' + iconClass;
        });

        // Color preview updates
        document.getElementById('primaryColor').addEventListener('input', function() {
            document.getElementById('primaryPreview').style.backgroundColor = this.value;
            document.getElementById('colorBar1').style.backgroundColor = this.value;
            document.getElementById('navbarPreview').style.background = 
                `linear-gradient(135deg, ${this.value} 0%, ${document.getElementById('secondaryColor').value} 100%)`;
        });

        document.getElementById('secondaryColor').addEventListener('input', function() {
            document.getElementById('secondaryPreview').style.backgroundColor = this.value;
            document.getElementById('colorBar2').style.backgroundColor = this.value;
            document.getElementById('navbarPreview').style.background = 
                `linear-gradient(135deg, ${document.getElementById('primaryColor').value} 0%, ${this.value} 100%)`;
        });

        document.getElementById('accentColor').addEventListener('input', function() {
            document.getElementById('accentPreview').style.backgroundColor = this.value;
            document.getElementById('colorBar3').style.backgroundColor = this.value;
        });

        // Initialize color previews
        window.addEventListener('load', function() {
            const primary = document.getElementById('primaryColor').value;
            const secondary = document.getElementById('secondaryColor').value;
            const accent = document.getElementById('accentColor').value;
            
            document.getElementById('colorBar1').style.backgroundColor = primary;
            document.getElementById('colorBar2').style.backgroundColor = secondary;
            document.getElementById('colorBar3').style.backgroundColor = accent;
        });
    </script>
</body>
</html>
