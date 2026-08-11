<?php
// Cargar roles disponibles desde la base de datos (patrón MVC)
require_once(__DIR__ . "/../models/mUsuario.php");
$mRol = new mUsuario();
$roles = $mRol->getRoles();
?>

<div class="registration-container">
    <header class="reg-header">
        <h1 class="brand-title">SIMU</h1>
        <div class="logo-wrapper">
            <div class="main-logo"><i class="fas fa-user-shield"></i></div>
        </div>
        <h2 id="regTitle" class="h4 text-dark fw-bold">Crear cuenta</h2>
        <p class="text-muted small mb-0">Módulo de registro de nuevos usuarios del sistema</p>
    </header>

    <!-- Mensaje de error al registrar -->
    <div id="regError" class="reg-alert" style="display:none;">
        <i class="fas fa-exclamation-circle me-2"></i><span id="regErrorText"></span>
    </div>

    <!-- PASO 1: Datos de Acceso -->
    <section id="step1" class="reg-step active">
        <div class="input-row">
            <div class="input-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Juan">
            </div>
            <div class="input-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" placeholder="Pérez">
            </div>
        </div>

        <div class="input-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" placeholder="correo@ejemplo.com">
        </div>

        <div class="input-group">
            <label for="telefono">Teléfono <span class="text-muted font-normal">(Opcional)</span></label>
            <input type="tel" id="telefono" placeholder="300 123 4567">
        </div>
        
        <div class="input-group">
            <label for="pass">Contraseña</label>
            <div class="password-wrapper">
                <input type="password" id="pass" placeholder="Mín. 6 caracteres">
                <i class="fas fa-eye eye-toggle" id="toggleIcon"></i>
            </div>
            <div class="strength-meter"><div id="strengthBar"></div></div>
            <small id="strengthText">Seguridad: Baja</small>
        </div>

        <div class="input-group">
            <label for="rol">Rol del usuario</label>
            <select id="rol">
                <?php foreach ($roles as $rolItem): ?>
                    <option value="<?= (int)$rolItem['id_rol']; ?>" <?= (int)$rolItem['id_rol'] === 3 ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($rolItem['rol']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" id="btnRegistrar" class="btn btn-primary" onclick="registrarUsuario()">Crear cuenta y continuar <i class="fas fa-arrow-right ms-2"></i></button>
    </section>

    <!-- PASO 2: Verificación de Perfil -->
    <section id="step2" class="reg-step">
        <div class="input-group" style="text-align: center;">
            <label class="form-label fw-semibold d-block mb-3">Código de Verificación</label>
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">
                Ingresa el código de 6 dígitos enviado a tu correo para activar tu perfil.
            </p>

            <!-- Aviso temporal: se muestra el código cuando el envío de correos aún no está configurado -->
            <div id="regCodeHint" class="alert alert-info py-2 px-3 mx-auto" style="display:none; max-width: 420px; font-size: 0.85rem;"></div>

            <div class="d-flex justify-content-center gap-2 mb-3">
                <input type="text" class="form-control text-center fs-4 fw-bold code-input" maxlength="1" style="width: 45px; height: 50px;" required>
                <input type="text" class="form-control text-center fs-4 fw-bold code-input" maxlength="1" style="width: 45px; height: 50px;" required>
                <input type="text" class="form-control text-center fs-4 fw-bold code-input" maxlength="1" style="width: 45px; height: 50px;" required>
                <input type="text" class="form-control text-center fs-4 fw-bold code-input" maxlength="1" style="width: 45px; height: 50px;" required>
                <input type="text" class="form-control text-center fs-4 fw-bold code-input" maxlength="1" style="width: 45px; height: 50px;" required>
                <input type="text" class="form-control text-center fs-4 fw-bold code-input" maxlength="1" style="width: 45px; height: 50px;" required>
            </div>
        </div>

        <input type="hidden" id="regCorreo">
        <div id="regCodeError" class="reg-alert" style="display:none;">
            <i class="fas fa-exclamation-circle me-2"></i><span id="regCodeErrorText"></span>
        </div>

        <button type="button" id="btnVerificar" class="btn btn-primary w-100 mb-2" onclick="verificarCodigo()">Verificar y Crear Perfil <i class="fas fa-check-circle ms-2"></i></button>
        <button type="button" class="btn btn-link w-100" onclick="nextStep(1)"><i class="fas fa-arrow-left me-1"></i> Atrás</button>
    </section>

    <!-- PASO 3: Éxito -->
    <section id="step3" class="reg-step">
        <div class="success-anim"><i class="fas fa-check-circle"></i></div>
        <h2 class="text-center h4 fw-bold">¡Perfil Verificado!</h2>
        <p class="success-desc">Tu cuenta en SIMU ha sido verificada con éxito. Ya puedes iniciar sesión.</p>
        <a href="index.php?pg=vlogin" class="btn btn-primary w-100 text-decoration-none">Ir a Iniciar Sesión</a>
    </section>
</div>