<?php
require_once("conexion.php");

class Medicon extends Conexion
{
    public function obtenerConductor($id = 1)
    {
        $con = $this->get_conexion();
        $sql = "SELECT c.id_conductor AS id, c.nombre, c.documento, c.telefono, c.correo, c.licencia,
                       c.tipo_licencia AS tipoLicencia, c.estado, c.jornada, c.id_usuario,
                       CONCAT(u.nombre, ' ', u.apellidos) AS usuario_nombre
                FROM conductor c
                LEFT JOIN usuario u ON c.id_usuario = u.id_usuario
                WHERE c.id_conductor = :id
                LIMIT 1";

        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);
        $conductor = $st->fetch(PDO::FETCH_ASSOC);

        if (!$conductor) {
            return [
                'id' => 1,
                'nombre' => 'Germán Pérez',
                'documento' => '1020304050',
                'telefono' => '3109876543',
                'correo' => 'german.conductor@simu.com',
                'licencia' => 'C1-ABC',
                'tipoLicencia' => 'Servicio Público',
                'estado' => 'Activo',
                'jornada' => 'Mañana',
                'id_usuario' => null
            ];
        }

        $conductor['estado'] = $conductor['estado'] ?? 'Activo';
        return $conductor;
    }

    public function listarTodosConductores()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_conductor AS id, nombre, licencia FROM conductor ORDER BY id_conductor ASC";
        $st = $con->prepare($sql);
        $st->execute();
        $lista = $st->fetchAll(PDO::FETCH_ASSOC);

        if (empty($lista)) {
            $lista = [
                ['id' => 1, 'nombre' => 'Germán Pérez', 'licencia' => 'C1-ABC']
            ];
        }
        return $lista;
    }

    public function listarUsuariosConductores()
    {
        $con = $this->get_conexion();
        $sql = "SELECT u.id_usuario, CONCAT(u.nombre, ' ', u.apellidos) AS nombre
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                WHERE LOWER(r.nombre_del_rol) = 'conductor'
                ORDER BY u.nombre, u.apellidos";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarConductor($datos)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE conductor
                SET nombre = :nombre, documento = :documento, telefono = :telefono, correo = :correo,
                    licencia = :licencia, tipo_licencia = :tipoLicencia, estado = :estado,
                    jornada = :jornada, id_usuario = :id_usuario
                WHERE id_conductor = :id_conductor";

        $st = $con->prepare($sql);
        return $st->execute([
            ':nombre'        => $datos['nombre'],
            ':documento'     => $datos['documento'],
            ':telefono'      => $datos['telefono'],
            ':correo'        => $datos['correo'],
            ':licencia'      => $datos['licencia'],
            ':tipoLicencia'  => $datos['tipoLicencia'],
            ':estado'        => $datos['estado'],
            ':jornada'       => $datos['jornada'],
            ':id_usuario'    => !empty($datos['id_usuario']) ? $datos['id_usuario'] : null,
            ':id_conductor'  => $datos['id']
        ]);
    }
}