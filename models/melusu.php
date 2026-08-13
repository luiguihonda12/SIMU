<?php
require_once("conexion.php");

class melusu extends Conexion {

    public function existe($id) {
        $con = $this->get_conexion();

        $sql = "SELECT id_usuario
                FROM usuario
                WHERE id_usuario = :id
                LIMIT 1";

        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);

        return (bool)$st->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $con = $this->get_conexion();

        $sql = "DELETE FROM usuario
                WHERE id_usuario = :id";

        $st = $con->prepare($sql);

        return $st->execute([':id' => $id]);
    }
}
?>
