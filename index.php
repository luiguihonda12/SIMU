<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logueado = isset($_SESSION['id_usuario']);
$idRol    = (int)($_SESSION['id_rol'] ?? 0);

$pg = $_GET['pg'] ?? 'login';

// Mapeo seguro de páginas permitidas y sus archivos
$allowedPages = [
    'dashboard'          => 'views/dashboard.php',
    'creaUsu'            => 'views/creaUsu.php',
    'crearUsuario'       => 'views/creaUsu.php',
    'vmen'               => 'views/vmen.php',
    // Autenticación y recuperación de cuenta
    'login'              => 'views/vlogin.php',
    'vlogin'             => 'views/vlogin.php',
    'registro'           => 'views/vregistro.php',
    'vregistro'          => 'views/vregistro.php',
    'verificacion'       => 'views/vcoder.php',
    'vcoder'             => 'views/vcoder.php',
    'codigoVerificacion' => 'views/vcoder.php',
    'olvido'             => 'views/volvid.php',
    'volvid'             => 'views/volvid.php',
    'olvidoContrasena'   => 'views/volvid.php',
    'reset'              => 'views/vreset.php',
    'vreset'             => 'views/vreset.php',
    'confirmacionFinal'  => 'views/vreset.php',
    // Perfil de usuario
    'perfilUsuario'      => 'views/vperfilusu.php',
    'editarUsuario'      => 'views/veditarusu.php',
    'vistaUsuario'       => 'views/vvistausu.php',
    // Menú inicial cliente
    'menuCliente'        => 'views/vmenucli.php',
    // Conductor
    'conductor'          => 'views/vcondu.php',
    'dashboardConductor' => 'views/vdascon.php',
    'editarConductor'    => 'views/vedicon.php',
    // Busetas y Vehículos
    'registrarBusetas'       => 'views/vregisb.php',
    'regisb'                 => 'views/vregisb.php',
    'listadoBusetas'         => 'views/vlistb.php',
    'listb'                  => 'views/vlistb.php',
    'editarBusetas'          => 'views/vedib.php',
    'edib'                   => 'views/vedib.php',
    'cambiarEstadoBusetas'   => 'views/vcameb.php',
    'cameb'                  => 'views/vcameb.php',
    'reporteBusetas'         => 'views/vreporb.php',
    'reporb'                 => 'views/vreporb.php',
    'gestionRoles'           => 'views/vgesr.php',
    'gesr'                   => 'views/vgesr.php',
    // Rutas y Horarios
    'registrarParaderos' => 'views/vrepar.php',
    'edicionRuta'        => 'views/vmodru.php',
    'listadoRutas'       => 'views/vlisru.php',
    'registroRutas'      => 'views/vregru.php',
    // PQRS
    'detallePQRS'        => 'views/vdpqrs.php',
    'gestionPQRS'        => 'views/vgpqrs.php',
    'nuevaPQRS'          => 'views/vnpqrs.php'
];

/* ============================================================
   CONTROL DE ACCESO POR ROL
   - Públicas: no requieren sesión
   - 1 Administrador: acceso total
   - 2 Conductor: módulos de conductor y su perfil
   - 3 Cliente: menú inicial cliente y módulos de cliente
   ============================================================ */

$paginasPublicas = [
    'login', 'vlogin',
    'registro', 'vregistro',
    'verificacion', 'vcoder', 'codigoVerificacion',
    'olvido', 'volvid', 'olvidoContrasena',
    'reset', 'vreset', 'confirmacionFinal'
];

$paginasConductor = [
    'conductor',
    'dashboardConductor',
    'perfilUsuario',
    'vistaUsuario',
    'editarUsuario'
];

$paginasCliente = [
    'menuCliente',
    'consultarRutas',
    'paraderos',
    'horarios',
    'historialViajes',
    'nuevaPQRS',
    'perfilUsuario',
    'vistaUsuario',
    'editarUsuario'
];

function paginaPermitida($pg, $idRol, $paginasPublicas, $paginasConductor, $paginasCliente)
{
    // Páginas públicas (autenticación) siempre accesibles
    if (in_array($pg, $paginasPublicas)) {
        return true;
    }

    // Sin sesión no se accede a páginas privadas
    if (!isset($_SESSION['id_usuario'])) {
        return false;
    }

    // Administrador: acceso total
    if ($idRol === 1) {
        return true;
    }

    // Conductor
    if ($idRol === 2) {
        return in_array($pg, $paginasConductor);
    }

    // Cliente
    if ($idRol === 3) {
        return in_array($pg, $paginasCliente);
    }

    return false;
}

if (!paginaPermitida($pg, $idRol, $paginasPublicas, $paginasConductor, $paginasCliente)) {
    if (!$logueado) {
        header("Location: index.php?pg=login&error=acceso_no_autorizado");
        exit();
    }

    // Usuario con sesión pero sin permiso: a su página de inicio por rol
    if ($idRol === 2) {
        header("Location: index.php?pg=dashboardConductor");
    } elseif ($idRol === 3) {
        header("Location: index.php?pg=menuCliente");
    } else {
        header("Location: index.php?pg=dashboard");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMU - Sistema Integrado de Movilidad Urbana</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tipografía Inter de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

    <!-- Hojas de Estilo del Menú y General -->
    <link rel="stylesheet" type="text/css" href="css/menu.css?v=1">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=3">

    <!-- Aplica el modo oscuro guardado antes de renderizar (evita parpadeo) -->
    <script>
        if (localStorage.getItem('simu-theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>
<body>

    <!-- Encabezado Institucional -->
    <?php include 'views/header.php'; ?>

    <!-- Capa Oscura para cerrar el menú en dispositivos móviles -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Layout Principal: Menú Vertical a la Izquierda, Contenido a la Derecha -->
    <div class="app-layout">
        
        <!-- Menú Vertical en el Lado Izquierdo (solo con sesión activa) -->
        <?php if ($logueado) { include 'views/vmen.php'; } ?>

        <!-- Área Principal de Contenido (Dinámica) -->
        <main class="main-content">
            <?php
                if (array_key_exists($pg, $allowedPages) && file_exists($allowedPages[$pg])) {
                    include $allowedPages[$pg];
                } elseif (file_exists("views/" . $pg . ".php")) {
                    include "views/" . $pg . ".php";
                } else {
                    // Vista por defecto para módulos futuros en desarrollo
                    $moduloNombre = ucfirst($pg);
                    ?>
                    <div class="registration-container text-center py-5">
                        <div class="mb-4 text-warning mod-dev-icon">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <h2 class="h3 fw-bold text-dark mb-2">Módulo "<?=htmlspecialchars($moduloNombre);?>" en Desarrollo</h2>
                        <p class="text-muted mb-4">
                            Este módulo estará disponible próximamente en el Sistema Integrado de Movilidad Urbana (SIMU).
                        </p>
                    <?php
                        $paginaVolver = 'login';

                        if ($idRol === 1) {
                            $paginaVolver = 'dashboard';
                        } elseif ($idRol === 2) {
                            $paginaVolver = 'dashboardConductor';
                        } elseif ($idRol === 3) {
                            $paginaVolver = 'menuCliente';
                        }
                    ?>
                    <a href="index.php?pg=<?= $paginaVolver; ?>" class="btn btn-primary mod-dev-btn">
                        <i class="fas fa-home me-2"></i>Volver al inicio
                    </a>
                    </div>
                    <?php
                }
            ?>
        </main>

    </div>

    <!-- Pie de Página Institucional -->
    <?php include 'views/footer.php'; ?>

    <!-- Scripts Bootstrap y Validaciones SIMU -->
    <script src="js/code.js?v=3"></script>
    <script src="js/valida.js?v=3"></script>
</body>
</html>
