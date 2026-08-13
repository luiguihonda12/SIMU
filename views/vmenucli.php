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
        <h1 class="dash-title"><i class="fas fa-user me-2"></i> Menú Inicial Cliente</h1>
        <p class="dash-subtitle">Consulta los servicios disponibles del Sistema Integrado de Movilidad Urbana</p>
    </header>

    <div class="row g-3">
        <?php foreach ($opciones as $opcion) { ?>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="<?= $opcion['url']; ?>" class="text-decoration-none">
                    <button type="button" class="btn btn-light border shadow-sm w-100 py-3 text-start">
                        <i class="<?= $opcion['icono']; ?> me-3" style="color: #00a3c7;"></i>
                        <span class="fw-semibold text-dark"><?= htmlspecialchars($opcion['nombre']); ?></span>
                    </button>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
