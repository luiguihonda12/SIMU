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
    <link rel="stylesheet" type="text/css" href="css/style.css?v=2">

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
        
        <!-- Menú Vertical en el Lado Izquierdo -->
        <?php include 'views/vmen.php'; ?>

        <!-- Área Principal de Contenido (Dinámica) -->
        <main class="main-content">
            <?php
                $pg = $_GET['pg'] ?? 'creaUsu';

                // Mapeo seguro de páginas permitidas y sus archivos
                $allowedPages = [
                    'dashboard' => 'views/dashboard.php',
                    'creaUsu'   => 'views/creaUsu.php',
                    'crearUsuario' => 'views/creaUsu.php',
                    'vmen'      => 'views/vmen.php',
                    // Conductor
                    'conductor' => 'views/vcondu.php',
                    'dashboardConductor' => 'views/vdascon.php',
                    'editarConductor' => 'views/vedicon.php',
                    // PQRS
                    'detallePQRS' => 'views/vdpqrs.php',
                    'gestionPQRS' => 'views/vgpqrs.php'
                ];

                if (array_key_exists($pg, $allowedPages) && file_exists($allowedPages[$pg])) {
                    include $allowedPages[$pg];
                } elseif (file_exists("views/" . $pg . ".php")) {
                    include "views/" . $pg . ".php";
                } else {
                    // Vista por defecto para módulos futuros en desarrollo
                    $moduloNombre = ucfirst($pg);
                    ?>
                    <div class="registration-container text-center py-5">
                        <div class="mb-4 text-warning" style="font-size: 3.5rem;">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <h2 class="h3 fw-bold text-dark mb-2">Módulo "<?=htmlspecialchars($moduloNombre);?>" en Desarrollo</h2>
                        <p class="text-muted mb-4">
                            Este módulo estará disponible próximamente en el Sistema Integrado de Movilidad Urbana (SIMU).
                        </p>
                        <a href="index.php?pg=creaUsu" class="btn btn-primary" style="max-width: 250px; margin: 0 auto;">
                            <i class="fas fa-user-plus me-2"></i>Ir a Crear Usuario
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
    <script src="js/code.js?v=2"></script>
    <script src="js/valida.js?v=1"></script>
</body>
</html>