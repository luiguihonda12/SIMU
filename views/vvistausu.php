<?php

/**
 * ============================================================
 * VISTA 29 - VISTA USUARIO
 * ============================================================
 */

require_once __DIR__ . '/../controllers/cvistausu.php';

$controladorVista = new Cvistausu();

$usuario = $controladorVista->index();

if (!$usuario) {
    $usuario = [
        'id_usuario' => '',
        'nombre'     => 'Sin sesión',
        'apellidos'  => '',
        'correo'     => '',
        'telefono'   => '',
        'id_rol'     => '',
        'rol'        => 'Invitado'
    ];
}

$nombreCompleto = trim($usuario['nombre'] . ' ' . $usuario['apellidos']);

?>


<div class="vista-usuario">

    <!-- =====================================================
         ENCABEZADO
         ===================================================== -->

    <div class="vu-header">

        <h1 class="vu-title">
            <i class="fas fa-id-card me-2"></i>
            Vista Usuario
        </h1>

        <p class="vu-subtitle">
            Consulta detallada de la información del usuario.
        </p>

    </div>


    <!-- =====================================================
         TARJETA
         ===================================================== -->

    <div class="vu-card">

        <div class="vu-card-header">

            <h2>
                <i class="fas fa-address-card"></i>
                Información del Usuario
            </h2>

        </div>

        <div class="vu-body">

            <!-- Perfil -->
            <div class="vu-profile">

                <div class="vu-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <div>

                    <div class="vu-name">
                        <?= htmlspecialchars($nombreCompleto); ?>
                    </div>

                    <span class="vu-rol">
                        <i class="fas fa-user-tag"></i>
                        <?= htmlspecialchars($usuario['rol']); ?>
                    </span>

                </div>

            </div>


            <!-- Datos -->
            <div class="vu-grid">

                <div class="vu-field">
                    <label>ID Usuario</label>
                    <div class="vu-value">
                        <?= htmlspecialchars($usuario['id_usuario']); ?>
                    </div>
                </div>

                <div class="vu-field">
                    <label>Rol</label>
                    <div class="vu-value">
                        <?= htmlspecialchars($usuario['rol']); ?>
                    </div>
                </div>

                <div class="vu-field">
                    <label>Nombre</label>
                    <div class="vu-value">
                        <?= htmlspecialchars($usuario['nombre']); ?>
                    </div>
                </div>

                <div class="vu-field">
                    <label>Apellidos</label>
                    <div class="vu-value">
                        <?= htmlspecialchars($usuario['apellidos']); ?>
                    </div>
                </div>

                <div class="vu-field">
                    <label>Correo electrónico</label>
                    <div class="vu-value">
                        <?= htmlspecialchars($usuario['correo']); ?>
                    </div>
                </div>

                <div class="vu-field">
                    <label>Teléfono</label>
                    <div class="vu-value">
                        <?= htmlspecialchars($usuario['telefono'] ?? 'Sin registrar'); ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
