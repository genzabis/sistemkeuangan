@echo off
echo ========================================
echo SETUP CEPAT - Sistem Keuangan Laravel
echo ========================================
echo.

echo [INFO] Mengaktifkan PHP Zip Extension...
echo.

REM Backup php.ini
copy D:\xampp\php\php.ini D:\xampp\php\php.ini.backup >nul 2>&1

REM Aktifkan zip extension
powershell -Command "(Get-Content D:\xampp\php\php.ini) -replace ';extension=zip', 'extension=zip' | Set-Content D:\xampp\php\php.ini"

echo [OK] Zip extension diaktifkan!
echo.

echo [1/5] Install Composer dependencies...
D:\xampp\php\php.exe C:\ProgramData\ComposerSetup\bin\composer.phar install --no-interaction
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Composer install gagal!
    pause
    exit /b 1
)
echo.

echo [2/5] Generate application key...
D:\xampp\php\php.exe artisan key:generate
echo.

echo [3/5] Run migrations...
D:\xampp\php\php.exe artisan migrate --force
echo.

echo [4/5] Build assets...
call npm run build
echo.

echo ========================================
echo Setup Selesai!
echo ========================================
echo.
echo Untuk menjalankan aplikasi:
echo   D:\xampp\php\php.exe artisan serve
echo.
echo Kemudian buka browser: http://localhost:8000
echo.
pause
