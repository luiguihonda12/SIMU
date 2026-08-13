<?php
$totalUsuarios = 0;
$listaUsuarios = array();
$listaRoles = array();
$filtroRol = $_GET['rol'] ?? '';

if (file_exists(__DIR__ . "/../models/mDashboard.php")) {
    require_once(__DIR__ . "/../models/mDashboard.php");
    if (class_exists("mDashboard")) {
        $mDashboard = new mDashboard();
        $filtroRol = (int)$filtroRol;
        $totalUsuarios = $mDashboard->getTotalUsuarios($filtroRol);
        $listaUsuarios = $mDashboard->getUsuarios($filtroRol);
        $listaRoles = $mDashboard->getRoles();
    }
}
?>
