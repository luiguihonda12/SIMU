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
            // Código de recuperación de 6 dígitos
            $codigo = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $modelo = new Molvid();

            if ($modelo->guardarTokenRecuperacion($correo, $codigo)) {
                // Intentar enviar el código por correo (requiere PHPMailer configurado)
                require_once(__DIR__ . '/ccorreo.php');
                $asunto = 'Recuperación de contraseña SIMU';
                $mensajeHtml = '<h3>Recupera tu contraseña</h3>'
                    . '<p>Recibimos una solicitud para restablecer tu contraseña en el Sistema Integrado de Movilidad Urbana (SIMU).</p>'
                    . '<p>Ingresa este código de verificación para continuar:</p>'
                    . '<h2 style="font-size:2rem;letter-spacing:4px;">' . $codigo . '</h2>'
                    . '<p>Si no solicitaste este cambio, ignora este correo.</p>';
                $enviado = enviarCorreoSimu($correo, $asunto, $mensajeHtml);

                $res['ok']            = true;
                $res['msg']           = 'Se ha enviado un código de recuperación a su correo.';
                $res['correo']        = $correo;
                $res['correo_enviado'] = $enviado;
                // Solo para pruebas mientras no se configure PHPMailer
                $res['codigo_debug']  = $enviado ? '' : $codigo;
            } else {
                $res['msg'] = 'Error al procesar la solicitud.';
            }
        }
    }
} else {
    $res['msg'] = 'Método no permitido.';
}

echo json_encode($res);
