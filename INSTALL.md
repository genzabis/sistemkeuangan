# Panduan Instalasi Expense Tracker

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM (untuk build assets)
- SQLite atau MySQL

## Langkah Instalasi

### Opsi 1: Menggunakan Script Otomatis (Windows)

1. Buka Command Prompt atau PowerShell
2. Navigasi ke folder `expense-tracker`
3. Jalankan script instalasi:
   ```bash
   INSTALL.bat
   ```

### Opsi 2: Manual Installation

#### 1. Setup PHP di PATH (Jika menggunakan XAMPP)

Tambahkan PHP ke system PATH atau gunakan path lengkap:
```bash
C:\xampp\php\php.exe
```

#### 2. Install Dependencies

```bash
cd expense-tracker
composer install
npm install
```

#### 3. Setup Environment

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

Edit file `.env` jika diperlukan (default sudah menggunakan SQLite).

#### 4. Generate Application Key

```bash
php artisan key:generate
```

#### 5. Setup Database

Untuk SQLite (default):
```bash
# Windows
type nul > database\database.sqlite

# Linux/Mac
touch database/database.sqlite
```

Untuk MySQL, edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=
```

#### 6. Jalankan Migration

```bash
php artisan migrate
```

#### 7. Build Assets (Opsional untuk Development)

Untuk development:
```bash
npm run dev
```

Untuk production:
```bash
npm run build
```

#### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: http://localhost:8000

## Troubleshooting

### PHP tidak ditemukan

Jika menggunakan XAMPP dan PHP tidak ada di PATH:
```bash
C:\xampp\php\php.exe artisan serve
```

### Error saat migration

Pastikan:
1. File database SQLite sudah dibuat
2. Folder `database` memiliki permission write
3. Koneksi database di `.env` sudah benar

### Error saat npm install

Pastikan Node.js dan NPM sudah terinstall:
```bash
node --version
npm --version
```

### Port 8000 sudah digunakan

Gunakan port lain:
```bash
php artisan serve --port=8080
```

## Fitur Aplikasi

1. **Autentikasi** - Register dan Login
2. **Dashboard** - Total hari ini, grafik 7 hari, transaksi terakhir
3. **Transaksi** - CRUD dengan filter tanggal dan kategori
4. **Laporan** - Total per bulan dengan pie chart per kategori
5. **Profile** - Edit profile dan hapus akun

## Kategori Pengeluaran

- Makan
- Transport
- Rokok
- Belanja
- Hiburan
- Tagihan
- Lainnya

## Teknologi

- Laravel 11
- Laravel Breeze (Authentication)
- Tailwind CSS
- Chart.js
- Alpine.js
- SQLite/MySQL

## Lisensi

MIT License
