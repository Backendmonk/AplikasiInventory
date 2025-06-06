@echo off
REM Jalankan Laragon
start "" "C:\laragon\laragon.exe"

REM Tunggu beberapa detik agar Laragon selesai loading
timeout /t 5 >nul

REM Cek apakah virtual host Laravel sudah aktif
setlocal enabledelayedexpansion
set HOST=http://aplikasiinventory.wn
set MAX_WAIT=15
set COUNT=0

:WAIT_LOOP
curl -s -o nul -w "%%{http_code}" !HOST! | findstr /r "^200$" >nul
if !errorlevel! == 0 (
    goto SERVER_READY
) else (
    set /a COUNT+=1
    if !COUNT! GEQ %MAX_WAIT% (
        echo Virtual Host tidak merespon setelah %MAX_WAIT% detik. Lanjut membuka browser...
        goto SERVER_READY
    )
    timeout /t 1 >nul
    goto WAIT_LOOP
)

:SERVER_READY
start "" !HOST!
