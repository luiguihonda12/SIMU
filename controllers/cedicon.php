<?php

/**
 * ============================================================
 * CONTROLADOR: EDITAR CONDUCTOR
 * ============================================================
 */

require_once __DIR__ . '/../models/medicon.php';

class Cedicon
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Medicon();
    }

    public function mostrar($id = 1)
    {
        return $this->modelo->obtenerConductor($id);
    }

    public function listarConductores()
    {
        return $this->modelo->listarTodosConductores();
    }

    public function usuariosConductores()
    {
        return $this->modelo->listarUsuariosConductores();
    }

    public function actualizar($datos)
    {
        return $this->modelo->actualizarConductor($datos);
    }
}