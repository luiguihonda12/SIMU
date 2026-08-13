<?php

require_once __DIR__ . '/../controllers/cedicon.php';

$controlador = new Cedicon();

$mensaje = '';
$tipoMensaje = '';

$id = $_GET['id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datos = [
        'id' => trim($_POST['id'] ?? ''),
        'nombre' => trim($_POST['nombre'] ?? ''),
        'documento' => trim($_POST['documento'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'correo' => trim($_POST['correo'] ?? ''),
        'licencia' => trim($_POST['licencia'] ?? ''),
        'tipoLicencia' => trim($_POST['tipoLicencia'] ?? ''),
        'estado' => trim($_POST['estado'] ?? ''),
        'jornada' => trim($_POST['jornada'] ?? ''),
        'id_usuario' => trim($_POST['id_usuario'] ?? '')
    ];

    if (
        $datos['nombre'] === '' ||
        $datos['documento'] === '' ||
        $datos['telefono'] === '' ||
        $datos['correo'] === ''
    ) {

        $mensaje = 'Por favor completa los campos obligatorios.';
        $tipoMensaje = 'danger';

    } else {

        if ($controlador->actualizar($datos)) {

            $mensaje = 'Los datos del conductor fueron actualizados correctamente.';
            $tipoMensaje = 'success';

        } else {

            $mensaje = 'No fue posible actualizar los datos.';
            $tipoMensaje = 'danger';
        }
    }
}

$conductor = $controlador->mostrar($id);

if (!$conductor) {
    $conductor = [
        'id' => $id,
        'nombre' => 'Conductor no encontrado',
        'documento' => '',
        'telefono' => '',
        'correo' => '',
        'licencia' => '',
        'tipoLicencia' => 'Servicio Público',
        'estado' => 'Activo',
        'jornada' => 'Mañana',
        'id_usuario' => null
    ];
}

$usuariosConductores = $controlador->usuariosConductores();

?>


<div class="editar-conductor">

    <!-- // Encabezado -->
    <div class="ec-header">

        <div>

            <h1 class="ec-title">
                <i class="fas fa-user-pen me-2"></i>
                Editar Conductor
            </h1>

            <p class="ec-subtitle">
                Actualiza la información del conductor seleccionado.
            </p>

        </div>

        <a
            href="index.php?pg=conductor"
            class="ec-back"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Volver a Conductores
        </a>

    </div>


    <!-- // Formulario -->
    <div class="ec-card">

        <div class="ec-card-header">

            <h2>
                <i class="fas fa-id-card"></i>
                Información del conductor
            </h2>

        </div>


        <div class="ec-body">

            <?php if ($mensaje !== '') { ?>

                <div
                    class="ec-alert ec-alert-<?= $tipoMensaje; ?>"
                >

                    <?php if ($tipoMensaje === 'success') { ?>

                        <i class="fas fa-circle-check me-1"></i>

                    <?php } else { ?>

                        <i class="fas fa-circle-exclamation me-1"></i>

                    <?php } ?>

                    <?= htmlspecialchars($mensaje); ?>

                </div>

            <?php } ?>


            <!-- // Perfil -->
            <div class="ec-profile">

                <div class="ec-avatar">

                    <i class="fas fa-user"></i>

                </div>

                <div>

                    <div class="ec-name">

                        <?= htmlspecialchars($conductor['nombre']); ?>

                    </div>

                    <div class="ec-id">

                        Conductor #<?= htmlspecialchars($conductor['id']); ?>

                    </div>

                </div>

            </div>


            <form
                method="POST"
                action="index.php?pg=editarConductor&id=<?= urlencode($id); ?>"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($conductor['id'] ?? $id); ?>"
                >

                <div class="ec-grid">


                    <!-- // Nombre -->
                    <div class="ec-field">

                        <label>
                            Nombre completo <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="<?= htmlspecialchars($conductor['nombre'] ?? ''); ?>"
                            required
                        >

                    </div>


                    <!-- // Documento -->
                    <div class="ec-field">

                        <label>
                            Documento <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="documento"
                            value="<?= htmlspecialchars($conductor['documento']); ?>"
                            required
                        >

                    </div>


                    <!-- // Teléfono -->
                    <div class="ec-field">

                        <label>
                            Teléfono <span>*</span>
                        </label>

                        <input
                            type="tel"
                            name="telefono"
                            value="<?= htmlspecialchars($conductor['telefono']); ?>"
                            required
                        >

                    </div>


                    <!-- // Correo -->
                    <div class="ec-field">

                        <label>
                            Correo electrónico <span>*</span>
                        </label>

                        <input
                            type="email"
                            name="correo"
                            value="<?= htmlspecialchars($conductor['correo'] ?? ''); ?>"
                            required
                        >

                    </div>


                    <!-- // Usuario vinculado -->
                    <div class="ec-field full">

                        <label>
                            Usuario vinculado
                        </label>

                        <select name="id_usuario">

                            <option value="">
                                -- Sin usuario vinculado --
                            </option>

                            <?php foreach ($usuariosConductores as $uc) { ?>

                                <option
                                    value="<?= htmlspecialchars($uc['id_usuario']); ?>"
                                    <?= !empty($conductor['id_usuario']) && (int)$conductor['id_usuario'] === (int)$uc['id_usuario'] ? 'selected' : ''; ?>
                                >
                                    <?= htmlspecialchars($uc['nombre']); ?>
                                </option>

                            <?php } ?>

                        </select>

                        <small>
                            El usuario seleccionado debe tener el rol Conductor.
                        </small>

                    </div>


                    <!-- // Licencia -->
                    <div class="ec-field">

                        <label>
                            Número de licencia
                        </label>

                        <input
                            type="text"
                            name="licencia"
                            value="<?= htmlspecialchars($conductor['licencia']); ?>"
                        >

                    </div>


                    <!-- // Tipo de licencia -->
                    <div class="ec-field">

                        <label>
                            Tipo de licencia
                        </label>

                        <select name="tipoLicencia">

                            <option
                                value="Servicio Público"
                                <?= $conductor['tipoLicencia'] === 'Servicio Público' ? 'selected' : ''; ?>
                            >
                                Servicio Público
                            </option>

                            <option
                                value="Particular"
                                <?= $conductor['tipoLicencia'] === 'Particular' ? 'selected' : ''; ?>
                            >
                                Particular
                            </option>

                            <option
                                value="Especial"
                                <?= $conductor['tipoLicencia'] === 'Especial' ? 'selected' : ''; ?>
                            >
                                Especial
                            </option>

                        </select>

                    </div>


                    <!-- // Estado -->
                    <div class="ec-field">

                        <label>
                            Estado
                        </label>

                        <select name="estado">

                            <option
                                value="Activo"
                                <?= $conductor['estado'] === 'Activo' ? 'selected' : ''; ?>
                            >
                                Activo
                            </option>

                            <option
                                value="Inactivo"
                                <?= $conductor['estado'] === 'Inactivo' ? 'selected' : ''; ?>
                            >
                                Inactivo
                            </option>

                            <option
                                value="Suspendido"
                                <?= $conductor['estado'] === 'Suspendido' ? 'selected' : ''; ?>
                            >
                                Suspendido
                            </option>

                        </select>

                    </div>


                    <!-- // Jornada -->
                    <div class="ec-field">

                        <label>
                            Jornada
                        </label>

                        <select name="jornada">

                            <option
                                value="Mañana"
                                <?= $conductor['jornada'] === 'Mañana' ? 'selected' : ''; ?>
                            >
                                Mañana
                            </option>

                            <option
                                value="Tarde"
                                <?= $conductor['jornada'] === 'Tarde' ? 'selected' : ''; ?>
                            >
                                Tarde
                            </option>

                            <option
                                value="Noche"
                                <?= $conductor['jornada'] === 'Noche' ? 'selected' : ''; ?>
                            >
                                Noche
                            </option>

                        </select>

                    </div>

                </div>


                <!-- // Botones -->
                <div class="ec-actions">

                    <a
                        href="index.php?pg=conductor"
                        class="ec-btn ec-btn-cancel"
                    >
                        <i class="fas fa-xmark me-1"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="ec-btn ec-btn-save"
                    >
                        <i class="fas fa-floppy-disk me-1"></i>
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>