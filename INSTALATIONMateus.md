# INSTALATIONMateus — Instalación y pruebas de SIMU

Guía práctica para instalar el entorno en Windows, conectar Railway, usar DBeaver y probar SIMU desde Git Bash.

## 1. Abrir Git Bash en el proyecto

```bash
cd /c/Users/Arroz/Desktop/SIMUMateus/SIMU
git checkout feature/new_changes_katt
```

## 2. Instalar herramientas

PowerShell:

```powershell
winget install --id PHP.PHP.8.4 --exact --accept-source-agreements --accept-package-agreements
winget install --id Oracle.MySQL --exact --accept-source-agreements --accept-package-agreements
winget install --id DBeaver.DBeaver.Community --exact --accept-source-agreements --accept-package-agreements
winget install --id Oracle.MySQLShell --exact --accept-source-agreements --accept-package-agreements
npm install -g @railway/cli
```

Comprobar:

```bash
source tools/git-bash-env.sh
php -v
node --version
npm --version
railway --version
```

Si Git Bash dice `php: command not found`, ejecutar:

```bash
source tools/git-bash-env.sh
```

DBeaver puede abrirse desde Git Bash con:

```bash
/c/Users/Arroz/AppData/Local/DBeaver/dbeaver.exe
```

## 3. Iniciar sesión en Railway

```bash
railway login
railway whoami
railway project list
```

El proyecto SIMU es:

```text
Proyecto: amused-manifestation
Project ID: ffb17429-cc3f-472a-ac21-7906b0fa334e
Environment: production
Service: MySQL
```

Enlazarlo al proyecto local:

```bash
railway link \
  --project ffb17429-cc3f-472a-ac21-7906b0fa334e \
  --environment production \
  --service MySQL
```

Comprobar estado:

```bash
railway status
```

## 4. Abrir el túnel para DBeaver

```bash
railway connect MySQL --tunnel-only
```

No cerrar esta terminal. Railway mostrará un puerto local, por ejemplo `60831`.

La conexión de DBeaver será:

```text
Host: 127.0.0.1
Port: puerto mostrado por Railway
Database: railway
User: root
Password: MYSQL_ROOT_PASSWORD de Railway
```

No utilizar:

```text
mysql.railway.internal
```

Ese dominio funciona solamente entre servicios internos de Railway.

## 5. Importar la estructura de SIMU desde DBeaver

1. Abrir DBeaver.
2. Crear una conexión MySQL.
3. Usar `127.0.0.1` y el puerto del túnel.
4. Pulsar `Test Connection`.
5. Abrir la conexión `railway`.
6. Clic derecho sobre la conexión → `SQL Editor` → `Script SQL`.
7. Abrir:

```text
db/movilidad_mer.sql
```

Si el archivo aparece como `<none>`, asociarlo con `Ctrl + 9` y seleccionar la conexión `railway`.

Ejecutar el script completo con:

```text
Alt + X
```

Actualizar `Databases` con `F5`.

## 6. Comprobar la base

Ejecutar una consulta por vez:

```sql
SHOW DATABASES;
```

```sql
USE movilidad_mer;
```

```sql
SHOW TABLES;
```

También:

```sql
SELECT * FROM movilidad_mer.usuario;
SELECT * FROM movilidad_mer.conductor;
```

La base debe contener, entre otras, estas tablas:

```text
buseta
conductor
conductor_ruta
empresa
empresa_ruta
pago
paradero
pqrs
rol
rol_empresa
ruta
usuario
```

## 7. Crear usuarios de aplicación

Desde DBeaver, conectado como administrador, abrir y ejecutar:

```text
db/railway_app_user.sql
```

Antes de ejecutar, cambiar los valores:

```sql
CAMBIA_ESTA_PASSWORD
CAMBIA_PASSWORD_DE_TU_AMIGO
```

Se crean:

```text
simu_app
simu_dev_friend
```

No usar `root` dentro de la aplicación.

## 8. Configurar SIMU contra Railway

El túnel debe seguir abierto. En otra terminal Git Bash:

```bash
source tools/git-bash-env.sh
export SIMU_DB_HOST=127.0.0.1
export SIMU_DB_PORT=60831
export SIMU_DB_NAME=movilidad_mer
export SIMU_DB_USER=simu_app
export SIMU_DB_PASSWORD='password-de-simu_app'
```

Cambiar `60831` por el puerto real que muestre Railway.

## 9. Iniciar SIMU

```bash
php -S 127.0.0.1:8000 -t .
```

Páginas:

```text
http://127.0.0.1:8000/index.php?pg=inicio
http://127.0.0.1:8000/index.php?pg=creaUsu
http://127.0.0.1:8000/index.php?pg=conductores
```

## 10. Probar que guarda datos

Registrar un usuario desde:

```text
http://127.0.0.1:8000/index.php?pg=creaUsu
```

Luego comprobar desde DBeaver:

```sql
SELECT id_usuario, nombre, correo
FROM movilidad_mer.usuario
ORDER BY id_usuario DESC;
```

Registrar un conductor desde:

```text
http://127.0.0.1:8000/index.php?pg=conductores
```

Comprobar:

```sql
SELECT id_conductor, nombre, licencia, telefono
FROM movilidad_mer.conductor
ORDER BY id_conductor DESC;
```

## 11. Pruebas automáticas

Sintaxis PHP:

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
```

Prueba HTTP de registro, CSRF y hash:

```bash
php tests/http_smoke.php
```

Inspección de tablas y relaciones:

```bash
php tools/inspect-db.php
```

## 12. Problemas frecuentes

### `php: command not found`

```bash
source tools/git-bash-env.sh
```

### `No active connection` en DBeaver

El archivo SQL no está asociado a Railway. Seleccionar la pestaña del archivo y presionar `Ctrl + 9`; elegir `railway 127.0.0.1:PUERTO`.

### `Project not found` en Railway

Verificar el ID exacto y volver a iniciar sesión:

```bash
railway logout
railway login
railway project list
```

### El túnel deja de funcionar

Ejecutar nuevamente:

```bash
railway connect MySQL --tunnel-only
```

El puerto local puede cambiar.

### La consola web de Railway da error con varias consultas

Ejecutar cada consulta por separado. No pegar juntas:

```sql
SHOW DATABASES;
USE movilidad_mer;
SHOW TABLES;
```

## Seguridad

- Nunca subir `.env`.
- Nunca compartir la contraseña de `root`.
- Cambiar las contraseñas que hayan sido expuestas.
- No publicar el puerto 3306 del computador.
- Usar usuarios limitados para SIMU y para colaboradores.
