<?php
header('Content-Type: application/json; charset=utf-8');

$res = array('ok' => false, 'msg' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre    = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo    = trim($_POST['email'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $pass      = $_POST['pass'] ?? '';
    $rol       = (int)($_POST['rol'] ?? 0);

    if ($nombre === '' || $apellidos === '' || $correo === '' || $pass === '') {
        $res['msg'] = 'Todos los campos obligatorios deben estar diligenciados.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $res['msg'] = 'El correo electrónico no es válido.';
    } elseif (strlen($pass) < 6) {
        $res['msg'] = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($rol <= 0) {
        $res['msg'] = 'Debes seleccionar un rol válido.';
    } else {
        require_once(__DIR__ . "/../models/mUsuario.php");
        $mUsuario = new mUsuario();

        if (!$mUsuario->existeRol($rol)) {
            $res['msg'] = 'El rol seleccionado no es válido.';
        } elseif ($mUsuario->existeCorreo($correo)) {
            $res['msg'] = 'Ya existe un usuario registrado con ese correo.';
        } else {
            // Código de verificación de 6 dígitos para activar la cuenta
            $codigo = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $datos = array(
                'nombre'              => $nombre,
                'apellidos'           => $apellidos,
                'correo'              => $correo,
                'telefono'            => $telefono === '' ? null : $telefono,
                'contrasena'          => password_hash($pass, PASSWORD_DEFAULT),
                'codigo_verificacion' => $codigo,
                'estado'              => 0, // Pendiente de verificación
                'id_rol'              => $rol
            );

            if ($mUsuario->setUsuario($datos)) {
                // Intentar enviar el código por correo (requiere PHPMailer configurado)
                require_once(__DIR__ . '/ccorreo.php');
                $asunto = 'Código de verificación SIMU';
                $mensajeHtml = '<h3>¡Hola ' . htmlspecialchars($nombre) . '!</h3>'
                    . '<p>Gracias por registrarte en el Sistema Integrado de Movilidad Urbana (SIMU).</p>'
                    . '<p>Tu código de verificación para activar tu cuenta es:</p>'
                    . '<h2 style="font-size:2rem;letter-spacing:4px;">' . $codigo . '</h2>'
                    . '<p>Ingresa este código en la aplicación para completar tu registro.</p>';
                $enviado = enviarCorreoSimu($correo, $asunto, $mensajeHtml);

                $res['ok']            = true;
                $res['msg']           = 'Usuario creado. Ingresa el código enviado a tu correo para activar la cuenta.';
                $res['correo']        = $correo;
                $res['correo_enviado'] = $enviado;
                // Solo para pruebas mientras no se configure PHPMailer
                $res['codigo_debug']  = $enviado ? '' : $codigo;
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
