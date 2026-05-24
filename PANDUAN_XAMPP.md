# Panduan Instalasi Sistem Keuangan di XAMPP

## Lokasi Aplikasi
📁 `D:\xampp\htdocs\sistemkeuangan`

## Langkah Instalasi

### 1. Pastikan XAMPP Sudah Terinstall
- PHP >= 8.2
- MySQL (opsional, bisa pakai SQLite)
- Apache Web Server

### 2. Buka Command Prompt / Terminal
```bash
cd D:\xampp\htdocs\sistemkeuangan
```

### 3. Install Dependencies

#### A. Install Composer Dependencies
```bash
D:\xampp\php\php.exe D:\xampp\composer.phar install
```

Atau jika Composer sudah di PATH:
```bash
composer install
```

#### B. Install NPM Dependencies
```bash
npm install
```

### 4. Setup Environment

```bash
copy .env.example .env
```

### 5. Generate Application Key

```bash
D:\xampp\php\php.exe artisan key:generate
```

Atau:
```bash
php artisan key:generate
```

### 6. Setup Database

#### Opsi 1: SQLite (Recommended - Lebih Mudah)
```bash
type nul > database\database.sqlite
```

File `.env` sudah dikonfigurasi untuk SQLite secara default.

#### Opsi 2: MySQL
1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Buat database baru: `sistemkeuangan`
3. Edit file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistemkeuangan
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

### 8. Build Assets

#### Development (dengan hot reload):
```bash
npm run dev
```

#### Production (untuk deployment):
```bash
npm run build
```

### 9. Jalankan Aplikasi

#### Opsi 1: Menggunakan Laravel Development Server
```bash
php artisan serve
```
Buka: http://localhost:8000

#### Opsi 2: Menggunakan Apache XAMPP
1. Pastikan Apache sudah running di XAMPP Control Panel
2. Buka: http://localhost/sistemkeuangan/public

**PENTING:** Untuk menggunakan Apache, URL root harus mengarah ke folder `public`.

### 10. Konfigurasi Apache (Opsional - Untuk URL Lebih Bersih)

Buat file `.htaccess` di `D:\xampp\htdocs\sistemkeuangan`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Atau edit `httpd-vhosts.conf` untuk virtual host:

```apache
<VirtualHost *:80>
    DocumentRoot "D:/xampp/htdocs/sistemkeuangan/public"
    ServerName sistemkeuangan.test
    
    <Directory "D:/xampp/htdocs/sistemkeuangan/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Tambahkan di `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 sistemkeuangan.test
```

Restart Apache, lalu akses: http://sistemkeuangan.test

## Troubleshooting

### Error: "Class not found" atau "Composer autoload"
```bash
composer dump-autoload
```

### Error: Permission denied pada storage
```bash
icacls "D:\xampp\htdocs\sistemkeuangan\storage" /grant Everyone:(OI)(CI)F /T
icacls "D:\xampp\htdocs\sistemkeuangan\bootstrap\cache" /grant Everyone:(OI)(CI)F /T
```

### Error: npm install gagal
Pastikan Node.js sudah terinstall:
```bash
node --version
npm --version
```

### Port 8000 sudah digunakan
```bash
php artisan serve --port=8080
```

### Apache tidak bisa akses folder
Pastikan folder `public` memiliki permission read untuk Apache.

## Fitur Aplikasi

1. **Register & Login** - Autentikasi user
2. **Dashboard** - Total hari ini, grafik 7 hari, transaksi terakhir
3. **Transaksi** - CRUD dengan filter tanggal & kategori
4. **Laporan** - Total per bulan dengan pie chart
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
- Laravel Breeze
- Tailwind CSS
- Chart.js
- SQLite/MySQL

## URL Akses

### Development Server:
```
http://localhost:8000
```

### Apache XAMPP:
```
http://localhost/sistemkeuangan/public
```

### Virtual Host (jika dikonfigurasi):
```
http://sistemkeuangan.test
```

## Catatan Penting

1. Pastikan XAMPP Apache dan MySQL (jika pakai MySQL) sudah running
2. Untuk development, gunakan `npm run dev` agar Tailwind CSS ter-compile
3. Untuk production, gunakan `npm run build`
4. Database SQLite akan tersimpan di `database/database.sqlite`
5. Log aplikasi ada di `storage/logs/laravel.log`

## Support

Jika ada masalah, cek:
- File `.env` sudah benar
- Database sudah dibuat dan migration sudah dijalankan
- Folder `storage` dan `bootstrap/cache` memiliki permission write
- Apache mod_rewrite sudah enabled (untuk .htaccess)

Selamat menggunakan Sistem Keuangan! 🎉
