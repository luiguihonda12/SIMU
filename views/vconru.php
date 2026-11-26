<?php
/**
 * ============================================================
 * VISTA - CONSULTAR HORARIOS (CLIENTE)
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cconru.php';

$cConru = new Cconru();
$datConru = $cConru->index();

$horarios = $datConru['horarios'];
$resumen  = $datConru['resumen'];
$busqueda = $datConru['busqueda'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-clock"></i> Consultar Horarios</h1>
        <p class="dash-subtitle">Consulta los horarios de salida de cada ruta del Sistema Integrado de Movilidad Urbana</p>
    </header>

    <!-- Tarjetas de resumen -->
    <div class="dash-stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-route"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['totalRutas']; ?></span>
                <span class="stat-label">Rutas con horario</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <span class="stat-value"><?= $resumen['primerHorario'] ? htmlspecialchars($resumen['primerHorario']) : '--:--'; ?></span>
                <span class="stat-label">Primer horario</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-hourglass-end"></i></div>
            <div>
                <span class="stat-value"><?= $resumen['ultimoHorario'] ? htmlspecialchars($resumen['ultimoHorario']) : '--:--'; ?></span>
                <span class="stat-label">Último horario</span>
            </div>
        </div>
    </div>

    <!-- Buscador -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-magnifying-glass me-2"></i>Buscar por ruta</h3>
        </div>
        <form method="get" action="index.php" class="p-3">
            <input type="hidden" name="pg" value="horarios">
            <div class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label for="busqueda" class="form-label">Nombre de ruta, origen o destino</label>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" value="<?= htmlspecialchars($busqueda); ?>" placeholder="Ej: Norte, Centro">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de horarios -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-table me-2"></i>Horarios de rutas</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ruta</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Horario de salida</th>
                        <th>Busetas asignadas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($horarios) > 0) { ?>
                        <?php foreach ($horarios as $h) { ?>
                            <tr>
                                <td class="text-muted"><?= (int)$h['id_ruta']; ?></td>
                                <td><strong><?= htmlspecialchars($h['nombre']); ?></strong></td>
                                <td><?= htmlspecialchars($h['origen']); ?></td>
                                <td><?= htmlspecialchars($h['destino']); ?></td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-clock me-1"></i><?= htmlspecialchars($h['horario']); ?>
                                    </span>
                                </td>
                                <td><span class="rol-badge"><?= (int)$h['busetas']; ?></span></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No se encontraron horarios con ese criterio de búsqueda.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
