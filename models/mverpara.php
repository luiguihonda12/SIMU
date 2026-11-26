<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: VER PARADEROS (CLIENTE)
 * Permite al cliente ver los paraderos disponibles
 * ============================================================
 */
class Mverpara extends Conexion
{
    /**
     * Lista todos los paraderos con la ruta a la que pertenecen.
     */
    public function listarParaderos($busqueda = '')
    {
        $con = $this->get_conexion();
        $sql = "SELECT pa.id_paradero,
                       pa.nombre,
                       pa.ubicacion,
                       COALESCE(r.nombre, 'Sin ruta asignada') AS ruta,
                       r.origen,
                       r.destino
                FROM paradero pa
                LEFT JOIN ruta r ON r.id_ruta = pa.id_ruta
                WHERE pa.nombre    LIKE :bus
                   OR pa.ubicacion LIKE :bus
                   OR r.nombre     LIKE :bus
                ORDER BY pa.nombre ASC";
        $st = $con->prepare($sql);
        $st->execute([':bus' => '%' . $busqueda . '%']);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen de paraderos para las tarjetas de estadísticas.
     */
    public function resumen()
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    (SELECT COUNT(*) FROM paradero) AS totalParaderos,
                    (SELECT COUNT(*) FROM paradero WHERE id_ruta IS NOT NULL) AS conRuta,
                    (SELECT COUNT(*) FROM paradero WHERE id_ruta IS NULL) AS sinRuta";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}
