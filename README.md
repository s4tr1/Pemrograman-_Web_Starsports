# StarSports - Toko Sepatu Olahraga

Aplikasi web manajemen toko sepatu olahraga dengan operasi CRUD lengkap yang dibangun menggunakan PHP, MySQL, dan Bootstrap 5.

## 🚀 Fitur Utama

- **CREATE**: Tambah data sepatu baru dengan validasi
- **READ**: Tampilan tabel data sepatu yang dinamis
- **UPDATE**: Edit data sepatu dengan form yang sudah terisi data lama
- **DELETE**: Hapus data dengan konfirmasi
- **UI Modern**: Menggunakan Bootstrap 5 dengan custom styling
- **Animasi**: Smooth animations untuk meningkatkan user experience

Fitur Tambahan
-  **Pencarian**: Fitur search berdasarkan nama sepatu atau merk
-  **Validasi**: Validasi harga dan stok harus berupa angka positif
-  **Prepared Statement**: Menggunakan PDO Prepared Statement untuk keamanan
-  **Statistics Dashboard**: Menampilkan total produk, stok, dan merk
-  **Responsive Design**: Tampilan menyesuaikan berbagai ukuran layar
-  **Alert Messages**: Notifikasi sukses/error dengan auto-dismiss

## 📋 Persyaratan Sistem

- **XAMPP** (Apache + MySQL + PHP 7.4+)
- **Web Browser** (Chrome, Firefox, Edge, Safari)
- **Text Editor** (VS Code, Sublime Text, dll) - opsional untuk modifikasi

## 🛠️ Cara Instalasi

### 1. Setup XAMPP

1. Download dan install XAMPP dari [https://www.apachefriends.org](https://www.apachefriends.org)
2. Jalankan XAMPP Control Panel
3. Start **Apache** dan **MySQL**

### 2. Setup Database

1. Buka browser dan akses [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Klik tab **"SQL"**
3. Copy semua isi dari file `starsports_database.sql`
4. Paste ke dalam SQL Query Box
5. Klik tombol **"Go"** atau **"Kirim"**
6. Database `starsports` dan tabel `sepatu` akan otomatis terbuat beserta data sample

### 3. Setup Aplikasi

1. Copy semua file aplikasi ke folder `htdocs` di direktori instalasi XAMPP
   - Windows: `C:\xampp\htdocs\starsports\`
   - Mac: `/Applications/XAMPP/htdocs/starsports/`
   - Linux: `/opt/lampp/htdocs/starsports/`

2. Struktur folder harus seperti ini:
   ```
   htdocs/
   └── starsports/
       ├── config.php
       ├── index.php
       ├── create.php
       ├── edit.php
       ├── update.php
       ├── delete.php
       ├── style.css
       ├── starsports_database.sql
       └── README.md
   ```

### 4. Akses Aplikasi

1. Buka browser
2. Akses [http://localhost/starsports](http://localhost/starsports)
3. Aplikasi siap digunakan! 🎉

## 📖 Cara Penggunaan

### Tambah Data Sepatu
1. Klik tombol **"Tambah Produk"** di navbar atau di halaman utama
2. Isi semua field yang diperlukan (semua field wajib diisi)
3. Klik tombol **"Simpan"**
4. Data akan ditambahkan dan muncul notifikasi sukses

### Lihat/Cari Data
1. Semua data sepatu ditampilkan di tabel utama
2. Gunakan search bar untuk mencari sepatu berdasarkan nama atau merk
3. Statistik dashboard menampilkan total produk, stok, dan merk

### Edit Data
1. Klik tombol **Edit** (icon pensil kuning) pada baris data yang ingin diedit
2. Form edit akan muncul dengan data lama sudah terisi
3. Ubah data yang diinginkan
4. Klik tombol **"Update Data"**
5. Data akan diperbarui dan muncul notifikasi sukses

### Hapus Data
1. Klik tombol **Delete** (icon trash merah) pada baris data yang ingin dihapus
2. Akan muncul konfirmasi: "Apakah Anda yakin ingin menghapus sepatu [nama_sepatu]?"
3. Klik **OK** untuk menghapus atau **Cancel** untuk membatalkan
4. Data akan dihapus dan muncul notifikasi sukses

## 🗂️ Struktur Database

### Tabel: `sepatu`

| Field | Type | Keterangan |
|-------|------|------------|
| id | INT(11) AUTO_INCREMENT | Primary Key |
| nama_sepatu | VARCHAR(100) | Nama sepatu |
| merk | VARCHAR(50) | Merk sepatu (Nike, Adidas, dll) |
| kategori | VARCHAR(50) | Kategori (Running, Basketball, dll) |
| ukuran | VARCHAR(10) | Ukuran sepatu (36-46) |
| warna | VARCHAR(30) | Warna sepatu |
| harga | DECIMAL(10,2) | Harga dalam Rupiah |
| stok | INT(11) | Jumlah stok |
| deskripsi | TEXT | Deskripsi produk |
| gambar | VARCHAR(255) | Nama file gambar (default: default.jpg) |
| created_at | TIMESTAMP | Waktu data dibuat |
| updated_at | TIMESTAMP | Waktu data diupdate |

## 🎨 Teknologi yang Digunakan

- **Backend**: PHP 7.4+ dengan PDO
- **Database**: MySQL
- **Frontend**: 
  - HTML5
  - CSS3 (Custom + Animations)
  - Bootstrap 5.3
  - JavaScript (ES6+)
- **Icons**: Font Awesome 6.4
- **Fonts**: Google Fonts (Poppins)

## 🔒 Keamanan

- ✅ Menggunakan **PDO Prepared Statements** untuk mencegah SQL Injection
- ✅ Input validation dan sanitization dengan `htmlspecialchars()`
- ✅ Validasi data di sisi server dan client
- ✅ Error handling yang proper

## 📱 Responsive Design

Aplikasi ini responsive dan dapat diakses dengan baik di:
- 💻 Desktop (1920px+)
- 💻 Laptop (1366px - 1920px)
- 📱 Tablet (768px - 1024px)
- 📱 Mobile (320px - 767px)

## 🎯 Fitur Tambahan

### Animasi
- Fade in animation untuk card dan alert
- Slide up animation untuk statistics cards
- Bounce animation untuk hero icon
- Hover effects pada tabel dan button
- Smooth transitions

### UI/UX
- Gradient backgrounds
- Modern card design
- Interactive buttons dengan hover effects
- Color-coded badges untuk stok
- Loading states
- Custom scrollbar

## 🐛 Troubleshooting

### Database Connection Error
**Masalah**: "ERROR: Tidak dapat terhubung ke database"

**Solusi**:
1. Pastikan MySQL di XAMPP sudah running
2. Cek konfigurasi di `config.php`:
   - DB_HOST: 'localhost'
   - DB_USER: 'root'
   - DB_PASS: '' (kosong untuk default XAMPP)
   - DB_NAME: 'starsports'
3. Pastikan database sudah diimport

### 404 Not Found
**Masalah**: Halaman tidak ditemukan

**Solusi**:
1. Pastikan file ada di folder `htdocs/starsports/`
2. Akses dengan URL yang benar: `http://localhost/starsports`
3. Pastikan Apache di XAMPP sudah running

### Data Tidak Tersimpan
**Masalah**: Data tidak tersimpan setelah submit

**Solusi**:
1. Cek console browser (F12) untuk error JavaScript
2. Pastikan semua field wajib diisi
3. Cek error log di XAMPP

## 👥 Tim Pengembang

Aplikasi ini dibuat untuk memenuhi **Tugas 2 Pemrograman Web Semester Ganjil 2025/2026**.

---

## 📝 Lisensi

Aplikasi ini dibuat untuk keperluan akademik.

---

## 📞 Support

Jika ada pertanyaan atau masalah, silakan hubungi tim pengembang atau dosen pengampu.

---

**Happy Coding! 🚀**
