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

    public function actualizar($datos)
    {
        return $this->modelo->actualizarPQRS($datos);
    }
}