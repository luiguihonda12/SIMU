<div class="simu-auth-shell">
    <div class="simu-auth-card">

        <!-- Panel Institucional SIMU -->
        <div class="simu-auth-brand">
            <div class="simu-auth-brand-content">
                <div class="simu-auth-status-badge">
                    <span class="simu-auth-status-dot"></span>
                    <span>Sistema Operativo &bull; SIMU v1.0</span>
                </div>

                <div class="simu-auth-brand-logo">
                    <img src="img/logo-simu.png" alt="Logo SIMU">
                    <div>
                        <div class="text-white-50 text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.1em;">Plataforma Oficial</div>
                        <div class="fw-bold fs-4 text-white lh-1">SIMU</div>
                    </div>
                </div>

                <h1 class="simu-auth-brand-title">Sistema Integrado de Movilidad Urbana</h1>
                <p class="simu-auth-brand-desc">
                    Supervisión integral de transporte público, despacho de flota, trazabilidad de rutas y centro de atención ciudadana.
                </p>

                <ul class="simu-auth-highlights">
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-bus-simple"></i></span>
                        <span>Gestión y Monitoreo de Flota</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-route"></i></span>
                        <span>Control de Rutas, Trazados y Paraderos</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-id-badge"></i></span>
                        <span>Panel y Telemetría para Conductores</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-headset"></i></span>
                        <span>Portal Ciudadano y Gestión PQRS</span>
                    </li>
                </ul>
            </div>

            <div class="simu-auth-brand-footer">
                <span><i class="fas fa-shield-halved me-1 text-info"></i> Acceso Cifrado SSL</span>
                <span>SIMU &copy; 2026</span>
            </div>
        </div>

        <!-- Panel de Formulario: Iniciar Sesión -->
        <div class="simu-auth-form-side">
            <!-- Botón de Modo Oscuro Flotante -->
            <button class="theme-toggle auth-theme-toggle-floating" id="themeToggleBtn" type="button" aria-label="Cambiar modo oscuro" title="Modo oscuro">
                <span class="theme-toggle-icon">
                    <i class="fas fa-sun theme-icon theme-icon-sun"></i>
                    <i class="fas fa-moon theme-icon theme-icon-moon"></i>
                </span>
            </button>

            <div class="simu-auth-form-inner">
                <div class="simu-auth-header">
                    <div class="simu-auth-header-badge">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                    </div>
                    <h2 class="simu-auth-header-title">Iniciar Sesión</h2>
                    <p class="simu-auth-header-subtitle">Ingresa tus credenciales para acceder a la plataforma</p>
                </div>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'datos_erroneos'): ?>
                <div class="alert alert-danger text-center py-2 mb-3" role="alert">
                    <i class="fas fa-circle-exclamation me-1"></i>
                    <strong>Acceso denegado:</strong> El correo o la contraseña no coinciden.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'campos_vacios'): ?>
                <div class="alert alert-warning text-center py-2 mb-3" role="alert">
                    <i class="fas fa-triangle-exclamation me-1"></i>
                    Por favor diligencia todos los campos solicitados.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'no_verificado'): ?>
                <div class="alert alert-warning text-center py-2 mb-3" role="alert">
                    <i class="fas fa-shield-halved me-1"></i>
                    <strong>Cuenta pendiente:</strong> Actívala con el código enviado a tu correo.
                    <a href="index.php?pg=vcoder" class="alert-link d-inline-block mt-1">Verificar cuenta</a>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'acceso_no_autorizado'): ?>
                <div class="alert alert-warning text-center py-2 mb-3" role="alert">
                    <i class="fas fa-lock me-1"></i>
                    Debes iniciar sesión para consultar esa sección.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'password_reset'): ?>
                <div class="alert alert-success text-center py-2 mb-3" role="alert">
                    <i class="fas fa-circle-check me-1"></i>
                    <strong>Contraseña actualizada:</strong> Ya puedes iniciar sesión.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'sesion_cerrada'): ?>
                <div class="alert alert-info text-center py-2 mb-3" role="alert">
                    <i class="fas fa-check me-1"></i>
                    Sesión finalizada correctamente.
                </div>
            <?php endif; ?>

            <form action="controllers/cLogin.php" method="POST">
                <div class="simu-form-group">
                    <label class="simu-form-label" for="correo">Correo Electrónico</label>
                    <div class="simu-input-wrapper">
                        <i class="fas fa-envelope simu-input-icon"></i>
                        <input
                            type="email"
                            class="form-control simu-auth-input"
                            id="correo"
                            name="correo"
                            placeholder="nombre@ejemplo.com"
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                <div class="simu-form-group">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="simu-form-label mb-0" for="clave">Contraseña</label>
                        <a href="index.php?pg=olvido" class="small text-decoration-none" style="color: var(--simu-primary); font-weight: 600;">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                    <div class="simu-input-wrapper">
                        <i class="fas fa-lock simu-input-icon"></i>
                        <div class="password-wrapper">
                            <input
                                type="password"
                                class="form-control simu-auth-input"
                                id="clave"
                                name="clave"
                                placeholder="••••••••••••"
                                required
                                autocomplete="current-password"
                            >
                            <i class="fas fa-eye eye-toggle js-ver-clave" data-target="clave" role="button" tabindex="0" title="Mostrar u ocultar contraseña"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-simu-auth">
                    <span>Acceder al Sistema</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="simu-auth-nav-links">
                <div>
                    <span class="text-muted">¿No tienes una cuenta aún?</span>
                    <a href="index.php?pg=registro" class="ms-1">
                        Registrarme <i class="fas fa-user-plus ms-0.5"></i>
                    </a>
                </div>
            </div>
            </div><!-- /.simu-auth-form-inner -->
        </div><!-- /.simu-auth-form-side -->

    </div><!-- /.simu-auth-card -->
</div><!-- /.simu-auth-shell -->
