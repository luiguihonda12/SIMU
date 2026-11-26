<?php
$tokenReset = trim($_GET['token'] ?? ($_POST['token'] ?? ''));
?>
<div class="simu-auth-shell">
    <div class="simu-auth-card">

        <!-- Panel Institucional SIMU -->
        <div class="simu-auth-brand">
            <div class="simu-auth-brand-content">
                <div class="simu-auth-status-badge">
                    <span class="simu-auth-status-dot"></span>
                    <span>Actualización de Clave</span>
                </div>

                <div class="simu-auth-brand-logo">
                    <img src="img/logo-simu.png" alt="Logo SIMU">
                    <div>
                        <div class="text-white-50 text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.1em;">Seguridad de Cuenta</div>
                        <div class="fw-bold fs-4 text-white lh-1">SIMU</div>
                    </div>
                </div>

                <h1 class="simu-auth-brand-title">Establece tu Nueva Contraseña</h1>
                <p class="simu-auth-brand-desc">
                    Elige una contraseña robusta para resguardar el acceso seguro a tu perfil en el Sistema Integrado de Movilidad Urbana.
                </p>

                <ul class="simu-auth-highlights">
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-shield"></i></span>
                        <span>Mínimo 6 caracteres y al menos una mayúscula</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-hashtag"></i></span>
                        <span>Mínimo dos números para mayor robustez</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-asterisk"></i></span>
                        <span>Al menos un carácter especial (!, @, #, $, %)</span>
                    </li>
                </ul>
            </div>

            <div class="simu-auth-brand-footer">
                <span><i class="fas fa-lock me-1 text-info"></i> Parámetros de Seguridad SIMU</span>
                <span>SIMU &copy; 2026</span>
            </div>
        </div>

        <!-- Panel de Formulario: Restablecer Contraseña -->
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
                        <i class="fas fa-lock-open"></i>
                    </div>
                    <h2 class="simu-auth-header-title">Confirmación Final</h2>
                    <p class="simu-auth-header-subtitle">Ingresa y confirma tu nueva contraseña de acceso</p>
                </div>

                <?php if ($tokenReset === ''): ?>
                    <div class="alert alert-danger text-center py-2 px-3 small mb-3" role="alert">
                        <i class="fas fa-circle-exclamation me-1"></i>
                        <strong>Enlace no válido:</strong> El token de recuperación expiró o no se encontró.
                    </div>
                    <div class="text-center mt-3">
                        <a href="index.php?pg=olvido" class="btn btn-simu-auth">
                            <i class="fas fa-arrow-rotate-left me-1"></i> Solicitar Nuevo Enlace
                        </a>
                    </div>
                <?php else: ?>

                    <div id="resMsg" class="alert js-hidden"></div>

                    <form id="formReset" onsubmit="guardarNuevaPassword(event)">
                        <input type="hidden" name="token" id="resToken" value="<?php echo htmlspecialchars($tokenReset); ?>">

                        <div class="simu-form-group">
                            <label class="simu-form-label" for="resPassword">Nueva Contraseña</label>
                            <div class="simu-input-wrapper">
                                <i class="fas fa-lock simu-input-icon"></i>
                                <div class="password-wrapper">
                                    <input
                                        type="password"
                                        class="form-control simu-auth-input"
                                        id="resPassword"
                                        name="password"
                                        placeholder="Ej: Simu2026#"
                                        required
                                        autocomplete="new-password"
                                    >
                                    <i class="fas fa-eye eye-toggle js-ver-clave" data-target="resPassword" role="button" tabindex="0" title="Mostrar u ocultar contraseña"></i>
                                </div>
                            </div>

                            <ul class="list-unstyled small mt-2 mb-0" id="reqClave">
                                <li id="reqLong" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Mínimo 6 caracteres</li>
                                <li id="reqMayus" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Al menos una letra mayúscula</li>
                                <li id="reqNums" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Mínimo 2 números</li>
                                <li id="reqSimb" class="text-muted"><i class="fas fa-circle-xmark me-1"></i>Al menos un símbolo (! @ # $ %)</li>
                            </ul>
                        </div>

                        <div class="simu-form-group">
                            <label class="simu-form-label" for="resConfirm">Confirmar Nueva Contraseña</label>
                            <div class="simu-input-wrapper">
                                <i class="fas fa-shield-halved simu-input-icon"></i>
                                <div class="password-wrapper">
                                    <input
                                        type="password"
                                        class="form-control simu-auth-input"
                                        id="resConfirm"
                                        name="confirm_password"
                                        placeholder="Repite tu contraseña"
                                        required
                                        autocomplete="new-password"
                                    >
                                    <i class="fas fa-eye eye-toggle js-ver-clave" data-target="resConfirm" role="button" tabindex="0" title="Mostrar u ocultar contraseña"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="btnReset" class="btn btn-simu-auth">
                            <span>Guardar Contraseña e Ingresar</span>
                            <i class="fas fa-check-circle"></i>
                        </button>
                    </form>

                <?php endif; ?>

                <div class="simu-auth-nav-links">
                    <a href="index.php?pg=login">
                        <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
                    </a>
                </div>
            </div><!-- /.simu-auth-form-inner -->
        </div><!-- /.simu-auth-form-side -->

    </div><!-- /.simu-auth-card -->
</div><!-- /.simu-auth-shell -->
