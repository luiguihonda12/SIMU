<div class="registration-container">
    <header class="reg-header"><h1 class="brand-title">SIMU</h1><div class="logo-wrapper"><div class="main-logo"><i class="fas fa-user-shield"></i></div></div><h2 class="h4 text-dark fw-bold">Crear usuario</h2><p class="text-muted small mb-0">Registra una cuenta para acceder al sistema.</p></header>
    <form method="post" action="index.php?pg=creaUsu" novalidate>
        <?= csrf_field() ?><input type="hidden" name="action" value="crear_usuario">
        <div class="input-row"><div class="input-group"><label for="nombre">Nombre</label><input required minlength="2" type="text" id="nombre" name="nombre" placeholder="Juan"></div><div class="input-group"><label for="apellidos">Apellidos</label><input required type="text" id="apellidos" name="apellidos" placeholder="Pérez"></div></div>
        <div class="input-group"><label for="correo">Correo electrónico</label><input required type="email" id="correo" name="correo" placeholder="correo@ejemplo.com"></div>
        <div class="input-group"><label for="password">Contraseña</label><div class="password-wrapper"><input required minlength="8" type="password" id="password" name="password" placeholder="Mínimo 8 caracteres"><i class="fas fa-eye eye-toggle" data-password-target="password"></i></div><small class="text-muted">Debe incluir una mayúscula y un número.</small></div>
        <div class="input-group"><label for="password_confirm">Confirmar contraseña</label><input required type="password" id="password_confirm" name="password_confirm"></div>
        <button type="submit" class="btn btn-primary">Crear usuario <i class="fas fa-user-plus ms-2"></i></button>
    </form>
</div>
<?php $usuarios = $db ? $db->query('SELECT u.id_usuario, u.nombre, u.correo, r.nombre_del_rol FROM usuario u INNER JOIN rol r ON r.id_rol = u.id_rol ORDER BY u.id_usuario DESC')->fetchAll() : []; ?>
<section class="module-card users-list-card">
    <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h5 mb-0">Usuarios registrados</h2><span class="badge bg-info-subtle text-info-emphasis"><?= count($usuarios) ?> registros</span></div>
    <div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Nombre</th><th>Correo</th><th>Rol</th></tr></thead><tbody><?php foreach ($usuarios as $usuario): ?><tr><td><?= e($usuario['nombre']) ?></td><td><?= e($usuario['correo']) ?></td><td><?= e($usuario['nombre_del_rol']) ?></td></tr><?php endforeach; ?></tbody></table></div>
</section>
