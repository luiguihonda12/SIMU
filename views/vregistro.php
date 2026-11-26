<div class="simu-auth-shell">
    <div class="simu-auth-card">

        <!-- Panel Institucional SIMU -->
        <div class="simu-auth-brand">
            <div class="simu-auth-brand-content">
                <div class="simu-auth-status-badge">
                    <span class="simu-auth-status-dot"></span>
                    <span>Registro de Usuario &bull; SIMU v1.0</span>
                </div>

                <div class="simu-auth-brand-logo">
                    <img src="img/logo-simu.png" alt="Logo SIMU">
                    <div>
                        <div class="text-white-50 text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.1em;">Plataforma Oficial</div>
                        <div class="fw-bold fs-4 text-white lh-1">SIMU</div>
                    </div>
                </div>

                <h1 class="simu-auth-brand-title">Únete al Sistema de Movilidad Urbana</h1>
                <p class="simu-auth-brand-desc">
                    Crea tu cuenta para planificar tus rutas, consultar paraderos y frecuencias en tiempo real, radicar PQRS y viajar informado por toda la ciudad.
                </p>

                <ul class="simu-auth-highlights">
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-user-check"></i></span>
                        <span>Acceso personalizado a rutas y paraderos</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-map-location-dot"></i></span>
                        <span>Trazabilidad y tiempos de espera en tiempo real</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-comments"></i></span>
                        <span>Gestión y radicación directa de solicitudes PQRS</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-shield-halved"></i></span>
                        <span>Validación segura y protección integral de datos</span>
                    </li>
                </ul>
            </div>

            <div class="simu-auth-brand-footer">
                <span><i class="fas fa-shield-halved me-1 text-info"></i> Acceso Cifrado SSL</span>
                <span>SIMU &copy; 2026</span>
            </div>
        </div>

        <!-- Panel de Formulario: Registro de Usuario -->
        <div class="simu-auth-form-side">
            <!-- Botón de Modo Oscuro Flotante -->
            <button class="theme-toggle auth-theme-toggle-floating" id="themeToggleBtn" type="button" aria-label="Cambiar modo oscuro" title="Modo oscuro">
                <span class="theme-toggle-icon">
                    <i class="fas fa-sun theme-icon theme-icon-sun"></i>
                    <i class="fas fa-moon theme-icon theme-icon-moon"></i>
                </span>
            </button>

            <div class="simu-auth-form-inner" style="max-width: 480px;">
                <div class="simu-auth-header">
                    <div class="simu-auth-header-badge">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="simu-auth-header-title" id="regTitle">Crear cuenta</h2>
                    <p class="simu-auth-header-subtitle">Registro de nuevos usuarios del sistema</p>
                </div>

                <!-- Mensaje de error al registrar -->
                <div id="regError" class="reg-alert js-hidden mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i><span id="regErrorText"></span>
                </div>

                <!-- PASO 1: Datos de Acceso -->
                <section id="step1" class="reg-step active">
                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <label class="simu-form-label" for="nombre">Nombre</label>
                            <div class="simu-input-wrapper">
                                <i class="fas fa-user simu-input-icon"></i>
                                <input type="text" class="form-control simu-auth-input" id="nombre" placeholder="Juan" required autocomplete="given-name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="simu-form-label" for="apellidos">Apellidos</label>
                            <div class="simu-input-wrapper">
                                <i class="fas fa-user simu-input-icon"></i>
                                <input type="text" class="form-control simu-auth-input" id="apellidos" placeholder="Pérez" required autocomplete="family-name">
                            </div>
                        </div>
                    </div>

                    <div class="simu-form-group">
                        <label class="simu-form-label" for="email">Correo electrónico</label>
                        <div class="simu-input-wrapper">
                            <i class="fas fa-envelope simu-input-icon"></i>
                            <input type="email" class="form-control simu-auth-input" id="email" placeholder="correo@ejemplo.com" required autocomplete="email">
                        </div>
                    </div>

                    <div class="simu-form-group">
                        <label class="simu-form-label" for="telefono">Teléfono <span class="text-muted fw-normal">(Opcional)</span></label>
                        <div class="simu-input-wrapper">
                            <i class="fas fa-phone simu-input-icon"></i>
                            <input type="tel" class="form-control simu-auth-input" id="telefono" placeholder="300 123 4567" autocomplete="tel">
                        </div>
                    </div>

                    <div class="simu-form-group">
                        <label class="simu-form-label" for="pass">Contraseña</label>
                        <div class="simu-input-wrapper">
                            <i class="fas fa-lock simu-input-icon"></i>
                            <div class="password-wrapper">
                                <input type="password" class="form-control simu-auth-input" id="pass" placeholder="Ej: Simu2026#" required autocomplete="new-password">
                                <i class="fas fa-eye eye-toggle js-ver-clave" data-target="pass" role="button" tabindex="0" title="Mostrar u ocultar contraseña"></i>
                            </div>
                        </div>
                        <div class="strength-meter"><div id="strengthBar"></div></div>
                        <small id="strengthText" class="d-block mt-1">Seguridad: Baja</small>
                        <ul class="list-unstyled small mt-2 mb-0" id="reqClave">
                            <li id="reqLong" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Mínimo 6 caracteres</li>
                            <li id="reqMayus" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Al menos una letra mayúscula</li>
                            <li id="reqNums" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Mínimo 2 números</li>
                            <li id="reqSimb" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Al menos un símbolo (! @ # $ %)</li>
                        </ul>
                    </div>

                    <button type="button" id="btnRegistrar" class="btn btn-simu-auth" onclick="registrarUsuarioPublico()">
                        <span>Crear cuenta y continuar</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </section>

                <!-- PASO 2: Verificación de Perfil -->
                <section id="step2" class="reg-step">
                    <div class="simu-form-group text-center">
                        <label class="form-label fw-semibold d-block mb-2">Código de Verificación</label>
                        <p class="text-muted small mb-3">
                            Ingresa el código de 6 dígitos enviado a tu correo para activar tu perfil.
                        </p>

                        <!-- Aviso temporal -->
                        <div id="regCodeHint" class="alert alert-info py-2 px-3 mx-auto js-hidden reg-code-hint mb-3"></div>

                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <input type="text" class="form-control text-center code-input" maxlength="1" required inputmode="numeric">
                            <input type="text" class="form-control text-center code-input" maxlength="1" required inputmode="numeric">
                            <input type="text" class="form-control text-center code-input" maxlength="1" required inputmode="numeric">
                            <input type="text" class="form-control text-center code-input" maxlength="1" required inputmode="numeric">
                            <input type="text" class="form-control text-center code-input" maxlength="1" required inputmode="numeric">
                            <input type="text" class="form-control text-center code-input" maxlength="1" required inputmode="numeric">
                        </div>
                    </div>

                    <input type="hidden" id="regCorreo">
                    <div id="regCodeError" class="reg-alert js-hidden mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i><span id="regCodeErrorText"></span>
                    </div>

                    <button type="button" id="btnVerificar" class="btn btn-simu-auth w-100 mb-2" onclick="verificarCodigo()">
                        <span>Verificar y Crear Perfil</span>
                        <i class="fas fa-check-circle"></i>
                    </button>
                    <button type="button" class="btn btn-link w-100 text-decoration-none mt-1" onclick="nextStep(1)">
                        <i class="fas fa-arrow-left me-1"></i> Atrás
                    </button>
                </section>

                <!-- PASO 3: Éxito -->
                <section id="step3" class="reg-step text-center py-4">
                    <div class="simu-auth-header-badge mx-auto mb-3" style="width: 64px; height: 64px; font-size: 2rem; color: #10b981; background: rgba(16, 185, 129, 0.15);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 class="h4 fw-bold text-dark mb-2">¡Perfil Verificado!</h2>
                    <p class="text-muted small mb-4">Tu cuenta en SIMU ha sido verificada con éxito. Ya puedes iniciar sesión.</p>
                    <a href="index.php?pg=vlogin" class="btn btn-simu-auth w-100 text-decoration-none">
                        <span>Ir a Iniciar Sesión</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </section>

                <div class="simu-auth-nav-links">
                    <div>
                        <span class="text-muted">¿Ya tienes una cuenta?</span>
                        <a href="index.php?pg=login" class="ms-1">
                            Iniciar Sesión <i class="fas fa-arrow-right-to-bracket ms-0.5"></i>
                        </a>
                    </div>
                </div>
            </div><!-- /.simu-auth-form-inner -->
        </div><!-- /.simu-auth-form-side -->

    </div><!-- /.simu-auth-card -->
</div><!-- /.simu-auth-shell -->
