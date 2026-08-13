#!/bin/bash

set -e

if [ "$IS_LARAVEL" = "true" ]; then
  if [ "$RAILPACK_SKIP_MIGRATIONS" != "true" ]; then
    echo "Running migrations and seeding database ..."
    php artisan migrate --force
  fi

  php artisan storage:link
  php artisan optimize:clear
  php artisan optimize

  echo "Starting Laravel server ..."
fi

# SIMU: inicializa la base de datos la primera vez (importación idempotente).
# Si falla, la app arranca igual para poder revisar los logs.
if [ -n "$MYSQLHOST" ]; then
  echo "SIMU: inicializando la base de datos ..."
  php /app/db/importar.php || echo "SIMU: AVISO: no se pudo inicializar la base de datos."
fi

# Iniciar el servidor FrankenPHP
exec docker-php-entrypoint --config /Caddyfile --adapter caddyfile 2>&1
