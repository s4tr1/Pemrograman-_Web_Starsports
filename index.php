<?php
require_once 'config.php';

// Load settings
$settings = getAllSettings($pdo);
$siteName = $settings['site_name'] ?? 'StarSports';
$siteTagline = $settings['site_tagline'] ?? 'Kelola Koleksi Sepatu Olahraga Terbaik Anda';
$showStatistics = ($settings['show_statistics'] ?? '1') == '1';
$showHero = ($settings['show_hero'] ?? '1') == '1';
$logoIcon = $settings['logo_icon'] ?? 'fa-running';

// Fungsi untuk mendapatkan semua data sepatu
function getAllSepatu($pdo, $search = '') {
    if (!empty($search)) {
        $sql = "SELECT * FROM sepatu
                WHERE nama_sepatu LIKE ? OR merk LIKE ?
                ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $param = "%$search%";
        $stmt->execute([$param, $param]);
    } else {
        $stmt = $pdo->query("SELECT * FROM sepatu ORDER BY id DESC");
    }
    return $stmt->fetchAll();
}

// Ambil data sepatu
$search = isset($_GET['search']) ? cleanInput($_GET['search']) : '';
$sepatus = getAllSepatu($pdo, $search);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StarSports - Toko Sepatu Olahraga</title>
    
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
                <i class="fas <?php echo htmlspecialchars($logoIcon); ?>"></i> 
                <span class="brand-text"><?php echo htmlspecialchars(substr($siteName, 0, 4)); ?></span><span class="brand-highlight"><?php echo htmlspecialchars(substr($siteName, 4)); ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">
                            <i class="fas fa-cog"></i> Admin Panel
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <?php if($showHero): ?>
    <section class="hero-carousel-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <!-- Slide 1: Running Shoes -->
                <div class="carousel-item active">
                    <div class="hero-slide-modern" style="background: linear-gradient(135deg, rgba(88, 85, 85, 0.7) 0%, rgba(85, 81, 81, 0.8) 100%), url('https://i.pinimg.com/1200x/70/93/a5/7093a5cead3586d387cc015b9f6994f1.jpg') center/cover;">
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <span class="hero-label">CATALYST LIBERTE V5</span>
                                        <h1 class="hero-title-modern">LIBERTE V5</h1>
                                        <p class="hero-subtitle-modern">Teknologi terkini untuk performa maksimal. Rasakan kenyamanan luar biasa di setiap langkah.</p>
                                        <div class="hero-cta">
                                            <a href="#products" class="btn btn-hero-primary">
                                                <i class="fas fa-shopping-cart"></i> Beli Sekarang
                                            </a>
                                            <a href="#products" class="btn btn-hero-outline">
                                                <i class="fas fa-info-circle"></i> Detail Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2: Promo -->
                <div class="carousel-item">
                    <div class="hero-slide-modern" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.7) 0%, rgba(130, 124, 124, 0.8) 0%), url('https://www.specs.id/media/magestore/bannerslider/images/w/e/webbanner_timnas_futsal_jersey_specs_copy_2.jpg') center/cover;">
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <span class="hero-label">SPECIAL OFFER</span>
                                        <h1 class="hero-title-modern">DISKON HINGGA 50%</h1>
                                        <p class="hero-subtitle-modern">Promo spesial untuk semua kategori sepatu olahraga. Jangan lewatkan kesempatan emas ini!</p>
                                        <div class="hero-cta">
                                            <a href="#products" class="btn btn-hero-primary">
                                                <i class="fas fa-tags"></i> Lihat Promo
                                            </a>
                                            <a href="#products" class="btn btn-hero-outline">
                                                <i class="fas fa-clock"></i> Promo Terbatas
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3: New Collection -->
                <div class="carousel-item">
                    <div class="hero-slide-modern" style="background: linear-gradient(135deg, rgba(157, 175, 205, 0.46) 0%, rgba(61, 67, 80, 0.8) 1%), url('https://www.specs.id/media/magestore/bannerslider/images/s/l/slide_banner_specs_ls_4_nitro_new_1920x900_.jpg') center/cover;">
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <span class="hero-label">NEW ARRIVAL 2025</span>
                                        <h1 class="hero-title-modern">KOLEKSI TERBARU</h1>
                                        <p class="hero-subtitle-modern">Sepatu sport terbaru dari brand ternama dunia. Style dan performa dalam satu paket.</p>
                                        <div class="hero-cta">
                                            <a href="#products" class="btn btn-hero-primary">
                                                <i class="fas fa-star"></i> Lihat Koleksi
                                            </a>
                                            <a href="#products" class="btn btn-hero-outline">
                                                <i class="fas fa-arrow-right"></i> Jelajahi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="container mt-5 mb-5">


        <!-- Brand Carousel Section -->
         <div class="brand-section mb-5">
            <h3 class="section-title text-center mb-4">
                <i class="fas fa-award"></i> Brand Ternama
            </h3>
            <div class="brand-carousel-wrapper">
                <div id="brandCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row text-center">
                                <div class="col-4 col-md-2">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg" alt="Nike" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg" alt="Adidas" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/en/d/da/Puma_complete_logo.svg" alt="Puma" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 d-none d-md-block">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Ortuseight.png" alt="Ortuseight" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 d-none d-md-block">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Specs_Sport_Apparell.jpg/500px-Specs_Sport_Apparell.jpg" alt="Specs" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 d-none d-md-block">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/New_Balance_logo.svg/450px-New_Balance_logo.svg.png?20160801155106" alt="New Balance" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row text-center">
                                <div class="col-4 col-md-2">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://mills.co.id/cdn/shop/files/LOGO-MILLS-PRIMARY-512x512.png?v=1730539406&width=165" alt="Mills" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="//upload.wikimedia.org/wikipedia/commons/thumb/5/53/MIZUNO_logo.svg/300px-MIZUNO_logo.svg.png" alt="Mizuono" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Under_armour_logo.svg" alt="Under Armour" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 d-none d-md-block">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/Skechers_logo.svg" alt="Skechers" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 d-none d-md-block">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c5/Diadora_Logo.svg" alt="Diadora" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 d-none d-md-block">
                                    <div class="brand-item">
                                        <div class="brand-logo-img">
                                            <img src="https://seeklogo.com/images/A/airwalk-logo-CC30E3DEEA-seeklogo.com.png" alt="Airwalk" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <?php if($showStatistics): ?>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card animate-slide-up">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-shoe-prints"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo count($sepatus); ?></h3>
                        <p>Total Produk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card animate-slide-up" style="animation-delay: 0.1s;">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo array_sum(array_column($sepatus, 'stok')); ?></h3>
                        <p>Total Stok</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo count(array_unique(array_column($sepatus, 'merk'))); ?></h3>
                        <p>Total Merk</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Product Gallery Section -->
        <div class="product-gallery-section mb-5">
            <h3 class="section-title text-center mb-4">
                <i class="fas fa-th"></i> Galeri Produk Pilihan
            </h3>
            
            <div class="gallery-grid">
                <!-- Grid Item 1 - Large -->
                <div class="gallery-item gallery-large">
                    <div class="gallery-card">
                        <img src="https://i.pinimg.com/1200x/ce/1e/94/ce1e947e45b23fbebd443aaf1ef22876.jpg" alt="Sneakers Collection" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h4>Sports Collection</h4>
                                <p>Koleksi Sepatu Olahraga Terbaik Terbaik</p>
                                <a href="#products" class="btn btn-gallery">Lihat Koleksi <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Item 2 - Medium -->
                <div class="gallery-item gallery-medium">
                    <div class="gallery-card">
                        <img src="https://ortuseightdev.id:8030/assets/dist/magazine/Jogosala-Radiant-SE.jpg" alt="T-Shirts" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h4>Futsal Performance</h4>
                                <p>Kumpulan senjata Futsal</p>
                                <a href="#products" class="btn btn-gallery">Belanja <i class="fas fa-shopping-bag"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Item 3 - Medium -->
                <div class="gallery-item gallery-medium">
                    <div class="gallery-card">
                        <img src="https://i.pinimg.com/1200x/f6/5c/67/f65c670fbe16c880f378a6f9559a0a24.jpg" alt="Football" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h4>Football Equipment</h4>
                                <p>Perlengkapan Sepak Bola</p>
                                <a href="#products" class="btn btn-gallery">Jelajahi <i class="fas fa-futbol"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Item 4 - Small -->
                <div class="gallery-item gallery-small">
                    <div class="gallery-card">
                        <img src="https://i.pinimg.com/1200x/19/cd/0a/19cd0aab0835811b84cd7e250b1b534c.jpg" alt="Bags" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h4>Top Casual</h4>
                                <p>For Lifestyle</p>
                                <a href="#products" class="btn btn-gallery-sm">View</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Item 5 - Small -->
                <div class="gallery-item gallery-small">
                    <div class="gallery-card">
                        <img src="https://i.pinimg.com/1200x/85/1f/98/851f98057c8c668b397167b7f2f8f495.jpg" alt="Running Shoes" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h4>Rare Shoes</h4>
                                <p>Sepatu Langka</p>
                                <a href="#products" class="btn btn-gallery-sm">Shop</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Item 6 - Wide -->
                <div class="gallery-item gallery-wide">
                    <div class="gallery-card">
                        <img src="https://i.pinimg.com/1200x/7a/87/10/7a8710cc1157b7a4f9f529bb9cccf38c.jpg" alt="Training" loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-content">
                                <h4>Training Equipment</h4>
                                <p>Perlengkapan Training Profesional</p>
                                <a href="#products" class="btn btn-gallery">Explore Collection <i class="fas fa-dumbbell"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <form method="GET" action="index.php" class="search-form">
                    <div class="input-group shadow-sm">
                        <input type="text" class="form-control form-control-lg" name="search" 
                               placeholder="Cari sepatu berdasarkan nama atau merk..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <?php if($search): ?>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="category-filter mb-4" id="products">
            <h3 class="section-title mb-3">
                <i class="fas fa-th-large"></i> Katalog Produk
            </h3>
            <div class="d-flex gap-2 flex-wrap mb-3">
                <button class="btn btn-outline-primary active" onclick="filterCategory('all')">
                    <i class="fas fa-border-all"></i> Semua
                </button>
                <button class="btn btn-outline-primary" onclick="filterCategory('Running')">
                    <i class="fas fa-running"></i> Running
                </button>
                <button class="btn btn-outline-primary" onclick="filterCategory('Futsal')">
                    <i class="fas fa-basketball-ball"></i> Futsal
                </button>
                <button class="btn btn-outline-primary" onclick="filterCategory('Football')">
                    <i class="fas fa-futbol"></i> Football
                </button>
                <button class="btn btn-outline-primary" onclick="filterCategory('Casual')">
                    <i class="fas fa-shoe-prints"></i> Casual
                </button>
                <button class="btn btn-outline-primary" onclick="filterCategory('Training')">
                    <i class="fas fa-dumbbell"></i> Training
                </button>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if(isset($_GET['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Product Grid Catalog -->
        <div class="row g-4" id="productGrid">
            <?php if(count($sepatus) > 0): ?>
                <?php foreach($sepatus as $sepatu): ?>
                    <div class="col-6 col-md-4 col-lg-3 product-item" data-category="<?php echo htmlspecialchars($sepatu['kategori']); ?>">
                        <div class="product-card">
                            <!-- Product Image -->
                            <div class="product-image-wrapper">
                                <img src="<?php echo file_exists('uploads/' . $sepatu['gambar']) ? 'uploads/' . $sepatu['gambar'] : 'uploads/default.jpg'; ?>" 
                                     alt="<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>"
                                     class="product-image"
                                     onclick="showImageModal('<?php echo file_exists('uploads/' . $sepatu['gambar']) ? 'uploads/' . $sepatu['gambar'] : 'uploads/default.jpg'; ?>', '<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>')">
                                <div class="product-badges">
                                    <?php if($sepatu['stok'] < 10): ?>
                                        <span class="badge bg-danger">Stok Terbatas</span>
                                    <?php endif; ?>
                                    <span class="badge badge-category"><?php echo htmlspecialchars($sepatu['kategori']); ?></span>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="product-info">
                                <div class="product-brand"><?php echo htmlspecialchars($sepatu['merk']); ?></div>
                                <h5 class="product-name"><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></h5>
                                
                                <div class="product-details">
                                    <span class="detail-item">
                                        <i class="fas fa-ruler"></i> <?php echo htmlspecialchars($sepatu['ukuran']); ?>
                                    </span>
                                    <span class="detail-item">
                                        <i class="fas fa-palette"></i> <?php echo htmlspecialchars($sepatu['warna']); ?>
                                    </span>
                                </div>
                                
                                <div class="product-stock">
                                    <i class="fas fa-boxes"></i> Stok: <strong><?php echo $sepatu['stok']; ?></strong>
                                </div>
                                
                                <div class="product-price">
                                    <?php echo formatRupiah($sepatu['harga']); ?>
                                </div>
                                
                                <?php if(!empty($sepatu['deskripsi'])): ?>
                                <p class="product-description"><?php echo htmlspecialchars(substr($sepatu['deskripsi'], 0, 80)); ?><?php echo strlen($sepatu['deskripsi']) > 80 ? '...' : ''; ?></p>
                                <?php endif; ?>
                                
                                <div class="product-actions">
                                    <a href="edit.php?id=<?php echo $sepatu['id']; ?>" 
                                       class="btn btn-warning btn-sm flex-fill" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm flex-fill" 
                                            onclick="confirmDelete(<?php echo $sepatu['id']; ?>, '<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
                        <h4>Tidak ada produk<?php echo $search ? " dengan kata kunci: <strong>$search</strong>" : ""; ?></h4>
                        <p class="text-muted">Tambahkan produk baru untuk memulai</p>
                        <button class="btn btn-primary btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- View Toggle & Old Table (Hidden by default) -->
        <div class="text-center mt-4">
            <button class="btn btn-outline-secondary" onclick="toggleView()">
                <i class="fas fa-table"></i> Tampilkan Mode Tabel
            </button>
        </div>

        <!-- Table Card (Hidden) -->
        <div class="card table-card shadow-lg animate-fade-in mt-4" id="tableView" style="display: none;">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Sepatu (Mode Tabel)</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">Gambar</th>
                                <th width="18%">Nama Sepatu</th>
                                <th width="10%">Merk</th>
                                <th width="10%">Kategori</th>
                                <th width="7%">Ukuran</th>
                                <th width="9%">Warna</th>
                                <th width="11%">Harga</th>
                                <th width="7%">Stok</th>
                                <th width="13%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($sepatus) > 0): ?>
                                <?php foreach($sepatus as $sepatu): ?>
                                    <tr class="table-row-animate">
                                        <td><span class="badge bg-secondary"><?php echo $sepatu['id']; ?></span></td>
                                        <td>
                                            <img src="<?php echo file_exists('uploads/' . $sepatu['gambar']) ? 'uploads/' . $sepatu['gambar'] : 'uploads/default.jpg'; ?>" 
                                                 alt="<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>"
                                                 class="img-thumbnail product-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                                 onclick="showImageModal('<?php echo file_exists('uploads/' . $sepatu['gambar']) ? 'uploads/' . $sepatu['gambar'] : 'uploads/default.jpg'; ?>', '<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>')">
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($sepatu['merk']); ?></td>
                                        <td><span class="badge badge-category"><?php echo htmlspecialchars($sepatu['kategori']); ?></span></td>
                                        <td><?php echo htmlspecialchars($sepatu['ukuran']); ?></td>
                                        <td><?php echo htmlspecialchars($sepatu['warna']); ?></td>
                                        <td class="text-success fw-bold"><?php echo formatRupiah($sepatu['harga']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $sepatu['stok'] < 10 ? 'bg-danger' : 'bg-success'; ?>">
                                                <?php echo $sepatu['stok']; ?> pcs
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="edit.php?id=<?php echo $sepatu['id']; ?>" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="confirmDelete(<?php echo $sepatu['id']; ?>, '<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data sepatu<?php echo $search ? " dengan kata kunci: <strong>$search</strong>" : ""; ?></p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                            <i class="fas fa-plus"></i> Tambah Sepatu
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Sepatu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="create.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Gambar Sepatu</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*" onchange="previewImage(this, 'preview-add')">
                                <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 2MB)</small>
                                <div class="mt-2">
                                    <img id="preview-add" src="uploads/default.jpg" alt="Preview" style="max-width: 200px; max-height: 200px; display: none;" class="img-thumbnail">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Sepatu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_sepatu" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Merk <span class="text-danger">*</span></label>
                                <select class="form-control" name="merk" required>
                                    <option value="">Pilih Merk</option>
                                    <option value="Nike">Nike</option>
                                    <option value="Adidas">Adidas</option>
                                    <option value="Puma">Puma</option>
                                    <option value="Ortuseight">Ortuseight</option>
                                    <option value="Specs">Specs</option>
                                    <option value="New Balance">New Balance</option>
                                    <option value="Mills">Mills</option>
                                    <option value="Mizuno">Mizuno</option>
                                    <option value="Vans">Vans</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Running">Running</option>
                                    <option value="Football">Football</option>
                                    <option value="Futsal">Futsal</option>
                                    <option value="Training">Training</option>
                                    <option value="Casual">Casual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ukuran <span class="text-danger">*</span></label>
                                <select class="form-control" name="ukuran" required>
                                    <option value="">Pilih Ukuran</option>
                                    <?php for($i = 36; $i <= 46; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Warna <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="warna" required placeholder="Contoh: Hitam, Putih/Merah">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="harga" required min="0" step="1000" placeholder="Contoh: 500000">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stok" required min="0" placeholder="Jumlah stok">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Deskripsi singkat tentang sepatu"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

 <!-- StarSports custom footer -->
<footer class="site-footer starsports-footer" role="contentinfo" aria-label="StarSports footer">
  <div class="container footer-grid">
    <div class="footer-column brands">
      <h3>Brands @ StarSports</h3>
      <p>Kami menghadirkan merek-merek terbaik:</p>
      <ul class="brand-list">
        <li>Nike</li>
        <li>Adidas</li>
        <li>Puma</li>
        <li>Ortuseight</li>
        <li>Specs</li>
        <li>New Balance</li>
        <li>Mills</li>
        <li>Mizuno</li>
        <li>Vans</li>
        <li>Under Armour</li>
        <li>Skechers</li>
        <li>Diadora</li>
        <li>Airwalk</li>
      </ul>
    </div>
    <div class="footer-column links">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#products">Katalog</a></li>
        <li><a href="#">Promo</a></li>
        <li><a href="#">Kontak</a></li>
        <li><a href="#">Bantuan</a></li>
      </ul>
    </div>
    <div class="footer-column contact">
      <h3>Customer Care</h3>
      <p class="hours">Mon - Fri, 8:00 - 17:00 WIB</p>
      <p class="phone">+62 21 54315928</p>
      <p class="email"><a href="mailto:cs@starsports.local">cs@starsports.local</a></p>
      <p class="address">StarSports HQ, Jl. Olahraga No.1, Kota</p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <span id="ss-year"></span> StarSports. All rights reserved.</p>
    <a href="#" id="back-to-top-ss" class="back-to-top-ss" aria-label="Back to top">↑</a>
  </div>
</footer>
<script>
document.getElementById('ss-year')?.textContent = new Date().getFullYear();
document.getElementById('back-to-top-ss')?.addEventListener('click', function(e){ e.preventDefault(); window.scrollTo({top:0, behavior:'smooth'}); });
</script>
<style>
.starsports-footer{background:#f7f7fb;color:#222;padding:40px 20px;font-family:Arial, sans-serif;border-top:1px solid #eee}
.starsports-footer a{color:#222}
.footer-grid{display:flex;flex-wrap:wrap;gap:24px;max-width:1200px;margin:0 auto}
.footer-column{flex:1 1 220px;min-width:180px}
.footer-column h3{font-size:16px;margin-bottom:12px}
.brand-list{columns:2;list-style:none;padding:0;margin:0}
.brand-list li{margin:6px 0;padding-left:6px}
.footer-bottom{border-top:1px solid rgba(0,0,0,0.06);margin-top:24px;padding-top:16px;display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:24px auto 0}
@media(max-width:800px){.footer-grid{flex-direction:column}}
</style>
<!-- End StarSports footer -->


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        function confirmDelete(id, nama) {
            if(confirm(`Apakah Anda yakin ingin menghapus sepatu "${nama}"?`)) {
                window.location.href = `delete.php?id=${id}`;
            }
        }

        // Preview image before upload
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Show image in modal
        function showImageModal(imageSrc, imageName) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = imageName;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }

        // Filter products by category
        function filterCategory(category) {
            const products = document.querySelectorAll('.product-item');
            const buttons = document.querySelectorAll('.category-filter button');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('button').classList.add('active');
            
            // Filter products
            products.forEach(product => {
                if (category === 'all') {
                    product.style.display = 'block';
                    setTimeout(() => product.classList.add('visible'), 10);
                } else {
                    if (product.dataset.category === category) {
                        product.style.display = 'block';
                        setTimeout(() => product.classList.add('visible'), 10);
                    } else {
                        product.style.display = 'none';
                        product.classList.remove('visible');
                    }
                }
            });
        }

        // Toggle between grid and table view
        function toggleView() {
            const gridView = document.getElementById('productGrid');
            const tableView = document.getElementById('tableView');
            const toggleBtn = event.target.closest('button');
            
            if (tableView.style.display === 'none') {
                gridView.style.display = 'none';
                tableView.style.display = 'block';
                toggleBtn.innerHTML = '<i class="fas fa-th"></i> Tampilkan Mode Grid';
            } else {
                gridView.style.display = 'flex';
                tableView.style.display = 'none';
                toggleBtn.innerHTML = '<i class="fas fa-table"></i> Tampilkan Mode Tabel';
            }
        }

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-item, .table-row-animate').forEach(item => {
            observer.observe(item);
        });

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Initialize product items animation
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.querySelectorAll('.product-item').forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('visible');
                    }, index * 50);
                });
            }, 100);
        });
    </script>
</body>
</html>