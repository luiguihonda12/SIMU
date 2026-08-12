<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    echo '<script>window.location.href = "index.php?pg=login&error=acceso_no_autorizado";</script>';
    exit();
}

$sesUsuario = $_SESSION['usuario']    ?? '';
$sesCorreo  = $_SESSION['correo']     ?? '';
$sesId      = $_SESSION['id_usuario'] ?? 0;
$sesRol     = $_SESSION['rol']        ?? '';