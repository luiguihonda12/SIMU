<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: CONSULTAR RUTAS (CLIENTE)
 * Permite al cliente buscar y visualizar rutas disponibles
 * ============================================================
 */
class Mconsul extends Conexion
{
    /**
     * Lista las rutas disponibles con paraderos y busetas asociadas.
     * Opcionalmente filtra por nombre, origen o destino.
     */
    public function listarRutas($busqueda = '')
    {
        $con = $this->get_conexion();
        $sql = "SELECT r.id_ruta,
                       r.nombre,
                       r.origen,
                       r.destino,
                       r.horario,
                       (SELECT COUNT(*) FROM paradero p WHERE p.id_ruta = r.id_ruta) AS paraderos,
                       (SELECT COUNT(*) FROM buseta b  WHERE b.id_ruta = r.id_ruta AND b.estado = 'activa') AS busetas
                FROM ruta r
                WHERE r.nombre  LIKE :bus
                   OR r.origen  LIKE :bus
                   OR r.destino LIKE :bus
                ORDER BY r.nombre ASC";
        $st = $con->prepare($sql);
        $st->execute([':bus' => '%' . $busqueda . '%']);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen general de rutas para las tarjetas de estadísticas.
     */
    public function resumen()
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    (SELECT COUNT(*) FROM ruta)     AS rutas,
                    (SELECT COUNT(*) FROM paradero)  AS paraderos,
                    (SELECT COUNT(*) FROM buseta WHERE estado = 'activa') AS busetasActivas";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene el detalle de una ruta específica con sus paraderos.
     */
    public function obtenerRuta($idRuta)
    {
        $con = $this->get_conexion();
        $st = $con->prepare("SELECT * FROM ruta WHERE id_ruta = :id");
        $st->execute([':id' => $idRuta]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Paraderos de una ruta.
     */
    public function paraderosPorRuta($idRuta)
    {
        $con = $this->get_conexion();
        $st = $con->prepare("SELECT * FROM paradero WHERE id_ruta = :id ORDER BY nombre ASC");
        $st->execute([':id' => $idRuta]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
