<?php

/**
 * ============================================================
 * VISTA 14 - EDITAR USUARIO
 * ============================================================
 */

require_once __DIR__ . '/../controllers/ceditarusu.php';

$controlador = new Ceditarusu();

$mensaje = '';
$tipoMensaje = '';

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datos = [
        'id_usuario' => trim($_POST['id_usuario'] ?? ''),
        'nombre'     => trim($_POST['nombre'] ?? ''),
        'apellidos'  => trim($_POST['apellidos'] ?? ''),
        'correo'     => trim($_POST['correo'] ?? ''),
        'telefono'   => trim($_POST['telefono'] ?? '')
    ];

    if (
        $datos['nombre'] === '' ||
        $datos['apellidos'] === '' ||
        $datos['correo'] === ''
    ) {

        $mensaje = 'Por favor completa los campos obligatorios.';
        $tipoMensaje = 'danger';

    } else {

        if ($controlador->actualizar($datos)) {

            $mensaje = 'Los datos del usuario fueron actualizados correctamente.';
            $tipoMensaje = 'success';

        } else {

            $mensaje = 'No fue posible actualizar los datos.';
            $tipoMensaje = 'danger';
        }
    }
}

$usuario = $controlador->mostrar($id);

if (!$usuario) {
    $usuario = [
        'id_usuario' => '',
        'nombre'     => 'Usuario no encontrado',
        'apellidos'  => '',
        'correo'     => '',
        'telefono'   => '',
        'id_rol'     => '',
        'rol'        => ''
    ];
}

?>

<style>

.editar-usuario {
    padding: 25px;
    width: 100%;
}

.eu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    gap: 15px;
    flex-wrap: wrap;
}

.eu-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.eu-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.eu-back {
    color: #009bbd;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.eu-back:hover {
    color: #007f9b;
}

.eu-card {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(0,0,0,.05);
    overflow: hidden;
}

.eu-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid #edf3f5;
}

.eu-card-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
}

.eu-card-header i {
    color: #00a8c8;
    margin-right: 7px;
}

.eu-body {
    padding: 22px;
}

.eu-profile {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 25px;
    padding: 15px;
    background: #f5fbfc;
    border-radius: 11px;
}

.eu-avatar {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #e2f7fb;
    color: #009bbd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
}

.eu-name {
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
}

.eu-id {
    color: #78909c;
    font-size: 11px;
    margin-top: 3px;
}

.eu-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

.eu-field {
    display: flex;
    flex-direction: column;
}

.eu-field.full {
    grid-column: 1 / -1;
}

.eu-field label {
    color: #455a64;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 7px;
}

.eu-field label span {
    color: #e53935;
}

.eu-field input,
.eu-field select {
    width: 100%;
    border: 1px solid #d5e4e9;
    border-radius: 8px;
    padding: 11px 12px;
    color: #30485d;
    background: #fff;
    font-size: 13px;
    outline: none;
    transition: .2s;
}

.eu-field input:focus,
.eu-field select:focus {
    border-color: #00a8c8;
    box-shadow: 0 0 0 3px rgba(0,168,200,.10);
}

.eu-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #edf3f5;
}

.eu-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 0;
    border-radius: 8px;
    padding: 11px 18px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    cursor: pointer;
}

.eu-btn-cancel {
    color: #607d8b;
    background: #edf2f4;
}

.eu-btn-save {
    color: #fff;
    background: #00a4c4;
}

.eu-btn-save:hover {
    background: #008eaa;
}

.eu-alert {
    border-radius: 8px;
    padding: 11px 14px;
    margin-bottom: 20px;
    font-size: 12px;
    font-weight: 600;
}

.eu-alert-success {
    color: #246b2a;
    background: #e7f6e9;
    border: 1px solid #c8e8cc;
}

.eu-alert-danger {
    color: #9b2525;
    background: #fdeaea;
    border: 1px solid #f4cccc;
}

@media (max-width: 700px) {

    .editar-usuario {
        padding: 15px;
    }

    .eu-grid {
        grid-template-columns: 1fr;
    }

    .eu-field.full {
        grid-column: auto;
    }

    .eu-actions {
        flex-direction: column;
    }

    .eu-btn {
        width: 100%;
        justify-content: center;
    }
}

</style>


<div class="editar-usuario">

    <!-- =====================================================
         ENCABEZADO
         ===================================================== -->

    <div class="eu-header">

        <div>

            <h1 class="eu-title">
                <i class="fas fa-user-pen me-2"></i>
                Editar Usuario
            </h1>

            <p class="eu-subtitle">
                Actualiza la información de tu usuario.
            </p>

        </div>

        <a
            href="index.php?pg=perfilUsuario"
            class="eu-back"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Volver al Perfil
        </a>

    </div>


    <!-- =====================================================
         FORMULARIO
         ===================================================== -->

    <div class="eu-card">

        <div class="eu-card-header">

            <h2>
                <i class="fas fa-id-card"></i>
                Información del usuario
            </h2>

        </div>

        <div class="eu-body">

            <?php if ($mensaje !== '') { ?>

                <div
                    class="eu-alert eu-alert-<?= $tipoMensaje; ?>"
                >

                    <?php if ($tipoMensaje === 'success') { ?>

                        <i class="fas fa-circle-check me-1"></i>

                    <?php } else { ?>

                        <i class="fas fa-circle-exclamation me-1"></i>

                    <?php } ?>

                    <?= htmlspecialchars($mensaje); ?>

                </div>

            <?php } ?>


            <!-- Perfil -->
            <div class="eu-profile">

                <div class="eu-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <div>

                    <div class="eu-name">
                        <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?>
                    </div>

                    <div class="eu-id">
                        Usuario #<?= htmlspecialchars($usuario['id_usuario']); ?>
                        · <?= htmlspecialchars($usuario['rol']); ?>
                    </div>

                </div>

            </div>


            <form
                method="POST"
                action="index.php?pg=editarUsuario"
            >

                <input
                    type="hidden"
                    name="id_usuario"
                    value="<?= htmlspecialchars($usuario['id_usuario']); ?>"
                >

                <div class="eu-grid">

                    <!-- Nombre -->
                    <div class="eu-field">

                        <label>
                            Nombre <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="<?= htmlspecialchars($usuario['nombre']); ?>"
                            required
                        >

                    </div>


                    <!-- Apellidos -->
                    <div class="eu-field">

                        <label>
                            Apellidos <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="apellidos"
                            value="<?= htmlspecialchars($usuario['apellidos']); ?>"
                            required
                        >

                    </div>


                    <!-- Correo -->
                    <div class="eu-field">

                        <label>
                            Correo electrónico <span>*</span>
                        </label>

                        <input
                            type="email"
                            name="correo"
                            value="<?= htmlspecialchars($usuario['correo']); ?>"
                            required
                        >

                    </div>


                    <!-- Teléfono -->
                    <div class="eu-field">

                        <label>
                            Teléfono
                        </label>

                        <input
                            type="tel"
                            name="telefono"
                            value="<?= htmlspecialchars($usuario['telefono'] ?? ''); ?>"
                        >

                    </div>


                    <!-- Rol (solo lectura) -->
                    <div class="eu-field">

                        <label>
                            Rol
                        </label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($usuario['rol']); ?>"
                            readonly
                        >

                    </div>

                </div>


                <!-- Botones -->
                <div class="eu-actions">

                    <a
                        href="index.php?pg=perfilUsuario"
                        class="eu-btn eu-btn-cancel"
                    >
                        <i class="fas fa-xmark me-1"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="eu-btn eu-btn-save"
                    >
                        <i class="fas fa-floppy-disk me-1"></i>
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
