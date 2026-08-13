<?php
require_once("conexion.php");

class meditarusu extends Conexion
{
    public function obtenerUsuario($id_usuario)
    {
        $con = $this->get_conexion();

        $sql = "SELECT
                    u.id_usuario,
                    u.nombre,
                    u.apellidos,
                    u.correo,
                    u.telefono,
                    u.id_rol,
                    r.nombre_del_rol AS rol
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                WHERE u.id_usuario = :id_usuario";

        $stmt = $con->prepare($sql);

        $stmt->execute([
            ':id_usuario' => $id_usuario
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarUsuario($datos)
    {
        $con = $this->get_conexion();

        $sql = "UPDATE usuario
                SET
                    nombre = :nombre,
                    apellidos = :apellidos,
                    correo = :correo,
                    telefono = :telefono
                WHERE id_usuario = :id_usuario";

        $stmt = $con->prepare($sql);

        return $stmt->execute([
            ':nombre'      => $datos['nombre'],
            ':apellidos'   => $datos['apellidos'],
            ':correo'      => $datos['correo'],
            ':telefono'    => $datos['telefono'],
            ':id_usuario'  => $datos['id_usuario']
        ]);
    }
}
?>
