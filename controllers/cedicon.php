<?php

require_once __DIR__ . '/../models/medicon.php';

class Cedicon
{
    private $modelo;

    // Constructor
    public function __construct()
    {
        $this->modelo = new Medicon();
    }

    // Mostrar conductor
    public function mostrar($id = 1)
    {
        return $this->modelo->obtenerConductor($id);
    }

    // Usuarios disponibles con rol Conductor
    public function usuariosConductores()
    {
        return $this->modelo->listarUsuariosConductores();
    }

    // Guardar cambios
    public function actualizar($datos)
    {
        return $this->modelo->actualizarConductor($datos);
    }
}
