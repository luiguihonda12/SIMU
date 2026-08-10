# SIMU — Sistema Integrado de Movilidad Urbana

Aplicación web de movilidad urbana construida con PHP nativo, MySQL, PDO, HTML, CSS y JavaScript. Actualmente funciona como un MVP para gestionar usuarios y conductores, con la base preparada para vehículos, empresas, rutas, pagos y PQRS.

> Este proyecto no usa frameworks de aplicación. Bootstrap se utiliza únicamente como librería visual.

## Funcionalidades actuales

- Panel principal con contadores reales de la base de datos.
- Registro de usuarios mediante formulario `POST`.
- Validación del lado servidor y del navegador.
- Contraseñas nuevas almacenadas con `password_hash`.
- Protección CSRF mediante sesiones.
- Conexión PDO con consultas preparadas, excepciones y `utf8mb4`.
- Registro y listado de conductores.
- Asignación opcional de busetas.
- Menú lateral responsive.
- Configuración mediante variables de entorno.
- Herramienta de inspección de tablas, relaciones y calidad de datos.
- Prueba HTTP automática de usuarios y conductores.

## Estructura

```text
app/                  Bootstrap de sesión y helpers comunes
controllers/          Procesamiento de usuarios y conductores
css/                  Bootstrap local y estilos SIMU
db/                   Esquema, datos iniciales y usuario de aplicación
docs/                 Guía de Railway y DBeaver
img/                  Logo
models/               Configuración y conexión PDO
tests/                Pruebas HTTP de humo
tools/                Scripts de Git Bash, MySQL e inspección
views/                Paneles y componentes visuales
index.php             Punto de entrada y router seguro
```

## Requisitos

- Windows 10/11.
- PHP 8.4+ con `pdo_mysql` y `mysqli`.
- MySQL 8+ o MySQL administrado en Railway.
- Composer opcional para futuras dependencias.
- Node.js/npm para instalar Railway CLI.
- Git.
- DBeaver Community para revisar la base visualmente.

## Instalación local

Desde PowerShell como administrador, si las herramientas no están instaladas:

```powershell
winget install --id PHP.PHP.8.4 --exact
winget install --id Oracle.MySQL --exact
winget install --id DBeaver.DBeaver.Community --exact
npm install -g @railway/cli
```

En Git Bash, cargar PHP y las herramientas:

```bash
source tools/git-bash-env.sh
php -v
railway --version
```

## Configuración

Copia el ejemplo:

```bash
cp .env.example .env
```

Edita `.env` con tus datos. `.env` está excluido de Git y nunca debe compartirse.

Para una base local:

```env
SIMU_DB_HOST=127.0.0.1
SIMU_DB_PORT=3306
SIMU_DB_NAME=movilidad_mer
SIMU_DB_USER=root
SIMU_DB_PASSWORD=tu_password_local
```

Para Railway usando el túnel local, el host será `127.0.0.1` y el puerto será el que imprima `railway connect`.

## Railway

El proyecto utiliza una base MySQL en Railway. El flujo recomendado es:

```bash
railway login
railway link --project ffb17429-cc3f-472a-ac21-7906b0fa334e --environment production --service MySQL
railway status
railway connect MySQL --tunnel-only
```

El último comando mantiene un túnel SSH abierto y muestra host, puerto y credenciales para DBeaver. No uses `mysql.railway.internal` desde tu computador local; ese host es interno de Railway.

La guía detallada está en [docs/railway-dbeaver.md](docs/railway-dbeaver.md) y en [INSTALATIONMateus.md](INSTALATIONMateus.md).

## DBeaver

Con el túnel abierto, crea una conexión MySQL con los datos que imprime Railway. Normalmente:

```text
Host: 127.0.0.1
Port: puerto local del túnel
Database: railway
User: root
Password: contraseña actual de Railway
```

Desde DBeaver ejecuta primero `db/movilidad_mer.sql`. Después ejecuta `db/railway_app_user.sql` para crear usuarios de aplicación separados de `root`.


## Autenticación y permisos

La aplicación usa sesiones PHP y tres roles: administrador (crear, consultar y eliminar), operador (crear y consultar) y solo lectura (consultar). Las contraseñas nuevas se guardan con `password_hash`; las contraseñas heredadas pueden migrarse una sola vez:

```bash
php tools/hash-legacy-passwords.php --apply
```

## Ejecutar la aplicación

En Git Bash:

```bash
./tools/start-simu-git-bash.sh
```

Abre:

- Panel: <http://127.0.0.1:8000/index.php?pg=inicio>
- Usuarios: <http://127.0.0.1:8000/index.php?pg=creaUsu>
- Conductores: <http://127.0.0.1:8000/index.php?pg=conductores>

## Pruebas y revisión

Sintaxis PHP:

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
```

Prueba HTTP, CSRF, registro y hash:

```bash
php tests/http_smoke.php
```

Inspección de la base:

```bash
php tools/inspect-db.php
```

Si la aplicación usa autenticación, primero inicia sesión y después prueba los formularios según el rol de la cuenta.

## Seguridad

- No subir `.env`.
- No compartir la contraseña de `root`.
- Usar `simu_app` para la aplicación y otro usuario para cada colaborador.
- Cambiar cualquier contraseña que haya sido publicada.
- No exponer el puerto 3306 directamente del computador.
- Mantener el túnel Railway abierto solamente mientras se trabaja.

## Rama actual

Los cambios documentados fueron desarrollados en:

```text
feature/new_changes_katt
```

Commit principal:

```text
ad3f589 Implement functional SIMU MVP and Railway tooling
```
