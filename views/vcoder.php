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
                <form action="index.php?pg=vreset" method="POST">
                    <div class="mb-4 text-center">
                        <label class="form-label fw-semibold d-block mb-3">Código de 6 dígitos</label>
                        <div class="d-flex justify-content-center gap-2">
                            <input type="text" class="form-control text-center fs-4 fw-bold" name="digito1" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold" name="digito2" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold" name="digito3" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold" name="digito4" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold" name="digito5" maxlength="1" style="width: 45px; height: 50px;" required>
                            <input type="text" class="form-control text-center fs-4 fw-bold" name="digito6" maxlength="1" style="width: 45px; height: 50px;" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info text-white w-100 py-2 fw-semibold">
                        Verificar Código <i class="fas fa-check-circle ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
