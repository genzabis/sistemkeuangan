# Aplikasi Pencatatan Pengeluaran Harian

Aplikasi Laravel 11 untuk mencatat pengeluaran harian dengan fitur autentikasi, dashboard, grafik, dan laporan.

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite atau MySQL

## Cara Instalasi

### 1. Setup PHP di PATH (Jika menggunakan XAMPP)
Tambahkan PHP ke system PATH:
```
C:\xampp\php
```

Atau jalankan command dengan path lengkap:
```
C:\xampp\php\php.exe artisan serve
```

### 2. Install Dependencies
```bash
cd expense-tracker
composer install
npm install
```

### 3. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Setup Database
Edit file `.env`:
```
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

Buat file database:
```bash
type nul > database\database.sqlite
```

### 5. Jalankan Migration
```bash
php artisan migrate
```

### 6. Build Assets
```bash
npm run build
```

### 7. Jalankan Aplikasi
```bash
php artisan serve
```

Buka browser: http://localhost:8000

## Fitur Aplikasi

### 1. Autentikasi
- Register akun baru
- Login/Logout
- Setiap user memiliki data transaksi sendiri

### 2. Dashboard
- Total pengeluaran hari ini (format Rupiah)
- Grafik bar pengeluaran 7 hari terakhir
- 5 transaksi terakhir

### 3. Transaksi
- Tambah transaksi baru
- Edit transaksi
- Hapus transaksi
- Field: Tanggal, Nominal, Kategori, Catatan

### 4. Riwayat
- Tabel semua transaksi
- Filter berdasarkan tanggal (dari - sampai)
- Filter berdasarkan kategori
- Aksi edit dan hapus per baris

### 5. Laporan
- Total pengeluaran per bulan
- Pie chart pengeluaran per kategori

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
- SQLite

## Struktur Database

### Table: transactions
- id (primary key)
- user_id (foreign key)
- name (string)
- date (date)
- amount (integer)
- category (enum)
- notes (text, nullable)
- timestamps

## Catatan
- Semua nominal dalam format Rupiah (IDR)
- Tanggal dalam format dd/mm/yyyy
- Responsive untuk mobile
- Validasi server-side dan client-side
"# sistemkeuangan" 
