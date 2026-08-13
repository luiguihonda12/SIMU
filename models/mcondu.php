<?php
require_once("conexion.php");

/**
 * ============================================================
 * MODELO: CONDUCTOR
 * Vista 16 - Conductor
 * ============================================================
 */

class Mcondu extends Conexion
{
    /**
     * Obtener el conductor vinculado a un usuario.
     *
     * Si se recibe $idConductor se busca ese registro.
     * Si se recibe $idUsuario se busca el conductor asociado
     * a la cuenta de usuario (rol Conductor).
     */
    public function obtenerConductor($idUsuario = null, $idConductor = null)
    {
        $con = $this->get_conexion();

        $sql = "
            SELECT
                c.id_conductor AS id,
                c.nombre,
                c.documento,
                c.telefono,
                c.correo,
                c.licencia,
                c.tipo_licencia AS tipoLicencia,
                c.estado,
                c.jornada,
                c.id_usuario,
                u.nombre AS usuario_nombre,
                u.apellidos AS usuario_apellidos,
                CONCAT(u.nombre, ' ', u.apellidos) AS usuario
            FROM conductor c
            LEFT JOIN usuario u ON c.id_usuario = u.id_usuario
        ";

        if ($idConductor !== null) {
            $sql .= " WHERE c.id_conductor = :idConductor LIMIT 1";
            $st = $con->prepare($sql);
            $st->execute([':idConductor' => $idConductor]);
        } else {
            $sql .= " WHERE c.id_usuario = :idUsuario LIMIT 1";
            $st = $con->prepare($sql);
            $st->execute([':idUsuario' => $idUsuario]);
        }

        $conductor = $st->fetch(PDO::FETCH_ASSOC);

        if (!$conductor) {
            return null;
        }

        $conductor['estado'] = $conductor['estado'] ?? 'Activo';

        return $conductor;
    }

    /**
     * Rutas disponibles para el conductor.
     *
     * Datos temporales mientras se completa el módulo de rutas.
     */
    public function obtenerRutas()
    {
        return [
            [
                "id" => 1,
                "nombre" => "Ruta 01: Centro - Chía",
                "vehiculo" => "BUS-7892",
                "estado" => "Activo"
            ],

            [
                "id" => 2,
                "nombre" => "Ruta 02: Chía - Centro",
                "vehiculo" => "BUS-4567",
                "estado" => "Activo"
            ],

            [
                "id" => 3,
                "nombre" => "Ruta 03: Chía - Cajicá",
                "vehiculo" => "BUS-3210",
                "estado" => "Activo"
            ]
        ];
    }

    /**
     * Iniciar una ruta.
     *
     * Por ahora solamente devuelve el estado.
     * Después podemos conectarlo a la BD.
     */
    public function iniciarRuta($rutaId)
    {
        return [
            "success" => true,
            "estado" => "EN RUTA",
            "mensaje" => "La ruta ha sido iniciada correctamente."
        ];
    }

    /**
     * Finalizar una ruta.
     */
    public function finalizarRuta($rutaId)
    {
        return [
            "success" => true,
            "estado" => "FINALIZADA",
            "mensaje" => "La ruta ha sido finalizada correctamente."
        ];
    }
}
