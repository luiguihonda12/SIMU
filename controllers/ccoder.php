<?php
require_once(__DIR__ . '/../models/mcoder.php');

header('Content-Type: application/json; charset=utf-8');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');

    if ($correo === '' || $codigo === '') {
        $res['msg'] = 'El correo y el código son obligatorios.';
    } elseif (strlen($codigo) !== 6 || !ctype_digit($codigo)) {
        $res['msg'] = 'El código de verificación debe ser de 6 dígitos numéricos.';
    } else {
        $modelo = new Mcoder();

        if ($modelo->verificarCodigo($correo, $codigo)) {
            if ($modelo->activarUsuario($correo)) {
                $res['ok']       = true;
                $res['msg']      = 'Cuenta verificada exitosamente.';
                $res['contexto'] = 'registro';
            } else {
                $res['msg'] = 'No fue posible activar la cuenta.';
            }

        } elseif ($modelo->verificarCodigoRecuperacion($correo, $codigo)) {
            $token = bin2hex(random_bytes(32));

            if ($modelo->guardarTokenReset($correo, $token)) {
                $res['ok']       = true;
                $res['msg']      = 'Código verificado. Establece tu nueva contraseña.';
                $res['contexto'] = 'recuperacion';
                $res['token']    = $token;
            } else {
                $res['msg'] = 'No fue posible generar el enlace de cambio de contraseña.';
            }

        } else {
            $res['msg'] = 'Código inválido o ya utilizado.';
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);