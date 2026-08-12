<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('enviarCorreoSimu')) {

    define('SIMU_CORREO_USUARIO', 'Simucodex@gmail.com');
    define('SIMU_CORREO_CLAVE',   'rbys wmex sman ohdy');
    define('SIMU_CORREO_NOMBRE',  'Sistema SIMU');

    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require_once(__DIR__ . '/../vendor/autoload.php');
    } elseif (file_exists(__DIR__ . '/../PHPMailer/src/PHPMailer.php')) {
        require_once(__DIR__ . '/../PHPMailer/src/Exception.php');
        require_once(__DIR__ . '/../PHPMailer/src/PHPMailer.php');
        require_once(__DIR__ . '/../PHPMailer/src/SMTP.php');
    }

    function enviarCorreoSimu($destinatario, $asunto, $mensajeHtml) {
        $GLOBALS['simu_error_correo'] = '';

        if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            $GLOBALS['simu_error_correo'] = 'PHPMailer no está instalado en la carpeta del proyecto.';
            return false;
        }

        if (SIMU_CORREO_USUARIO === 'tucorreo@gmail.com') {
            $GLOBALS['simu_error_correo'] = 'Falta configurar el correo y la contraseña de aplicación en ccorreo.php.';
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = SIMU_CORREO_USUARIO;
            $mail->Password   = SIMU_CORREO_CLAVE;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SIMU_CORREO_USUARIO, SIMU_CORREO_NOMBRE);
            $mail->addAddress($destinatario);

            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $mensajeHtml;
            $mail->AltBody = strip_tags(str_replace(array('<br>', '</p>'), "\n", $mensajeHtml));

            $mail->send();
            return true;

        } catch (Exception $e) {
            $GLOBALS['simu_error_correo'] = $mail->ErrorInfo;
            return false;
        }
    }

    function errorCorreoSimu() {
        return $GLOBALS['simu_error_correo'] ?? '';
    }
}