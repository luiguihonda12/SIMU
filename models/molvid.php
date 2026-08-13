<?php
require_once(__DIR__ . '/conexion.php');

class Molvid extends Conexion
{
    // Guarda el token de recuperación en el usuario indicado
    public function guardarTokenRecuperacion($correo, $token)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario SET token_recuperacion = :token WHERE correo = :correo";
        $st = $con->prepare($sql);
        return $st->execute([':token' => $token, ':correo' => $correo]);
    }
}
