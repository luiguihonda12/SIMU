<?php
/**
 * ============================================================
 * VISTA 10 - MODULO DE REGISTRO DE RUTAS
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cregru.php';

$cRegru = new Cregru();
$datRegru = $cRegru->index();

$rutas   = $datRegru['rutas'];
$mensaje = $datRegru['mensaje'];
$tipo    = $datRegru['tipo'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-plus"></i> Registro de Rutas</h1>
        <p class="dash-subtitle">Registre una nueva ruta de operacion del sistema de transporte</p>
    </header>

    <?php if ($mensaje != '') { ?>
        <div class="alert alert-<?= $tipo; ?>" role="alert">
            <i class="fas fa-info-circle me-2"></i><?= htmlspecialchars($mensaje); ?>
        </div>
    <?php } ?>

    <div class="dash-table-card">
        <div class="dash-table-header">
            <h3><i class="fas fa-route me-2"></i>Nueva ruta</h3>
        </div>
        <form method="post" action="index.php?pg=registroRutas" class="p-3">
            <input type="hidden" name="ope" value="1">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre de la ruta</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" placeholder="Ruta Centro" required>
                </div>
                <div class="col-md-6">
                    <label for="horario" class="form-label">Horario de salida</label>
                    <input type="time" class="form-control" id="horario" name="horario" required>
                </div>
                <div class="col-md-6">
                    <label for="origen" class="form-label">Origen</label>
                    <input type="text" class="form-control" id="origen" name="origen" maxlength="100" placeholder="Centro" required>
                </div>
                <div class="col-md-6">
                    <label for="destino" class="form-label">Destino</label>
                    <input type="text" class="form-control" id="destino" name="destino" maxlength="100" placeholder="Universidad" required>
                </div>
            </div>
            <div class="dash-actions mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Registrar ruta</button>
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
                        <th>Accion</th>
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
                                <td>
                                    <a href="index.php?pg=registroRutas&ope=4&id_ruta=<?= (int)$r['id_ruta']; ?>" onclick="return confirm('Desea eliminar la ruta <?= htmlspecialchars(addslashes($r['nombre'])); ?>?')">
                                        <i class="fa-regular fa-trash-can fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Aun no hay rutas registradas.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
