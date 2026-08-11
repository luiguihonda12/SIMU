<?php

require_once __DIR__ . '/../models/mpqrs.php';

class Cdpqrs
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mpqrs();
    }

    public function mostrar($id = null)
    {
        return $this->modelo->obtenerPQRS($id);
    }

    public function actualizar($id, $datos)
    {
        return $this->modelo->actualizarPQRS($id, $datos);
    }

    public function crear($datos)
    {
        return $this->modelo->crearPQRS($datos);
    }
}
