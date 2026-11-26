<?php
/**
 * ============================================================
 * VISTA - VER PARADEROS (CLIENTE)
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cverpara.php';

$cVerpara = new Cverpara();
$datVerpara = $cVerpara->index();

$paraderos = $datVerpara['paraderos'];
$resumen   = $datVerpara['resumen'];
$busqueda  = $datVerpara['busqueda'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-map-marker-alt"></i> Ver Paraderos</h1>
        <p class="dash-subtitle">Consulta los paraderos disponibles y la ruta a la que pertenecen</p>
    </header>

    <!-- Tarjetas de resumen -->
    <div class="dash-stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['totalParaderos']; ?></span>
                <span class="stat-label">Total paraderos</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['conRuta']; ?></span>
                <span class="stat-label">Con ruta asignada</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['sinRuta']; ?></span>
                <span class="stat-label">Sin ruta asignada</span>
            </div>
        </div>
    </div>

    <!-- Buscador -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-magnifying-glass me-2"></i>Buscar paradero</h3>
        </div>
        <form method="get" action="index.php" class="p-3">
            <input type="hidden" name="pg" value="paraderos">
            <div class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label for="busqueda" class="form-label">Nombre del paradero, ubicación o ruta</label>
                    <input type="text" class="form-control" id="busqueda" name="busqueda" value="<?= htmlspecialchars($busqueda); ?>" placeholder="Ej: Principal, Parque, Norte">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de paraderos -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-table me-2"></i>Paraderos registrados</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Ruta asignada</th>
                        <th>Origen</th>
                        <th>Destino</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($paraderos) > 0) { ?>
                        <?php foreach ($paraderos as $p) { ?>
                            <tr>
                                <td class="text-muted"><?= (int)$p['id_paradero']; ?></td>
                                <td><strong><?= htmlspecialchars($p['nombre']); ?></strong></td>
                                <td><?= htmlspecialchars($p['ubicacion']); ?></td>
                                <td>
                                    <?php if ($p['ruta'] === 'Sin ruta asignada') { ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-circle me-1"></i><?= $p['ruta']; ?>
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-route me-1"></i><?= htmlspecialchars($p['ruta']); ?>
                                        </span>
                                    <?php } ?>
                                </td>
                                <td><?= htmlspecialchars($p['origen'] ?? '—'); ?></td>
                                <td><?= htmlspecialchars($p['destino'] ?? '—'); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No se encontraron paraderos con ese criterio de búsqueda.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
