<?php
require_once(__DIR__ . '/conexion.php');

class Mlogin extends Conexion
{
    /**
     * Valida las credenciales de un usuario contra la tabla `usuario`.
     * Acepta contraseñas encriptadas con password_hash() (bcrypt) o en texto plano.
     */
    public static function validarUsuario($correo, $clave)
    {
        $modelo = new Mlogin();
        $con = $modelo->get_conexion();

        $sql = "SELECT * FROM usuario WHERE correo = :correo LIMIT 1";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo]);
        $usuario = $st->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return false;
        }

        $hash = $usuario['contrasena'];

        if (strncmp($hash, '$2y$', 4) === 0 || strncmp($hash, '$2a$', 4) === 0) {
            return password_verify($clave, $hash) ? $usuario : false;
        }

        return hash_equals($hash, $clave) ? $usuario : false;
    }
}
