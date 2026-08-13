<?php

require_once __DIR__ . '/../models/mperfilusu.php';

class Cperfilusu
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new mperfilusu();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_usuario = $_SESSION['id_usuario'] ?? null;

        $usuario = $id_usuario
            ? $this->modelo->obtenerUsuario($id_usuario)
            : null;

        return $usuario;
    }
}
?>
