<?php $currentPage = $_GET['pg'] ?? 'inicio'; ?>
<aside class="app-sidebar left-sidebar">
    <div class="sidebar-header"><h6 class="title"><i class="fas fa-th-large me-2"></i>Menú Principal</h6><span class="badge bg-secondary rounded-pill" style="font-size:.65rem">V 2.0</span></div>
    <nav class="sidebar-nav">
        <div class="sidebar-category">Inicio</div>
        <a href="index.php?pg=inicio" class="nav-item-link <?= $currentPage === 'inicio' ? 'active' : '' ?>"><span class="nav-item-content"><span class="nav-item-icon"><i class="fas fa-gauge-high"></i></span><span>Panel principal</span></span><span class="badge-module badge-active">Activo</span></a>
        <div class="sidebar-category">Usuarios y Seguridad</div>
        <?php if (can_manage_users()): ?><a href="index.php?pg=creaUsu" class="nav-item-link <?= in_array($currentPage, ['creaUsu', 'crearUsuario'], true) ? 'active' : '' ?>"><span class="nav-item-content"><span class="nav-item-icon"><i class="fas fa-user-plus"></i></span><span>Crear usuario</span></span><span class="badge-module badge-active">Activo</span></a><?php endif; ?>
        <div class="sidebar-category">Gestión Operativa</div>
        <a href="index.php?pg=conductores" class="nav-item-link <?= $currentPage === 'conductores' ? 'active' : '' ?>"><span class="nav-item-content"><span class="nav-item-icon"><i class="fas fa-id-card"></i></span><span>Conductores</span></span><span class="badge-module badge-active">Activo</span></a>
        <?php foreach ([['buseta','Busetas / Vehículos','fa-bus'],['ruta','Rutas y Horarios','fa-route'],['empresa','Empresas','fa-building'],['pago','Pagos y Tarifas','fa-wallet'],['pqrs','PQRS','fa-comments']] as [$slug, $label, $icon]): ?>
            <a href="index.php?pg=<?= $slug ?>" class="nav-item-link <?= $currentPage === $slug ? 'active' : '' ?>"><span class="nav-item-content"><span class="nav-item-icon"><i class="fas <?= $icon ?>"></i></span><span><?= $label ?></span></span><span class="badge-module badge-upcoming">Próximamente</span></a>
        <?php endforeach; ?>
    </nav>
</aside>
