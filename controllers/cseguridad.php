<?php
/* =========================================================
   SIMU - Control de acceso a las vistas protegidas
   Se incluye al inicio de cada vista que requiere sesión.
   ========================================================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    // index.php ya imprimió HTML, por eso header() falla aquí
    echo '<script>window.location.href = "index.php?pg=login&error=acceso_no_autorizado";</script>';
    exit();
}

/* Datos de sesión listos para usar en las vistas */
$sesUsuario = $_SESSION['usuario']    ?? '';
$sesCorreo  = $_SESSION['correo']     ?? '';
$sesId      = $_SESSION['id_usuario'] ?? 0;
$sesRol     = $_SESSION['rol']        ?? '';