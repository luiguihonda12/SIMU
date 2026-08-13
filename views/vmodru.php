<?php
/**
 * ============================================================
 * VISTA 8 - MODULO DE EDICION DE RUTA
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cmodru.php';

$cModru = new Cmodru();
$datModru = $cModru->index();

$rutas       = $datModru['rutas'];
$ruta        = $datModru['ruta'];
$idRuta      = $datModru['idRuta'];
$paraderos   = $datModru['paraderos'];
$disponibles = $datModru['disponibles'];
$paraEdit    = $datModru['paraEdit'];
$mensaje     = $datModru['mensaje'];
$tipo        = $datModru['tipo'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-route"></i> Modulo de Edicion de Ruta</h1>
        <p class="dash-subtitle">Actualice los datos de la ruta y administre los paraderos de su recorrido</p>
    </header>

    <?php if ($mensaje != '') { ?>
        <div class="alert alert-<?= $tipo; ?>" role="alert">
            <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($mensaje); ?>
        </div>
    <?php } ?>

    <div class="dash-table-card">
        <div class="dash-table-header">
            <h3><i class="fas fa-map-signs me-2"></i>Ruta de operacion</h3>
        </div>
        <form method="get" action="index.php" class="p-3">
            <input type="hidden" name="pg" value="edicionRuta">
            <div class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label for="selRuta" class="form-label">Seleccione la ruta</label>
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
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Cargar recorrido</button>
                </div>
            </div>
        </form>
    </div>

    <?php if (is_array($ruta)) { ?>
        <div class="dash-stats-row mt-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-route"></i></div>
                <div>
                    <span class="stat-value"><?= htmlspecialchars($ruta['nombre']); ?></span>
                    <span class="stat-label"><?= htmlspecialchars($ruta['origen']); ?> - <?= htmlspecialchars($ruta['destino']); ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <span class="stat-value"><?= count($paraderos); ?></span>
                    <span class="stat-label">Paraderos del recorrido</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <span class="stat-value"><?= htmlspecialchars($ruta['horario']); ?></span>
                    <span class="stat-label">Horario de salida</span>
                </div>
            </div>
        </div>

        <div class="dash-table-card mt-4">
            <div class="dash-table-header">
                <h3><i class="fas fa-pen-to-square me-2"></i>Datos de la ruta #<?= (int)$ruta['id_ruta']; ?></h3>
            </div>
            <form method="post" action="index.php?pg=edicionRuta" class="p-3">
                <input type="hidden" name="ope" value="5">
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
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar datos de la ruta</button>
                </div>
            </form>
        </div>

        <div class="dash-table-card mt-4">
            <div class="dash-table-header">
                <h3><i class="fas fa-plus-circle me-2"></i>Agregar paradero al recorrido</h3>
            </div>
            <form method="post" action="index.php?pg=edicionRuta" class="p-3">
                <input type="hidden" name="ope" value="1">
                <input type="hidden" name="id_ruta" value="<?= (int)$ruta['id_ruta']; ?>">
                <div class="row g-2 align-items-end">
                    <div class="col-md-9">
                        <label for="id_paradero" class="form-label">Paraderos existentes</label>
                        <select name="id_paradero" id="id_paradero" class="form-select">
                            <option value="">-- Seleccione un paradero --</option>
                            <?php foreach ($disponibles as $d) { ?>
                                <option value="<?= (int)$d['id_paradero']; ?>">
                                    <?= htmlspecialchars($d['nombre']); ?> - <?= htmlspecialchars($d['ubicacion']); ?>
                                    <?= ($d['ruta_actual'] != '') ? '[actualmente en: ' . htmlspecialchars($d['ruta_actual']) . ']' : '[sin ruta]'; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100" <?= (count($disponibles) == 0) ? 'disabled' : ''; ?>><i class="fas fa-plus me-2"></i>Agregar</button>
                    </div>
                </div>
                <?php if (count($disponibles) == 0) { ?>
                    <p class="text-muted mt-2 mb-0">No hay otros paraderos registrados. Puede crear uno nuevo en el formulario siguiente.</p>
                <?php } ?>
            </form>
        </div>

        <div class="dash-table-card mt-4">
            <div class="dash-table-header">
                <h3><i class="fas fa-map-pin me-2"></i>Crear paradero nuevo en esta ruta</h3>
            </div>
            <form method="post" action="index.php?pg=edicionRuta" class="p-3">
                <input type="hidden" name="ope" value="6">
                <input type="hidden" name="id_ruta" value="<?= (int)$ruta['id_ruta']; ?>">
                <div class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label for="nombre_nuevo" class="form-label">Nombre del paradero</label>
                        <input type="text" class="form-control" id="nombre_nuevo" name="nombre_par" maxlength="100" placeholder="Paradero Puente del Comun" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ubicacion_nuevo" class="form-label">Ubicacion</label>
                        <input type="text" class="form-control" id="ubicacion_nuevo" name="ubicacion_par" maxlength="150" placeholder="Autopista Norte Km 21" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-plus me-2"></i>Crear y agregar</button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (is_array($paraEdit)) { ?>
            <div class="dash-table-card mt-4">
                <div class="dash-table-header">
                    <h3><i class="fas fa-pen-to-square me-2"></i>Editando paradero #<?= (int)$paraEdit['id_paradero']; ?></h3>
                </div>
                <form method="post" action="index.php?pg=edicionRuta" class="p-3">
                    <input type="hidden" name="ope" value="3">
                    <input type="hidden" name="id_ruta" value="<?= (int)$ruta['id_ruta']; ?>">
                    <input type="hidden" name="id_paradero" value="<?= (int)$paraEdit['id_paradero']; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre_par" class="form-label">Nombre del paradero</label>
                            <input type="text" class="form-control" id="nombre_par" name="nombre_par" maxlength="100" value="<?= htmlspecialchars($paraEdit['nombre']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ubicacion_par" class="form-label">Ubicacion</label>
                            <input type="text" class="form-control" id="ubicacion_par" name="ubicacion_par" maxlength="150" value="<?= htmlspecialchars($paraEdit['ubicacion']); ?>" required>
                        </div>
                    </div>
                    <div class="dash-actions mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar paradero</button>
                        <a href="index.php?pg=edicionRuta&id_ruta=<?= (int)$ruta['id_ruta']; ?>" class="btn btn-outline-simu ms-2">Cancelar</a>
                    </div>
                </form>
            </div>
        <?php } ?>

        <div class="dash-table-card mt-4">
            <div class="dash-table-header">
                <h3><i class="fas fa-list-ol me-2"></i>Recorrido actual</h3>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Paradero</th>
                            <th>Ubicacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($paraderos) > 0) { ?>
                            <?php $orden = 1; ?>
                            <?php foreach ($paraderos as $p) { ?>
                                <tr>
                                    <td class="text-muted"><?= $orden++; ?></td>
                                    <td><strong><?= htmlspecialchars($p['nombre']); ?></strong></td>
                                    <td><?= htmlspecialchars($p['ubicacion']); ?></td>
                                    <td>
                                        <a href="index.php?pg=edicionRuta&ope=2&id_ruta=<?= (int)$ruta['id_ruta']; ?>&id_paradero=<?= (int)$p['id_paradero']; ?>" class="me-3" title="Editar paradero">
                                            <i class="fa-regular fa-pen-to-square fa-lg"></i>
                                        </a>
                                        <a href="index.php?pg=edicionRuta&ope=4&id_ruta=<?= (int)$ruta['id_ruta']; ?>&id_paradero=<?= (int)$p['id_paradero']; ?>" title="Retirar del recorrido" onclick="return confirm('Desea retirar el paradero <?= htmlspecialchars(addslashes($p['nombre'])); ?> del recorrido?')">
                                            <i class="fa-regular fa-circle-xmark fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Esta ruta aun no tiene paraderos asignados.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="dash-table-card mt-4">
            <p class="text-center text-muted py-4 mb-0">Seleccione una ruta para editar sus datos y administrar su recorrido.</p>
        </div>
    <?php } ?>
</div>
