<?php
/**
 * ============================================================
 * VISTA 7 - REGISTRAR PARADEROS
 * ============================================================
 */
require_once __DIR__ . '/../controllers/crepar.php';

$cRepar = new Crepar();
$datRepar = $cRepar->index();

$rutas     = $datRepar['rutas'];
$paraderos = $datRepar['paraderos'];
$mensaje   = $datRepar['mensaje'];
$tipo      = $datRepar['tipo'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-map-marker-alt"></i> Registrar Paraderos</h1>
        <p class="dash-subtitle">Registre los puntos de parada del sistema y asocielos a una ruta si lo requiere</p>
    </header>

    <?php if ($mensaje != '') { ?>
        <div class="alert alert-<?= $tipo; ?>" role="alert">
            <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($mensaje); ?>
        </div>
    <?php } ?>

    <div class="dash-table-card">
        <div class="dash-table-header">
            <h3><i class="fas fa-plus-circle me-2"></i>Nuevo paradero</h3>
        </div>
        <form method="post" action="index.php?pg=registrarParaderos" class="p-3">
            <input type="hidden" name="ope" value="1">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre del paradero</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" placeholder="Paradero Puente del Comun" required>
                </div>
                <div class="col-md-4">
                    <label for="ubicacion" class="form-label">Ubicacion</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" maxlength="150" placeholder="Autopista Norte Km 21" required>
                </div>
                <div class="col-md-4">
                    <label for="id_ruta" class="form-label">Ruta asociada (opcional)</label>
                    <select name="id_ruta" id="id_ruta" class="form-select">
                        <option value="">-- Sin ruta asignada --</option>
                        <?php foreach ($rutas as $r) { ?>
                            <option value="<?= (int)$r['id_ruta']; ?>"><?= htmlspecialchars($r['nombre']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="dash-actions mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Registrar paradero</button>
            </div>
            <p class="text-muted mt-2 mb-0">Los paraderos sin ruta quedan disponibles para asignarse desde el Modulo de Edicion de Ruta.</p>
        </form>
    </div>

    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-table me-2"></i>Paraderos registrados</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Paradero</th>
                        <th>Ubicacion</th>
                        <th>Ruta</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($paraderos) > 0) { ?>
                        <?php foreach ($paraderos as $p) { ?>
                            <tr>
                                <td class="text-muted"><?= (int)$p['id_paradero']; ?></td>
                                <td><strong><?= htmlspecialchars($p['nombre']); ?></strong></td>
                                <td><?= htmlspecialchars($p['ubicacion']); ?></td>
                                <td><?= ($p['ruta'] != '') ? htmlspecialchars($p['ruta']) : '<span class="text-muted">Sin ruta</span>'; ?></td>
                                <td>
                                    <a href="index.php?pg=registrarParaderos&ope=4&id_paradero=<?= (int)$p['id_paradero']; ?>" title="Eliminar paradero" onclick="return confirm('Desea eliminar el paradero <?= htmlspecialchars(addslashes($p['nombre'])); ?>?')">
                                        <i class="fa-regular fa-trash-can fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aun no hay paraderos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
