<?php
/**
 * ============================================================
 * VISTA 6 - EDITAR RUTAS
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cedrut.php';

$cEdrut = new Cedrut();
$datEdrut = $cEdrut->index();

$rutas   = $datEdrut['rutas'];
$ruta    = $datEdrut['ruta'];
$idRuta  = $datEdrut['idRuta'];
$mensaje = $datEdrut['mensaje'];
$tipo    = $datEdrut['tipo'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-edit"></i> Editar Rutas</h1>
        <p class="dash-subtitle">Actualice los datos basicos de una ruta ya registrada en el sistema</p>
    </header>

    <?php if ($mensaje != '') { ?>
        <div class="alert alert-<?= $tipo; ?>" role="alert">
            <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($mensaje); ?>
        </div>
    <?php } ?>

    <div class="dash-table-card">
        <div class="dash-table-header">
            <h3><i class="fas fa-route me-2"></i>Seleccione la ruta a editar</h3>
        </div>
        <form method="get" action="index.php" class="p-3">
            <input type="hidden" name="pg" value="editarRutas">
            <div class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label for="selRuta" class="form-label">Ruta</label>
                    <select name="id_ruta" id="selRuta" class="form-select">
                        <option value="">-- Seleccione una ruta --</option>
                        <?php foreach ($rutas as $r) { ?>
                            <option value="<?= (int)$r['id_ruta']; ?>" <?= ($idRuta == $r['id_ruta']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($r['nombre']); ?> (<?= htmlspecialchars($r['origen']); ?> - <?= htmlspecialchars($r['destino']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Cargar</button>
                </div>
            </div>
        </form>
    </div>

    <?php if (is_array($ruta)) { ?>
        <div class="dash-table-card mt-4">
            <div class="dash-table-header">
                <h3><i class="fas fa-pen-to-square me-2"></i>Datos de la ruta #<?= (int)$ruta['id_ruta']; ?></h3>
            </div>
            <form method="post" action="index.php?pg=editarRutas" class="p-3">
                <input type="hidden" name="ope" value="3">
                <input type="hidden" name="id_ruta" value="<?= (int)$ruta['id_ruta']; ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre de la ruta</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" value="<?= htmlspecialchars($ruta['nombre']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="horario" class="form-label">Horario de salida</label>
                        <input type="time" class="form-control" id="horario" name="horario" value="<?= htmlspecialchars($ruta['horario']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="origen" class="form-label">Origen</label>
                        <input type="text" class="form-control" id="origen" name="origen" maxlength="100" value="<?= htmlspecialchars($ruta['origen']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="destino" class="form-label">Destino</label>
                        <input type="text" class="form-control" id="destino" name="destino" maxlength="100" value="<?= htmlspecialchars($ruta['destino']); ?>" required>
                    </div>
                </div>
                <div class="dash-actions mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar cambios</button>
                    <a href="index.php?pg=listadoRutas" class="btn btn-outline-simu ms-2"><i class="fas fa-list me-2"></i>Ver listado</a>
                </div>
            </form>
        </div>
    <?php } else { ?>
        <div class="dash-table-card mt-4">
            <p class="text-center text-muted py-4 mb-0">Seleccione una ruta para habilitar el formulario de edicion.</p>
        </div>
    <?php } ?>
</div>