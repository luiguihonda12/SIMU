<?php
require_once("conexion.php");

class mgesr extends Conexion {

    public function listar() {
        $con = $this->get_conexion();

        $sql = "
            SELECT
                id_rol,
                nombre_del_rol

            FROM rol

            ORDER BY nombre_del_rol
        ";

        $st = $con->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existe($nombre, $id = 0) {
        $con = $this->get_conexion();

        if ($id > 0) {
            $sql = "
                SELECT id_rol
                FROM rol
                WHERE nombre_del_rol = :nombre
                AND id_rol <> :id
            ";

            $st = $con->prepare($sql);
            $st->execute([
                ':nombre' => $nombre,
                ':id'     => $id
            ]);
        } else {
            $sql = "
                SELECT id_rol
                FROM rol
                WHERE nombre_del_rol = :nombre
            ";

            $st = $con->prepare($sql);
            $st->execute([':nombre' => $nombre]);
        }

        return (bool)$st->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre) {
        $con = $this->get_conexion();

        $sql = "INSERT INTO rol
                (nombre_del_rol)
                VALUES (:nombre)";

        $st = $con->prepare($sql);

        return $st->execute([':nombre' => $nombre]);
    }

    public function actualizar($id, $nombre) {
        $con = $this->get_conexion();

        $sql = "UPDATE rol
                SET nombre_del_rol = :nombre
                WHERE id_rol = :id";

        $st = $con->prepare($sql);

        return $st->execute([
            ':nombre' => $nombre,
            ':id'     => $id
        ]);
    }

    // El rol puede estar asignado a usuarios, por eso se valida antes
    public function enUso($id) {
        $con = $this->get_conexion();

        $sql = "SELECT COUNT(*) AS total
                FROM usuario
                WHERE id_rol = :id";

        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);

        return (int)$row['total'] > 0;
    }

    public function eliminar($id) {
        $con = $this->get_conexion();

        $sql = "DELETE FROM rol
                WHERE id_rol = :id";

        $st = $con->prepare($sql);

        return $st->execute([':id' => $id]);
    }
}
?>
