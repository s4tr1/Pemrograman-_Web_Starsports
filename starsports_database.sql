-- Database: starsports
-- Buat database baru

CREATE DATABASE IF NOT EXISTS starsports;
USE starsports;

-- Tabel untuk menyimpan data sepatu
CREATE TABLE IF NOT EXISTS sepatu (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_sepatu VARCHAR(100) NOT NULL,
    merk VARCHAR(50) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    ukuran VARCHAR(10) NOT NULL,
    warna VARCHAR(30) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT(11) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data sample
INSERT INTO sepatu (nama_sepatu, merk, kategori, ukuran, warna, harga, stok, deskripsi) VALUES
('Air Max 270', 'Nike', 'Running', '42', 'Hitam/Putih', 1250000, 15, 'Sepatu running dengan cushioning maksimal untuk kenyamanan sepanjang hari'),
('Ultraboost 22', 'Adidas', 'Running', '43', 'Biru Navy', 2100000, 8, 'Sepatu lari premium dengan teknologi Boost yang responsif'),
('Chuck Taylor All Star', 'Converse', 'Casual', '41', 'Merah', 650000, 20, 'Sepatu klasik yang iconic dan stylish untuk gaya kasual'),
('Curry 10', 'Under Armour', 'Basketball', '44', 'Putih/Emas', 1850000, 10, 'Sepatu basket signature Stephen Curry dengan traksi superior'),
('Phantom GT2', 'Nike', 'Football', '42', 'Hijau Neon', 1650000, 12, 'Sepatu sepak bola dengan fit yang presisi dan kontrol bola maksimal'),
('Gel-Kayano 29', 'Asics', 'Running', '43', 'Abu-abu', 1750000, 7, 'Sepatu stability untuk pelari dengan pronasi berlebih'),
('Court Vision', 'Nike', 'Casual', '40', 'Putih', 850000, 18, 'Terinspirasi dari basket klasik dengan gaya modern'),
('Superstar', 'Adidas', 'Casual', '42', 'Hitam/Putih', 1100000, 14, 'Sepatu ikonik dengan three stripes dan shell toe legendary');
