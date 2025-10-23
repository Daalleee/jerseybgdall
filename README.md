# JerseyDall - Platform Jual Beli Jersey Online

JerseyDall adalah aplikasi web berbasis Laravel yang dirancang khusus untuk kebutuhan jual beli jersey sepak bola secara online. Aplikasi ini menawarkan pengalaman yang mudah dan aman bagi para penggemar sepak bola dalam mencari, menjual, dan membeli jersey tim favorit mereka.

## Daftar Isi

-   [Fitur Utama](#fitur-utama)
-   [Teknologi yang Digunakan](#teknologi-yang-digunakan)
-   [Prasyarat Sistem](#prasyarat-sistem)
-   [Instalasi](#instalasi)
-   [Konfigurasi](#konfigurasi)
-   [Penggunaan](#penggunaan)
-   [Struktur Proyek](#struktur-proyek)
-   [Database](#database)
-   [API dan Fungsi Penting](#api-dan-fungsi-penting)
-   [Pengembangan](#pengembangan)
-   [Testing](#testing)
-   [Deployment](#deployment)
-   [Kontribusi](#kontribusi)
-   [Lisensi](#lisensi)
-   [Dukungan dan Masalah](#dukungan-dan-masalah)

## Fitur Utama

### 1. Sistem Multi-Role

-   **Admin**: Mengelola platform, verifikasi jersey pelanggan, mengelola transaksi, dan mengawasi aktivitas pengguna
-   **Pelanggan**: Membeli jersey, menjual jersey milik mereka, mengelola profil dan transaksi

### 2. Fitur Jual Beli Jersey

-   **Fitur Jual Jersey**: Pelanggan dapat mengupload jersey yang ingin dijual dengan foto dan deskripsi lengkap
-   **Fitur Beli Jersey**: Pelanggan dapat membeli jersey dari sistem atau dari pelanggan lain
-   **Verifikasi Manual**: Setiap transaksi diverifikasi secara manual oleh admin untuk keamanan dan kepercayaan

### 3. Manajemen Produk

-   **Jersey Sistem**: Jersey yang diupload oleh admin untuk penjualan langsung
-   **Jersey Pelanggan**: Jersey yang diupload oleh pengguna untuk dijual
-   **Manajemen Stok**: Sistem pengelolaan stok yang akurat untuk setiap jersey

### 4. Dashboard

-   **Dashboard Admin**: Menampilkan statistik platform, daftar transaksi, jersey yang menunggu verifikasi, dan pengelolaan pengguna
-   **Dashboard Pelanggan**: Menampilkan jersey tersedia, riwayat pembelian, penjualan, dan informasi akun

### 5. Sistem Transaksi

-   **Status Transaksi**: Setiap transaksi memiliki status (pending, selesai, ditolak) untuk transparansi
-   **Bukti Pembayaran**: Upload bukti pembayaran untuk konfirmasi transaksi
-   **Alur Transaksi**: Proses transaksi yang jelas dan terdokumentasi

### 6. Manajemen Pengguna

-   **Autentikasi**: Sistem login/register dengan validasi
-   **Profil Pengguna**: Setiap pengguna dapat mengelola informasi pribadi mereka

### 7. Tampilan Responsif

-   **Mobile-Friendly**: Tampilan yang responsif untuk perangkat mobile dan desktop
-   **UI/UX yang Intuitif**: Desain yang mudah digunakan dan menarik

## Teknologi yang Digunakan

-   **Backend**: Laravel 12.x
-   **Database**: MySQL
-   **Frontend**: Bootstrap 5, JavaScript
-   **CSS Framework**: Bootstrap 5
-   **Icon**: Font Awesome
-   **Development Server**: Artisan (Laravel)
-   **Dependency Management**: Composer (PHP)

## Prasyarat Sistem

Sebelum Anda memulai, pastikan sistem Anda memiliki:

-   PHP >= 8.2
-   Composer
-   MySQL (atau database lain yang didukung Laravel)
-   Node.js (untuk opsi development frontend assets)
-   NPM atau Yarn

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/Daalleee/jerseybgdall.git
cd jerseybgdall
```

### 2. Instal Dependencies

```bash
composer install
npm install # jika ingin mengembangkan assets frontend
```

### 3. Konfigurasi Environment

Salin file `.env.example` ke `.env`:

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jerseydall
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 6. Migrasi Database

```bash
php artisan migrate --seed
```

Perintah ini akan membuat struktur database dan mengisi data awal jika ada.

### 7. Storage Link

```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://127.0.0.1:8000`

## Konfigurasi

### File Environment (.env)

Beberapa konfigurasi penting dalam file `.env`:

-   `APP_NAME`: Nama aplikasi
-   `APP_ENV`: Lingkungan (local, production)
-   `APP_KEY`: Kunci aplikasi (dihasilkan secara otomatis)
-   `DB_*`: Konfigurasi database
-   `MAIL_*`: Konfigurasi email (jika diperlukan)
-   `CACHE_*`: Konfigurasi cache (jika diperlukan)

### Konfigurasi Tambahan

-   **Storage**: File gambar jersey disimpan di `storage/app/public` dan diakses melalui `/storage`
-   **Cache**: Gunakan `php artisan config:cache` untuk produksi
-   **Route Cache**: Gunakan `php artisan route:cache` untuk produksi

## Penggunaan

### 1. Registrasi & Login

-   Akses halaman `/register` untuk mendaftar akun baru
-   Akses halaman `/login` untuk login ke sistem
-   Pengguna default akan dibuat saat seeding

### 2. Untuk Admin

-   Login sebagai admin (akun dengan role `admin`)
-   Akses dashboard admin di `/admin/dashboard`
-   Kelola jersey sistem dan jersey dari pelanggan
-   Verifikasi transaksi dan kelola pengguna

### 3. Untuk Pelanggan

-   Login sebagai pelanggan
-   Jelajahi jersey yang tersedia di `/available-jerseys`
-   Jual jersey dengan mengakses `/jerseys/sell`
-   Lihat riwayat transaksi di `/transactions`

### 4. Fitur Utama

-   **Jual Jersey**: Upload jersey Anda sendiri untuk dijual
-   **Beli Jersey**: Beli jersey dari sistem atau dari pelanggan lain
-   **Verifikasi Transaksi**: Setiap transaksi melalui proses verifikasi manual

### Menambahkan Fitur Baru

1. **Buat Migration**: Gunakan `php artisan make:migration`
2. **Buat Model**: Gunakan `php artisan make:model`
3. **Buat Controller**: Gunakan `php artisan make:controller`
4. **Tambahkan Route**: Di `routes/web.php`
5. **Buat View**: Di `resources/views/`
6. **Testing**: Pastikan menulis test untuk fitur baru

### Melaporkan Masalah

Jika Anda menemukan bug atau memiliki saran fitur:

1. Cek apakah masalah sudah dilaporkan sebelumnya
2. Buat issue baru dengan template yang sesuai
3. Sertakan detail lingkungan, langkah reproduksi, dan harapan perilaku

Dikembangkan dengan ❤️ untuk komunitas penggemar sepak bola

Jika Anda menikmati proyek ini, jangan lupa untuk ⭐ repository ini!
