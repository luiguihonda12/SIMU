<div class="simu-auth-shell">
    <div class="simu-auth-card">

        <!-- Panel Institucional SIMU -->
        <div class="simu-auth-brand">
            <div class="simu-auth-brand-content">
                <div class="simu-auth-status-badge">
                    <span class="simu-auth-status-dot"></span>
                    <span>Recuperación de Credenciales</span>
                </div>

                <div class="simu-auth-brand-logo">
                    <img src="img/logo-simu.png" alt="Logo SIMU">
                    <div>
                        <div class="text-white-50 text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.1em;">Seguridad SIMU</div>
                        <div class="fw-bold fs-4 text-white lh-1">SIMU</div>
                    </div>
                </div>

                <h1 class="simu-auth-brand-title">Recupera el Acceso a tu Cuenta</h1>
                <p class="simu-auth-brand-desc">
                    Te enviaremos un código de seguridad de 6 dígitos para validar tu identidad y habilitar el restablecimiento de tu contraseña.
                </p>

                <ul class="simu-auth-highlights">
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-shield-halved"></i></span>
                        <span>Validación mediante código seguro de un solo uso</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-envelope-open-text"></i></span>
                        <span>Envío inmediato al correo electrónico registrado</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-lock"></i></span>
                        <span>Cifrado y protección de datos institucionales</span>
                    </li>
                </ul>
            </div>

            <div class="simu-auth-brand-footer">
                <span><i class="fas fa-shield-halved me-1 text-info"></i> Canal de Seguridad Oficial</span>
                <span>SIMU &copy; 2026</span>
            </div>
        </div>

        <!-- Panel de Formulario: Solicitar Código -->
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
                        <i class="fas fa-key"></i>
                    </div>
                    <h2 class="simu-auth-header-title">Recuperar Contraseña</h2>
                    <p class="simu-auth-header-subtitle">Ingresa el correo electrónico asociado a tu cuenta</p>
                </div>

                <div id="olvMsg" class="alert js-hidden"></div>

                <form id="formOlvido" onsubmit="enviarInstrucciones(event)">
                    <div class="simu-form-group">
                        <label class="simu-form-label" for="olvCorreo">Correo Electrónico Registrado</label>
                        <div class="simu-input-wrapper">
                            <i class="fas fa-envelope simu-input-icon"></i>
                            <input
                                type="email"
                                class="form-control simu-auth-input"
                                id="olvCorreo"
                                name="correo"
                                placeholder="nombre@ejemplo.com"
                                required
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <button type="submit" id="btnOlvido" class="btn btn-simu-auth">
                        <span>Enviar Código de Verificación</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <div class="simu-auth-nav-links">
                    <a href="index.php?pg=login">
                        <i class="fas fa-arrow-left"></i> Volver a Iniciar Sesión
                    </a>
                </div>
            </div><!-- /.simu-auth-form-inner -->
        </div><!-- /.simu-auth-form-side -->

    </div><!-- /.simu-auth-card -->
</div><!-- /.simu-auth-shell -->
