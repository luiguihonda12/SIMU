<?php
header('Content-Type: application/json; charset=utf-8');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre    = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo    = trim($_POST['email'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $pass      = $_POST['pass'] ?? '';

    if ($nombre === '' || $apellidos === '' || $correo === '' || $pass === '') {
        $res['msg'] = 'Todos los campos obligatorios deben estar diligenciados.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $res['msg'] = 'El correo electrónico no es válido.';
    } elseif (strlen($pass) < 6) {
        $res['msg'] = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        require_once(__DIR__ . "/../models/mUsuario.php");
        $mUsuario = new mUsuario();

        if ($mUsuario->existeCorreo($correo)) {
            $res['msg'] = 'Ya existe un usuario registrado con ese correo.';
        } else {
            $datos = array(
                'nombre'     => $nombre,
                'apellidos'  => $apellidos,
                'correo'     => $correo,
                'telefono'   => $telefono === '' ? null : $telefono,
                'contrasena' => password_hash($pass, PASSWORD_DEFAULT),
                'id_rol'     => 3
            );

            if ($mUsuario->setUsuario($datos)) {
                $res['ok']  = true;
                $res['msg'] = 'Usuario creado correctamente.';
            } else {
                $res['msg'] = 'Ocurrió un error al guardar el usuario en la base de datos.';
            }
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);
?>
