<?php
require_once("conexion.php");

class mDashboard extends Conexion {

    public function getTotalUsuarios() {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total FROM usuario";
        $st = $con->prepare($sql);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    public function getUsuarios() {
        $con = $this->get_conexion();
        $sql = "SELECT u.id_usuario, u.nombre, u.apellidos, u.correo, r.nombre_del_rol AS rol
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
