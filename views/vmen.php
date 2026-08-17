<?php


if (file_exists("controllers/cmen.php")) {
    @include_once("controllers/cmen.php");
}

$currentPage = $_GET['pg'] ?? 'creaUsu';


$idRolSesion = (int) ($_SESSION['id_rol'] ?? 0);
$esAdmin = ($idRolSesion === 1);
$esConductor = ($idRolSesion === 2);
$esCliente = ($idRolSesion === 3);

?>


<aside class="app-sidebar left-sidebar">


    <div class="sidebar-header">

        <h6 class="title">

            <i class="fas fa-th-large me-2"></i>

            Menú Principal

        </h6>


        <span class="badge bg-secondary rounded-pill vmen-mini">
            V 1.0
        </span>

    </div>



    <!-- =====================================================
         NAVEGACIÓN
         ===================================================== -->

    <nav class="sidebar-nav">


        <!-- =================================================
             GENERAL
             ================================================= -->

        <div class="sidebar-category">
            General
        </div>


        <!-- =================================================
             DASHBOARD
             VISTAS 15, 25 Y 26
             ================================================= -->

        <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'dashboard',
                    'menuCliente'
                ]
            ) ? 'open' : ''; ?>">


            <button type="button" class="sidebar-dropdown-btn">

                <span class="nav-item-content">

                    <span class="nav-item-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </span>

                    <span>
                        Dashboard
                    </span>

                </span>


                <i class="fas fa-chevron-down dropdown-arrow"></i>

            </button>


            <div class="sidebar-dropdown-content">


                <!-- VISTA 15 (Administrador y Conductor) -->

                <?php if ($esAdmin || $esConductor) { ?>

                    <a href="index.php?pg=dashboard" class="sidebar-subitem
                    <?= ($currentPage == 'dashboard') ? 'active' : ''; ?>">

                        <i class="fas fa-chart-pie"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>

                <?php } ?>


                <!-- VISTA 27 (Administrador y Cliente) -->

                <?php if ($esAdmin || $esCliente) { ?>

                    <a href="index.php?pg=menuCliente" class="sidebar-subitem
                    <?= ($currentPage == 'menuCliente') ? 'active' : ''; ?>">

                        <i class="fas fa-user"></i>

                        <span>
                            Menú Inicial Cliente
                        </span>

                    </a>

                <?php } ?>


            </div>

        </div>



<!-- =================================================
             AUTENTICACIÓN (solo usuarios NO logueados)
             ================================================= -->

        <?php if (!isset($_SESSION['id_usuario'])) { ?>

            <div class="sidebar-category">
                Acceso
            </div>

            <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'login',
                    'registro',
                    'codigoVerificacion',
                    'olvidoContrasena',
                    'confirmacionFinal'
                ]
            ) ? 'open' : ''; ?>">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-lock"></i>
                        </span>

                        <span>
                            Autenticación
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <!-- VISTA 1 -->

                    <a href="index.php?pg=login" class="sidebar-subitem
                    <?= ($currentPage == 'login') ? 'active' : ''; ?>">

                        <i class="fas fa-sign-in-alt"></i>

                        <span>
                            Iniciar Sesión
                        </span>

                    </a>


                    <!-- VISTA 2 -->

                    <a href="index.php?pg=registro" class="sidebar-subitem
                    <?= ($currentPage == 'registro') ? 'active' : ''; ?>">

                        <i class="fas fa-user-plus"></i>

                        <span>
                            Registro
                        </span>

                    </a>


                    <!-- VISTA 3 -->

                    <a href="index.php?pg=codigoVerificacion" class="sidebar-subitem
                    <?= ($currentPage == 'codigoVerificacion') ? 'active' : ''; ?>">

                        <i class="fas fa-shield-alt"></i>

                        <span>
                            Código Verificación
                        </span>

                    </a>


                    <!-- VISTA 4 -->

                    <a href="index.php?pg=olvidoContrasena" class="sidebar-subitem
                    <?= ($currentPage == 'olvidoContrasena') ? 'active' : ''; ?>">

                        <i class="fas fa-key"></i>

                        <span>
                            Olvidé Contraseña
                        </span>

                    </a>


                    <!-- VISTA 5 -->

                    <a href="index.php?pg=confirmacionFinal" class="sidebar-subitem
                    <?= ($currentPage == 'confirmacionFinal') ? 'active' : ''; ?>">

                        <i class="fas fa-check-circle"></i>

                        <span>
                            Confirmación Final
                        </span>

                    </a>


                </div>

            </div>

        <?php } ?>


        <!-- =================================================
             USUARIOS Y SEGURIDAD (solo Administrador logueado)
             ================================================= -->

        <?php if ($esAdmin) { ?>

            <div class="sidebar-category">
                Usuarios y Seguridad
            </div>


            <!-- =================================================
                 CREAR USUARIO (Admin)
                 ================================================= -->

            <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'creaUsu',
                    'crearUsuario'
                ]
            ) ? 'open' : ''; ?>">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-user-plus"></i>
                        </span>

                        <span>
                            Crear Usuario
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <!-- VISTA 13 -->

                    <a href="index.php?pg=creaUsu" class="sidebar-subitem
                    <?= ($currentPage == 'creaUsu' || $currentPage == 'crearUsuario') ? 'active' : ''; ?>">

                        <i class="fas fa-user-plus"></i>

                        <span>
                            Crear Usuario
                        </span>

                    </a>


                </div>

            </div>

        <?php } ?>



        <!-- =================================================
             GESTIÓN OPERATIVA (Administrador y Conductor)
             ================================================= -->

        <?php if ($esAdmin || $esConductor) { ?>

            <div class="sidebar-category">
                Gestión Operativa
            </div>

        <?php } ?>



        <!-- =================================================
             CONDUCTOR (Administrador y Conductor)
             VISTAS 16, 17 Y 18
             ================================================= -->

        <?php if ($esAdmin || $esConductor) { ?>

            <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'conductor',
                    'dashboardConductor',
                    'editarConductor'
                ]
            ) ? 'open' : ''; ?>">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-id-card"></i>
                        </span>

                        <span>
                            Conductor
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <!-- VISTA 16 -->

                    <a href="index.php?pg=conductor" class="sidebar-subitem
                    <?= ($currentPage == 'conductor') ? 'active' : ''; ?>">

                        <i class="fas fa-user-tie"></i>

                        <span>
                            Conductor
                        </span>

                    </a>


                    <!-- VISTA 17 -->

                    <a href="index.php?pg=dashboardConductor" class="sidebar-subitem
                    <?= ($currentPage == 'dashboardConductor') ? 'active' : ''; ?>">

                        <i class="fas fa-chart-line"></i>

                        <span>
                            Dashboard Conductor
                        </span>

                    </a>


                    <!-- VISTA 18 (solo Administrador) -->

                    <?php if ($esAdmin) { ?>

                        <a href="index.php?pg=editarConductor" class="sidebar-subitem
                    <?= ($currentPage == 'editarConductor') ? 'active' : ''; ?>">

                            <i class="fas fa-user-edit"></i>

                            <span>
                                Editar Conductor
                            </span>

                        </a>

                    <?php } ?>


                </div>

            </div>

        <?php } ?>



        <!-- =================================================
             BUSETAS Y VEHÍCULOS (solo Administrador)
             VISTAS 19, 20, 21, 22, 23 Y 24
             ================================================= -->

        <?php if ($esAdmin) { ?>

            <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'registrarBusetas',
                    'listadoBusetas',
                    'editarBusetas',
                    'cambiarEstadoBusetas',
                    'reporteBusetas',
                    'gestionRoles'
                ]
            ) ? 'open' : ''; ?>">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-bus"></i>
                        </span>

                        <span>
                            Busetas y Vehículos
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <!-- VISTA 19 -->

                    <a href="index.php?pg=registrarBusetas" class="sidebar-subitem
                    <?= ($currentPage == 'registrarBusetas') ? 'active' : ''; ?>">

                        <i class="fas fa-plus-circle"></i>

                        <span>
                            Registrar Busetas
                        </span>

                    </a>


                    <!-- VISTA 20 -->

                    <a href="index.php?pg=listadoBusetas" class="sidebar-subitem
                    <?= ($currentPage == 'listadoBusetas') ? 'active' : ''; ?>">

                        <i class="fas fa-list"></i>

                        <span>
                            Listado de Busetas
                        </span>

                    </a>


                    <!-- VISTA 21 -->

                    <a href="index.php?pg=editarBusetas" class="sidebar-subitem
                    <?= ($currentPage == 'editarBusetas') ? 'active' : ''; ?>">

                        <i class="fas fa-edit"></i>

                        <span>
                            Editar Busetas
                        </span>

                    </a>


                    <!-- VISTA 22 -->

                    <a href="index.php?pg=cambiarEstadoBusetas" class="sidebar-subitem
                    <?= ($currentPage == 'cambiarEstadoBusetas') ? 'active' : ''; ?>">

                        <i class="fas fa-toggle-on"></i>

                        <span>
                            Cambiar Estado Busetas
                        </span>

                    </a>


                    <!-- VISTA 23 -->

                    <a href="index.php?pg=reporteBusetas" class="sidebar-subitem
                    <?= ($currentPage == 'reporteBusetas') ? 'active' : ''; ?>">

                        <i class="fas fa-chart-bar"></i>

                        <span>
                            Reporte Busetas
                        </span>

                    </a>


                    <!-- VISTA 24 -->

                    <a href="index.php?pg=gestionRoles" class="sidebar-subitem
                    <?= ($currentPage == 'gestionRoles') ? 'active' : ''; ?>">

                        <i class="fas fa-user-shield"></i>

                        <span>
                            Gestión Roles
                        </span>

                    </a>


                </div>

            </div>

        <?php } ?>



        <!-- =================================================
             RUTAS Y HORARIOS (solo Administrador)
             VISTAS 7, 8, 9 Y 10
             ================================================= -->

        <?php if ($esAdmin) { ?>

            <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'registrarParaderos',
                    'edicionRuta',
                    'listadoRutas',
                    'registroRutas'
                ]
            ) ? 'open' : ''; ?>">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-route"></i>
                        </span>

                        <span>
                            Rutas y Horarios
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <!-- VISTA 7 -->

                    <a href="index.php?pg=registrarParaderos" class="sidebar-subitem
                    <?= ($currentPage == 'registrarParaderos') ? 'active' : ''; ?>">

                        <i class="fas fa-map-marker-alt"></i>

                        <span>
                            Registrar Paraderos
                        </span>

                    </a>


                    <!-- VISTA 8 -->

                    <a href="index.php?pg=edicionRuta" class="sidebar-subitem
                    <?= ($currentPage == 'edicionRuta') ? 'active' : ''; ?>">

                        <i class="fas fa-route"></i>

                        <span>
                            Módulo de Edición de Ruta
                        </span>

                    </a>


                    <!-- VISTA 9 -->

                    <a href="index.php?pg=listadoRutas" class="sidebar-subitem
                    <?= ($currentPage == 'listadoRutas') ? 'active' : ''; ?>">

                        <i class="fas fa-list"></i>

                        <span>
                            Módulo de Listado de Rutas
                        </span>

                    </a>


                    <!-- VISTA 10 -->

                    <a href="index.php?pg=registroRutas" class="sidebar-subitem
                    <?= ($currentPage == 'registroRutas') ? 'active' : ''; ?>">

                        <i class="fas fa-plus"></i>

                        <span>
                            Módulo de Registro de Rutas
                        </span>

                    </a>


                </div>

            </div>

        <?php } ?>



        <!-- =================================================
             EMPRESA (solo Administrador)
             SIN VISTAS ASIGNADAS TODAVÍA
             ================================================= -->

        <?php if ($esAdmin) { ?>

            <div class="sidebar-dropdown">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-building"></i>
                        </span>

                        <span>
                            Empresa
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <div class="sidebar-empty-item">

                        <i class="fas fa-clock"></i>

                        <span>
                            Sin vistas asignadas
                        </span>

                    </div>


                </div>

            </div>

        <?php } ?>



        <!-- =================================================
             SERVICIOS Y SOPORTE
             ================================================= -->

        <div class="sidebar-category">
            Servicios y Soporte
        </div>



        <!-- =================================================
             PQRS (solo Administrador)
             VISTAS 27 Y 28
             ================================================= -->

        <?php if ($esAdmin) { ?>

            <div class="sidebar-dropdown
            <?= in_array(
                $currentPage,
                [
                    'gestionPQRS',
                    'nuevaPQRS',
                    'vistaAdmin',
                    'pqrs'
                ]
            ) ? 'open' : ''; ?>">


                <button type="button" class="sidebar-dropdown-btn">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">
                            <i class="fas fa-comments"></i>
                        </span>

                        <span>
                            PQRS
                        </span>

                    </span>


                    <i class="fas fa-chevron-down dropdown-arrow"></i>

                </button>


                <div class="sidebar-dropdown-content">


                    <!-- VISTA 27 -->

                    <a href="index.php?pg=gestionPQRS" class="sidebar-subitem
                    <?= ($currentPage == 'gestionPQRS') ? 'active' : ''; ?>">

                        <i class="fas fa-comments"></i>

                        <span>
                            Gestión PQRS
                        </span>

                    </a>


                    <a href="index.php?pg=nuevaPQRS" class="sidebar-subitem
                    <?= ($currentPage == 'nuevaPQRS') ? 'active' : ''; ?>">

                        <i class="fas fa-circle-plus"></i>

                        <span>
                            Registrar PQRS
                        </span>

                    </a>


                    <a href="index.php?pg=detallePQRS" class="sidebar-subitem
                    <?= ($currentPage == 'detallePQRS') ? 'active' : ''; ?>">

                        <i class="fas fa-file-alt"></i>

                        <span>
                            Detalle PQRS
                        </span>

                    </a>


                </div>

            </div>

        <?php } ?>



        <!-- =================================================
             MENÚ DINÁMICO DE BASE DE DATOS (solo Administrador)
             ================================================= -->

        <?php if ($esAdmin && isset($datMen) && is_array($datMen) && count($datMen) > 0) { ?>


            <div class="sidebar-category">
                Menú Dinámico (BD)
            </div>


            <?php foreach ($datMen as $dm) { ?>


                <a href="index.php?pg=<?= htmlspecialchars($dm["idpag"]); ?>" class="nav-item-link
                    <?= ($currentPage == $dm["idpag"]) ? 'active' : ''; ?>">

                    <span class="nav-item-content">

                        <span class="nav-item-icon">

                            <i class="<?= htmlspecialchars($dm["icopag"]); ?>"></i>

                        </span>


                        <span>

                            <?= htmlspecialchars($dm["nompag"]); ?>

                        </span>

                    </span>

                </a>


            <?php } ?>


        <?php } ?>


    </nav>

</aside>