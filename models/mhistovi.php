<?php
require_once(__DIR__ . "/conexion.php");

/**
 * ============================================================
 * MODELO: HISTORIAL DE VIAJES (CLIENTE)
 * Muestra el historial de pagos/viajes del usuario logueado
 * ============================================================
 */
class Mhistovi extends Conexion
{
    /**
     * Lista los viajes (pagos) del usuario actual con la información de la ruta.
     */
    public function listarViajes($idUsuario)
    {
        $con = $this->get_conexion();
        $sql = "SELECT p.id_pago,
                       p.fecha,
                       p.monto,
                       p.metodo_pago,
                       r.nombre   AS ruta,
                       r.origen,
                       r.destino
                FROM pago p
                INNER JOIN ruta r ON r.id_ruta = p.id_ruta
                WHERE p.id_usuario = :id
                ORDER BY p.fecha DESC";
        $st = $con->prepare($sql);
        $st->execute([':id' => $idUsuario]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen de viajes del usuario: total viajes, monto total, último viaje.
     */
    public function resumen($idUsuario)
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    COUNT(*)        AS totalViajes,
                    COALESCE(SUM(monto), 0) AS montoTotal,
                    MAX(fecha)      AS ultimoViaje
                FROM pago
                WHERE id_usuario = :id";
        $st = $con->prepare($sql);
        $st->execute([':id' => $idUsuario]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}
