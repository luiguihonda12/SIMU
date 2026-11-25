<?php
require_once(__DIR__ . '/conexion.php');

class Mcoder extends Conexion
{
    private const MAX_INTENTOS = 5;

    /* Verifica que el código corresponda a una cuenta aún sin activar */
    public function verificarCodigo($correo, $codigo)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_usuario FROM usuario
                WHERE correo = :correo AND codigo_verificacion = :codigo AND estado = 0";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo, ':codigo' => $codigo]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    /* Activa la cuenta y limpia el código de verificación */
    public function activarUsuario($correo)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario SET estado = 1, codigo_verificacion = NULL WHERE correo = :correo";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo]);
        return $st->rowCount() > 0;
    }

    /* Verifica el código de recuperación: caduca a los 15 minutos y permite 5 intentos */
    public function verificarCodigoRecuperacion($correo, $codigo)
    {
        $con = $this->get_conexion();

        // La caducidad se evalúa en MySQL con NOW() para evitar desfases
        // entre la zona horaria de PHP y la del servidor de base de datos.
        $st = $con->prepare("SELECT id_usuario, token_recuperacion, recuperacion_intentos,
                                    CASE WHEN recuperacion_expira_en IS NOT NULL
                                         AND recuperacion_expira_en >= NOW()
                                         THEN 1 ELSE 0 END AS vigente
                             FROM usuario WHERE correo = :correo LIMIT 1");
        $st->execute([':correo' => $correo]);
        $usuario = $st->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || empty($usuario['token_recuperacion'])) {
            return false;
        }

        if ((int)$usuario['vigente'] !== 1 || (int)$usuario['recuperacion_intentos'] >= self::MAX_INTENTOS) {
            $this->limpiarRecuperacion($correo);
            return false;
        }

        if (hash_equals((string)$usuario['token_recuperacion'], (string)$codigo)) {
            // Código correcto: reinicia el contador por si hubo intentos fallidos previos.
            $st = $con->prepare("UPDATE usuario SET recuperacion_intentos = 0 WHERE correo = :correo");
            $st->execute([':correo' => $correo]);
            return true;
        }

        // Intento fallido: se cuenta en BD para que no se evada abriendo otra sesión.
        $intentos = (int)$usuario['recuperacion_intentos'] + 1;
        $st = $con->prepare("UPDATE usuario SET recuperacion_intentos = :intentos WHERE correo = :correo");
        $st->execute([':intentos' => $intentos, ':correo' => $correo]);

        if ($intentos >= self::MAX_INTENTOS) {
            $this->limpiarRecuperacion($correo);
        }

        return false;
    }

    /* Invalida cualquier recuperación pendiente para ese correo */
    private function limpiarRecuperacion($correo)
    {
        $con = $this->get_conexion();
        $st = $con->prepare("UPDATE usuario
                             SET token_recuperacion = NULL,
                                 recuperacion_expira_en = NULL,
                                 recuperacion_intentos = 0
                             WHERE correo = :correo");
        $st->execute([':correo' => $correo]);
    }

    /* Cambia el código de 6 dígitos por un token seguro de un solo uso (15 min) */
    public function guardarTokenReset($correo, $token)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario
                SET token_recuperacion     = :token,
                    recuperacion_expira_en = DATE_ADD(NOW(), INTERVAL 15 MINUTE),
                    recuperacion_intentos  = 0
                WHERE correo = :correo";
        $st = $con->prepare($sql);
        $st->execute([':token' => $token, ':correo' => $correo]);
        return $st->rowCount() > 0;
    }
}