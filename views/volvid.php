<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 p-4 rounded-4">
                <div class="text-center mb-3">
                    <div class="bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="fw-bold">Recuperar Contraseña</h3>
                    <p class="text-muted small">Te enviaremos las instrucciones de recuperación</p>
                </div>
                <form id="formOlvido" action="index.php?pg=vcoder" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Correo electrónico registrado</label>
                        <input type="email" class="form-control" name="correo" placeholder="correo@ejemplo.com" required>
                    </div>
                    <button type="submit" class="btn btn-info text-white w-100 py-2 fw-semibold">
                        Enviar Instrucciones <i class="fas fa-paper-plane ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
