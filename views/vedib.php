<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4>
                Editar Buseta
            </h4>

        </div>

        <div class="card-body">

            <form id="frmEditB">

                <input
                    type="hidden"
                    name="id_buseta"
                    id="ebId"
                >


                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Placa *
                        </label>

                        <input
                            type="text"
                            id="ebPlaca"
                            name="placa"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Capacidad *
                        </label>

                        <input
                            type="number"
                            id="ebCap"
                            name="capacidad"
                            min="1"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Estado *
                        </label>

                        <select
                            id="ebEstado"
                            name="estado"
                            class="form-select"
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


                    <div class="col-md-4">

                        <label class="form-label">
                            Ruta *
                        </label>

                        <select
                            id="ebRuta"
                            name="id_ruta"
                            class="form-select"
                            required
                        ></select>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Empresa *
                        </label>

                        <select
                            id="ebEmpresa"
                            name="id_empresa"
                            class="form-select"
                            required
                        ></select>

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary mt-4"
                >
                    Guardar cambios
                </button>


                <a
                    href="index.php?pg=listb"
                    class="btn btn-secondary mt-4"
                >
                    Volver
                </a>


                <div
                    id="ebMsg"
                    class="mt-3"
                ></div>

            </form>

        </div>

    </div>

</div>


<script>

async function cargarBusetaEditar() {

    const parametros =
        new URLSearchParams(
            window.location.search
        );

    const id = parametros.get('id');

    if (!id) {

        document.querySelector('#ebMsg').innerHTML =
            `<div class="alert alert-danger">
                No se recibió el ID de la buseta.
            </div>`;

        return;
    }


    const respuesta = await fetch(
        'controllers/cedib.php?id=' + id
    );

    const datos = await respuesta.json();


    if (!datos.ok) {

        document.querySelector('#ebMsg').innerHTML =
            `<div class="alert alert-danger">
                ${datos.msg}
            </div>`;

        return;
    }


    document.querySelector('#ebId').value =
        datos.buseta.id_buseta;

    document.querySelector('#ebPlaca').value =
        datos.buseta.placa;

    document.querySelector('#ebCap').value =
        datos.buseta.capacidad;

    document.querySelector('#ebEstado').value =
        datos.buseta.estado;


    const ruta =
        document.querySelector('#ebRuta');

    ruta.innerHTML = '';

    datos.rutas.forEach(function(item) {

        ruta.innerHTML += `
            <option
                value="${item.id_ruta}"
                ${item.id_ruta == datos.buseta.id_ruta
                    ? 'selected'
                    : ''}
            >
                ${item.nombre}
            </option>
        `;

    });


    const empresa =
        document.querySelector('#ebEmpresa');

    empresa.innerHTML = '';

    datos.empresas.forEach(function(item) {

        empresa.innerHTML += `
            <option
                value="${item.id_empresa}"
                ${item.id_empresa == datos.buseta.id_empresa
                    ? 'selected'
                    : ''}
            >
                ${item.nombre}
            </option>
        `;

    });

}


document.querySelector('#frmEditB')
.addEventListener('submit', async function(e) {

    e.preventDefault();

    const respuesta = await fetch(
        'controllers/cedib.php',
        {
            method: 'POST',
            body: new FormData(this)
        }
    );

    const datos = await respuesta.json();

    document.querySelector('#ebMsg').innerHTML = `
        <div class="alert alert-${datos.ok ? 'success' : 'danger'}">
            ${datos.msg}
        </div>
    `;

});


cargarBusetaEditar();

</script>