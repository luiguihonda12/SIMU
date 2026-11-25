<?php
require_once(__DIR__ . '/conexion.php');

class Molvid extends Conexion
{
    // Guarda el código de recuperación y su caducidad (15 minutos).
    public function guardarTokenRecuperacion($correo, $token)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario
                SET token_recuperacion     = :token,
                    recuperacion_expira_en = DATE_ADD(NOW(), INTERVAL 15 MINUTE),
                    recuperacion_intentos  = 0
                WHERE correo = :correo";
        $st = $con->prepare($sql);
        return $st->execute([':token' => $token, ':correo' => $correo]);
    }
}
