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
     * Lista las rutas registradas con su vehiculo (buseta)
     * y los paraderos que conforman el recorrido.
     */
    public function obtenerRutas()
    {
        $con = $this->get_conexion();

        $sql = "SELECT r.id_ruta AS id, r.nombre, r.origen, r.destino, r.horario,
                       COALESCE(b.placa, 'Sin asignar') AS vehiculo
                FROM ruta r
                LEFT JOIN buseta b ON b.id_ruta = r.id_ruta
                ORDER BY r.id_ruta DESC";

        $st = $con->prepare($sql);
        $st->execute();

        $rutas = $st->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rutas as &$ruta) {
            $p = $con->prepare("
                SELECT id_paradero, nombre, ubicacion
                FROM paradero
                WHERE id_ruta = :id
                ORDER BY id_paradero
            ");
            $p->execute([':id' => $ruta['id']]);
            $ruta['paradas'] = $p->fetchAll(PDO::FETCH_ASSOC);
        }

        return $rutas;
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
            "estado" => "EN RUTA"
        ];
    }

    /**
     * Finalizar una ruta.
     */
    public function finalizarRuta($rutaId)
    {
        return [
            "success" => true,
            "estado" => "FINALIZADA"
        ];
    }
}
