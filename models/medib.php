<?php
require_once("conexion.php");

class medib extends Conexion {

    public function obtener($id) {
        $con = $this->get_conexion();

        $sql = "
            SELECT
                id_buseta,
                placa,
                capacidad,
                estado,
                id_ruta,
                id_empresa
            FROM buseta
            WHERE id_buseta = :id
        ";

        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);

        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function existePlacaOtro($placa, $id) {
        $con = $this->get_conexion();

        $sql = "
            SELECT id_buseta
            FROM buseta
            WHERE placa = :placa
            AND id_buseta <> :id
            LIMIT 1
        ";

        $st = $con->prepare($sql);
        $st->execute([':placa' => $placa, ':id' => $id]);

        return (bool)$st->fetch(PDO::FETCH_ASSOC);
    }

    public function rutas() {
        $con = $this->get_conexion();

        $sql = "SELECT id_ruta, nombre
                FROM ruta
                ORDER BY nombre";

        $st = $con->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function empresas() {
        $con = $this->get_conexion();

        $sql = "SELECT id_empresa, nombre
                FROM empresa
                ORDER BY nombre";

        $st = $con->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($datos) {
        $con = $this->get_conexion();

        $sql = "
            UPDATE buseta
            SET
                placa = :placa,
                capacidad = :capacidad,
                estado = :estado,
                id_ruta = :id_ruta,
                id_empresa = :id_empresa

            WHERE id_buseta = :id_buseta
        ";

        $st = $con->prepare($sql);

        return $st->execute([
            ':placa'      => $datos['placa'],
            ':capacidad'  => $datos['capacidad'],
            ':estado'     => $datos['estado'],
            ':id_ruta'    => $datos['id_ruta'],
            ':id_empresa' => $datos['id_empresa'],
            ':id_buseta'  => $datos['id_buseta']
        ]);
    }
}
?>
