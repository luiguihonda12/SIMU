<?php
require_once __DIR__ . '/../models/mmodru.php';

/**
 * ============================================================
 * CONTROLADOR: MODULO DE EDICION DE RUTA
 * Vista 8 - Edicion del recorrido (paraderos) de una ruta
 * ope: 0 = mostrar, 1 = agregar paradero, 2 = cargar paradero,
 *      3 = actualizar paradero, 4 = retirar paradero del recorrido
 * ============================================================
 */
class Cmodru
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mmodru();
    }

    public function index()
    {
        $ope        = $_REQUEST['ope'] ?? 0;
        $idRuta     = $_REQUEST['id_ruta'] ?? '';
        $idParadero = $_REQUEST['id_paradero'] ?? '';
        $mensaje    = '';
        $tipo       = '';
        $ruta       = null;
        $paraderos  = [];
        $libres     = [];
        $paraEdit   = null;

        if ($ope == 1 && $idRuta != '') {
            if ($idParadero == '') {
                $mensaje = 'Seleccione el paradero que desea agregar al recorrido.';
                $tipo    = 'danger';
            } elseif ($this->modelo->asignarParadero($idParadero, $idRuta)) {
                $mensaje = 'El paradero fue agregado al recorrido de la ruta.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible agregar el paradero al recorrido.';
                $tipo    = 'danger';
            }
        }

        if ($ope == 3) {
            $datos = [
                'id_paradero' => $idParadero,
                'nombre'      => trim($_REQUEST['nombre'] ?? ''),
                'ubicacion'   => trim($_REQUEST['ubicacion'] ?? '')
            ];

            if ($datos['id_paradero'] == '' || $datos['nombre'] == '' || $datos['ubicacion'] == '') {
                $mensaje = 'El nombre y la ubicacion del paradero son obligatorios.';
                $tipo    = 'danger';
            } elseif ($this->modelo->actualizarParadero($datos)) {
                $mensaje = 'El paradero fue actualizado correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible actualizar el paradero.';
                $tipo    = 'danger';
            }
        }

        if ($ope == 4) {
            if ($idParadero != '' && $this->modelo->quitarParadero($idParadero)) {
                $mensaje = 'El paradero fue retirado del recorrido.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible retirar el paradero del recorrido.';
                $tipo    = 'danger';
            }
        }

        if ($idRuta != '') {
            $ruta      = $this->modelo->obtenerRuta($idRuta);
            $paraderos = $this->modelo->paraderosDeRuta($idRuta);
            $libres    = $this->modelo->paraderosLibres();
        }

        // ope 2: cargar un paradero puntual en el formulario de edicion
        if ($ope == 2 && $idParadero != '') {
            foreach ($paraderos as $p) {
                if ($p['id_paradero'] == $idParadero) {
                    $paraEdit = $p;
                }
            }
        }

        return [
            'rutas'     => $this->modelo->listarRutas(),
            'ruta'      => $ruta,
            'idRuta'    => $idRuta,
            'paraderos' => $paraderos,
            'libres'    => $libres,
            'paraEdit'  => $paraEdit,
            'mensaje'   => $mensaje,
            'tipo'      => $tipo
        ];
    }
}