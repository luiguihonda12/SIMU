#!/usr/bin/env bash
set -e

MYSQL_EXE='C:\\Program Files\\MySQL\\MySQL Server 8.4\\bin\\mysqld.exe'
DATA_DIR='C:\\ProgramData\\SIMU-MySQL\\data'
BASE_DIR='C:\\Program Files\\MySQL\\MySQL Server 8.4'

powershell.exe -NoProfile -ExecutionPolicy Bypass -Command "Start-Process -FilePath '$MYSQL_EXE' -ArgumentList @('--no-defaults','--datadir=\"$DATA_DIR\"','--basedir=\"$BASE_DIR\"','--port=3306','--bind-address=127.0.0.1') -WindowStyle Hidden"
echo 'MySQL iniciado en 127.0.0.1:3306'
