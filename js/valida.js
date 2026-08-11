

document.addEventListener('DOMContentLoaded', function() {

    const toggleIcon = document.getElementById('toggleIcon');
    const passInput = document.getElementById('pass');
    
    if (toggleIcon && passInput) {
        toggleIcon.addEventListener('click', function() {
            const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        passInput.addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            
            if (!bar || !text) return;

            let score = 0;
            if (val.length >= 6) score += 25;
            if (val.match(/[A-Z]/)) score += 25;
            if (val.match(/[0-9]/)) score += 25;
            if (val.match(/[^a-zA-Z0-9]/)) score += 25;

            bar.style.width = score + '%';

            if (score <= 25) {
                bar.style.backgroundColor = '#ef4444';
                text.textContent = 'Seguridad: Baja';
            } else if (score <= 50) {
                bar.style.backgroundColor = '#f59e0b';
                text.textContent = 'Seguridad: Media';
            } else if (score <= 75) {
                bar.style.backgroundColor = '#3b82f6';
                text.textContent = 'Seguridad: Buena';
            } else {
                bar.style.backgroundColor = '#22c55e';
                text.textContent = 'Seguridad: Fuerte';
            }
        });
    }
});

/**
 * Cambia el paso del formulario paso a paso en el módulo de crear usuario
 * @param {number} step 
 */
function nextStep(step) {
    const steps = document.querySelectorAll('.reg-step');
    steps.forEach(s => s.classList.remove('active'));

    const targetStep = document.getElementById('step' + step);
    if (targetStep) {
        targetStep.classList.add('active');
    }

    const regTitle = document.getElementById('regTitle');
    if (regTitle) {
        if (step === 1) regTitle.textContent = 'Crear cuenta';
        else if (step === 3) regTitle.textContent = 'Confirmación';
    }
}

/**
 * Envía los datos del formulario al controlador cUsuario para
 * crear el usuario en la base de datos (arquitectura MVC).
 */
async function registrarUsuario() {
    const nombre    = document.getElementById('nombre').value.trim();
    const apellidos = document.getElementById('apellidos').value.trim();
    const email     = document.getElementById('email').value.trim();
    const telefono  = document.getElementById('telefono').value.trim();
    const pass      = document.getElementById('pass').value;
    const rol       = document.getElementById('rol').value;
    const btn       = document.getElementById('btnRegistrar');

    if (!nombre || !apellidos || !email || !pass) {
        mostrarError('Todos los campos obligatorios deben estar diligenciados.');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarError();

    try {
        const resp = await fetch('controllers/cUsuario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ nombre, apellidos, email, telefono, pass, rol }).toString()
        });
        const json = await resp.json();

        if (json.ok) {
            nextStep(3);
        } else {
            mostrarError(json.msg || 'No se pudo crear el usuario.');
        }
    } catch (e) {
        mostrarError('Error de conexión con el servidor.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

function mostrarError(msg) {
    const errBox = document.getElementById('regError');
    const errText = document.getElementById('regErrorText');
    if (errBox) errBox.style.display = 'flex';
    if (errText) errText.textContent = msg;
}

function ocultarError() {
    const errBox = document.getElementById('regError');
    if (errBox) errBox.style.display = 'none';
}
