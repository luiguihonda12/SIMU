<?php
require_once("conexion.php");

class mlistb extends Conexion {

    public function listar($filtro = '') {
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

        if ($filtro !== '') {
            $sql .= "
                WHERE
                    b.placa LIKE :buscar
                    OR b.estado LIKE :buscar
                    OR r.nombre LIKE :buscar
                    OR e.nombre LIKE :buscar
            ";
            $params = [':buscar' => "%{$filtro}%"];
        }

        $sql .= "
            ORDER BY b.id_buseta DESC
        ";

        $st = $con->prepare($sql);
        $st->execute($params);

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
