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

        if ($controlador->actualizar($id, $datos)) {

            $mensaje = 'La PQRS fue actualizada correctamente.';
            $tipoMensaje = 'success';

        } else {

            $mensaje = 'No fue posible actualizar la PQRS.';
            $tipoMensaje = 'danger';
        }
    }
}

$pqrs = $controlador->mostrar($id);

// Si la PQRS no existe se muestra un mensaje de aviso
if ($pqrs === null) {
    echo '<div class="pqrs-pad">'
        . '<div class="pqrs-alert pqrs-alert-danger">'
        . 'No se encontró la PQRS solicitada.</div>'
        . '<a href="index.php?pg=gestionPQRS" class="pqrs-link">'
        . '<i class="fas fa-arrow-left me-1"></i> Volver a PQRS</a>'
        . '</div>';
    return;
}


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
                        class="pqrs-info-grid pqrs-mt20"
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