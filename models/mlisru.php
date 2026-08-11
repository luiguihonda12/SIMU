<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: MODULO DE LISTADO DE RUTAS
 * Vista 9 - Listado de Rutas
 * ============================================================
 */
class Mlisru extends Conexion
{
    // Listado de rutas con el total de paraderos y busetas asociadas
    public function listar($busqueda = '')
    {
        $con = $this->get_conexion();
        $sql = "SELECT r.id_ruta,
                       r.nombre,
                       r.origen,
                       r.destino,
                       r.horario,
                       (SELECT COUNT(*) FROM paradero p WHERE p.id_ruta = r.id_ruta) AS paraderos,
                       (SELECT COUNT(*) FROM buseta b WHERE b.id_ruta = r.id_ruta) AS busetas
                FROM ruta r
                WHERE r.nombre LIKE :bus
                   OR r.origen LIKE :bus
                   OR r.destino LIKE :bus
                ORDER BY r.nombre ASC";
        $st = $con->prepare($sql);
        $st->execute([':bus' => '%' . $busqueda . '%']);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Indicadores generales del modulo
    public function resumen()
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    (SELECT COUNT(*) FROM ruta) AS rutas,
                    (SELECT COUNT(*) FROM paradero) AS paraderos,
                    (SELECT COUNT(*) FROM paradero WHERE id_ruta IS NULL) AS sinRuta";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
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

    // Elimina la ruta y libera los paraderos que le pertenecian
    public function eliminar($idRuta)
    {
        $con = $this->get_conexion();

        $st = $con->prepare("UPDATE paradero SET id_ruta = NULL WHERE id_ruta = :id");
        $st->execute([':id' => $idRuta]);

        $st = $con->prepare("DELETE FROM ruta WHERE id_ruta = :id");
        return $st->execute([':id' => $idRuta]);
    }
}