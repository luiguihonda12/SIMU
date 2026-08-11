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

    // Paraderos existentes que aun no pertenecen a ninguna ruta
    public function paraderosLibres()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_paradero, nombre, ubicacion
                FROM paradero
                WHERE id_ruta IS NULL
                ORDER BY nombre ASC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
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

    // Agrega un paradero libre al recorrido de la ruta
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