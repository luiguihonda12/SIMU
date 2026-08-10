#!/usr/bin/env bash
set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
source "$SCRIPT_DIR/git-bash-env.sh"
cd "$PROJECT_DIR"

if [[ ! -f .env ]]; then
    echo 'Falta el archivo .env. Cópialo desde .env.example y completa la contraseña de Railway.' >&2
    exit 1
fi

# Exporta las variables locales para PHP y las herramientas de diagnóstico.
set -a
source .env
set +a

: "${SIMU_DB_HOST:?Falta SIMU_DB_HOST en .env}"
: "${SIMU_DB_PORT:?Falta SIMU_DB_PORT en .env}"
: "${SIMU_DB_NAME:?Falta SIMU_DB_NAME en .env}"
: "${SIMU_DB_USER:?Falta SIMU_DB_USER en .env}"
: "${SIMU_DB_PASSWORD:?Falta SIMU_DB_PASSWORD en .env}"

echo 'Comprobando conexión con la base de datos...'
php tools/check-db.php

echo 'SIMU disponible en http://127.0.0.1:8000/index.php?pg=inicio'
php -S 127.0.0.1:8000 -t .
