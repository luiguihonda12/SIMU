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
                <form action="controllers/creset.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_POST['token'] ?? ($_GET['token'] ?? '')); ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Repite tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-info text-white w-100 py-2 fw-semibold">
                        Guardar Contraseña <i class="fas fa-check-circle ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
