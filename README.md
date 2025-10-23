# JerseyDall - Platform Jual Beli Jersey Online

JerseyDall adalah aplikasi web berbasis Laravel yang dirancang khusus untuk kebutuhan jual beli jersey sepak bola secara online. Aplikasi ini menawarkan pengalaman yang mudah dan aman bagi para penggemar sepak bola dalam mencari, menjual, dan membeli jersey tim favorit mereka.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Prasyarat Sistem](#prasyarat-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [Struktur Proyek](#struktur-proyek)
- [Database](#database)
- [API dan Fungsi Penting](#api-dan-fungsi-penting)
- [Pengembangan](#pengembangan)
- [Testing](#testing)
- [Deployment](#deployment)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)
- [Dukungan dan Masalah](#dukungan-dan-masalah)

## Fitur Utama

### 1. Sistem Multi-Role
- **Admin**: Mengelola platform, verifikasi jersey pelanggan, mengelola transaksi, dan mengawasi aktivitas pengguna
- **Pelanggan**: Membeli jersey, menjual jersey milik mereka, mengelola profil dan transaksi

### 2. Fitur Jual Beli Jersey
- **Fitur Jual Jersey**: Pelanggan dapat mengupload jersey yang ingin dijual dengan foto dan deskripsi lengkap
- **Fitur Beli Jersey**: Pelanggan dapat membeli jersey dari sistem atau dari pelanggan lain
- **Verifikasi Manual**: Setiap transaksi diverifikasi secara manual oleh admin untuk keamanan dan kepercayaan

### 3. Manajemen Produk
- **Jersey Sistem**: Jersey yang diupload oleh admin untuk penjualan langsung
- **Jersey Pelanggan**: Jersey yang diupload oleh pengguna untuk dijual
- **Manajemen Stok**: Sistem pengelolaan stok yang akurat untuk setiap jersey

### 4. Dashboard
- **Dashboard Admin**: Menampilkan statistik platform, daftar transaksi, jersey yang menunggu verifikasi, dan pengelolaan pengguna
- **Dashboard Pelanggan**: Menampilkan jersey tersedia, riwayat pembelian, penjualan, dan informasi akun

### 5. Sistem Transaksi
- **Status Transaksi**: Setiap transaksi memiliki status (pending, selesai, ditolak) untuk transparansi
- **Bukti Pembayaran**: Upload bukti pembayaran untuk konfirmasi transaksi
- **Alur Transaksi**: Proses transaksi yang jelas dan terdokumentasi

### 6. Manajemen Pengguna
- **Autentikasi**: Sistem login/register dengan validasi
- **Profil Pengguna**: Setiap pengguna dapat mengelola informasi pribadi mereka

### 7. Tampilan Responsif
- **Mobile-Friendly**: Tampilan yang responsif untuk perangkat mobile dan desktop
- **UI/UX yang Intuitif**: Desain yang mudah digunakan dan menarik

## Teknologi yang Digunakan

- **Backend**: Laravel 12.x
- **Database**: MySQL
- **Frontend**: Bootstrap 5, JavaScript
- **CSS Framework**: Bootstrap 5
- **Icon**: Font Awesome
- **Development Server**: Artisan (Laravel)
- **Dependency Management**: Composer (PHP)

## Prasyarat Sistem

Sebelum Anda memulai, pastikan sistem Anda memiliki:

- PHP >= 8.2
- Composer
- MySQL (atau database lain yang didukung Laravel)
- Node.js (untuk opsi development frontend assets)
- NPM atau Yarn

## Instalasi

### 1. Clone Repository

```bash
git clone <URL_REPOSITORY_ANDA>
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

- `APP_NAME`: Nama aplikasi
- `APP_ENV`: Lingkungan (local, production)
- `APP_KEY`: Kunci aplikasi (dihasilkan secara otomatis)
- `DB_*`: Konfigurasi database
- `MAIL_*`: Konfigurasi email (jika diperlukan)
- `CACHE_*`: Konfigurasi cache (jika diperlukan)

### Konfigurasi Tambahan

- **Storage**: File gambar jersey disimpan di `storage/app/public` dan diakses melalui `/storage`
- **Cache**: Gunakan `php artisan config:cache` untuk produksi
- **Route Cache**: Gunakan `php artisan route:cache` untuk produksi

## Penggunaan

### 1. Registrasi & Login

- Akses halaman `/register` untuk mendaftar akun baru
- Akses halaman `/login` untuk login ke sistem
- Pengguna default akan dibuat saat seeding

### 2. Untuk Admin

- Login sebagai admin (akun dengan role `admin`)
- Akses dashboard admin di `/admin/dashboard`
- Kelola jersey sistem dan jersey dari pelanggan
- Verifikasi transaksi dan kelola pengguna

### 3. Untuk Pelanggan

- Login sebagai pelanggan
- Jelajahi jersey yang tersedia di `/available-jerseys`
- Jual jersey dengan mengakses `/jerseys/sell`
- Lihat riwayat transaksi di `/transactions`

### 4. Fitur Utama

- **Jual Jersey**: Upload jersey Anda sendiri untuk dijual
- **Beli Jersey**: Beli jersey dari sistem atau dari pelanggan lain
- **Verifikasi Transaksi**: Setiap transaksi melalui proses verifikasi manual

## Struktur Proyek

```
├── app/                    # Kode aplikasi utama
│   ├── Http/              # Controller, Middleware, Request, Resource
│   │   ├── Controllers/   # File-file controller
│   │   ├── Middleware/    # Middleware kustom
│   │   └── Requests/      # Form request validation
│   ├── Models/            # Model Eloquent
│   └── Providers/         # Service providers
├── bootstrap/             # File bootstrap framework
├── config/                # File-file konfigurasi
├── database/              # Migration, seeders, factories
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── public/                # Folder publik (assets, storage link)
├── resources/             # View, assets, lang
│   ├── css/              # File CSS
│   ├── js/               # File JavaScript
│   ├── views/            # Blade templates
│   └── lang/             # File bahasa
├── routes/                # File-route aplikasi
├── storage/               # File-file storage
├── tests/                 # File-file test
├── vendor/                # Dependencies Composer
├── .env                   # File environment (tidak ada di repo)
├── .gitignore            # File yang diabaikan oleh Git
├── artisan               # Script CLI Laravel
├── composer.json         # Dependencies dan konfigurasi Composer
├── package.json          # Dependencies frontend
├── phpunit.xml           # Konfigurasi PHPUnit
├── README.md             # Dokumentasi ini
└── vite.config.js        # Konfigurasi Vite (jika digunakan)
```

## Database

### Skema Database Penting

#### 1. users
- id
- name
- email
- password
- role (admin/pelanggan)
- phone_number
- address
- created_at
- updated_at

#### 2. jerseys
- id
- user_id (foreign key ke users, NULL untuk jersey sistem)
- name
- description
- price
- stock
- photo (gambar utama)
- additional_photos (JSON array untuk foto tambahan)
- type (sistem/pelanggan)
- status (aktif, pending_review, ditolak)
- size
- sizes (JSON array untuk beberapa ukuran)
- created_at
- updated_at
- slug

#### 3. transactions
- id
- jersey_id (foreign key ke jerseys)
- user_id (foreign key ke users - pembeli)
- buyer_address
- buyer_phone
- payment_proof
- type (pembelian/penjualan)
- status (pending/selesai/ditolak)
- created_at
- updated_at
- transaction_code (kode unik)

#### 4. jersey_photos
- id
- jersey_id (foreign key ke jerseys)
- photo_path
- created_at
- updated_at

## API dan Fungsi Penting

### Controller Utama

#### DashboardController
- `adminDashboard()`: Dashboard untuk admin
- `customerDashboard()`: Dashboard untuk pelanggan

#### JerseyController
- `availableJerseys()`: Menampilkan jersey yang tersedia untuk dibeli
- `showSellForm()`: Menampilkan form untuk menjual jersey
- `sellJersey()`: Menyimpan jersey yang akan dijual oleh pelanggan
- `adminIndex()`: Daftar semua jersey untuk admin
- `adminCreate()`, `adminStore()`, `adminEdit()`, `adminUpdate()`, `adminDestroy()`: CRUD jersey untuk admin
- `approveJersey()`, `rejectJersey()`: Fungsi verifikasi jersey dari pelanggan

#### TransactionController
- `showBuyForm()`: Menampilkan form pembelian
- `buyJersey()`: Proses pembelian jersey
- `customerTransactions()`: Riwayat transaksi pelanggan
- `customerBoughtTransactions()`, `customerSoldTransactions()`: Rincian transaksi
- `adminIndex()`: Daftar semua transaksi untuk admin
- `approveTransaction()`, `rejectTransaction()`: Fungsi verifikasi transaksi

### Model Penting

#### Jersey Model
- Relasi ke `user`, `transactions`, `photos`
- Scope untuk filter: `aktif()`, `sistemAktif()`, `pelangganDisetujui()`
- Method `hasSize()`, `hasStock()`, `reduceStock()`, `getAllPhotosAttribute()`

#### Transaction Model
- Relasi ke `jersey`, `user`
- Method `isPurchase()`, `isSale()`, `isPending()`, `isCompleted()`, `isRejected()`

## Pengembangan

### Menambahkan Fitur Baru

1. **Buat Migration**: Gunakan `php artisan make:migration`
2. **Buat Model**: Gunakan `php artisan make:model`
3. **Buat Controller**: Gunakan `php artisan make:controller`
4. **Tambahkan Route**: Di `routes/web.php`
5. **Buat View**: Di `resources/views/`
6. **Testing**: Pastikan menulis test untuk fitur baru

### Gaya Penulisan Kode

- Ikuti standar PSR-12 untuk PHP
- Gunakan type hinting dan return type
- Gunakan model relationship dengan benar
- Gunakan form request untuk validasi input
- Gunakan resource untuk API response (jika diperlukan)

## Testing

### Menjalankan Test

```bash
# Menjalankan semua test
php artisan test

# Menjalankan test dengan coverage
php artisan test --coverage
```

### Jenis-jenis Test

- **Feature Tests**: Pengujian end-to-end
- **Unit Tests**: Pengujian komponen individual

## Deployment

### Server Production

1. **Konfigurasi Environment**:
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Konfigurasi database

2. **Optimasi Aplikasi**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Setup Web Server**:
   - Arahkan document root ke folder `public/`
   - Konfigurasi rewrite rules untuk Laravel

4. **Cron Jobs** (jika diperlukan):
   - Tambahkan cron job untuk queue worker

## Kontribusi

Terima kasih atas minat Anda untuk berkontribusi pada proyek ini!

### Panduan Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/NamaFitur`)
3. Commit perubahan Anda (`git commit -m 'Menambahkan fitur X'`)
4. Push ke branch (`git push origin feature/NamaFitur`)
5. Buat Pull Request

### Standar Kontribusi

- Ikuti gaya penulisan kode yang konsisten
- Pastikan semua test melewati
- Dokumentasikan perubahan yang Anda buat
- Gunakan commit message yang jelas dan deskriptif

## Lisensi

MIT License. Lihat file `LICENSE` untuk informasi lebih lanjut.

## Dukungan dan Masalah

### Melaporkan Masalah

Jika Anda menemukan bug atau memiliki saran fitur:

1. Cek apakah masalah sudah dilaporkan sebelumnya
2. Buat issue baru dengan template yang sesuai
3. Sertakan detail lingkungan, langkah reproduksi, dan harapan perilaku

### Dukungan

- **Email**: [alamat_email_support@jerseydall.com]
- **Forum**: [link_forum_dukungan]
- **Documentation**: [link_dokumentasi_lengkap]

---

Dikembangkan dengan ❤️ untuk komunitas penggemar sepak bola

Jika Anda menikmati proyek ini, jangan lupa untuk ⭐ repository ini!