<?php
/**
 * Control de acceso para endpoints AJAX/JSON del panel de administración.
 * Se incluye al inicio de cada controlador que modifica datos.
 * Responde 403 en JSON cuando no hay sesión de administrador.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function simuNoAutorizado($mensaje)
{
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok' => false,
        'msg' => $mensaje
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

function simuExigirAdmin()
{
    if (!isset($_SESSION['id_usuario'])) {
        simuNoAutorizado('Debes iniciar sesión para realizar esta acción.');
    }

    if ((int)($_SESSION['id_rol'] ?? 0) !== 1) {
        simuNoAutorizado('No tienes permisos para realizar esta acción.');
    }
}

function simuExigirSesion()
{
    if (!isset($_SESSION['id_usuario'])) {
        simuNoAutorizado('Debes iniciar sesión para realizar esta acción.');
    }
}
