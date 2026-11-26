<div class="dashboard-container">

    <header class="dash-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1 class="dash-title"><i class="fas fa-bus-simple"></i> Registrar Buseta</h1>
            <p class="dash-subtitle">Incorpora un nuevo vehículo a la flota operativa del sistema</p>
        </div>
        <a href="index.php?pg=listb" class="btn btn-secondary">
            <i class="fas fa-list"></i> Ver Listado
        </a>
    </header>

    <div class="card">

        <div class="card-header">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle"></i> Datos del Vehículo
            </h4>
        </div>

        <div class="card-body">

            <form id="frmRegisB">

                <div class="row g-3">

                    <!-- Placa -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Placa *
                        </label>

                        <input
                            type="text"
                            name="placa"
                            class="form-control"
                            maxlength="20"
                            placeholder="Ej: ABC-123"
                            required
                        >

                    </div>

                    <!-- Capacidad -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Capacidad *
                        </label>

                        <input
                            type="number"
                            name="capacidad"
                            min="1"
                            class="form-control"
                            placeholder="Ej: 40"
                            required
                        >

                    </div>

                    <!-- Estado -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Estado *
                        </label>

                        <select
                            name="estado"
                            class="form-select"
                            required
                        >

                            <option value="activa">
                                Activa
                            </option>

                            <option value="inactiva">
                                Inactiva
                            </option>

                            <option value="mantenimiento">
                                Mantenimiento
                            </option>

                        </select>

                    </div>

                    <!-- Ruta -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Ruta *
                        </label>

                        <select
                            name="id_ruta"
                            id="rbRuta"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Cargando...
                            </option>

                        </select>

                    </div>

                    <!-- Empresa -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Empresa *
                        </label>

                        <select
                            name="id_empresa"
                            id="rbEmpresa"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Cargando...
                            </option>

                        </select>

                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="index.php?pg=listb" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Buseta
                    </button>
                </div>

                <div id="rbMsg" class="mt-3"></div>

            </form>

        </div>

    </div>

</div>


<script>

async function cargarDatosBuseta() {

    try {

        const respuesta = await fetch(
            'controllers/cregisb.php'
        );

        const datos = await respuesta.json();

        if (!datos.ok) {

            document.querySelector('#rbMsg').innerHTML =
                `<div class="alert alert-danger">
                    ${datos.msg}
                </div>`;

            return;
        }

        const ruta = document.querySelector('#rbRuta');
        const empresa = document.querySelector('#rbEmpresa');

        ruta.innerHTML =
            '<option value="">Seleccione...</option>';

        datos.rutas.forEach(function(item) {

            ruta.innerHTML += `
                <option value="${item.id_ruta}">
                    ${item.nombre}
                </option>
            `;

        });

        empresa.innerHTML =
            '<option value="">Seleccione...</option>';

        datos.empresas.forEach(function(item) {

            empresa.innerHTML += `
                <option value="${item.id_empresa}">
                    ${item.nombre}
                </option>
            `;

        });

    } catch (error) {

        document.querySelector('#rbMsg').innerHTML =
            `<div class="alert alert-danger">
                Error al cargar los datos.
            </div>`;
    }
}


document.querySelector('#frmRegisB')
.addEventListener('submit', async function(e) {

    e.preventDefault();

    const formulario = new FormData(this);

    const respuesta = await fetch(
        'controllers/cregisb.php',
        {
            method: 'POST',
            body: formulario
        }
    );

    const datos = await respuesta.json();

    document.querySelector('#rbMsg').innerHTML = `
        <div class="alert alert-${datos.ok ? 'success' : 'danger'}">
            ${datos.msg}
        </div>
    `;

    if (datos.ok) {

        this.reset();

    }

});


cargarDatosBuseta();

</script>