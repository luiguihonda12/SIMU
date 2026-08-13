<?php

/**
 * ============================================================
 * VISTA 12 - PERFIL USUARIO
 * ============================================================
 */

require_once __DIR__ . '/../controllers/cperfilusu.php';

$controladorPerfil = new Cperfilusu();

$usuario = $controladorPerfil->index();

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


<div class="perfil-usuario">

    <!-- =====================================================
         ENCABEZADO
         ===================================================== -->

    <div class="pu-header">

        <div>

            <h1 class="pu-title">
                <i class="fas fa-user-circle me-2"></i>
                Perfil de Usuario
            </h1>

            <p class="pu-subtitle">
                Información de la cuenta del usuario.
            </p>

        </div>

    </div>


    <!-- =====================================================
         TARJETA
         ===================================================== -->

    <div class="pu-card">

        <div class="pu-card-header">

            <h2>
                <i class="fas fa-id-card"></i>
                Información de la cuenta
            </h2>

        </div>

        <div class="pu-body">

            <!-- Perfil -->
            <div class="pu-profile">

                <div class="pu-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <div>

                    <div class="pu-name">
                        <?= htmlspecialchars($nombreCompleto); ?>
                    </div>

                    <span class="pu-rol">
                        <i class="fas fa-user-tag"></i>
                        <?= htmlspecialchars($usuario['rol']); ?>
                    </span>

                </div>

            </div>


            <!-- Datos -->
            <div class="pu-grid">

                <div class="pu-field">
                    <label>ID Usuario</label>
                    <div class="pu-value">
                        <?= htmlspecialchars($usuario['id_usuario']); ?>
                    </div>
                </div>

                <div class="pu-field">
                    <label>Rol</label>
                    <div class="pu-value">
                        <?= htmlspecialchars($usuario['rol']); ?>
                    </div>
                </div>

                <div class="pu-field">
                    <label>Nombre</label>
                    <div class="pu-value">
                        <?= htmlspecialchars($usuario['nombre']); ?>
                    </div>
                </div>

                <div class="pu-field">
                    <label>Apellidos</label>
                    <div class="pu-value">
                        <?= htmlspecialchars($usuario['apellidos']); ?>
                    </div>
                </div>

                <div class="pu-field">
                    <label>Correo electrónico</label>
                    <div class="pu-value">
                        <?= htmlspecialchars($usuario['correo']); ?>
                    </div>
                </div>

                <div class="pu-field">
                    <label>Teléfono</label>
                    <div class="pu-value">
                        <?= htmlspecialchars($usuario['telefono'] ?? 'Sin registrar'); ?>
                    </div>
                </div>

            </div>


            <!-- Acciones -->
            <div class="pu-actions">

                <a
                    href="index.php?pg=editarUsuario"
                    class="pu-btn pu-btn-edit"
                >
                    <i class="fas fa-user-edit me-1"></i>
                    Editar Usuario
                </a>

            </div>

        </div>

    </div>

</div>
