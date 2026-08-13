<?php
require_once __DIR__ . '/../models/mmodru.php';

/**
 * ============================================================
 * CONTROLADOR: MODULO DE EDICION DE RUTA
 * Vista 8 - Edicion del recorrido (paraderos) de una ruta
 * ope: 0 = mostrar, 1 = agregar paradero existente,
 *      2 = cargar paradero, 3 = actualizar paradero,
 *      4 = retirar paradero, 5 = actualizar datos de la ruta,
 *      6 = crear paradero nuevo en el recorrido
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
        $ope         = $_REQUEST['ope'] ?? 0;
        $idRuta      = $_REQUEST['id_ruta'] ?? '';
        $idParadero  = $_REQUEST['id_paradero'] ?? '';
        $mensaje     = '';
        $tipo        = '';
        $ruta        = null;
        $paraderos   = [];
        $disponibles = [];
        $paraEdit    = null;

        // Actualizar los datos basicos de la ruta
        if ($ope == 5) {
            $datos = [
                'id_ruta' => $idRuta,
                'nombre'  => trim($_REQUEST['nombre'] ?? ''),
                'origen'  => trim($_REQUEST['origen'] ?? ''),
                'destino' => trim($_REQUEST['destino'] ?? ''),
                'horario' => trim($_REQUEST['horario'] ?? '')
            ];

            if ($datos['id_ruta'] == '' || $datos['nombre'] == '' || $datos['origen'] == '' || $datos['destino'] == '' || $datos['horario'] == '') {
                $mensaje = 'Todos los datos de la ruta son obligatorios.';
                $tipo    = 'danger';
            } elseif ($this->modelo->existeNombre($datos['nombre'], $datos['id_ruta'])) {
                $mensaje = 'Ya existe otra ruta registrada con ese nombre.';
                $tipo    = 'danger';
            } elseif ($this->modelo->actualizarRuta($datos)) {
                $mensaje = 'Los datos de la ruta fueron actualizados correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible actualizar los datos de la ruta.';
                $tipo    = 'danger';
            }
        }

        // Agregar un paradero existente al recorrido
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

        // Crear un paradero nuevo directamente en el recorrido
        if ($ope == 6 && $idRuta != '') {
            $datos = [
                'nombre'    => trim($_REQUEST['nombre_par'] ?? ''),
                'ubicacion' => trim($_REQUEST['ubicacion_par'] ?? ''),
                'id_ruta'   => $idRuta
            ];

            if ($datos['nombre'] == '' || $datos['ubicacion'] == '') {
                $mensaje = 'Debe indicar el nombre y la ubicacion del nuevo paradero.';
                $tipo    = 'danger';
            } elseif ($this->modelo->crearParadero($datos)) {
                $mensaje = 'El paradero fue creado y agregado al recorrido.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible crear el paradero.';
                $tipo    = 'danger';
            }
        }

        // Actualizar un paradero del recorrido
        if ($ope == 3) {
            $datos = [
                'id_paradero' => $idParadero,
                'nombre'      => trim($_REQUEST['nombre_par'] ?? ''),
                'ubicacion'   => trim($_REQUEST['ubicacion_par'] ?? '')
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

        // Retirar un paradero del recorrido
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
            $ruta        = $this->modelo->obtenerRuta($idRuta);
            $paraderos   = $this->modelo->paraderosDeRuta($idRuta);
            $disponibles = $this->modelo->paraderosDisponibles($idRuta);
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
            'rutas'       => $this->modelo->listarRutas(),
            'ruta'        => $ruta,
            'idRuta'      => $idRuta,
            'paraderos'   => $paraderos,
            'disponibles' => $disponibles,
            'paraEdit'    => $paraEdit,
            'mensaje'     => $mensaje,
            'tipo'        => $tipo
        ];
    }
}
