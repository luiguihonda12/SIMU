<?php
/**
 * ============================================================
 * VISTA - MENÚ INICIAL CLIENTE
 * ============================================================
 */
require_once __DIR__ . '/../controllers/cmenucli.php';

$cMenuCli = new Cmenucli();
$datMenu  = $cMenuCli->index();

$opciones = $datMenu['opciones'];
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-compass"></i> Menú Inicial Cliente</h1>
        <p class="dash-subtitle">Consulta y accede rápidamente a los servicios disponibles del Sistema Integrado de Movilidad Urbana</p>
    </header>

    <div class="row g-3 g-md-4">
        <?php foreach ($opciones as $opcion) { ?>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="<?= htmlspecialchars($opcion['url']); ?>" class="simu-service-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="simu-service-icon">
                            <i class="<?= htmlspecialchars($opcion['icono']); ?>"></i>
                        </div>
                        <span class="simu-service-title"><?= htmlspecialchars($opcion['nombre']); ?></span>
                    </div>
                    <i class="fas fa-chevron-right simu-service-arrow"></i>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
