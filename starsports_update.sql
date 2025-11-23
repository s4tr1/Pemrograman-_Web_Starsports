-- Database: starsports (UPDATE)
-- Tambahan tabel untuk settings admin

USE starsports;

-- Tabel settings untuk admin panel
CREATE TABLE IF NOT EXISTS settings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    setting_type VARCHAR(20) DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, setting_type) VALUES
('site_name', 'StarSports', 'text'),
('site_tagline', 'Kelola Koleksi Sepatu Olahraga Terbaik Anda', 'text'),
('primary_color', '#667eea', 'color'),
('secondary_color', '#764ba2', 'color'),
('accent_color', '#f59e0b', 'color'),
('show_statistics', '1', 'boolean'),
('show_hero', '1', 'boolean'),
('items_per_page', '10', 'number'),
('logo_icon', 'fa-running', 'text')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value);

-- Pastikan kolom gambar ada di tabel sepatu
-- (Sudah ada dari SQL sebelumnya, tapi pastikan)
ALTER TABLE sepatu MODIFY COLUMN gambar VARCHAR(255) DEFAULT 'default.jpg';
