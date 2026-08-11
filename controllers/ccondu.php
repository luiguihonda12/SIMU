<?php

/**
 * ============================================================
 * CONTROLADOR: CONDUCTOR
 * Vista 16 - Conductor
 * ============================================================
 */

require_once __DIR__ . '/../models/mcondu.php';


class Ccondu
{
    private $modelo;


    public function __construct()
    {
        $this->modelo = new Mcondu();
    }


    /**
     * Mostrar la pantalla principal del conductor.
     */
    public function index()
    {
        $conductor = $this->modelo->obtenerConductor();

        $rutas = $this->modelo->obtenerRutas();

        $rutaSeleccionada = $rutas[0];

        $rutaActiva = false;

        $estadoRuta = "LISTA PARA INICIAR";

        return [
            "conductor" => $conductor,
            "rutas" => $rutas,
            "rutaSeleccionada" => $rutaSeleccionada,
            "rutaActiva" => $rutaActiva,
            "estadoRuta" => $estadoRuta
        ];
    }


    /**
     * Iniciar ruta.
     */
    public function iniciarRuta($rutaId)
    {
        return $this->modelo->iniciarRuta($rutaId);
    }


    /**
     * Finalizar ruta.
     */
    public function finalizarRuta($rutaId)
    {
        return $this->modelo->finalizarRuta($rutaId);
    }
}