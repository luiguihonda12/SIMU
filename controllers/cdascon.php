<?php

/**
 * ============================================================
 * CONTROLADOR: DASHBOARD CONDUCTOR
 * Vista 17
 * ============================================================
 */

require_once __DIR__ . '/../models/mdascon.php';


class Cdascon
{
    private $modelo;


    public function __construct()
    {
        $this->modelo = new Mdascon();
    }


    /**
     * Carga toda la información necesaria
     * para el Dashboard del conductor.
     */
    public function index()
    {
        $conductor = $this->modelo->obtenerConductor();

        $resumen = $this->modelo->obtenerResumen();

        $rutaActual = $this->modelo->obtenerRutaActual();

        $proximasRutas = $this->modelo->obtenerProximasRutas();

        $alertas = $this->modelo->obtenerAlertas();


        return [
            "conductor" => $conductor,
            "resumen" => $resumen,
            "rutaActual" => $rutaActual,
            "proximasRutas" => $proximasRutas,
            "alertas" => $alertas
        ];
    }
}