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

<style>

.perfil-usuario {
    padding: 25px;
    width: 100%;
}

.pu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    gap: 15px;
    flex-wrap: wrap;
}

.pu-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.pu-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.pu-card {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(0,0,0,.05);
    overflow: hidden;
}

.pu-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid #edf3f5;
}

.pu-card-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
}

.pu-card-header i {
    color: #00a8c8;
    margin-right: 7px;
}

.pu-body {
    padding: 22px;
}

.pu-profile {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 25px;
    padding: 18px;
    background: #f5fbfc;
    border-radius: 11px;
}

.pu-avatar {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    background: #e2f7fb;
    color: #009bbd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
    flex-shrink: 0;
}

.pu-name {
    color: #17324d;
    font-size: 17px;
    font-weight: 800;
}

.pu-rol {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 5px;
    padding: 3px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    background: #e7f7eb;
    color: #2e7d32;
}

.pu-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.pu-field {
    display: flex;
    flex-direction: column;
}

.pu-field.full {
    grid-column: 1 / -1;
}

.pu-field label {
    color: #455a64;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: .03em;
}

.pu-field .pu-value {
    width: 100%;
    border: 1px solid #d5e4e9;
    border-radius: 8px;
    padding: 11px 12px;
    color: #30485d;
    background: #f8fbfc;
    font-size: 13px;
}

.pu-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #edf3f5;
}

.pu-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 0;
    border-radius: 8px;
    padding: 11px 18px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    cursor: pointer;
}

.pu-btn-edit {
    color: #fff;
    background: #00a4c4;
}

.pu-btn-edit:hover {
    background: #008eaa;
}

@media (max-width: 700px) {

    .perfil-usuario {
        padding: 15px;
    }

    .pu-grid {
        grid-template-columns: 1fr;
    }

    .pu-field.full {
        grid-column: auto;
    }

    .pu-actions {
        flex-direction: column;
    }

    .pu-btn {
        width: 100%;
        justify-content: center;
    }
}

</style>


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
