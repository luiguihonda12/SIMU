<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-3">
            <i class="bi bi-box-arrow-in-right text-primary" style="font-size: 2.5rem;"></i>
            <h3 class="fw-bold mt-2">Iniciar Sesión</h3>
            <p class="text-muted small">Acceso al Sistema Integrado de Movilidad Urbana</p>
        </div>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'datos_erroneos'): ?>
            <div class="alert alert-danger text-center py-2 small" role="alert">
                <strong>Acceso denegado:</strong> El correo o la contraseña no están registrados.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'campos_vacios'): ?>
            <div class="alert alert-warning text-center py-2 small" role="alert">
                Por favor ingresa el correo y la contraseña.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'no_verificado'): ?>
            <div class="alert alert-warning text-center py-2 small" role="alert">
                <strong>Cuenta sin verificar:</strong> Ingresa el código que enviamos a tu correo.
                <a href="index.php?pg=vcoder" class="alert-link d-inline-block mt-1">Verificar mi cuenta</a>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'password_reset'): ?>
            <div class="alert alert-success text-center py-2 small" role="alert">
                <strong>Contraseña actualizada:</strong> Ya puedes iniciar sesión con tu nueva contraseña.
            </div>
        <?php endif; ?>

        <form action="controllers/cLogin.php" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>

        <div class="text-center mt-3">
            <a href="index.php?pg=olvido" class="small text-decoration-none">Olvidé mi contraseña</a><br>
            <a href="index.php?pg=registro" class="small text-decoration-none">Registrarse</a>
        </div>
    </div>
</div>
