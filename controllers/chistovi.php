<?php
require_once __DIR__ . '/cseguridad_api.php';
simuExigirSesion();

require_once __DIR__ . '/../models/mhistovi.php';

/**
 * ============================================================
 * CONTROLADOR: HISTORIAL DE VIAJES (CLIENTE)
 * ============================================================
 */
class Chistovi
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mhistovi();
    }

    public function index()
    {
        $idUsuario = (int) ($_SESSION['id_usuario'] ?? 0);

        return [
            'viajes'  => $this->modelo->listarViajes($idUsuario),
            'resumen' => $this->modelo->resumen($idUsuario)
        ];
    }
}
