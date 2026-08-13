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

<style>

.vista-usuario {
    padding: 25px;
    width: 100%;
}

.vu-header {
    margin-bottom: 22px;
}

.vu-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.vu-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.vu-card {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(0,0,0,.05);
    overflow: hidden;
}

.vu-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid #edf3f5;
}

.vu-card-header h2 {
    margin: 0;
    color: #17324d;
    font-size: 16px;
    font-weight: 800;
}

.vu-card-header i {
    color: #00a8c8;
    margin-right: 7px;
}

.vu-body {
    padding: 22px;
}

.vu-profile {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 25px;
    padding: 18px;
    background: #f5fbfc;
    border-radius: 11px;
}

.vu-avatar {
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

.vu-name {
    color: #17324d;
    font-size: 17px;
    font-weight: 800;
}

.vu-rol {
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

.vu-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.vu-field {
    display: flex;
    flex-direction: column;
}

.vu-field.full {
    grid-column: 1 / -1;
}

.vu-field label {
    color: #455a64;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: .03em;
}

.vu-field .vu-value {
    width: 100%;
    border: 1px solid #d5e4e9;
    border-radius: 8px;
    padding: 11px 12px;
    color: #30485d;
    background: #f8fbfc;
    font-size: 13px;
}

@media (max-width: 700px) {

    .vista-usuario {
        padding: 15px;
    }

    .vu-grid {
        grid-template-columns: 1fr;
    }

    .vu-field.full {
        grid-column: auto;
    }
}

</style>


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
