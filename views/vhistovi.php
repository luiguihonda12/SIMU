<?php
/**
 * ============================================================
 * VISTA - HISTORIAL DE VIAJES (CLIENTE)
 * ============================================================
 */
require_once __DIR__ . '/../controllers/chistovi.php';

$cHistovi = new Chistovi();
$datHistovi = $cHistovi->index();

$viajes  = $datHistovi['viajes'];
$resumen = $datHistovi['resumen'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-clipboard-list"></i> Historial de Viajes</h1>
        <p class="dash-subtitle">Revisa el historial de tus viajes realizados en el Sistema Integrado de Movilidad Urbana</p>
    </header>

    <!-- Tarjetas de resumen -->
    <div class="dash-stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
            <div>
                <span class="stat-value"><?= (int)$resumen['totalViajes']; ?></span>
                <span class="stat-label">Viajes realizados</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <span class="stat-value">$<?= number_format((float)$resumen['montoTotal'], 0, ',', '.'); ?></span>
                <span class="stat-label">Total gastado</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div>
                <span class="stat-value"><?= $resumen['ultimoViaje'] ? htmlspecialchars($resumen['ultimoViaje']) : 'Sin viajes'; ?></span>
                <span class="stat-label">Último viaje</span>
            </div>
        </div>
    </div>

    <!-- Tabla de historial -->
    <div class="dash-table-card mt-4">
        <div class="dash-table-header">
            <h3><i class="fas fa-history me-2"></i>Detalle de viajes</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Ruta</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Método de pago</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($viajes) > 0) { ?>
                        <?php foreach ($viajes as $v) { ?>
                            <tr>
                                <td class="text-muted"><?= (int)$v['id_pago']; ?></td>
                                <td><?= htmlspecialchars($v['fecha']); ?></td>
                                <td><strong><?= htmlspecialchars($v['ruta']); ?></strong></td>
                                <td><?= htmlspecialchars($v['origen']); ?></td>
                                <td><?= htmlspecialchars($v['destino']); ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-credit-card me-1"></i><?= htmlspecialchars($v['metodo_pago']); ?>
                                    </span>
                                </td>
                                <td><strong>$<?= number_format((float)$v['monto'], 0, ',', '.'); ?></strong></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i>Aún no tienes viajes registrados en el sistema.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
