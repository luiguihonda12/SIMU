<?php

require_once __DIR__ . '/../controllers/cedicon.php';

$controlador = new Cedicon();

$mensaje = '';
$tipoMensaje = '';

$id = $_GET['id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datos = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'documento' => trim($_POST['documento'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'correo' => trim($_POST['correo'] ?? ''),
        'licencia' => trim($_POST['licencia'] ?? ''),
        'tipoLicencia' => trim($_POST['tipoLicencia'] ?? ''),
        'estado' => trim($_POST['estado'] ?? ''),
        'jornada' => trim($_POST['jornada'] ?? '')
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

?>

<style>

.editar-conductor {
    padding: 25px;
    width: 100%;
}

.ec-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    gap: 15px;
    flex-wrap: wrap;
}

.ec-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.ec-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.ec-back {
    color: #009bbd;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.ec-back:hover {
    color: #007f9b;
}

.ec-card {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(0,0,0,.05);
    overflow: hidden;
}

.ec-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid #edf3f5;
}

.ec-card-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
}

.ec-card-header i {
    color: #00a8c8;
    margin-right: 7px;
}

.ec-body {
    padding: 22px;
}

.ec-profile {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 25px;
    padding: 15px;
    background: #f5fbfc;
    border-radius: 11px;
}

.ec-avatar {
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

.ec-name {
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
}

.ec-id {
    color: #78909c;
    font-size: 11px;
    margin-top: 3px;
}

.ec-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

.ec-field {
    display: flex;
    flex-direction: column;
}

.ec-field.full {
    grid-column: 1 / -1;
}

.ec-field label {
    color: #455a64;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 7px;
}

.ec-field label span {
    color: #e53935;
}

.ec-field input,
.ec-field select {
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

.ec-field input:focus,
.ec-field select:focus {
    border-color: #00a8c8;
    box-shadow: 0 0 0 3px rgba(0,168,200,.10);
}

.ec-field small {
    color: #90a4ae;
    font-size: 10px;
    margin-top: 5px;
}

.ec-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #edf3f5;
}

.ec-btn {
    border: 0;
    border-radius: 8px;
    padding: 11px 18px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    cursor: pointer;
}

.ec-btn-cancel {
    color: #607d8b;
    background: #edf2f4;
}

.ec-btn-save {
    color: #fff;
    background: #00a4c4;
}

.ec-btn-save:hover {
    background: #008eaa;
}

.ec-alert {
    border-radius: 8px;
    padding: 11px 14px;
    margin-bottom: 20px;
    font-size: 12px;
    font-weight: 600;
}

.ec-alert-success {
    color: #246b2a;
    background: #e7f6e9;
    border: 1px solid #c8e8cc;
}

.ec-alert-danger {
    color: #9b2525;
    background: #fdeaea;
    border: 1px solid #f4cccc;
}

@media (max-width: 700px) {

    .editar-conductor {
        padding: 15px;
    }

    .ec-grid {
        grid-template-columns: 1fr;
    }

    .ec-field.full {
        grid-column: auto;
    }

    .ec-actions {
        flex-direction: column;
    }

    .ec-btn {
        width: 100%;
        text-align: center;
    }
}

</style>


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

                <div class="ec-grid">


                    <!-- // Nombre -->
                    <div class="ec-field">

                        <label>
                            Nombre completo <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="<?= htmlspecialchars($conductor['nombre']); ?>"
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
                            value="<?= htmlspecialchars($conductor['correo']); ?>"
                            required
                        >

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