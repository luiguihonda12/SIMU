<?php
require_once __DIR__ . '/../models/mlisru.php';

/**
 * ============================================================
 * CONTROLADOR: MODULO DE LISTADO DE RUTAS
 * Vista 9 - Listado de Rutas
 * ope: 0 = mostrar, 4 = eliminar
 * ============================================================
 */
class Clisru
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mlisru();
    }

    public function index()
    {
        $ope      = $_REQUEST['ope'] ?? 0;
        $busqueda = trim($_REQUEST['busqueda'] ?? '');
        $mensaje  = '';
        $tipo     = '';

        if ($ope == 4) {
            $idRuta = $_REQUEST['id_ruta'] ?? '';

            if ($idRuta == '') {
                $mensaje = 'No se recibio la ruta que desea eliminar.';
                $tipo    = 'danger';
            } elseif ($this->modelo->tienePagos($idRuta)) {
                $mensaje = 'La ruta tiene pagos asociados y no puede eliminarse.';
                $tipo    = 'danger';
            } elseif ($this->modelo->eliminar($idRuta)) {
                $mensaje = 'La ruta fue eliminada y sus paraderos quedaron libres.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible eliminar la ruta.';
                $tipo    = 'danger';
            }
        }

        return [
            'rutas'    => $this->modelo->listar($busqueda),
            'resumen'  => $this->modelo->resumen(),
            'busqueda' => $busqueda,
            'mensaje'  => $mensaje,
            'tipo'     => $tipo
        ];
    }
}