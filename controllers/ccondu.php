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
     *
     * Busca el conductor vinculado al usuario de la sesión.
     * Si no existe vínculo, usa el primer conductor de la BD.
     */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUsuario = $_SESSION['id_usuario'] ?? null;

        $conductor = $this->modelo->obtenerConductor($idUsuario);

        if (!$conductor) {
            $conductor = $this->modelo->obtenerConductor(null, 1);
        }

        if (!$conductor) {
            $conductor = [
                "id" => null,
                "nombre" => "Sin conductor asignado",
                "licencia" => "-",
                "telefono" => "-",
                "id_usuario" => null,
                "estado" => "Activo",
                "usuario" => null
            ];
        }

        $rutas = $this->modelo->obtenerRutas();

        $rutaSeleccionada = $rutas[0] ?? null;

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
