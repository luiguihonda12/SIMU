<div class="simu-auth-shell">
    <div class="simu-auth-card">

        <!-- Panel Institucional SIMU -->
        <div class="simu-auth-brand">
            <div class="simu-auth-brand-content">
                <div class="simu-auth-status-badge">
                    <span class="simu-auth-status-dot"></span>
                    <span>Validación en 2 Pasos</span>
                </div>

                <div class="simu-auth-brand-logo">
                    <img src="img/logo-simu.png" alt="Logo SIMU">
                    <div>
                        <div class="text-white-50 text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.1em;">Centro de Seguridad</div>
                        <div class="fw-bold fs-4 text-white lh-1">SIMU</div>
                    </div>
                </div>

                <h1 class="simu-auth-brand-title">Verificación de Identidad</h1>
                <p class="simu-auth-brand-desc">
                    Para resguardar la seguridad de las cuentas y las operaciones del transporte urbano, requerimos verificar el código emitido.
                </p>

                <ul class="simu-auth-highlights">
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-key"></i></span>
                        <span>Código temporal de 6 dígitos</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-clock"></i></span>
                        <span>Caducidad controlada para máxima protección</span>
                    </li>
                    <li class="simu-auth-highlight-item">
                        <span class="simu-auth-highlight-icon"><i class="fas fa-shield-halved"></i></span>
                        <span>Prevención de accesos no autorizados</span>
                    </li>
                </ul>
            </div>

            <div class="simu-auth-brand-footer">
                <span><i class="fas fa-user-shield me-1 text-info"></i> Trazabilidad Institucional</span>
                <span>SIMU &copy; 2026</span>
            </div>
        </div>

        <!-- Panel de Formulario: Código de Verificación -->
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
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="simu-auth-header-title">Código de Verificación</h2>
                    <p class="simu-auth-header-subtitle">Ingresa los 6 dígitos enviados a tu correo electrónico</p>
                </div>

                <div id="codMsg" class="alert js-hidden"></div>

                <form id="formCodigo" onsubmit="verificarCodigoRecuperacion(event)">
                    <?php $correoPre = trim($_GET['correo'] ?? ''); ?>
                    <?php if ($correoPre === ''): ?>
                        <div class="simu-form-group">
                            <label class="simu-form-label" for="codCorreo">Correo Electrónico</label>
                            <div class="simu-input-wrapper">
                                <i class="fas fa-envelope simu-input-icon"></i>
                                <input
                                    type="email"
                                    class="form-control simu-auth-input"
                                    id="codCorreo"
                                    name="correo"
                                    placeholder="correo@ejemplo.com"
                                    required
                                >
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" id="codCorreo" value="<?php echo htmlspecialchars($correoPre); ?>">
                        <div class="alert alert-info border text-center py-2 px-3 small mb-3" role="alert">
                            <i class="fas fa-envelope me-1"></i>
                            Código enviado a: <strong><?php echo htmlspecialchars($correoPre); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="simu-form-group text-center my-4">
                        <label class="simu-form-label d-block mb-3">Digita el código recibido</label>
                        <div class="d-flex justify-content-center gap-2">
                            <input type="text" class="form-control text-center code-input" name="digito1" maxlength="1" inputmode="numeric" required>
                            <input type="text" class="form-control text-center code-input" name="digito2" maxlength="1" inputmode="numeric" required>
                            <input type="text" class="form-control text-center code-input" name="digito3" maxlength="1" inputmode="numeric" required>
                            <input type="text" class="form-control text-center code-input" name="digito4" maxlength="1" inputmode="numeric" required>
                            <input type="text" class="form-control text-center code-input" name="digito5" maxlength="1" inputmode="numeric" required>
                            <input type="text" class="form-control text-center code-input" name="digito6" maxlength="1" inputmode="numeric" required>
                        </div>
                    </div>

                    <button type="submit" id="btnCodigo" class="btn btn-simu-auth">
                        <span>Verificar Código</span>
                        <i class="fas fa-check-circle"></i>
                    </button>
                </form>

                <div class="simu-auth-nav-links">
                    <a href="index.php?pg=olvido">
                        <i class="fas fa-arrow-left"></i> Solicitar otro código de recuperación
                    </a>
                    <a href="index.php?pg=login" class="text-muted small">
                        Volver al inicio de sesión
                    </a>
                </div>
            </div><!-- /.simu-auth-form-inner -->
        </div><!-- /.simu-auth-form-side -->

    </div><!-- /.simu-auth-card -->
</div><!-- /.simu-auth-shell -->
