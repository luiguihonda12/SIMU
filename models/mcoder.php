<?php
require_once(__DIR__ . '/conexion.php');

class Mcoder extends Conexion
{
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

    /* Verifica el código de recuperación guardado en token_recuperacion */
    public function verificarCodigoRecuperacion($correo, $codigo)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_usuario FROM usuario
                WHERE correo = :correo AND token_recuperacion = :codigo";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo, ':codigo' => $codigo]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    /* Cambia el código de 6 dígitos por un token seguro de un solo uso */
    public function guardarTokenReset($correo, $token)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE usuario SET token_recuperacion = :token WHERE correo = :correo";
        $st = $con->prepare($sql);
        $st->execute([':token' => $token, ':correo' => $correo]);
        return $st->rowCount() > 0;
    }
}