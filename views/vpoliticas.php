<?php
// SIMU ya inició la sesión en index.php. El destino del botón "Volver" depende del rol.
$paginaVolver = 'login';
if (isset($_SESSION['id_usuario'])) {
    $rolSesion = (int)($_SESSION['id_rol'] ?? 0);
    if ($rolSesion === 1) {
        $paginaVolver = 'dashboard';
    } elseif ($rolSesion === 2) {
        $paginaVolver = 'dashboardConductor';
    } elseif ($rolSesion === 3) {
        $paginaVolver = 'menuCliente';
    }
}
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card shadow-sm border-0 p-4 p-md-5 rounded-4">
                <div class="text-center mb-4">
                    <div class="bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2 auth-icon-circle">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Políticas de protección de datos</h3>
                    <p class="text-muted small mb-2">SIMU &ndash; Sistema Integrado de Movilidad Urbana</p>
                    <span class="badge bg-primary-subtle text-primary">Versión 1.0 &middot; Actualizada el 25 de noviembre de 2026</span>
                </div>

                <div class="alert alert-light border small" role="note">
                    <i class="fas fa-circle-info me-2"></i>
                    Este documento informa cómo SIMU recopila, usa, conserva y protege los datos personales de sus usuarios, conductores y ciudadanos, en cumplimiento de la <strong>Ley 1581 de 2012</strong> y el <strong>Decreto 1081 de 2015</strong> y sus normas complementarias.
                </div>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">1.</span> Responsable del tratamiento</h5>
                    <p class="text-muted small mb-0">
                        El responsable del tratamiento es <strong>NOVACODEX</strong>, operador de SIMU &ndash; Sistema Integrado de Movilidad Urbana.
                        Correo institucional de contacto: <strong>simucodex@gmail.com</strong>.
                        Es el encargado de decidir para qué se recogen los datos, de atender las solicitudes de los titulares y de velar por el cumplimiento de esta política.
                    </p>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">2.</span> Datos personales que se recopilan</h5>
                    <p class="text-muted small mb-2">Según el uso que se haga del sistema, SIMU puede tratar:</p>
                    <ul class="text-muted small mb-0">
                        <li><strong>Usuarios:</strong> nombre, apellidos, correo electrónico, teléfono, contraseña almacenada con hash, rol y estado de la cuenta.</li>
                        <li><strong>Conductores:</strong> documento de identidad, teléfono, correo, licencia de conducción, jornada, empresa y rutas asignadas.</li>
                        <li><strong>Operación:</strong> placas y estado de busetas, rutas, paraderos y empresas.</li>
                        <li><strong>PQRS:</strong> tipo de solicitud, descripción, estado, prioridad, fecha de radicación y respuesta.</li>
                        <li><strong>Datos técnicos:</strong> identificador de sesión y preferencia de tema oscuro almacenada en el navegador.</li>
                    </ul>
                    <p class="text-muted small mt-2 mb-0">
                        SIMU no solicita de manera habitual datos sensibles definidos en el artículo 5 de la Ley 1581 de 2012. Si un ciudadano los incluye voluntariamente en una PQRS, se tratarán con la reserva que exige la ley.
                    </p>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">3.</span> Finalidades del tratamiento</h5>
                    <ul class="text-muted small mb-0">
                        <li>Crear y autenticar cuentas, verificar la identidad del usuario y recuperar contraseñas.</li>
                        <li>Asignar permisos según el rol (administrador, conductor o cliente).</li>
                        <li>Gestionar el personal de conducción, las busetas, las rutas y los paraderos.</li>
                        <li>Recibir, tramitar y dar respuesta a las peticiones, quejas, reclamos y sugerencias (PQRS).</li>
                        <li>Enviar correos de verificación y recuperación de acceso.</li>
                        <li>Elaborar estadísticas de operación y cumplir obligaciones legales y contractuales.</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">4.</span> Derechos de los titulares</h5>
                    <p class="text-muted small mb-2">De acuerdo con el artículo 8 de la Ley 1581 de 2012, puedes:</p>
                    <ul class="text-muted small mb-0">
                        <li>Conocer, actualizar y rectificar tus datos personales.</li>
                        <li>Solicitar copia de la información que SIMU tiene sobre ti.</li>
                        <li>Ser informado sobre el uso que se les ha dado a tus datos.</li>
                        <li>Revocar la autorización o solicitar la supresión de tus datos, cuando no exista una obligación legal de conservarlos.</li>
                        <li>Abstenerse de suministrar datos no exigidos para la prestación del servicio.</li>
                        <li>Presentar quejas ante la Superintendencia de Industria y Comercio &ndash; SIC.</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">5.</span> Cómo ejercer tus derechos</h5>
                    <p class="text-muted small mb-0">
                        Puedes radicar tu solicitud escribiendo a <strong>simucodex@gmail.com</strong> o usando el módulo de <strong>PQRS</strong> disponible en SIMU.
                        Indica tu nombre, documento, correo y el derecho que deseas ejercer. Las consultas se responden dentro de los <strong>10 días hábiles</strong> y los reclamos dentro de los <strong>15 días hábiles</strong>, conforme a los artículos 14 y 16 de la Ley 1581 de 2012. Si ampliamos la información solicitada, el plazo se suspende hasta que la completes.
                    </p>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">6.</span> Conservación y eliminación</h5>
                    <p class="text-muted small mb-0">
                        Los datos se conservan mientras la cuenta esté activa y sea necesario para prestar el servicio o atender solicitudes. Cuando dejen de ser necesarios, o cuando el titular solicite su supresión y no exista una obligación legal de conservarlos, se eliminan o se anonimizan de forma segura.
                    </p>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">7.</span> Seguridad de la información</h5>
                    <p class="text-muted small mb-0">
                        SIMU aplica medidas técnicas y administrativas razonables: contraseñas almacenadas con funciones de hash, control de acceso por roles, regeneración del identificador de sesión al iniciar sesión, consultas a la base de datos mediante sentencias preparadas y verificación de permisos en los procesos de consulta y modificación. El acceso a la información está limitado a las personas autorizadas según su función.
                    </p>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">8.</span> Compartir información con terceros</h5>
                    <p class="text-muted small mb-0">
                        SIMU no comercializa ni cede los datos personales para fines publicitarios. Solo los comparte con proveedores que apoyan la operación (por ejemplo, el servicio de correo para verificaciones y recuperación) o con autoridades públicas cuando la ley lo exige, garantizando en cada caso las condiciones de confidencialidad y seguridad correspondientes.
                    </p>
                </section>

                <section class="mb-4">
                    <h5 class="fw-bold"><span class="text-primary">9.</span> Cambios en esta política</h5>
                    <p class="text-muted small mb-0">
                        Cuando se modifiquen las finalidades, los datos recopilados o los procedimientos, publicaremos una nueva versión en esta misma página con la fecha de actualización correspondiente.
                    </p>
                </section>

                <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
                    <a href="index.php?pg=<?= htmlspecialchars($paginaVolver, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="index.php?pg=nuevaPQRS" class="btn btn-outline-primary">
                        <i class="fas fa-comments me-2"></i>Radicar una PQRS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
