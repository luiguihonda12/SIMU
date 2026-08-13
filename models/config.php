<?php
// Local: usa los valores por defecto.
// Railway: inyecta automáticamente MYSQLHOST, MYSQLPORT, MYSQLUSER,
// MYSQLPASSWORD y MYSQLDATABASE al conectar el servicio MySQL.
$host = getenv('MYSQLHOST') ?: "localhost";
$db   = getenv('MYSQLDATABASE') ?: "movilidad_mer";
$user = getenv('MYSQLUSER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: "";
$port = getenv('MYSQLPORT') ?: "3306";
?>
