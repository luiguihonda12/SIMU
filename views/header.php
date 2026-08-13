
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sesNombre  = $_SESSION['usuario']    ?? '';
$sesCorreo  = $_SESSION['correo']     ?? '';
$sesId      = $_SESSION['id_usuario'] ?? 0;
$sesIdRol   = (int)($_SESSION['id_rol'] ?? 0);
$sesRol     = $_SESSION['rol']        ?? '';
?>

<header class="bg-institutional text-white py-2.5 barsup">

    <div class="container-fluid px-4 d-flex justify-content-between align-items-center">

        <!-- =====================================================
             LOGO Y NOMBRE DEL SISTEMA
             ===================================================== -->

        <a
            href="index.php"
            class="logo-container text-decoration-none d-flex align-items-center gap-3"
        >

            <img
                src="img/logo-simu.png"
                alt="SIMU - Sistema Integrado de Movilidad Urbana"
                class="header-logo-img"
            >

            <div class="d-none d-lg-block ps-3 border-start border-secondary border-opacity-50">

                <small class="text-white-50 d-block fw-normal style-subtitle">
                    Sistema Integrado de Movilidad Urbana
                </small>

            </div>

        </a>


        <!-- =====================================================
             CONTROLES DEL HEADER
             ===================================================== -->

        <div class="d-flex align-items-center gap-2">


            <!-- VERSIÓN -->

            <span class="badge badge-simu-version px-3 py-2 rounded-pill d-none d-sm-inline-block">

                <i class="fas fa-shield-alt me-1"></i>

                V 1.0

            </span>


            <!-- =================================================
                 BOTÓN DE USUARIO (solo con sesión activa)
                 VISTAS 12, 14 Y 29
                 ================================================= -->

            <?php if ($sesId) { ?>

            <div class="user-menu-wrapper">


                <button
                    class="btn btn-outline-simu user-menu-btn"
                    id="userMenuBtn"
                    type="button"
                    aria-label="Menú de usuario"
                    title="Perfil de usuario"
                >

                    <i class="fas fa-user"></i>

                </button>


                <!-- MENÚ DESPLEGABLE -->

                <div
                    class="user-dropdown"
                    id="userDropdown"
                >


                    <!-- CABECERA -->

                    <div class="user-dropdown-header">

                        <div class="user-avatar">

                            <i class="fas fa-user"></i>

                        </div>


                        <div class="user-info">

                            <strong>
                                <?= htmlspecialchars($sesNombre !== '' ? $sesNombre : 'Mi cuenta'); ?>
                            </strong>

                            <small>
                                <?= htmlspecialchars($sesCorreo !== '' ? $sesCorreo : 'Usuario SIMU'); ?>
                            </small>

                        </div>

                    </div>


                    <div class="user-dropdown-divider"></div>


                    <!-- =================================================
                         VISTA 12 - PERFIL USUARIOS
                         ================================================= -->

                    <a
                        href="index.php?pg=perfilUsuario"
                        class="user-dropdown-item"
                    >

                        <i class="fas fa-user-circle"></i>

                        <span>
                            Perfil Usuarios
                        </span>

                    </a>


                    <!-- =================================================
                         VISTA 14 - EDITAR USUARIO
                         ================================================= -->

                    <a
                        href="index.php?pg=editarUsuario"
                        class="user-dropdown-item"
                    >

                        <i class="fas fa-user-edit"></i>

                        <span>
                            Editar Usuario
                        </span>

                    </a>


                    <!-- =================================================
                         VISTA 29 - VISTA USUARIO
                         ================================================= -->

                    <a
                        href="index.php?pg=menuCliente"
                        class="user-dropdown-item"
                    >

                        <i class="fas fa-id-card"></i>

                        <span>
                            Vista Usuario
                        </span>

                    </a>


                    <div class="user-dropdown-divider"></div>


                    <!-- =================================================
                         CERRAR SESIÓN
                         ================================================= -->

                    <a
                        href="controllers/cLogout.php"
                        class="user-dropdown-item user-dropdown-item-logout"
                    >

                        <i class="fas fa-sign-out-alt"></i>

                        <span>
                            Cerrar sesión
                        </span>

                    </a>


                </div>

            </div>

            <?php } ?>


            <!-- =====================================================
                 MODO OSCURO
                 ===================================================== -->

            <button
                class="btn btn-outline-simu theme-toggle"
                id="themeToggleBtn"
                type="button"
                aria-label="Cambiar modo oscuro"
                title="Modo oscuro"
            >

                <span class="theme-toggle-icon">

                    <i class="fas fa-sun theme-icon theme-icon-sun"></i>

                    <i class="fas fa-moon theme-icon theme-icon-moon"></i>

                </span>

            </button>


            <!-- =====================================================
                 BOTÓN MENÚ MÓVIL
                 ===================================================== -->

            <button
                class="btn btn-outline-simu d-lg-none"
                id="sidebarToggleBtn"
                type="button"
                aria-label="Abrir Menú"
            >

                <i class="fas fa-bars"></i>

            </button>


        </div>

    </div>

</header>