<?php
require_once(__DIR__ . '/conexion.php');

class Mreset extends Conexion
{
    public function actualizarPasswordPorToken($token, $nuevoPassword)
    {
        $con  = $this->get_conexion();
        $hash = password_hash($nuevoPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE usuario
                SET contrasena = :contrasena, token_recuperacion = NULL, estado = 1
                WHERE token_recuperacion = :token";
        $st = $con->prepare($sql);
        $st->execute([':contrasena' => $hash, ':token' => $token]);

        return $st->rowCount() > 0;
    }
}