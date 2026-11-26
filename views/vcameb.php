<div class="dashboard-container">

    <header class="dash-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1 class="dash-title"><i class="fas fa-toggle-on"></i> Cambiar Estado de Buseta</h1>
            <p class="dash-subtitle">Actualiza la disponibilidad operativa del vehículo seleccionado</p>
        </div>
        <a href="index.php?pg=listb" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </header>

    <div class="card">

        <div class="card-header">
            <h4>
                <i class="fas fa-sliders"></i> Estado Operativo
            </h4>
        </div>

        <div class="card-body">

            <div id="ceInfo" class="mb-3"></div>

            <form id="frmEstado">

                <input
                    type="hidden"
                    name="id_buseta"
                    id="ceId"
                >

                <div class="mb-4" style="max-width: 420px;">
                    <label class="form-label" for="ceEstado">
                        Nuevo estado
                    </label>
                    <select
                        name="estado"
                        id="ceEstado"
                        class="form-select"
                    >
                        <option value="activa">Activa</option>
                        <option value="inactiva">Inactiva</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Cambiar estado
                    </button>
                    <a href="index.php?pg=listb" class="btn btn-secondary">
                        Volver al listado
                    </a>
                </div>

                <div id="ceMsg" class="mt-3"></div>

            </form>

        </div>

    </div>

</div>


<script>

async function cargarEstado() {

    const parametros =
        new URLSearchParams(
            window.location.search
        );

    const id = parametros.get('id');


    const respuesta = await fetch(
        'controllers/ccameb.php?id=' + id
    );

    const datos = await respuesta.json();


    if (!datos.ok) {

        document.querySelector('#ceInfo').innerHTML =
            `<div class="alert alert-danger">
                ${datos.msg}
            </div>`;

        return;
    }


    document.querySelector('#ceId').value =
        datos.buseta.id_buseta;

    document.querySelector('#ceEstado').value =
        datos.buseta.estado;


    document.querySelector('#ceInfo').innerHTML = `
        <p>
            <strong>Placa:</strong>
            ${datos.buseta.placa}
        </p>

        <p>
            <strong>Estado actual:</strong>
            ${datos.buseta.estado}
        </p>
    `;
}


document.querySelector('#frmEstado')
.addEventListener('submit', async function(e) {

    e.preventDefault();


    const respuesta = await fetch(
        'controllers/ccameb.php',
        {
            method: 'POST',
            body: new FormData(this)
        }
    );


    const datos = await respuesta.json();


    document.querySelector('#ceMsg').innerHTML = `
        <div class="alert alert-${datos.ok ? 'success' : 'danger'}">
            ${datos.msg}
        </div>
    `;


    if (datos.ok) {

        cargarEstado();

    }

});


cargarEstado();

</script>