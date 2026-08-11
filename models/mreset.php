<?php
require_once(__DIR__ . '/conexion.php');

class Mreset extends Conexion
{
    // Actualiza la contraseña usando el token de recuperación y lo invalida
    public function actualizarPasswordPorToken($token, $nuevoPassword)
    {
        $con = $this->get_conexion();
        $hash = password_hash($nuevoPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET contrasena = :contrasena, token_recuperacion = NULL
                WHERE token_recuperacion = :token";
        $st = $con->prepare($sql);
        return $st->execute([':contrasena' => $hash, ':token' => $token]);
    }
}
