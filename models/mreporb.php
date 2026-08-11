<?php
require_once("conexion.php");

class mreporb extends Conexion {

    public function reporte($estado = '') {
        $con = $this->get_conexion();

        $sql = "
            SELECT
                b.id_buseta,
                b.placa,
                b.capacidad,
                b.estado,
                r.nombre AS ruta,
                e.nombre AS empresa

            FROM buseta b

            INNER JOIN ruta r
                ON r.id_ruta = b.id_ruta

            INNER JOIN empresa e
                ON e.id_empresa = b.id_empresa
        ";

        $params = [];

        if (
            in_array(
                $estado,
                [
                    'activa',
                    'inactiva',
                    'mantenimiento'
                ],
                true
            )
        ) {
            $sql .= "
                WHERE b.estado = :estado
            ";
            $params = [':estado' => $estado];
        }

        $sql .= "
            ORDER BY b.id_buseta
        ";

        $st = $con->prepare($sql);
        $st->execute($params);

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
