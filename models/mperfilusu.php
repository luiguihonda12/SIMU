<?php
require_once("conexion.php");

class mperfilusu extends Conexion
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
}
?>
