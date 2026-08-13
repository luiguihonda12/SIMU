<?php
require_once(__DIR__ . '/conexion.php');

class Mregistro extends Conexion
{
    /* Inserta un usuario del registro público (sin selección de rol) */
    public function setUsuarioPublico($datos)
    {
        $con = $this->get_conexion();
        $sql = "INSERT INTO usuario (nombre, apellidos, correo, telefono, contrasena, codigo_verificacion, estado, id_rol)
                VALUES (:nombre, :apellidos, :correo, :telefono, :contrasena, :codigo_verificacion, 0, :id_rol)";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'              => $datos['nombre'],
            ':apellidos'           => $datos['apellidos'],
            ':correo'              => $datos['correo'],
            ':telefono'            => $datos['telefono'],
            ':contrasena'          => $datos['contrasena'],
            ':codigo_verificacion' => $datos['codigo_verificacion'],
            ':id_rol'              => $datos['id_rol']
        ]);
    }

    public function existeCorreo($correo)
    {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total FROM usuario WHERE correo = :correo";
        $st = $con->prepare($sql);
        $st->execute([':correo' => $correo]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }

    /* Rol asignado automáticamente a quien se registra por su cuenta */
    public function getIdRolCliente()
    {
        $con = $this->get_conexion();
        $st = $con->prepare("SELECT id_rol FROM rol WHERE nombre_del_rol LIKE 'Cliente' LIMIT 1");
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return (int)$row['id_rol'];
        }

        $st = $con->prepare("SELECT id_rol FROM rol ORDER BY id_rol LIMIT 1");
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['id_rol'] : 0;
    }
}