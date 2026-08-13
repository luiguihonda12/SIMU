# SIMU - Sistema Integrado de Movilidad Urbana

Aplicación web para la gestión de la movilidad urbana de un municipio. Permite la administración de usuarios, conductores, rutas, paraderos y el seguimiento de PQRS de los ciudadanos, bajo una arquitectura **MVC (Modelo - Vista - Controlador)**.

## Tecnologías

- **Backend:** PHP 7/8 (nativo, sin frameworks)
- **Base de datos:** MySQL (vía PDO)
- **Frontend:** Bootstrap 5, Font Awesome 6, Bootstrap Icons
- **JavaScript:** jQuery 3.7, DataTables 2.0
- **Tipografía:** Inter (Google Fonts)

## Estructura del proyecto

```
SIMU/
├── index.php              # Controlador frontal: carga las vistas por ?pg=
├── css/                   # Hojas de estilo (style.css, menu.css, bootstrap.min.css)
├── js/                    # Scripts (code.js: menú/modo oscuro, valida.js: formularios)
├── views/                 # Vistas (v*.php)
│   ├── header.php         # Encabezado institucional
│   ├── vmen.php           # Menú lateral
│   ├── footer.php         # Pie de página
│   ├── dashboard.php      # Panel de administración
│   ├── creaUsu.php        # Crear cuenta (paso 1) y éxito (paso 2)
│   ├── vlogin.php         # Iniciar sesión
│   ├── vregistro.php      # Registro guiado (paso 1)
│   ├── vcoder.php         # Código de verificación
│   ├── volvid.php         # Recuperar contraseña
│   ├── vreset.php         # Nueva contraseña
│   ├── vcondu.php         # Conductor
│   ├── vdascon.php        # Dashboard Conductor
│   ├── vedicon.php        # Editar Conductor
│   ├── vgpqrs.php         # Gestión PQRS (listado y resumen)
│   ├── vdpqrs.php         # Detalle PQRS (gestión de estado, prioridad y respuesta)
│   └── vnpqrs.php         # Registrar nueva PQRS
├── controllers/           # Controladores (c*.php)
├── models/                # Modelos (m*.php) + conexion.php + config.php
└── db/
    └── movilidad_mer.sql  # Respaldo de la base de datos
```

Cada módulo sigue el patrón:

```
views/    vModulo.php     ->  incluye  controllers/cModulo.php
controllers/cModulo.php   ->  utiliza  models/mModulo.php
models/   mModulo.php     ->  extiende Conexion (PDO) y consulta la BD
```

`index.php` es el único punto de entrada. Las páginas permitidas están definidas en el arreglo `$allowedPages`, por ejemplo:

```php
// Ejemplo de página registrada en index.php
'gestionPQRS' => 'views/vgpqrs.php'
```

## Requisitos

- [XAMPP](https://www.apachefriends.org/) (Apache + PHP 7.4 o superior + MySQL/MariaDB)

## Instalación

1. Clona o copia el repositorio en la carpeta raíz de Apache:

   ```
   C:\xampp\htdocs\SIMU
   ```

2. Inicia Apache y MySQL desde el panel de XAMPP.

3. Crea la base de datos e importa el respaldo:

   - Abre **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Crea una base de datos llamada `movilidad_mer` (utf8mb4).
   - Importa el archivo `db/movilidad_mer.sql`.

4. Accede a la aplicación:

   ```
   http://localhost/SIMU/index.php
   ```

## Configuración

Los datos de conexión a la base de datos se encuentran en `models/config.php`:

```php
<?php
$host = "localhost";
$db   = "movilidad_mer";
$user = "root";
$pass = "";
?>
```

## Usuarios de prueba

| Rol          | Correo            | Contraseña |
|--------------|-------------------|------------|
| Administrador| luis@email.com    | 123456     |
| Conductor    | carlos@email.com  | 123456     |
| Cliente      | ana@email.com     | 123456     |

También puedes crear un nuevo usuario desde **Crear Cuenta** (`?pg=creaUsu`), donde se asigna el rol (Administrador, Conductor o Cliente).

## Módulos del sistema

- **Crear cuenta:** registro de usuarios con selección de rol y medidor de seguridad de contraseña.
- **Iniciar sesión / Recuperar contraseña:** autenticación con `password_hash`/`password_verify` y flujo de recuperación (olvido, verificación, nueva contraseña).
- **Panel de administración:** resumen de usuarios y estadísticas.
- **Conductores:** consulta, edición y dashboard del conductor (actualmente con datos de ejemplo).
- **PQRS:** listado con resumen por estado, detalle con gestión de estado/prioridad/responsable/respuesta, y registro de nuevas solicitudes. Los códigos se generan automáticamente (`PQRS-00027`, ...).

## Despliegue en Railway

Railway detecta el proyecto como una app PHP (por `index.php` en la raíz) y lo despliega con **FrankenPHP** (PHP 8.4). Los cambios necesarios ya están incluidos en el repositorio:

- `models/config.php` y `models/conexion.php` leen las variables de entorno de Railway (`MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`) y usan los valores locales como respaldo.
- `composer.json` garantiza la instalación de la extensión `pdo_mysql`.
- `db/importar.php` importa `db/movilidad_mer.sql` de forma idempotente (solo si la BD está vacía).
- `start-container.sh` ejecuta la importación al arrancar y luego inicia FrankenPHP.
- `controllers/ccorreo.php` permite sobrescribir el correo SMTP con variables de entorno (`SIMU_CORREO_USUARIO`, `SIMU_CORREO_CLAVE`, `SIMU_CORREO_NOMBRE`).

### Pasos

1. Sube el repositorio a GitHub (ya existe `origin` configurado).
2. En [Railway](https://railway.app), crea un proyecto nuevo y usa **Deploy from GitHub repo**, seleccionando `SIMU`.
3. Añade el servicio **MySQL** al mismo proyecto (Railway lo crea automáticamente).
4. **Conecta** el servicio MySQL al servicio de la app (tab *Variables* o *Connect*). Railway inyecta `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD` y `MYSQLDATABASE` automáticamente.
5. Railway construye y despliega. Al primer arranque, `start-container.sh` importa la base de datos.
6. Genera un dominio público: pestaña **Settings → Networking → Generate Domain**.

La aplicación queda disponible en `https://<tu-dominio>.up.railway.app/index.php` (o directamente en `/`).

> **Nota sobre correos:** Gmail exige una contraseña de aplicación. Si quieres usar otro correo, define las variables `SIMU_CORREO_USUARIO` y `SIMU_CORREO_CLAVE` en las variables de entorno del servicio.

## Notas

- Los datos de sesión se almacenan con `$_SESSION` (nombre, correo e id de usuario).
- El módulo de conductores usa datos de ejemplo definidos en los modelos; aún no está conectado a MySQL.
- El envío de correos (verificación y recuperación) usa PHPMailer: instala el paquete en `vendor/` (por ejemplo con Composer) y configura las credenciales SMTP en `controllers/ccorreo.php`. Sin esto, los controladores funcionan en modo API sin enviar correos reales.
