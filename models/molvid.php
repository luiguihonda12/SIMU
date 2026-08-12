<?php
require_once(__DIR__ . '/conexion.php');

class Molvid extends Conexion
{
    // Guarda el código de recuperación de 6 dígitos
    public function guardarTokenRecuperacion($correo, $codigo)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario SET token_recuperacion = :token WHERE correo = :correo";
        $st = $con->prepare($sql);
        return $st->execute([':token' => $codigo, ':correo' => $correo]);
    }
}