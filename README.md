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

## Notas

- Los datos de sesión se almacenan con `$_SESSION` (nombre, correo e id de usuario).
- El módulo de conductores usa datos de ejemplo definidos en los modelos; aún no está conectado a MySQL.
- El envío de correos (verificación y recuperación) usa PHPMailer: instala el paquete en `vendor/` (por ejemplo con Composer) y configura las credenciales SMTP en `controllers/ccorreo.php`. Sin esto, los controladores funcionan en modo API sin enviar correos reales.
