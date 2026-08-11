<?php
// Envío de correos con PHPMailer.
// Requiere instalar PHPMailer (composer o manual) en la carpeta vendor.
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoSimu($destinatario, $asunto, $mensajeHtml) {
    // Si PHPMailer no está disponible, se informa al administrador
    if (!class_exists('PHPMailer')) {
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tu_correo_real@gmail.com';
        $mail->Password   = 'tu_contraseña_de_aplicacion';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('tu_correo_real@gmail.com', 'Sistema SIMU');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensajeHtml;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
