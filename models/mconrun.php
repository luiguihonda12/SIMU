<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: CONSULTAR HORARIOS (CLIENTE)
 * Permite al cliente consultar los horarios de las rutas
 * ============================================================
 */
class Mconrun extends Conexion
{
    /**
     * Lista todas las rutas con su horario, origen, destino
     * y la cantidad de busetas activas asignadas.
     */
    public function listarHorarios($busqueda = '')
    {
        $con = $this->get_conexion();
        $sql = "SELECT r.id_ruta,
                       r.nombre,
                       r.origen,
                       r.destino,
                       r.horario,
                       (SELECT COUNT(*) FROM buseta b WHERE b.id_ruta = r.id_ruta AND b.estado = 'activa') AS busetas
                FROM ruta r
                WHERE r.nombre  LIKE :bus
                   OR r.origen  LIKE :bus
                   OR r.destino LIKE :bus
                ORDER BY r.horario ASC";
        $st = $con->prepare($sql);
        $st->execute([':bus' => '%' . $busqueda . '%']);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen general de horarios.
     */
    public function resumen()
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    (SELECT COUNT(*) FROM ruta) AS totalRutas,
                    (SELECT MIN(horario) FROM ruta) AS primerHorario,
                    (SELECT MAX(horario) FROM ruta) AS ultimoHorario";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}
