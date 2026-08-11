<?php

class Mgpqrs
{
    private $pqrs = [

        [
            'id' => 'PQRS-00026',
            'tipo' => 'Petición',
            'categoria' => 'Servicio de transporte',
            'ciudadano' => 'María González',
            'fecha' => '10/08/2026',
            'estado' => 'En revisión',
            'prioridad' => 'Media'
        ],

        [
            'id' => 'PQRS-00025',
            'tipo' => 'Queja',
            'categoria' => 'Ruta y horarios',
            'ciudadano' => 'Carlos Rodríguez',
            'fecha' => '09/08/2026',
            'estado' => 'En proceso',
            'prioridad' => 'Alta'
        ],

        [
            'id' => 'PQRS-00024',
            'tipo' => 'Solicitud',
            'categoria' => 'Paraderos',
            'ciudadano' => 'Laura Martínez',
            'fecha' => '08/08/2026',
            'estado' => 'Resuelta',
            'prioridad' => 'Baja'
        ],

        [
            'id' => 'PQRS-00023',
            'tipo' => 'Reclamo',
            'categoria' => 'Servicio de transporte',
            'ciudadano' => 'Andrés Pérez',
            'fecha' => '07/08/2026',
            'estado' => 'En proceso',
            'prioridad' => 'Media'
        ],

        [
            'id' => 'PQRS-00022',
            'tipo' => 'Petición',
            'categoria' => 'Tarifas',
            'ciudadano' => 'Sofía Hernández',
            'fecha' => '06/08/2026',
            'estado' => 'Resuelta',
            'prioridad' => 'Baja'
        ],

        [
            'id' => 'PQRS-00021',
            'tipo' => 'Queja',
            'categoria' => 'Conductores',
            'ciudadano' => 'Juan Torres',
            'fecha' => '05/08/2026',
            'estado' => 'Rechazada',
            'prioridad' => 'Media'
        ]

    ];


    public function listar()
    {
        return $this->pqrs;
    }


    public function obtenerResumen()
    {
        $total = count($this->pqrs);
        $revision = 0;
        $proceso = 0;
        $resueltas = 0;

        foreach ($this->pqrs as $item) {

            if ($item['estado'] === 'En revisión') {
                $revision++;
            }

            if ($item['estado'] === 'En proceso') {
                $proceso++;
            }

            if ($item['estado'] === 'Resuelta') {
                $resueltas++;
            }
        }

        return [
            'total' => $total,
            'revision' => $revision,
            'proceso' => $proceso,
            'resueltas' => $resueltas
        ];
    }
}