<?php
require_once("conexion.php");

class mdeleb extends Conexion {

    public function eliminar($id) {
        $con = $this->get_conexion();

        $sql = "DELETE FROM buseta
                WHERE id_buseta = :id";

        $st = $con->prepare($sql);

        return $st->execute([':id' => $id]);
    }
}
?>
