<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: EDITAR RUTAS
 * Vista 6 - Editar Rutas
 * ============================================================
 */
class Medrut extends Conexion
{
    // Lista todas las rutas para el selector
    public function listar()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_ruta, nombre, origen, destino, horario
                FROM ruta
                ORDER BY nombre ASC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Trae una ruta puntual para cargarla en el formulario
    public function obtener($idRuta)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_ruta, nombre, origen, destino, horario
                FROM ruta
                WHERE id_ruta = :id";
        $st = $con->prepare($sql);
        $st->execute([':id' => $idRuta]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    // Actualiza los datos basicos de la ruta
    public function actualizar($datos)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE ruta
                SET nombre = :nombre,
                    origen = :origen,
                    destino = :destino,
                    horario = :horario
                WHERE id_ruta = :id";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'  => $datos['nombre'],
            ':origen'  => $datos['origen'],
            ':destino' => $datos['destino'],
            ':horario' => $datos['horario'],
            ':id'      => $datos['id_ruta']
        ]);
    }

    // Valida que no exista otra ruta con el mismo nombre
    public function existeNombre($nombre, $idRuta)
    {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total
                FROM ruta
                WHERE nombre = :nombre AND id_ruta <> :id";
        $st = $con->prepare($sql);
        $st->execute([':nombre' => $nombre, ':id' => $idRuta]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }
}