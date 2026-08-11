<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: REGISTRO DE RUTAS
 * Vista 10 - Registro de Rutas
 * ============================================================
 */
class Mregru extends Conexion
{
    // Lista las rutas registradas
    public function listar()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_ruta, nombre, origen, destino, horario
                FROM ruta
                ORDER BY id_ruta DESC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserta una ruta nueva
    public function registrar($datos)
    {
        $con = $this->get_conexion();
        $sql = "INSERT INTO ruta (nombre, origen, destino, horario)
                VALUES (:nombre, :origen, :destino, :horario)";
        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'  => $datos['nombre'],
            ':origen'  => $datos['origen'],
            ':destino' => $datos['destino'],
            ':horario' => $datos['horario']
        ]);
    }

    // Evita registrar dos rutas con el mismo nombre
    public function existeNombre($nombre)
    {
        $con = $this->get_conexion();
        $sql = "SELECT COUNT(*) AS total
                FROM ruta
                WHERE nombre = :nombre";
        $st = $con->prepare($sql);
        $st->execute([':nombre' => $nombre]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }

    // La tabla pago referencia la ruta sin ON DELETE, por eso se valida antes
    public function tienePagos($idRuta)
    {
        $con = $this->get_conexion();
        $st = $con->prepare("SELECT COUNT(*) AS total FROM pago WHERE id_ruta = :id");
        $st->execute([':id' => $idRuta]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'] > 0;
    }

    // Elimina una ruta
    public function eliminar($idRuta)
    {
        $con = $this->get_conexion();
        $sql = "DELETE FROM ruta WHERE id_ruta = :id";
        $st = $con->prepare($sql);
        return $st->execute([':id' => $idRuta]);
    }
}
