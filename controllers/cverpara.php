<?php
require_once __DIR__ . '/cseguridad_api.php';
simuExigirSesion();

require_once __DIR__ . '/../models/mverpara.php';

/**
 * ============================================================
 * CONTROLADOR: VER PARADEROS (CLIENTE)
 * ============================================================
 */
class Cverpara
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mverpara();
    }

    public function index()
    {
        $busqueda = trim($_REQUEST['busqueda'] ?? '');

        return [
            'paraderos' => $this->modelo->listarParaderos($busqueda),
            'resumen'   => $this->modelo->resumen(),
            'busqueda'  => $busqueda
        ];
    }
}
