<?php
/**
 * ============================================================
 * VISTA - CONSULTAR RUTAS (CLIENTE)
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cconsul.php';

$cConsul = new Cconsul();
$datConsul = $cConsul->index();

$rutas    = $datConsul['rutas'];
$resumen  = $datConsul['resumen'];
$busqueda = $datConsul['busqueda'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-route"></i> Consultar Rutas</h1>
        <p class="dash-subtitle">Busca y consulta las rutas disponibles en el Sistema Integrado de Movilidad Urbana</p>
    </header>

    <!-- Tarjetas de resumen -->
    <div class="dash-stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-route"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['rutas']; ?></span>
                <span class="stat-label">Rutas disponibles</span>
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
            <div class="stat-icon"><i class="fas fa-bus"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['busetasActivas']; ?></span>
                <span class="stat-label">Busetas activas</span>
            </div>
        </div>
    </div>

    <!-- Buscador -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-magnifying-glass me-2"></i>Buscar ruta</h3>
        </div>
        <form method="get" action="index.php" class="p-3">
            <input type="hidden" name="pg" value="consultarRutas">
            <div class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label for="busqueda" class="form-label">Nombre, origen o destino</label>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" value="<?= htmlspecialchars($busqueda); ?>" placeholder="Ej: Centro, Terminal, Universidad">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de rutas -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-table me-2"></i>Rutas disponibles</h3>
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
                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($r['horario']); ?></span></td>
                                <td><span class="rol-badge"><?= (int)$r['paraderos']; ?></span></td>
                                <td><span class="rol-badge"><?= (int)$r['busetas']; ?></span></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No se encontraron rutas con ese criterio de búsqueda.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
