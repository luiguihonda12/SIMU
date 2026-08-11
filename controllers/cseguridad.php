<?php
// Controlador de seguridad: restringe el acceso a las vistas autenticadas
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php?pg=login&error=acceso_no_autorizado");
    exit();
}
