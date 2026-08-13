<?php

require_once __DIR__ . '/../controllers/cdpqrs.php';

$controlador = new Cdpqrs();

$mensaje = '';
$tipoMensaje = '';
$nuevoId = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datos = [
        'nombre'      => trim($_POST['nombre'] ?? ''),
        'documento'   => trim($_POST['documento'] ?? ''),
        'correo'      => trim($_POST['correo'] ?? ''),
        'telefono'    => trim($_POST['telefono'] ?? ''),
        'tipo'        => trim($_POST['tipo'] ?? ''),
        'categoria'   => trim($_POST['categoria'] ?? ''),
        'prioridad'   => trim($_POST['prioridad'] ?? ''),
        'asunto'      => trim($_POST['asunto'] ?? ''),
        'descripcion' => trim($_POST['descripcion'] ?? '')
    ];

    if ($datos['nombre'] === '' || $datos['tipo'] === '' || $datos['categoria'] === ''
        || $datos['asunto'] === '' || $datos['descripcion'] === '') {

        $mensaje = 'Los campos obligatorios deben estar diligenciados.';
        $tipoMensaje = 'danger';

    } else {

        $nuevoId = $controlador->crear($datos);

        if ($nuevoId) {

            $mensaje = 'PQRS registrada correctamente.';
            $tipoMensaje = 'success';

        } else {

            $mensaje = 'No fue posible registrar la PQRS.';
            $tipoMensaje = 'danger';
        }
    }
}

?>


<div class="pqrs-new">

    <!-- // Encabezado -->
    <div class="pqrs-new-header">

        <h1 class="pqrs-new-title">
            <i class="fas fa-plus-circle me-2"></i>
            Nueva PQRS
        </h1>

        <p class="pqrs-new-subtitle">
            Registra una nueva solicitud ciudadana en el sistema.
        </p>

        <a
            href="index.php?pg=gestionPQRS"
            class="pqrs-new-back"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Volver a PQRS
        </a>

    </div>


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


    <?php if ($nuevoId) { ?>

        <div class="pqrs-card">

            <div class="pqrs-body text-center pqrs-success-body">

                <div
                    class="pqrs-success-icon"
                >
                    <i class="fas fa-circle-check"></i>
                </div>

                <h2 class="pqrs-success-title">
                    ¡PQRS registrada!
                </h2>

                <p
                    class="pqrs-success-desc"
                >
                    La solicitud fue registrada con el código
                    <strong class="pqrs-strong">
                        <?= htmlspecialchars($nuevoId); ?>
                    </strong>
                    y quedó en estado "En revisión".
                </p>

                <a
                    href="index.php?pg=detallePQRS&id=<?= urlencode($nuevoId); ?>"
                    class="pqrs-btn pqrs-btn-save"
                >
                    <i class="fas fa-eye me-1"></i>
                    Ver PQRS registrada
                </a>

            </div>

        </div>

    <?php } else { ?>


        <div class="pqrs-card">

            <div class="pqrs-card-header">

                <h2>
                    <i class="fas fa-file-circle-plus"></i>
                    Datos de la solicitud
                </h2>

            </div>


            <div class="pqrs-body">

                <form method="POST" action="index.php?pg=nuevaPQRS">

                    <div class="pqrs-form">

                        <div class="pqrs-field">
                            <label>Nombre completo <span class="pqrs-required">*</span></label>
                            <input type="text" name="nombre" placeholder="María González">
                        </div>

                        <div class="pqrs-field">
                            <label>Documento</label>
                            <input type="text" name="documento" placeholder="1.023.456.789">
                        </div>

                        <div class="pqrs-field">
                            <label>Correo electrónico</label>
                            <input type="email" name="correo" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="pqrs-field">
                            <label>Teléfono</label>
                            <input type="tel" name="telefono" placeholder="300 123 4567">
                        </div>

                        <div class="pqrs-field">
                            <label>Tipo de solicitud <span class="pqrs-required">*</span></label>
                            <select name="tipo">
                                <option value="Petición">Petición</option>
                                <option value="Queja">Queja</option>
                                <option value="Reclamo">Reclamo</option>
                                <option value="Solicitud">Solicitud</option>
                                <option value="Sugerencia">Sugerencia</option>
                            </select>
                        </div>

                        <div class="pqrs-field">
                            <label>Categoría <span class="pqrs-required">*</span></label>
                            <select name="categoria">
                                <option value="Servicio de transporte">Servicio de transporte</option>
                                <option value="Ruta y horarios">Ruta y horarios</option>
                                <option value="Paraderos">Paraderos</option>
                                <option value="Tarifas">Tarifas</option>
                                <option value="Conductores">Conductores</option>
                                <option value="General">General</option>
                            </select>
                        </div>

                        <div class="pqrs-field">
                            <label>Prioridad</label>
                            <select name="prioridad">
                                <option value="Baja">Baja</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>

                        <div class="pqrs-field">
                            <label>Asunto <span class="pqrs-required">*</span></label>
                            <input type="text" name="asunto" placeholder="Resumen del motivo de la solicitud">
                        </div>

                        <div class="pqrs-field pqrs-full">
                            <label>Descripción <span class="pqrs-required">*</span></label>
                            <textarea name="descripcion" placeholder="Describe con detalle la situación..."></textarea>
                        </div>

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
                            <i class="fas fa-check me-1"></i>
                            Registrar PQRS
                        </button>

                    </div>

                </form>

            </div>

        </div>

    <?php } ?>

</div>
