<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 p-4 rounded-4">
                <div class="text-center mb-3">
                    <div class="bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="fw-bold">Código de Verificación</h3>
                    <p class="text-muted small">Ingresa el código de 6 dígitos enviado a tu correo</p>
                </div>

                <div id="codMsg" class="alert" style="display:none;"></div>

                <form id="formCodigo" onsubmit="verificarCodigoRecuperacion(event)">
                    <?php $correoPre = trim($_GET['correo'] ?? ''); ?>
                    <?php if ($correoPre === ''): ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo electrónico</label>
                            <input type="email" class="form-control" id="codCorreo" name="correo" placeholder="correo@ejemplo.com" required>
                        </div>
                    <?php else: ?>
                        <input type="hidden" id="codCorreo" value="<?php echo htmlspecialchars($correoPre); ?>">
                        <div class="alert alert-light border text-center py-2 small" role="alert">
                            Enviado a <strong><?php echo htmlspecialchars($correoPre); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4 text-center">
                        <label class="form-label fw-semibold d-block mb-3">Código de 6 dígitos</label>
                        <div class="d-flex justify-content-center gap-2">
                            <input type="text" class="form-control text-center fs-4 fw-bold code-input" name="digito1" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold code-input" name="digito2" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold code-input" name="digito3" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold code-input" name="digito4" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold code-input" name="digito5" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold code-input" name="digito6" maxlength="1" style="width: 45px; height: 50px;" required>
                        </div>
                    </div>

                    <button type="submit" id="btnCodigo" class="btn btn-info text-white w-100 py-2 fw-semibold">
                        Verificar Código <i class="fas fa-check-circle ms-1"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?pg=olvido" class="small text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Volver a recuperar contraseña</a>
                </div>
            </div>
        </div>
    </div>
</div>