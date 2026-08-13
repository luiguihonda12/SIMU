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
