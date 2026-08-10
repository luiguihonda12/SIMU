<?php
$totalUsuarios = 0;
$listaUsuarios = array();

if (file_exists(__DIR__ . "/../models/mDashboard.php")) {
    require_once(__DIR__ . "/../models/mDashboard.php");
    if (class_exists("mDashboard")) {
        $mDashboard = new mDashboard();
        $totalUsuarios = $mDashboard->getTotalUsuarios();
        $listaUsuarios = $mDashboard->getUsuarios();
    }
}
?>
