<?php
require_once __DIR__ . '/cseguridad_api.php';
simuExigirSesion();

require_once __DIR__ . '/../models/mconrun.php';

/**
 * ============================================================
 * CONTROLADOR: CONSULTAR HORARIOS (CLIENTE)
 * ============================================================
 */
class Cconru
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mconrun();
    }

    public function index()
    {
        $busqueda = trim($_REQUEST['busqueda'] ?? '');

        return [
            'horarios' => $this->modelo->listarHorarios($busqueda),
            'resumen'  => $this->modelo->resumen(),
            'busqueda' => $busqueda
        ];
    }
}
