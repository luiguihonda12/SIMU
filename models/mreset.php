<?php
require_once(__DIR__ . '/conexion.php');

class Mreset extends Conexion
{
    /* Actualiza la contraseña usando el token de recuperación y lo invalida.
       Se valida con rowCount() porque execute() devuelve true aunque no
       se haya modificado ninguna fila. */
    public function actualizarPasswordPorToken($token, $nuevoPassword)
    {
        $con  = $this->get_conexion();
        $hash = password_hash($nuevoPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE usuario
                SET contrasena             = :contrasena,
                    token_recuperacion     = NULL,
                    recuperacion_expira_en = NULL,
                    recuperacion_intentos  = 0,
                    estado                 = 1
                WHERE token_recuperacion = :token
                  AND recuperacion_expira_en IS NOT NULL
                  AND recuperacion_expira_en >= NOW()
                  AND recuperacion_intentos < 5";
        $st = $con->prepare($sql);
        $st->execute([':contrasena' => $hash, ':token' => $token]);

        return $st->rowCount() > 0;
    }
}