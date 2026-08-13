<?php
header('Content-Type: application/json; charset=utf-8');

require_once(__DIR__ . '/cclave.php');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre    = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo    = trim($_POST['email'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $pass      = $_POST['pass'] ?? '';

    $errorClave = validarClaveSimu($pass);

    if ($nombre === '' || $apellidos === '' || $correo === '' || $pass === '') {
        $res['msg'] = 'Todos los campos obligatorios deben estar diligenciados.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $res['msg'] = 'El correo electrónico no es válido.';
    } elseif ($errorClave !== '') {
        $res['msg'] = $errorClave;
    } else {
        try {
        require_once(__DIR__ . "/../models/mregistro.php");
        $mRegistro = new Mregistro();

        $idRol = $mRegistro->getIdRolCliente();

        if ($idRol <= 0) {
            $res['msg'] = 'No hay roles configurados en el sistema.';
        } elseif ($mRegistro->existeCorreo($correo)) {
            $res['msg'] = 'Ya existe un usuario registrado con ese correo.';
        } else {
            $codigo = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $datos = array(
                'nombre'              => $nombre,
                'apellidos'           => $apellidos,
                'correo'              => $correo,
                'telefono'            => $telefono === '' ? null : $telefono,
                'contrasena'          => password_hash($pass, PASSWORD_DEFAULT),
                'codigo_verificacion' => $codigo,
                'id_rol'              => $idRol
            );

            if ($mRegistro->setUsuarioPublico($datos)) {

                require_once(__DIR__ . '/ccorreo.php');

                $asunto = 'Código de verificación SIMU';
                $mensajeHtml = '<h3>Hola ' . htmlspecialchars($nombre) . '</h3>'
                    . '<p>Este es tu código para la creación de cuenta SIMU:</p>'
                    . '<h2 style="font-size:2rem;letter-spacing:6px;">' . $codigo . '</h2>'
                    . '<p>Ingrésalo en la aplicación para activar tu cuenta.</p>';

                $enviado = enviarCorreoSimu($correo, $asunto, $mensajeHtml);

                $res['ok']             = true;
                $res['msg']            = 'Cuenta creada. Ingresa el código enviado a tu correo.';
                $res['correo']         = $correo;
                $res['correo_enviado'] = $enviado;
                $res['codigo_debug']   = $enviado ? '' : $codigo;
                $res['error_correo']   = $enviado ? '' : errorCorreoSimu();
            } else {
                $res['msg'] = 'Ocurrió un error al guardar el usuario en la base de datos.';
            }
        }
        } catch (Throwable $e) {
            $res['msg'] = 'Error del servidor: ' . $e->getMessage();
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);