<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: REGISTRAR PARADEROS
 * Vista 7 - Registrar Paraderos
 * ============================================================
 */
class Mrepar extends Conexion
{
    // Rutas disponibles para asociar el paradero
    public function listarRutas()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_ruta, nombre FROM ruta ORDER BY nombre ASC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserta un paradero nuevo
    public function registrar($datos)
    {
        $con = $this->get_conexion();
        $sql = "INSERT INTO paradero (nombre, ubicacion, id_ruta)
                VALUES (:nombre, :ubicacion, :id_ruta)";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'    => $datos['nombre'],
            ':ubicacion' => $datos['ubicacion'],
            ':id_ruta'   => $datos['id_ruta']
        ]);
    }

    // Paraderos registrados con el nombre de su ruta
    public function listar()
    {
        $con = $this->get_conexion();
        $sql = "SELECT p.id_paradero, p.nombre, p.ubicacion, r.nombre AS ruta
                FROM paradero p
                LEFT JOIN ruta r ON r.id_ruta = p.id_ruta
                ORDER BY p.id_paradero DESC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Elimina un paradero
    public function eliminar($idParadero)
    {
        $con = $this->get_conexion();
        $sql = "DELETE FROM paradero WHERE id_paradero = :id";
        $st = $con->prepare($sql);
        return $st->execute([':id' => $idParadero]);
    }

    // Evita duplicar el mismo paradero dentro de una misma ruta
    public function existe($nombre, $idRuta)
    {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total
                FROM paradero
                WHERE nombre = :nombre AND id_ruta = :id_ruta";
        $st = $con->prepare($sql);
        $st->execute([':nombre' => $nombre, ':id_ruta' => $idRuta]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }
}