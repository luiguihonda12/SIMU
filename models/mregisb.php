<?php
require_once("conexion.php");

class mregisb extends Conexion {

    // Verificar si la placa ya existe
    public function existePlaca($placa) {
        $con = $this->get_conexion();
        $sql = "SELECT id_buseta
                FROM buseta
                WHERE placa = :placa
                LIMIT 1";
        $st = $con->prepare($sql);
        $st->execute([':placa' => $placa]);
        return (bool)$st->fetch(PDO::FETCH_ASSOC);
    }

    // Listar rutas
    public function listarRutas() {
        $con = $this->get_conexion();
        $sql = "SELECT id_ruta, nombre
                FROM ruta
                ORDER BY nombre";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar empresas
    public function listarEmpresas() {
        $con = $this->get_conexion();
        $sql = "SELECT id_empresa, nombre
                FROM empresa
                ORDER BY nombre";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar buseta
    public function registrar($datos) {
        $con = $this->get_conexion();
        $sql = "INSERT INTO buseta
                (placa, capacidad, estado, id_ruta, id_empresa)
                VALUES (:placa, :capacidad, :estado, :id_ruta, :id_empresa)";
        $st = $con->prepare($sql);
        return $st->execute([
            ':placa'      => $datos['placa'],
            ':capacidad'  => $datos['capacidad'],
            ':estado'     => $datos['estado'],
            ':id_ruta'    => $datos['id_ruta'],
            ':id_empresa' => $datos['id_empresa']
        ]);
    }
}
?>
