<?php
// Cargar datos del controlador del dashboard (patrón MVC)
if (file_exists("controllers/cDashboard.php")) {
    @include_once("controllers/cDashboard.php");
}
?>

<div class="dashboard-container">
    <header class="dash-header">
        <h1 class="dash-title"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        <p class="dash-subtitle">Resumen general del Sistema Integrado de Movilidad Urbana (SIMU)</p>
    </header>

    <!-- Estadísticas -->
    <div class="dash-stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <span class="stat-value"><?=$totalUsuarios;?></span>
                <span class="stat-label">Usuarios Registrados</span>
            </div>
        </div>
    </div>

    <!-- Acción: ir a crear usuario -->
    <div class="dash-actions">
        <a href="index.php?pg=creaUsu" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Crear Usuario
        </a>
    </div>

    <!-- Tabla de usuarios -->
    <div class="dash-table-card">
        <div class="dash-table-header">
            <h3><i class="fas fa-table me-2"></i>Usuarios Registrados</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($listaUsuarios) && count($listaUsuarios) > 0) { ?>
                        <?php foreach ($listaUsuarios as $u) { ?>
                            <tr>
                                <td class="text-muted"><?=$u['id_usuario'];?></td>
                                <td><strong><?=htmlspecialchars($u['nombre'] . ' ' . $u['apellidos']);?></strong></td>
                                <td><?=htmlspecialchars($u['correo']);?></td>
                                <td><span class="rol-badge"><?=htmlspecialchars($u['rol']);?></span></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay usuarios registrados aún.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
