<?php

require_once __DIR__ . '/../models/mgpqrs.php';

class Cgpqrs
{
    private $modelo;


    public function __construct()
    {
        $this->modelo = new Mgpqrs();
    }


    public function listar()
    {
        return $this->modelo->listar();
    }


    public function resumen()
    {
        return $this->modelo->obtenerResumen();
    }
}