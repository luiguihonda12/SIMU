<?php
require_once __DIR__ . '/../models/mmenucli.php';

/**
 * ============================================================
 * CONTROLADOR: MENÚ INICIAL CLIENTE
 * Vista - Menú Inicial Cliente
 * ============================================================
 */
class Cmenucli
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mmenucli();
    }

    public function index()
    {
        return [
            'opciones' => $this->modelo->obtenerOpciones()
        ];
    }
}
