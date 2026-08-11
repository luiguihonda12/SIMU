<?php
require_once(__DIR__ . '/../models/mcoder.php');

header('Content-Type: application/json; charset=utf-8');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');

    if ($correo === '' || $codigo === '') {
        $res['msg'] = 'El correo y el código son obligatorios.';
    } elseif (strlen($codigo) !== 6 || !is_numeric($codigo)) {
        $res['msg'] = 'El código de verificación debe ser de 6 dígitos numéricos.';
    } else {
        $modelo = new Mcoder();
        $usuario = $modelo->verificarCodigo($correo, $codigo);

        if ($usuario) {
            $modelo->activarUsuario($correo);
            $res['ok']  = true;
            $res['msg'] = 'Cuenta verificada exitosamente.';
        } else {
            $res['msg'] = 'Código inválido o cuenta ya verificada.';
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);
