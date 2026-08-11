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

<style>

.pqrs-new {
    padding: 25px;
    width: 100%;
    max-width: 860px;
    margin: 0 auto;
}

.pqrs-new-header {
    margin-bottom: 22px;
}

.pqrs-new-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.pqrs-new-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.pqrs-new-back {
    color: #009bbd;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.pqrs-new-back:hover {
    color: #007f9b;
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

.pqrs-form {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0 16px;
}

.pqrs-form .pqrs-full {
    grid-column: 1 / -1;
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

.pqrs-field input,
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

.pqrs-field input:focus,
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

@media (max-width: 650px) {

    .pqrs-new {
        padding: 15px;
    }

    .pqrs-form {
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

            <div class="pqrs-body text-center" style="padding:30px;">

                <div
                    style="font-size:3rem;color:#22c55e;margin-bottom:10px;"
                >
                    <i class="fas fa-circle-check"></i>
                </div>

                <h2 style="color:#17324d;font-size:18px;font-weight:800;">
                    ¡PQRS registrada!
                </h2>

                <p
                    style="color:#78909c;font-size:13px;margin:8px 0 18px;"
                >
                    La solicitud fue registrada con el código
                    <strong style="color:#008da9;">
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
                            <label>Nombre completo <span style="color:#d04444;">*</span></label>
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
                            <label>Tipo de solicitud <span style="color:#d04444;">*</span></label>
                            <select name="tipo">
                                <option value="Petición">Petición</option>
                                <option value="Queja">Queja</option>
                                <option value="Reclamo">Reclamo</option>
                                <option value="Solicitud">Solicitud</option>
                                <option value="Sugerencia">Sugerencia</option>
                            </select>
                        </div>

                        <div class="pqrs-field">
                            <label>Categoría <span style="color:#d04444;">*</span></label>
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
                            <label>Asunto <span style="color:#d04444;">*</span></label>
                            <input type="text" name="asunto" placeholder="Resumen del motivo de la solicitud">
                        </div>

                        <div class="pqrs-field pqrs-full">
                            <label>Descripción <span style="color:#d04444;">*</span></label>
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
