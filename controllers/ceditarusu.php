<?php

require_once __DIR__ . '/../models/meditarusu.php';

class Ceditarusu
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new meditarusu();
    }

    public function mostrar($id = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_usuario = $id
            ?: ($_SESSION['id_usuario'] ?? null);

        return $id_usuario
            ? $this->modelo->obtenerUsuario($id_usuario)
            : null;
    }

    public function actualizar($datos)
    {
        return $this->modelo->actualizarUsuario($datos);
    }
}
?>
