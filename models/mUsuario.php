<?php
require_once("conexion.php");

class mUsuario extends Conexion {

    public function setUsuario($datos) {
        $con = $this->get_conexion();
        $sql = "INSERT INTO usuario (nombre, apellidos, correo, telefono, contrasena, codigo_verificacion, estado, id_rol)
                VALUES (:nombre, :apellidos, :correo, :telefono, :contrasena, :codigo_verificacion, :estado, :id_rol)";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'              => $datos['nombre'],
            ':apellidos'           => $datos['apellidos'],
            ':correo'              => $datos['correo'],
            ':telefono'            => $datos['telefono'],
            ':contrasena'          => $datos['contrasena'],
            ':codigo_verificacion' => $datos['codigo_verificacion'] ?? null,
            ':estado'              => $datos['estado'] ?? 0,
            ':id_rol'              => $datos['id_rol']
        ]);
    }

    public function existeCorreo($correo) {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total FROM usuario WHERE correo = :correo";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }

    public function getRoles() {
        $con = $this->get_conexion();
        $sql = "SELECT id_rol, nombre_del_rol AS rol FROM rol ORDER BY id_rol";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeRol($id) {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total FROM rol WHERE id_rol = :id";
        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }
}
?>
