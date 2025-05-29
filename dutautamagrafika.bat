@echo off
REM Jalankan Laragon
start "" "C:\laragon\laragon.exe"

REM Pindah ke folder project
cd /d "C:\laragon\www\AplikasiInventory"

REM Jalankan server Laravel tanpa jendela (background)
start "" /b php artisan serve >nul 2>&1

REM Tunggu sampai server Laravel ready dengan cek HTTP status
setlocal enabledelayedexpansion
set MAX_WAIT=15
set COUNT=0
:WAIT_LOOP
REM Cek HTTP response code di localhost:8000, hasil disimpan di ERRORLEVEL
curl -s -o nul -w "%%{http_code}" http://127.0.0.1:8000 | findstr /r "^200$" >nul
if %errorlevel%==0 (
    goto SERVER_READY
) else (
    set /a COUNT+=1
    if !COUNT! GEQ %MAX_WAIT% (
        echo Server tidak merespon setelah %MAX_WAIT% detik. Lanjut membuka browser...
        goto SERVER_READY
    )
    timeout /t 1 >nul
    goto WAIT_LOOP
)

:SERVER_READY
REM Buka browser ke alamat Laravel
start "" http://127.0.0.1:8000
