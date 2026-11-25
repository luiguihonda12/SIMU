<?php
require_once __DIR__ . '/../models/mdascon.php';

class Cdascon
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mdascon();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUsuario = $_SESSION['id_usuario'] ?? null;
        $idConductorGet = $_GET['id'] ?? null;

        $conductor = null;
        if ($idConductorGet) {
            $conductor = $this->modelo->obtenerConductorPorId($idConductorGet);
        } elseif ($idUsuario) {
            $conductor = $this->modelo->obtenerConductorPorUsuario($idUsuario);
        }

        $listaConductores = $this->modelo->listarTodosConductores();
        $resumen = $this->modelo->obtenerResumen();
        $rutaActual = $this->modelo->obtenerRutaActual();
        $proximasRutas = $this->modelo->obtenerProximasRutas();
        $alertas = $this->modelo->obtenerAlertas();

        return [
            "conductor" => $conductor,
            "listaConductores" => $listaConductores,
            "resumen" => $resumen,
            "rutaActual" => $rutaActual,
            "proximasRutas" => $proximasRutas,
            "alertas" => $alertas,
            "idSeleccionado" => $idConductorGet ?? ($conductor['id'] ?? null)
        ];
    }
}