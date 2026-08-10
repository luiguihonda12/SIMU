<?php
require_once("conexion.php");

class mUsuario extends Conexion {

    public function setUsuario($datos) {
        $con = $this->get_conexion();
        $sql = "INSERT INTO usuario (nombre, apellidos, correo, telefono, contrasena, id_rol)
                VALUES (:nombre, :apellidos, :correo, :telefono, :contrasena, :id_rol)";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'     => $datos['nombre'],
            ':apellidos'  => $datos['apellidos'],
            ':correo'     => $datos['correo'],
            ':telefono'   => $datos['telefono'],
            ':contrasena' => $datos['contrasena'],
            ':id_rol'     => $datos['id_rol']
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
}
?>
