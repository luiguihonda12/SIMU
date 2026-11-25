<?php
require_once __DIR__ . '/../models/mcondu.php';

class Ccondu
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mcondu();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUsuario = $_SESSION['id_usuario'] ?? null;
        
        // Verificar y sincronizar si el usuario actual es conductor pero no está en la tabla conductor
        if ($idUsuario) {
            $this->modelo->sincronizarConductorUsuario($idUsuario);
        }

        $idConductorGet = $_GET['id'] ?? null;
        
        // Si pasan un ID por URL, tiene prioridad; si no, busca por el usuario de la sesión
        $conductor = null;
        if ($idConductorGet) {
            $conductor = $this->modelo->obtenerConductorPorId($idConductorGet);
        } elseif ($idUsuario) {
            $conductor = $this->modelo->obtenerConductorPorUsuario($idUsuario);
        }

        $rutas = $this->modelo->obtenerRutas();
        $listaConductores = $this->modelo->listarTodosConductores();

        return [
            "conductor" => $conductor,
            "rutas" => $rutas,
            "listaConductores" => $listaConductores,
            "idSeleccionado" => $idConductorGet ?? ($conductor['id'] ?? null)
        ];
    }
}