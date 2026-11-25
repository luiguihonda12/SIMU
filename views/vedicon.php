<?php
require_once __DIR__ . '/../controllers/cedicon.php';
$controlador = new Cedicon();

$mensaje = '';
$tipoMensaje = '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($id)) {
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

    if ($datos['nombre'] === '' || $datos['documento'] === '' || $datos['telefono'] === '' || $datos['correo'] === '') {
        $mensaje = 'Por favor completa los campos obligatorios (*).';
        $tipoMensaje = 'danger';
    } else {
        if ($controlador->actualizar($datos)) {
            $mensaje = 'Los datos del conductor fueron actualizados y conectados correctamente.';
            $tipoMensaje = 'success';
        } else {
            $mensaje = 'No fue posible actualizar los datos.';
            $tipoMensaje = 'warning';
        }
    }
}

$listaConductores = $controlador->listarConductores();
$conductor = !empty($id) ? $controlador->mostrar($id) : null;
$usuariosConductores = $controlador->usuariosConductores();
?>

<div class="container py-2">
    <!-- Selector de Conductor -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-3">
                    <label for="selectorConductor" class="form-label fw-bold text-dark mb-1 mb-md-0">
                        <i class="fas fa-user-pen text-primary me-1"></i> Seleccionar Conductor:
                    </label>
                </div>
                <div class="col-12 col-md-9">
                    <select id="selectorConductor" class="form-select" onchange="if(this.value) { window.location.href='index.php?pg=editarConductor&id='+this.value; } else { window.location.href='index.php?pg=editarConductor'; }">
                        <option value="">-- Seleccione un conductor de la lista --</option>
                        <?php foreach ($listaConductores as $c) { ?>
                            <option value="<?= $c['id']; ?>" <?= (string)$c['id'] === (string)$id ? 'selected' : ''; ?>>
                                [ID: <?= $c['id']; ?>] <?= htmlspecialchars($c['nombre']); ?> (Licencia: <?= htmlspecialchars($c['licencia']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($id) || !$conductor) { ?>
        <!-- Mensaje cuando no hay conductor seleccionado -->
        <div class="card shadow-sm border-0 text-center p-5 bg-white">
            <div class="card-body">
                <div class="text-secondary mb-3">
                    <i class="fas fa-address-book fa-3x"></i>
                </div>
                <h4 class="fw-bold text-dark">Ningún conductor seleccionado para editar</h4>
                <p class="text-muted">Por favor, elija un conductor en el menú desplegable superior para cargar y modificar su información en tiempo real.</p>
            </div>
        </div>
    <?php } else { ?>

        <!-- Formulario de Edición -->
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 fs-6"><i class="fas fa-id-card me-2"></i> Editando a: <strong><?= htmlspecialchars($conductor['nombre']); ?></strong></h5>
            </div>
            <div class="card-body p-4 bg-white">
                <?php if ($mensaje !== '') { ?>
                    <div class="alert alert-<?= $tipoMensaje; ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($mensaje); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form method="POST" action="index.php?pg=editarConductor&id=<?= urlencode($id); ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($conductor['id'] ?? $id); ?>">

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($conductor['nombre'] ?? ''); ?>" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Documento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="documento" value="<?= htmlspecialchars($conductor['documento'] ?? ''); ?>" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="telefono" value="<?= htmlspecialchars($conductor['telefono'] ?? ''); ?>" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="correo" value="<?= htmlspecialchars($conductor['correo'] ?? ''); ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Usuario Vinculado</label>
                            <select name="id_usuario" class="form-select">
                                <option value="">-- Sin usuario vinculado --</option>
                                <?php foreach ($usuariosConductores as $uc) { ?>
                                    <option value="<?= htmlspecialchars($uc['id_usuario']); ?>" <?= !empty($conductor['id_usuario']) && (int)$conductor['id_usuario'] === (int)$uc['id_usuario'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($uc['nombre']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="form-text text-muted">El usuario seleccionado debe tener asignado el rol Conductor.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Número de Licencia</label>
                            <input type="text" class="form-control" name="licencia" value="<?= htmlspecialchars($conductor['licencia'] ?? ''); ?>">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Tipo de Licencia</label>
                            <select name="tipoLicencia" class="form-select">
                                <option value="Servicio Público" <?= ($conductor['tipoLicencia'] ?? '') === 'Servicio Público' ? 'selected' : ''; ?>>Servicio Público</option>
                                <option value="Particular" <?= ($conductor['tipoLicencia'] ?? '') === 'Particular' ? 'selected' : ''; ?>>Particular</option>
                                <option value="Especial" <?= ($conductor['tipoLicencia'] ?? '') === 'Especial' ? 'selected' : ''; ?>>Especial</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="Activo" <?= ($conductor['estado'] ?? '') === 'Activo' ? 'selected' : ''; ?>>Activo</option>
                                <option value="Inactivo" <?= ($conductor['estado'] ?? '') === 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                <option value="Suspendido" <?= ($conductor['estado'] ?? '') === 'Suspendido' ? 'selected' : ''; ?>>Suspendido</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Jornada</label>
                            <select name="jornada" class="form-select">
                                <option value="Mañana" <?= ($conductor['jornada'] ?? '') === 'Mañana' ? 'selected' : ''; ?>>Mañana</option>
                                <option value="Tarde" <?= ($conductor['jornada'] ?? '') === 'Tarde' ? 'selected' : ''; ?>>Tarde</option>
                                <option value="Noche" <?= ($conductor['jornada'] ?? '') === 'Noche' ? 'selected' : ''; ?>>Noche</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="index.php?pg=editarConductor" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>