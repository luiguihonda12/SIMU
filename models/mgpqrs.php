<?php
require_once("conexion.php");

class Mgpqrs extends Conexion
{
    // Listado de todas las PQRS
    public function listar()
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    id_pqrs AS id,
                    tipo_pqrs AS tipo,
                    categoria,
                    estado,
                    prioridad,
                    DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha,
                    nombre AS ciudadano
                FROM pqrs
                ORDER BY id_pqrs DESC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Resumen de PQRS por estado
    public function obtenerResumen()
    {
        $con = $this->get_conexion();
        $st = $con->query("SELECT estado, COUNT(*) AS total FROM pqrs GROUP BY estado");

        $resumen = [
            'total'     => 0,
            'revision'  => 0,
            'proceso'   => 0,
            'resueltas' => 0
        ];

        foreach ($st as $fila) {
            $resumen['total'] += (int)$fila['total'];

            if ($fila['estado'] === 'En revisión') {
                $resumen['revision'] = (int)$fila['total'];
            } elseif ($fila['estado'] === 'En proceso') {
                $resumen['proceso'] = (int)$fila['total'];
            } elseif ($fila['estado'] === 'Resuelta') {
                $resumen['resueltas'] = (int)$fila['total'];
            }
        }

        return $resumen;
    }
}
