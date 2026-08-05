<?php 
// Intentar cargar datos del controlador si existen
if(file_exists("controllers/cmen.php")){
    @include_once("controllers/cmen.php"); 
}

$currentPage = $_GET['pg'] ?? 'creaUsu';
?>

<aside class="right-sidebar">
    <div class="sidebar-header">
        <h6 class="title"><i class="fas fa-th-large me-2"></i>Menú Principal</h6>
        <span class="badge bg-secondary rounded-pill" style="font-size: 0.65rem;">V 1.0</span>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-category">Usuarios y Seguridad</div>
        <a href="index.php?pg=creaUsu" class="nav-item-link <?=($currentPage == 'creaUsu' || $currentPage == 'crearUsuario') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-user-plus"></i></span>
                <span>Crear Usuario</span>
            </span>
            <span class="badge-module badge-active">Activo</span>
        </a>

        <div class="sidebar-category">Gestión Operativa</div>
        <a href="index.php?pg=conductor" class="nav-item-link <?=($currentPage == 'conductor') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-id-card"></i></span>
                <span>Conductores</span>
            </span>
            <span class="badge-module badge-upcoming">Próximamente</span>
        </a>

        <a href="index.php?pg=buseta" class="nav-item-link <?=($currentPage == 'buseta') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-bus"></i></span>
                <span>Busetas / Vehículos</span>
            </span>
            <span class="badge-module badge-upcoming">Próximamente</span>
        </a>

        <a href="index.php?pg=ruta" class="nav-item-link <?=($currentPage == 'ruta') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-route"></i></span>
                <span>Rutas y Horarios</span>
            </span>
            <span class="badge-module badge-upcoming">Próximamente</span>
        </a>

        <a href="index.php?pg=empresa" class="nav-item-link <?=($currentPage == 'empresa') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-building"></i></span>
                <span>Empresas</span>
            </span>
            <span class="badge-module badge-upcoming">Próximamente</span>
        </a>

        <div class="sidebar-category">Servicios y Soporte</div>
        <a href="index.php?pg=pago" class="nav-item-link <?=($currentPage == 'pago') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-wallet"></i></span>
                <span>Pagos y Tarifas</span>
            </span>
            <span class="badge-module badge-upcoming">Próximamente</span>
        </a>

        <a href="index.php?pg=pqrs" class="nav-item-link <?=($currentPage == 'pqrs') ? 'active' : '';?>">
            <span class="nav-item-content">
                <span class="nav-item-icon"><i class="fas fa-comments"></i></span>
                <span>PQRS</span>
            </span>
            <span class="badge-module badge-upcoming">Próximamente</span>
        </a>

        <?php if(isset($datMen) && is_array($datMen) && count($datMen) > 0){ ?>
            <div class="sidebar-category">Menú Dinámico (BD)</div>
            <?php foreach($datMen AS $dm){ ?>
                <a href="index.php?pg=<?=$dm["idpag"];?>" class="nav-item-link <?=($currentPage == $dm["idpag"]) ? 'active' : '';?>">
                    <span class="nav-item-content">
                        <span class="nav-item-icon"><i class="<?=$dm["icopag"];?>"></i></span>
                        <span><?=$dm["nompag"];?></span>
                    </span>
                </a>
            <?php } ?>
        <?php } ?>
    </nav>
</aside>