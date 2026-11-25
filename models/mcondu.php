<?php
require_once("conexion.php");

class Mcondu extends Conexion
{
    // Sincroniza o crea el registro en la tabla conductor si el usuario logueado es rol Conductor
    public function sincronizarConductorUsuario($idUsuario)
    {
        $con = $this->get_conexion();

        // Verificar si el usuario existe y es conductor
        $stUser = $con->prepare("
            SELECT u.id_usuario, u.nombre, u.apellidos, u.correo, u.telefono, r.nombre_del_rol 
            FROM usuario u
            INNER JOIN rol r ON u.id_rol = r.id_rol
            WHERE u.id_usuario = :idUsuario
        ");
        $stUser->execute([':idUsuario' => $idUsuario]);
        $user = $stUser->fetch(PDO::FETCH_ASSOC);

        if ($user && strtolower($user['nombre_del_rol']) === 'conductor') {
            // Verificar si ya existe en la tabla conductor
            $stCond = $con->prepare("SELECT id_conductor FROM conductor WHERE id_usuario = :idUsuario LIMIT 1");
            $stCond->execute([':idUsuario' => $idUsuario]);
            $conductor = $stCond->fetch(PDO::FETCH_ASSOC);

            $nombreCompleto = trim($user['nombre'] . ' ' . $user['apellidos']);

            if (!$conductor) {
                // Insertar automáticamente si no existe
                $stIns = $con->prepare("
                    INSERT INTO conductor (nombre, documento, telefono, correo, licencia, tipo_licencia, estado, jornada, id_usuario)
                    VALUES (:nombre, 'Sin documento', :telefono, :correo, 'Sin licencia', 'Servicio Público', 'Activo', 'Mañana', :idUsuario)
                ");
                $stIns->execute([
                    ':nombre' => $nombreCompleto,
                    ':telefono' => $user['telefono'] ?? '3000000000',
                    ':correo' => $user['correo'] ?? 'correo@simu.com',
                    ':idUsuario' => $idUsuario
                ]);
            } else {
                // Actualizar datos básicos por si cambiaron en el perfil de usuario
                $stUp = $con->prepare("
                    UPDATE conductor 
                    SET nombre = :nombre, telefono = :telefono, correo = :correo 
                    WHERE id_usuario = :idUsuario
                ");
                $stUp->execute([
                    ':nombre' => $nombreCompleto,
                    ':telefono' => $user['telefono'] ?? '3000000000',
                    ':correo' => $user['correo'] ?? 'correo@simu.com',
                    ':idUsuario' => $idUsuario
                ]);
            }
        }
    }

    public function obtenerConductorPorUsuario($idUsuario)
    {
        $con = $this->get_conexion();
        $sql = "SELECT c.id_conductor AS id, c.nombre, c.documento, c.telefono, c.correo, c.licencia, 
                       c.tipo_licencia AS tipoLicencia, c.estado, c.jornada, c.id_usuario
                FROM conductor c
                WHERE c.id_usuario = :idUsuario LIMIT 1";
        $st = $con->prepare($sql);
        $st->execute([':idUsuario' => $idUsuario]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerConductorPorId($idConductor)
    {
        $con = $this->get_conexion();
        $sql = "SELECT c.id_conductor AS id, c.nombre, c.documento, c.telefono, c.correo, c.licencia, 
                       c.tipo_licencia AS tipoLicencia, c.estado, c.jornada, c.id_usuario
                FROM conductor c
                WHERE c.id_conductor = :idConductor LIMIT 1";
        $st = $con->prepare($sql);
        $st->execute([':idConductor' => $idConductor]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function listarTodosConductores()
    {
        $con = $this->get_conexion();
        $sql = "SELECT id_conductor AS id, nombre, licencia FROM conductor ORDER BY id_conductor ASC";
        $st = $con->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

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
            $p = $con->prepare("SELECT id_paradero, nombre, ubicacion FROM paradero WHERE id_ruta = :id ORDER BY id_paradero");
            $p->execute([':id' => $ruta['id']]);
            $ruta['paradas'] = $p->fetchAll(PDO::FETCH_ASSOC);
        }
        return $rutas;
    }
}