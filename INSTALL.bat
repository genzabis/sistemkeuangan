@echo off
echo ========================================
echo Expense Tracker - Installation Script
echo ========================================
echo.

REM Check if PHP is available
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] PHP tidak ditemukan di PATH!
    echo.
    echo Jika menggunakan XAMPP, tambahkan PHP ke PATH atau jalankan:
    echo C:\xampp\php\php.exe artisan serve
    echo.
    pause
    exit /b 1
)

echo [1/7] Memeriksa PHP...
php --version
echo.

echo [2/7] Install Composer dependencies...
call composer install
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Composer install gagal!
    pause
    exit /b 1
)
echo.

echo [3/7] Install NPM dependencies...
call npm install
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] NPM install gagal!
    pause
    exit /b 1
)
echo.

echo [4/7] Setup environment file...
if not exist .env (
    copy .env.example .env
    echo File .env berhasil dibuat
) else (
    echo File .env sudah ada
)
echo.

echo [5/7] Generate application key...
php artisan key:generate
echo.

echo [6/7] Setup database...
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo Database SQLite berhasil dibuat
) else (
    echo Database SQLite sudah ada
)
echo.

echo [7/7] Jalankan migrations...
php artisan migrate
if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Migration gagal. Pastikan database sudah dikonfigurasi dengan benar.
)
echo.

echo ========================================
echo Installation Complete!
echo ========================================
echo.
echo Untuk menjalankan aplikasi:
echo   php artisan serve
echo.
echo Kemudian buka browser: http://localhost:8000
echo.
echo Untuk build assets (production):
echo   npm run build
echo.
pause
