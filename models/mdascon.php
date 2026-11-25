<?php
require_once("conexion.php");

class Mdascon extends Conexion
{
    public function obtenerConductorPorUsuario($idUsuario)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_conductor AS id, nombre, documento, licencia, estado, jornada, id_usuario 
                FROM conductor WHERE id_usuario = :idUsuario LIMIT 1";
        $st = $con->prepare($sql);
        $st->execute([':idUsuario' => $idUsuario]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerConductorPorId($idConductor)
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_conductor AS id, nombre, documento, licencia, estado, jornada, id_usuario 
                FROM conductor WHERE id_conductor = :idConductor LIMIT 1";
        $st = $con->prepare($sql);
        $st->execute([':idConductor' => $idConductor]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function listarTodosConductores()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_conductor AS id, nombre, licencia FROM conductor ORDER BY id_conductor ASC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerResumen()
    {
        return [
            "rutasCompletadas" => 4,
            "rutasProgramadas" => 6,
            "paradasRealizadas" => 18,
            "paradasTotales" => 25,
            "tiempoConduccion" => "04h 35m",
            "kilometros" => "86.4 km"
        ];
    }

    public function obtenerRutaActual()
    {
        return [
            "nombre" => "Ruta 01: Centro - Chía",
            "vehiculo" => "BUS-7892",
            "estado" => "En ruta",
            "progreso" => 68,
            "paradaActual" => "Centro Comercial Sabana",
            "proximaParada" => "Parque Principal de Chía",
            "tiempoProximaParada" => "08 min",
            "velocidad" => "42 km/h",
            "tiempoRuta" => "01h 18m",
            "horaInicio" => "07:30 AM"
        ];
    }

    public function obtenerProximasRutas()
    {
        return [
            ["hora" => "10:30 AM", "ruta" => "Ruta 02: Chía - Centro", "vehiculo" => "BUS-7892", "estado" => "Programada"],
            ["hora" => "12:15 PM", "ruta" => "Ruta 03: Chía - Cajicá", "vehiculo" => "BUS-7892", "estado" => "Programada"],
            ["hora" => "02:00 PM", "ruta" => "Ruta 01: Centro - Chía", "vehiculo" => "BUS-7892", "estado" => "Programada"]
        ];
    }

    public function obtenerAlertas()
    {
        return [
            ["tipo" => "trafico", "titulo" => "Tráfico moderado", "descripcion" => "Se presenta congestión en el sector Centro de Chía.", "hora" => "09:42 AM"],
            ["tipo" => "informacion", "titulo" => "Próxima parada", "descripcion" => "Recuerde realizar parada en el Parque Principal.", "hora" => "09:38 AM"]
        ];
    }
}