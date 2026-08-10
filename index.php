<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/controllers/usuarios.php';
require_once __DIR__ . '/controllers/conductores.php';
require_once __DIR__ . '/controllers/auth.php';

$pages = [
    'login' => ['view' => 'views/login.php', 'title' => 'Iniciar sesión'],
    'inicio' => ['view' => 'views/dashboard.php', 'title' => 'Panel principal'],
    'creaUsu' => ['view' => 'views/creaUsu.php', 'title' => 'Crear usuario'],
    'crearUsuario' => ['view' => 'views/creaUsu.php', 'title' => 'Crear usuario'],
    'conductores' => ['view' => 'views/conductores.php', 'title' => 'Conductores'],
];
$pg = is_string($_GET['pg'] ?? null) ? $_GET['pg'] : 'inicio';
if (!isset($pages[$pg])) $pg = 'inicio';

$db = null;
$dbError = null;
try { $db = (new Conexion())->get_conexion(); } catch (Throwable $exception) { $dbError = 'No se pudo conectar con la base de datos. Revisa tu archivo .env.'; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    if (!$db) { flash('danger', $dbError ?? 'Base de datos no disponible.'); redirect('index.php?pg=login'); }
    procesar_login($db);
}

if ($pg === 'login' && is_authenticated()) redirect('index.php?pg=inicio');
if ($pg !== 'login') require_auth();
if (in_array($pg, ['creaUsu', 'crearUsuario'], true)) require_role(ROLE_ADMIN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$db) { flash('danger', $dbError ?? 'Base de datos no disponible.'); redirect('index.php?pg=' . urlencode($pg)); }
    if (($_POST['action'] ?? '') === 'logout') procesar_logout();
    if (($_POST['action'] ?? '') === 'crear_usuario') registrar_usuario($db);
    if (($_POST['action'] ?? '') === 'eliminar_usuario') eliminar_usuario($db);
    if (($_POST['action'] ?? '') === 'crear_conductor') registrar_conductor($db);
    if (($_POST['action'] ?? '') === 'eliminar_conductor') eliminar_conductor($db);
}

$flash = consume_flash();
$page = $pages[$pg];
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page['title']) ?> | SIMU</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/menu.css"><link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . '/views/header.php'; ?><div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="app-layout"><?php include __DIR__ . '/views/vmen.php'; ?><main class="main-content">
        <?php if ($dbError): ?><div class="alert alert-warning m-3"><i class="fas fa-database me-2"></i><?= e($dbError) ?></div><?php endif; ?>
        <?php if ($flash): ?><div class="alert alert-<?= e($flash['type']) ?> m-3" role="alert"><?= e($flash['message']) ?></div><?php endif; ?>
        <?php include __DIR__ . '/' . $page['view']; ?>
    </main></div>
    <?php include __DIR__ . '/views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script src="js/code.js"></script><script src="js/valida.js"></script>
</body></html>
