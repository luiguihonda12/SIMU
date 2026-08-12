<?php
require_once(__DIR__ . '/../models/mreset.php');

header('Content-Type: application/json; charset=utf-8');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token    = trim($_POST['token'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar = $_POST['confirm_password'] ?? '';

    if ($token === '' || $password === '') {
        $res['msg'] = 'El token y la nueva contraseña son obligatorios.';
    } elseif (strlen($password) < 6) {
        $res['msg'] = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($password !== $confirmar) {
        $res['msg'] = 'Las contraseñas no coinciden.';
    } else {
        $modelo = new Mreset();

        if ($modelo->actualizarPasswordPorToken($token, $password)) {
            $res['ok']  = true;
            $res['msg'] = 'Contraseña actualizada correctamente.';
        } else {
            $res['msg'] = 'El token no es válido o ya fue utilizado.';
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);