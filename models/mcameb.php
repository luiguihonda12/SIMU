<?php
require_once("conexion.php");

class mcameb extends Conexion {

    public function obtener($id) {
        $con = $this->get_conexion();

        $sql = "
            SELECT
                id_buseta,
                placa,
                estado
            FROM buseta
            WHERE id_buseta = :id
        ";

        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);

        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function cambiar($id, $estado) {
        $con = $this->get_conexion();

        $sql = "
            UPDATE buseta
            SET estado = :estado
            WHERE id_buseta = :id
        ";

        $st = $con->prepare($sql);

        return $st->execute([
            ':estado' => $estado,
            ':id'     => $id
        ]);
    }
}
?>
