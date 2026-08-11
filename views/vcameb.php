<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4>
                Cambiar Estado de Buseta
            </h4>

        </div>

        <div class="card-body">

            <div id="ceInfo"></div>

            <form id="frmEstado">

                <input
                    type="hidden"
                    name="id_buseta"
                    id="ceId"
                >


                <label class="form-label">
                    Nuevo estado
                </label>


                <select
                    name="estado"
                    id="ceEstado"
                    class="form-select mb-3"
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


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cambiar estado
                </button>


                <a
                    href="index.php?pg=listb"
                    class="btn btn-secondary"
                >
                    Volver
                </a>


                <div
                    id="ceMsg"
                    class="mt-3"
                ></div>

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