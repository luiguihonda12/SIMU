<?php
/**
 * ============================================================
 * VISTA 9 - MODULO DE LISTADO DE RUTAS
 * ============================================================
 */
require_once __DIR__ . '/../controllers/clisru.php';

$cLisru = new Clisru();
$datLisru = $cLisru->index();

$rutas    = $datLisru['rutas'];
$resumen  = $datLisru['resumen'];
$busqueda = $datLisru['busqueda'];
$mensaje  = $datLisru['mensaje'];
$tipo     = $datLisru['tipo'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-list"></i> Modulo de Listado de Rutas</h1>
        <p class="dash-subtitle">Consulte las rutas registradas, sus paraderos y las busetas asignadas</p>
    </header>

    <?php if ($mensaje != '') { ?>
        <div class="alert alert-<?= $tipo; ?>" role="alert">
            <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($mensaje); ?>
        </div>
    <?php } ?>

    <div class="dash-stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-route"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['rutas']; ?></span>
                <span class="stat-label">Rutas registradas</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['paraderos']; ?></span>
                <span class="stat-label">Paraderos totales</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-triangle-exclamation"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['sinRuta']; ?></span>
                <span class="stat-label">Paraderos sin ruta</span>
            </div>
        </div>
    </div>

    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-magnifying-glass me-2"></i>Buscar ruta</h3>
        </div>
        <form method="get" action="index.php" class="p-3">
            <input type="hidden" name="pg" value="listadoRutas">
            <div class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label for="busqueda" class="form-label">Nombre, origen o destino</label>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" value="<?= htmlspecialchars($busqueda); ?>" placeholder="Ej: Centro">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-table me-2"></i>Rutas registradas</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ruta</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Horario</th>
                        <th>Paraderos</th>
                        <th>Busetas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($rutas) > 0) { ?>
                        <?php foreach ($rutas as $r) { ?>
                            <tr>
                                <td class="text-muted"><?= (int)$r['id_ruta']; ?></td>
                                <td><strong><?= htmlspecialchars($r['nombre']); ?></strong></td>
                                <td><?= htmlspecialchars($r['origen']); ?></td>
                                <td><?= htmlspecialchars($r['destino']); ?></td>
                                <td><?= htmlspecialchars($r['horario']); ?></td>
                                <td><span class="rol-badge"><?= (int)$r['paraderos']; ?></span></td>
                                <td><span class="rol-badge"><?= (int)$r['busetas']; ?></span></td>
                                <td>
                                    <a href="index.php?pg=edicionRuta&id_ruta=<?= (int)$r['id_ruta']; ?>" class="me-3" title="Editar ruta y recorrido">
                                        <i class="fa-solid fa-map-location-dot fa-lg"></i>
                                    </a>
                                    <a href="index.php?pg=listadoRutas&ope=4&id_ruta=<?= (int)$r['id_ruta']; ?>" title="Eliminar ruta" onclick="return confirm('Desea eliminar la ruta <?= htmlspecialchars(addslashes($r['nombre'])); ?>?')">
                                        <i class="fa-regular fa-trash-can fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No se encontraron rutas con ese criterio de busqueda.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>