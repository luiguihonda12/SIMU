<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: MODULO DE EDICION DE RUTA
 * Vista 8 - Edicion del recorrido (paraderos) de una ruta
 * ============================================================
 */
class Mmodru extends Conexion
{
    // Rutas disponibles
    public function listarRutas()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_ruta, nombre, origen, destino, horario
                FROM ruta
                ORDER BY nombre ASC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Datos de la ruta seleccionada
    public function obtenerRuta($idRuta)
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
    public function actualizarRuta($datos)
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

    // Paraderos que conforman el recorrido de la ruta
    public function paraderosDeRuta($idRuta)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_paradero, nombre, ubicacion
                FROM paradero
                WHERE id_ruta = :id
                ORDER BY id_paradero ASC";
        $st = $con->prepare($sql);
        $st->execute([':id' => $idRuta]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Paraderos que se pueden agregar: los libres y los de otras rutas
    public function paraderosDisponibles($idRuta)
    {
        $con = $this->get_conexion();
        $sql = "SELECT p.id_paradero, p.nombre, p.ubicacion, r.nombre AS ruta_actual
                FROM paradero p
                LEFT JOIN ruta r ON r.id_ruta = p.id_ruta
                WHERE p.id_ruta IS NULL OR p.id_ruta <> :id
                ORDER BY (p.id_ruta IS NOT NULL), p.nombre ASC";
        $st = $con->prepare($sql);
        $st->execute([':id' => $idRuta]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crea un paradero directamente dentro del recorrido
    public function crearParadero($datos)
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

    // Actualiza nombre y ubicacion de un paradero del recorrido
    public function actualizarParadero($datos)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE paradero
                SET nombre = :nombre,
                    ubicacion = :ubicacion
                WHERE id_paradero = :id";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'    => $datos['nombre'],
            ':ubicacion' => $datos['ubicacion'],
            ':id'        => $datos['id_paradero']
        ]);
    }

    // Agrega un paradero al recorrido de la ruta
    public function asignarParadero($idParadero, $idRuta)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE paradero SET id_ruta = :id_ruta WHERE id_paradero = :id";
        $st = $con->prepare($sql);
        return $st->execute([':id_ruta' => $idRuta, ':id' => $idParadero]);
    }

    // Retira el paradero del recorrido sin borrarlo del sistema
    public function quitarParadero($idParadero)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE paradero SET id_ruta = NULL WHERE id_paradero = :id";
        $st = $con->prepare($sql);
        return $st->execute([':id' => $idParadero]);
    }
}
