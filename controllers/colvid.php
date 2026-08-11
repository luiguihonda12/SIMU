<?php
require_once(__DIR__ . '/../models/molvid.php');
require_once(__DIR__ . '/../models/mUsuario.php');

header('Content-Type: application/json; charset=utf-8');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo'] ?? '');

    if ($correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $res['msg'] = 'Ingrese un correo electrónico válido.';
    } else {
        $mUsuario = new mUsuario();

        if (!$mUsuario->existeCorreo($correo)) {
            $res['msg'] = 'El correo no está registrado en el sistema.';
        } else {
            $token = bin2hex(random_bytes(32));
            $modelo = new Molvid();

            if ($modelo->guardarTokenRecuperacion($correo, $token)) {
                $res['ok']  = true;
                $res['msg'] = 'Se ha enviado un enlace de recuperación a su correo.';
                $res['token_debug'] = $token; // Solo para pruebas mientras se configura el envío de correos
            } else {
                $res['msg'] = 'Error al procesar la solicitud.';
            }
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);
