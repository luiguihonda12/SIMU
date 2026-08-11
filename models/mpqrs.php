<?php
require_once("conexion.php");

class Mpqrs extends Conexion
{
    // Obtener una PQRS por su código
    public function obtenerPQRS($id = null)
    {
        $con = $this->get_conexion();
        $sql = "SELECT
                    id_pqrs AS id,
                    tipo_pqrs AS tipo,
                    categoria,
                    estado,
                    prioridad,
                    DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha,
                    DATE_FORMAT(hora, '%h:%i %p') AS hora,
                    nombre,
                    documento,
                    correo,
                    telefono,
                    asunto,
                    descripcion,
                    respuesta,
                    funcionario
                FROM pqrs
                WHERE id_pqrs = :id";
        $st = $con->prepare($sql);
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : null;
    }

    // Actualizar la gestión de una PQRS (estado, prioridad, responsable y respuesta)
    public function actualizarPQRS($id, $datos)
    {
        $con = $this->get_conexion();
        $sql = "UPDATE pqrs
                SET estado = :estado,
                    prioridad = :prioridad,
                    funcionario = :funcionario,
                    respuesta = :respuesta
                WHERE id_pqrs = :id";
        $st = $con->prepare($sql);
        return $st->execute([
            ':estado'      => $datos['estado'],
            ':prioridad'   => $datos['prioridad'],
            ':funcionario' => $datos['funcionario'],
            ':respuesta'   => $datos['respuesta'],
            ':id'          => $id
        ]);
    }

    // Registrar una nueva PQRS
    public function crearPQRS($datos)
    {
        $id = $this->siguienteId();
        $con = $this->get_conexion();
        $sql = "INSERT INTO pqrs (
                    id_pqrs, tipo_pqrs, categoria, estado, prioridad,
                    fecha, hora, asunto, descripcion, respuesta, funcionario,
                    id_usuario, nombre, documento, correo, telefono
                ) VALUES (
                    :id, :tipo, :categoria, :estado, :prioridad,
                    :fecha, :hora, :asunto, :descripcion, :respuesta, :funcionario,
                    :id_usuario, :nombre, :documento, :correo, :telefono
                )";
        $st = $con->prepare($sql);
        $ok = $st->execute([
            ':id'          => $id,
            ':tipo'        => $datos['tipo'],
            ':categoria'   => $datos['categoria'],
            ':estado'      => 'En revisión',
            ':prioridad'   => $datos['prioridad'],
            ':fecha'       => date('Y-m-d'),
            ':hora'        => date('H:i:s'),
            ':asunto'      => $datos['asunto'],
            ':descripcion' => $datos['descripcion'],
            ':respuesta'   => null,
            ':funcionario' => 'Sin asignar',
            ':id_usuario'  => $datos['id_usuario'] ?? null,
            ':nombre'      => $datos['nombre'],
            ':documento'   => $datos['documento'],
            ':correo'      => $datos['correo'],
            ':telefono'    => $datos['telefono']
        ]);

        return $ok ? $id : false;
    }

    // Genera el siguiente código secuencial, ej. PQRS-00027
    private function siguienteId()
    {
        $con = $this->get_conexion();
        $st = $con->query("SELECT MAX(CAST(SUBSTRING(id_pqrs, 6) AS UNSIGNED)) AS ultimo FROM pqrs");
        $row = $st->fetch(PDO::FETCH_ASSOC);
        $n = (int)$row['ultimo'] + 1;
        return 'PQRS-' . str_pad((string)$n, 5, '0', STR_PAD_LEFT);
    }
}
