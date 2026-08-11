<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">
                Registrar Buseta
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

                <button
                    type="submit"
                    class="btn btn-primary mt-4"
                >
                    Registrar
                </button>

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