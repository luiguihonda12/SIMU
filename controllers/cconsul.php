<?php
require_once __DIR__ . '/cseguridad_api.php';
simuExigirSesion();

require_once __DIR__ . '/../models/mconsul.php';

/**
 * ============================================================
 * CONTROLADOR: CONSULTAR RUTAS (CLIENTE)
 * ============================================================
 */
class Cconsul
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mconsul();
    }

    public function index()
    {
        $busqueda = trim($_REQUEST['busqueda'] ?? '');

        return [
            'rutas'    => $this->modelo->listarRutas($busqueda),
            'resumen'  => $this->modelo->resumen(),
            'busqueda' => $busqueda
        ];
    }
}
