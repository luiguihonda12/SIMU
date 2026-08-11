<?php
$tokenReset = trim($_GET['token'] ?? ($_POST['token'] ?? ''));
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 p-4 rounded-4">
                <div class="text-center mb-3">
                    <div class="bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-key"></i>
                    </div>
                    <h3 class="fw-bold">Confirmación Final</h3>
                    <p class="text-muted small">Establece tu nueva contraseña de acceso</p>
                </div>

                <?php if ($tokenReset === ''): ?>
                    <div class="alert alert-danger text-center py-2 small" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Enlace de recuperación inválido o incompleto.
                    </div>
                    <div class="text-center mt-2">
                        <a href="index.php?pg=olvido" class="btn btn-info text-white w-100 py-2 fw-semibold">
                            <i class="fas fa-lock me-1"></i> Solicitar nuevamente
                        </a>
                    </div>
                <?php else: ?>

                    <div id="resMsg" class="alert" style="display:none;"></div>

                    <form id="formReset" onsubmit="guardarNuevaPassword(event)">
                        <input type="hidden" name="token" id="resToken" value="<?php echo htmlspecialchars($tokenReset); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="resPassword" name="password" placeholder="Mínimo 6 caracteres" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="resConfirm" name="confirm_password" placeholder="Repite tu contraseña" required>
                        </div>
                        <button type="submit" id="btnReset" class="btn btn-info text-white w-100 py-2 fw-semibold">
                            Guardar y Iniciar Sesión <i class="fas fa-check-circle ms-1"></i>
                        </button>
                    </form>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
