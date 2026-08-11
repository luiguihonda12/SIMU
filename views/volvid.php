<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 p-4 rounded-4">
                <div class="text-center mb-3">
                    <div class="bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="fw-bold">Recuperar Contraseña</h3>
                    <p class="text-muted small">Te enviaremos un código de verificación a tu correo</p>
                </div>

                <div id="olvMsg" class="alert" style="display:none;"></div>

                <form id="formOlvido" onsubmit="enviarInstrucciones(event)">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Correo electrónico registrado</label>
                        <input type="email" class="form-control" id="olvCorreo" name="correo" placeholder="correo@ejemplo.com" required>
                    </div>
                    <button type="submit" id="btnOlvido" class="btn btn-info text-white w-100 py-2 fw-semibold">
                        Enviar Código <i class="fas fa-paper-plane ms-1"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?pg=login" class="small text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Volver al inicio de sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
