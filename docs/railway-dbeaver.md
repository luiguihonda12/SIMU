# SIMU con Railway y DBeaver

Esta configuración mantiene PHP nativo, PDO y MySQL. Railway aloja la base y DBeaver permite inspeccionarla.

## 1. Crear la base en Railway

1. Crea un proyecto en Railway.
2. Selecciona `New` → `Database` → `MySQL`.
3. Espera a que la base esté disponible.
4. En `Variables`, copia las variables de conexión. Railway expone `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE` y `MYSQL_URL` para sus servicios.
5. Para acceder desde DBeaver, revisa `Settings` → `Networking` → `TCP Proxy`. Usa el dominio y puerto del proxy, no el host interno `*.railway.internal`.

## 2. Importar el esquema

Desde DBeaver, abre una conexión administrativa a Railway y ejecuta:

```text
db/movilidad_mer.sql
```

Después ejecuta `db/railway_app_user.sql` reemplazando las dos contraseñas por valores únicos.

## 3. Crear la conexión en DBeaver

Usa `Database` → `New Database Connection` → `MySQL`. Tú puedes usar `simu_app` y tu amigo `simu_dev_friend`:

```text
Server Host: dominio del TCP Proxy
Port: puerto del TCP Proxy
Database: movilidad_mer
Username: simu_app o simu_dev_friend
Password: contraseña correspondiente
```

Prueba la conexión y guarda las credenciales en DBeaver, no en Git.

## 4. Configurar SIMU localmente

Copia `.env.example` como `.env` y usa los datos de Railway:

```env
SIMU_DB_HOST=dominio-del-tcp-proxy
SIMU_DB_PORT=puerto-del-tcp-proxy
SIMU_DB_NAME=movilidad_mer
SIMU_DB_USER=simu_app
SIMU_DB_PASSWORD=tu_password_privada
```

Luego inicia SIMU:

```bash
source tools/git-bash-env.sh
php -S 127.0.0.1:8000 -t .
```

## Recomendaciones

- No compartas el usuario `root`.
- No subas `.env` al repositorio.
- Entrega a tu amigo solamente el usuario `simu_app`.
- Para producción, limita permisos y activa TLS si el proveedor lo requiere.
- No abras el puerto 3306 de tu computador personal.
