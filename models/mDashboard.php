<?php
require_once("conexion.php");

class mDashboard extends Conexion {

    public function getRoles() {
        $con = $this->get_conexion();
        $sql = "SELECT id_rol, nombre_del_rol AS rol
                FROM rol
                ORDER BY id_rol";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUsuarios($idRol = null) {
        $con = $this->get_conexion();

        if (!empty($idRol)) {
            $sql = "SELECT COUNT(*) AS total FROM usuario WHERE id_rol = :idRol";
            $st = $con->prepare($sql);
            $st->execute([':idRol' => $idRol]);
        } else {
            $sql = "SELECT COUNT(*) AS total FROM usuario";
            $st = $con->prepare($sql);
            $st->execute();
        }

        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    public function getUsuarios($idRol = null) {
        $con = $this->get_conexion();

        $sql = "SELECT u.id_usuario, u.nombre, u.apellidos, u.correo, r.nombre_del_rol AS rol
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol";

        if (!empty($idRol)) {
            $sql .= " WHERE u.id_rol = :idRol";
        }

        $sql .= " ORDER BY u.id_usuario";

        $st = $con->prepare($sql);

        if (!empty($idRol)) {
            $st->execute([':idRol' => $idRol]);
        } else {
            $st->execute();
        }

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
