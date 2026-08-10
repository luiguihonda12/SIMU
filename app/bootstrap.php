<?php
declare(strict_types=1);

session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);
require_once __DIR__ . '/../models/conexion.php';
require_once __DIR__ . '/helpers.php';
