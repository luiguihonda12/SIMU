<?php

/**
 * ============================================================
 * MODELO: MENÚ INICIAL CLIENTE
 * Proporciona las opciones de servicios disponibles del cliente
 * ============================================================
 */
class Mmenucli
{
    public function obtenerOpciones()
    {
        return [

            [
                'nombre' => 'Consultar Rutas',
                'icono'  => 'fas fa-route',
                'url'    => 'index.php?pg=consultarRutas'
            ],

            [
                'nombre' => 'Ver Paraderos',
                'icono'  => 'fas fa-map-marker-alt',
                'url'    => 'index.php?pg=paraderos'
            ],

            [
                'nombre' => 'Consultar Horarios',
                'icono'  => 'fas fa-clock',
                'url'    => 'index.php?pg=horarios'
            ],

            [
                'nombre' => 'Historial de Viajes',
                'icono'  => 'fas fa-clipboard-list',
                'url'    => 'index.php?pg=historialViajes'
            ],

            [
                'nombre' => 'Enviar PQRS',
                'icono'  => 'fas fa-comment',
                'url'    => 'index.php?pg=nuevaPQRS'
            ],

            [
                'nombre' => 'Mi Perfil',
                'icono'  => 'fas fa-user',
                'url'    => 'index.php?pg=perfilUsuario'
            ]

        ];
    }
}
