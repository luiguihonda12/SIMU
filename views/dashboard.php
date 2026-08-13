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

    <!-- Filtro por rol -->
    <div class="dash-filter">
        <label for="filtroRol" class="dash-filter-label">
            <i class="fas fa-filter me-1"></i>Filtrar por rol:
        </label>
        <select id="filtroRol" class="form-select dash-filter-select" onchange="if(this.value){location.href='index.php?pg=dashboard&rol='+this.value;}else{location.href='index.php?pg=dashboard';}">
            <option value="">Todos los roles</option>
            <?php if (is_array($listaRoles)) { ?>
                <?php foreach ($listaRoles as $r) { ?>
                    <option value="<?=(int)$r['id_rol'];?>" <?=((int)$filtroRol === (int)$r['id_rol']) ? 'selected' : '';?>>
                        <?=htmlspecialchars($r['rol']);?>
                    </option>
                <?php } ?>
            <?php } ?>
        </select>
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
                        <th>Acciones</th>
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
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger btn-eliminar-usuario"
                                        data-id="<?=(int)$u['id_usuario'];?>"
                                        data-nombre="<?=htmlspecialchars($u['nombre'] . ' ' . $u['apellidos']);?>"
                                        title="Eliminar usuario"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay usuarios registrados aún.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const botones = document.querySelectorAll('.btn-eliminar-usuario');

    botones.forEach(function (boton) {

        boton.addEventListener('click', function () {

            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');

            if (!confirm('¿Estás seguro de eliminar al usuario "' + nombre + '"? Esta acción no se puede deshacer.')) {
                return;
            }

            fetch('controllers/celusu.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id_usuario=' + encodeURIComponent(id)
            })
            .then(function (respuesta) {
                return respuesta.json();
            })
            .then(function (datos) {
                alert(datos.msg);
                if (datos.ok) {
                    location.reload();
                }
            })
            .catch(function () {
                alert('Ocurrió un error al intentar eliminar el usuario.');
            });

        });

    });

});
</script>
