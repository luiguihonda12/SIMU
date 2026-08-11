<?php
require_once(__DIR__ . '/conexion.php');

class Mcoder extends Conexion
{
    // Verifica que el código corresponda a una cuenta aún sin activar
    public function verificarCodigo($correo, $codigo)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_usuario FROM usuario
                WHERE correo = :correo AND codigo_verificacion = :codigo AND estado = 0";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo, ':codigo' => $codigo]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    // Activa la cuenta y limpia el código de verificación
    public function activarUsuario($correo)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario SET estado = 1, codigo_verificacion = NULL WHERE correo = :correo";
        $st = $con->prepare($sql);
        return $st->execute([':correo' => $correo]);
    }
}
