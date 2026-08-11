<?php

require_once __DIR__ . '/../controllers/cdpqrs.php';

$controlador = new Cdpqrs();

$id = $_GET['id'] ?? null;

$mensaje = '';
$tipoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datos = [
        'estado' => trim($_POST['estado'] ?? ''),
        'prioridad' => trim($_POST['prioridad'] ?? ''),
        'funcionario' => trim($_POST['funcionario'] ?? ''),
        'respuesta' => trim($_POST['respuesta'] ?? '')
    ];

    if ($datos['estado'] === '') {

        $mensaje = 'Debes seleccionar un estado.';
        $tipoMensaje = 'danger';

    } else {

        if ($controlador->actualizar($datos)) {

            $mensaje = 'La PQRS fue actualizada correctamente.';
            $tipoMensaje = 'success';

        } else {

            $mensaje = 'No fue posible actualizar la PQRS.';
            $tipoMensaje = 'danger';
        }
    }
}

$pqrs = $controlador->mostrar($id);


// Estado visual
$estadoClase = 'pqrs-status-review';
$estadoIcono = 'fa-clock';

if ($pqrs['estado'] === 'Resuelta') {
    $estadoClase = 'pqrs-status-success';
    $estadoIcono = 'fa-circle-check';
}

if ($pqrs['estado'] === 'Rechazada') {
    $estadoClase = 'pqrs-status-danger';
    $estadoIcono = 'fa-circle-xmark';
}

?>

<style>

.pqrs-detail {
    padding: 25px;
    width: 100%;
}

.pqrs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 22px;
    flex-wrap: wrap;
}

.pqrs-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.pqrs-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.pqrs-back {
    color: #009bbd;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.pqrs-back:hover {
    color: #007f9b;
}

.pqrs-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.6fr) minmax(280px, .8fr);
    gap: 20px;
    align-items: start;
}

.pqrs-card {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(0,0,0,.05);
    overflow: hidden;
}

.pqrs-card-header {
    padding: 17px 20px;
    border-bottom: 1px solid #edf3f5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.pqrs-card-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 15px;
    font-weight: 800;
}

.pqrs-card-header i {
    color: #00a8c8;
    margin-right: 7px;
}

.pqrs-body {
    padding: 20px;
}

.pqrs-code {
    color: #009bbd;
    background: #e8f8fb;
    border-radius: 7px;
    padding: 6px 9px;
    font-size: 11px;
    font-weight: 800;
}

.pqrs-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.pqrs-info {
    background: #f7fbfc;
    border-radius: 9px;
    padding: 13px;
}

.pqrs-info-label {
    display: block;
    color: #90a4ae;
    font-size: 10px;
    text-transform: uppercase;
    font-weight: 800;
    margin-bottom: 5px;
}

.pqrs-info-value {
    display: block;
    color: #30485d;
    font-size: 13px;
    font-weight: 700;
}

.pqrs-description {
    margin-top: 18px;
    padding: 17px;
    background: #f8fbfc;
    border: 1px solid #edf3f5;
    border-radius: 10px;
}

.pqrs-description-title {
    color: #455a64;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 9px;
}

.pqrs-description-text {
    color: #526979;
    font-size: 13px;
    line-height: 1.6;
}

.pqrs-citizen {
    display: flex;
    align-items: center;
    gap: 13px;
}

.pqrs-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #e3f7fb;
    color: #009bbd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
    flex-shrink: 0;
}

.pqrs-citizen-name {
    color: #17324d;
    font-size: 14px;
    font-weight: 800;
}

.pqrs-citizen-data {
    color: #78909c;
    font-size: 11px;
    margin-top: 3px;
}

.pqrs-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 800;
}

.pqrs-status-review {
    color: #8a6500;
    background: #fff4d6;
}

.pqrs-status-success {
    color: #287b32;
    background: #e5f7e8;
}

.pqrs-status-danger {
    color: #a52b2b;
    background: #fde8e8;
}

.pqrs-side-section {
    margin-bottom: 20px;
}

.pqrs-side-section:last-child {
    margin-bottom: 0;
}

.pqrs-side-list {
    padding: 5px 20px 18px;
}

.pqrs-side-item {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid #edf3f5;
}

.pqrs-side-item:last-child {
    border-bottom: 0;
}

.pqrs-side-label {
    color: #90a4ae;
    font-size: 10px;
    font-weight: 700;
}

.pqrs-side-value {
    color: #30485d;
    font-size: 11px;
    font-weight: 800;
    text-align: right;
}

.pqrs-form {
    margin-top: 20px;
}

.pqrs-field {
    margin-bottom: 15px;
}

.pqrs-field label {
    display: block;
    color: #455a64;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 7px;
}

.pqrs-field select,
.pqrs-field textarea {
    width: 100%;
    border: 1px solid #d5e4e9;
    border-radius: 8px;
    padding: 10px 11px;
    color: #30485d;
    background: #fff;
    font-size: 12px;
    outline: none;
}

.pqrs-field select:focus,
.pqrs-field textarea:focus {
    border-color: #00a8c8;
    box-shadow: 0 0 0 3px rgba(0,168,200,.10);
}

.pqrs-field textarea {
    min-height: 120px;
    resize: vertical;
}

.pqrs-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 16px;
    border-top: 1px solid #edf3f5;
}

.pqrs-btn {
    border: 0;
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 11px;
    font-weight: 800;
    cursor: pointer;
    text-decoration: none;
}

.pqrs-btn-cancel {
    color: #607d8b;
    background: #edf2f4;
}

.pqrs-btn-save {
    color: #fff;
    background: #00a4c4;
}

.pqrs-btn-save:hover {
    background: #008eaa;
}

.pqrs-alert {
    padding: 11px 14px;
    border-radius: 8px;
    margin-bottom: 18px;
    font-size: 12px;
    font-weight: 600;
}

.pqrs-alert-success {
    color: #246b2a;
    background: #e7f6e9;
    border: 1px solid #c8e8cc;
}

.pqrs-alert-danger {
    color: #9b2525;
    background: #fdeaea;
    border: 1px solid #f4cccc;
}

@media (max-width: 900px) {

    .pqrs-layout {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 650px) {

    .pqrs-detail {
        padding: 15px;
    }

    .pqrs-info-grid {
        grid-template-columns: 1fr;
    }

    .pqrs-actions {
        flex-direction: column;
    }

    .pqrs-btn {
        width: 100%;
        text-align: center;
    }

}

</style>


<div class="pqrs-detail">

    <!-- // Encabezado -->
    <div class="pqrs-header">

        <div>

            <h1 class="pqrs-title">
                <i class="fas fa-file-circle-question me-2"></i>
                Detalle PQRS
            </h1>

            <p class="pqrs-subtitle">
                Consulta y gestiona la información de la solicitud ciudadana.
            </p>

        </div>

        <a
            href="index.php?pg=gestionPQRS"
            class="pqrs-back"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Volver a PQRS
        </a>

    </div>


    <div class="pqrs-layout">

        <!-- // Información principal -->
        <div>

            <div class="pqrs-card">

                <div class="pqrs-card-header">

                    <h2>
                        <i class="fas fa-file-lines"></i>
                        Información de la solicitud
                    </h2>

                    <span class="pqrs-code">
                        <?= htmlspecialchars($pqrs['id']); ?>
                    </span>

                </div>


                <div class="pqrs-body">

                    <?php if ($mensaje !== '') { ?>

                        <div class="pqrs-alert pqrs-alert-<?= $tipoMensaje; ?>">

                            <?php if ($tipoMensaje === 'success') { ?>

                                <i class="fas fa-circle-check me-1"></i>

                            <?php } else { ?>

                                <i class="fas fa-circle-exclamation me-1"></i>

                            <?php } ?>

                            <?= htmlspecialchars($mensaje); ?>

                        </div>

                    <?php } ?>


                    <!-- // Ciudadano -->
                    <div class="pqrs-citizen">

                        <div class="pqrs-avatar">

                            <i class="fas fa-user"></i>

                        </div>

                        <div>

                            <div class="pqrs-citizen-name">

                                <?= htmlspecialchars($pqrs['nombre']); ?>

                            </div>

                            <div class="pqrs-citizen-data">

                                <?= htmlspecialchars($pqrs['documento']); ?>

                                ·

                                <?= htmlspecialchars($pqrs['correo']); ?>

                                ·

                                <?= htmlspecialchars($pqrs['telefono']); ?>

                            </div>

                        </div>

                    </div>


                    <!-- // Datos -->
                    <div
                        class="pqrs-info-grid"
                        style="margin-top:20px;"
                    >

                        <div class="pqrs-info">

                            <span class="pqrs-info-label">
                                Tipo de solicitud
                            </span>

                            <span class="pqrs-info-value">
                                <?= htmlspecialchars($pqrs['tipo']); ?>
                            </span>

                        </div>


                        <div class="pqrs-info">

                            <span class="pqrs-info-label">
                                Categoría
                            </span>

                            <span class="pqrs-info-value">
                                <?= htmlspecialchars($pqrs['categoria']); ?>
                            </span>

                        </div>


                        <div class="pqrs-info">

                            <span class="pqrs-info-label">
                                Fecha
                            </span>

                            <span class="pqrs-info-value">
                                <?= htmlspecialchars($pqrs['fecha']); ?>
                                ·
                                <?= htmlspecialchars($pqrs['hora']); ?>
                            </span>

                        </div>


                        <div class="pqrs-info">

                            <span class="pqrs-info-label">
                                Prioridad
                            </span>

                            <span class="pqrs-info-value">
                                <?= htmlspecialchars($pqrs['prioridad']); ?>
                            </span>

                        </div>

                    </div>


                    <!-- // Asunto -->
                    <div class="pqrs-description">

                        <div class="pqrs-description-title">
                            <i class="fas fa-heading me-1"></i>
                            Asunto
                        </div>

                        <div class="pqrs-description-text">

                            <?= htmlspecialchars($pqrs['asunto']); ?>

                        </div>

                    </div>


                    <!-- // Descripción -->
                    <div class="pqrs-description">

                        <div class="pqrs-description-title">
                            <i class="fas fa-align-left me-1"></i>
                            Descripción de la solicitud
                        </div>

                        <div class="pqrs-description-text">

                            <?= htmlspecialchars($pqrs['descripcion']); ?>

                        </div>

                    </div>


                    <!-- // Respuesta anterior -->
                    <?php if ($pqrs['respuesta'] !== '') { ?>

                        <div class="pqrs-description">

                            <div class="pqrs-description-title">
                                <i class="fas fa-reply me-1"></i>
                                Respuesta registrada
                            </div>

                            <div class="pqrs-description-text">

                                <?= htmlspecialchars($pqrs['respuesta']); ?>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>


        <!-- // Panel lateral -->
        <div>


            <!-- // Estado -->
            <div class="pqrs-card pqrs-side-section">

                <div class="pqrs-card-header">

                    <h2>
                        <i class="fas fa-circle-info"></i>
                        Estado
                    </h2>

                </div>

                <div class="pqrs-body text-center">

                    <span class="pqrs-status <?= $estadoClase; ?>">

                        <i class="fas <?= $estadoIcono; ?>"></i>

                        <?= htmlspecialchars($pqrs['estado']); ?>

                    </span>

                </div>

            </div>


            <!-- // Datos adicionales -->
            <div class="pqrs-card pqrs-side-section">

                <div class="pqrs-card-header">

                    <h2>
                        <i class="fas fa-list-check"></i>
                        Seguimiento
                    </h2>

                </div>


                <div class="pqrs-side-list">

                    <div class="pqrs-side-item">

                        <span class="pqrs-side-label">
                            Código
                        </span>

                        <span class="pqrs-side-value">
                            <?= htmlspecialchars($pqrs['id']); ?>
                        </span>

                    </div>


                    <div class="pqrs-side-item">

                        <span class="pqrs-side-label">
                            Prioridad
                        </span>

                        <span class="pqrs-side-value">
                            <?= htmlspecialchars($pqrs['prioridad']); ?>
                        </span>

                    </div>


                    <div class="pqrs-side-item">

                        <span class="pqrs-side-label">
                            Responsable
                        </span>

                        <span class="pqrs-side-value">
                            <?= htmlspecialchars($pqrs['funcionario']); ?>
                        </span>

                    </div>


                    <div class="pqrs-side-item">

                        <span class="pqrs-side-label">
                            Fecha recibida
                        </span>

                        <span class="pqrs-side-value">
                            <?= htmlspecialchars($pqrs['fecha']); ?>
                        </span>

                    </div>

                </div>

            </div>


            <!-- // Actualizar PQRS -->
            <div class="pqrs-card">

                <div class="pqrs-card-header">

                    <h2>
                        <i class="fas fa-pen-to-square"></i>
                        Gestionar PQRS
                    </h2>

                </div>


                <div class="pqrs-body">

                    <form
                        method="POST"
                        action="index.php?pg=detallePQRS&id=<?= urlencode($pqrs['id']); ?>"
                    >

                        <div class="pqrs-field">

                            <label>
                                Estado
                            </label>

                            <select name="estado">

                                <option
                                    value="En revisión"
                                    <?= $pqrs['estado'] === 'En revisión' ? 'selected' : ''; ?>
                                >
                                    En revisión
                                </option>

                                <option
                                    value="En proceso"
                                    <?= $pqrs['estado'] === 'En proceso' ? 'selected' : ''; ?>
                                >
                                    En proceso
                                </option>

                                <option
                                    value="Resuelta"
                                    <?= $pqrs['estado'] === 'Resuelta' ? 'selected' : ''; ?>
                                >
                                    Resuelta
                                </option>

                                <option
                                    value="Rechazada"
                                    <?= $pqrs['estado'] === 'Rechazada' ? 'selected' : ''; ?>
                                >
                                    Rechazada
                                </option>

                            </select>

                        </div>


                        <div class="pqrs-field">

                            <label>
                                Prioridad
                            </label>

                            <select name="prioridad">

                                <option
                                    value="Baja"
                                    <?= $pqrs['prioridad'] === 'Baja' ? 'selected' : ''; ?>
                                >
                                    Baja
                                </option>

                                <option
                                    value="Media"
                                    <?= $pqrs['prioridad'] === 'Media' ? 'selected' : ''; ?>
                                >
                                    Media
                                </option>

                                <option
                                    value="Alta"
                                    <?= $pqrs['prioridad'] === 'Alta' ? 'selected' : ''; ?>
                                >
                                    Alta
                                </option>

                            </select>

                        </div>


                        <div class="pqrs-field">

                            <label>
                                Funcionario responsable
                            </label>

                            <select name="funcionario">

                                <option value="Sin asignar">
                                    Sin asignar
                                </option>

                                <option
                                    value="Administrador SIMU"
                                    <?= $pqrs['funcionario'] === 'Administrador SIMU' ? 'selected' : ''; ?>
                                >
                                    Administrador SIMU
                                </option>

                                <option
                                    value="Gestor de Movilidad"
                                    <?= $pqrs['funcionario'] === 'Gestor de Movilidad' ? 'selected' : ''; ?>
                                >
                                    Gestor de Movilidad
                                </option>

                            </select>

                        </div>


                        <div class="pqrs-field">

                            <label>
                                Respuesta
                            </label>

                            <textarea
                                name="respuesta"
                                placeholder="Escribe la respuesta para el ciudadano..."
                            ><?= htmlspecialchars($pqrs['respuesta']); ?></textarea>

                        </div>


                        <div class="pqrs-actions">

                            <a
                                href="index.php?pg=gestionPQRS"
                                class="pqrs-btn pqrs-btn-cancel"
                            >
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="pqrs-btn pqrs-btn-save"
                            >
                                <i class="fas fa-save me-1"></i>
                                Guardar
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>