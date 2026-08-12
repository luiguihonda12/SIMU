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
            $codigo = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $modelo = new Molvid();

            if ($modelo->guardarTokenRecuperacion($correo, $codigo)) {

                require_once(__DIR__ . '/ccorreo.php');

                $asunto = 'Cambio de contraseña SIMU';
                $mensajeHtml = '<h3>Recuperación de contraseña</h3>'
                    . '<p>Este es tu código de cambio de contraseña:</p>'
                    . '<h2 style="font-size:2rem;letter-spacing:6px;">' . $codigo . '</h2>'
                    . '<p>Si no solicitaste este cambio, ignora este correo.</p>';

                $enviado = enviarCorreoSimu($correo, $asunto, $mensajeHtml);

                $res['ok']             = true;
                $res['msg']            = 'Se ha enviado un código de recuperación a su correo.';
                $res['correo']         = $correo;
                $res['correo_enviado'] = $enviado;
                $res['codigo_debug']   = $enviado ? '' : $codigo;
                $res['error_correo']   = $enviado ? '' : errorCorreoSimu();
            } else {
                $res['msg'] = 'Error al procesar la solicitud.';
            }
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);