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

    // Auto-focus en inputs de código (salta al siguiente al escribir)
    document.querySelectorAll('.code-input').forEach((input, idx, arr) => {
        input.addEventListener('input', function() {
            if (this.value.length === 1 && idx < arr.length - 1) {
                arr[idx + 1].focus();
            }
        });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && idx > 0) {
                arr[idx - 1].focus();
            }
        });
    });
});

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
        else if (step === 2) regTitle.textContent = 'Verificación de Perfil';
        else if (step === 3) regTitle.textContent = 'Confirmación';
    }
}

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
            nextStep(2);
            document.getElementById('regCorreo').value = json.correo;
            // Mostrar código de depuración si el correo no se envió
            if (json.codigo_debug) {
                const hint = document.getElementById('regCodeHint');
                hint.textContent = '⚠️ Modo prueba: tu código es ' + json.codigo_debug;
                hint.style.display = 'block';
            }
            if (json.error_correo) {
                const hint = document.getElementById('regCodeHint');
                hint.textContent = '⚠️ Error al enviar correo: ' + json.error_correo;
                hint.className = 'alert alert-warning py-2 px-3 mx-auto';
                hint.style.display = 'block';
            }
        } else {
            mostrarError(json.msg || 'No se pudo crear el usuario.');
        }
    } catch (e) {
        mostrarError('Error de conexión con el servidor.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function verificarCodigo() {
    const inputs = document.querySelectorAll('.code-input');
    const codigo = Array.from(inputs).map(i => i.value).join('');
    const correo = document.getElementById('regCorreo').value;
    const btn = document.getElementById('btnVerificar');

    if (codigo.length !== 6) {
        mostrarErrorCodigo('El código debe tener 6 dígitos.');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarErrorCodigo();

    try {
        const resp = await fetch('controllers/ccoder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ correo, codigo }).toString()
        });
        const json = await resp.json();

        if (json.ok && json.contexto === 'registro') {
            nextStep(3);
        } else {
            mostrarErrorCodigo(json.msg || 'Código inválido.');
        }
    } catch (e) {
        mostrarErrorCodigo('Error de conexión con el servidor.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function enviarInstrucciones(event) {
    event.preventDefault();
    const correo = document.getElementById('olvCorreo').value.trim();
    const btn = document.getElementById('btnOlvido');

    if (!correo || !correo.includes('@')) {
        mostrarErrorOlvido('Ingrese un correo electrónico válido.');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarErrorOlvido();

    try {
        const resp = await fetch('controllers/colvid.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ correo }).toString()
        });
        const json = await resp.json();

        const msgBox = document.getElementById('olvMsg');
        if (json.ok) {
            msgBox.className = 'alert alert-success';
            msgBox.textContent = json.msg + (json.codigo_debug ? ' (Código de prueba: ' + json.codigo_debug + ')' : '');
            msgBox.style.display = 'block';
            if (json.codigo_debug) {
                // Pre-llenar en vcoder
                setTimeout(() => {
                    window.location.href = 'index.php?pg=vcoder&correo=' + encodeURIComponent(json.correo);
                }, 1500);
            }
        } else {
            msgBox.className = 'alert alert-danger';
            msgBox.textContent = json.msg + (json.error_correo ? ' (' + json.error_correo + ')' : '');
            msgBox.style.display = 'block';
        }
    } catch (e) {
        mostrarErrorOlvido('Error de conexión con el servidor.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function verificarCodigoRecuperacion(event) {
    event.preventDefault();
    const inputs = document.querySelectorAll('.code-input');
    const codigo = Array.from(inputs).map(i => i.value).join('');
    const correo = document.getElementById('codCorreo').value;
    const btn = document.getElementById('btnCodigo');

    if (codigo.length !== 6) {
        mostrarErrorCodigoRec('El código debe tener 6 dígitos.');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarErrorCodigoRec();

    try {
        const resp = await fetch('controllers/ccoder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ correo, codigo }).toString()
        });
        const json = await resp.json();

        const msgBox = document.getElementById('codMsg');
        if (json.ok && json.contexto === 'recuperacion') {
            msgBox.className = 'alert alert-success';
            msgBox.textContent = json.msg;
            msgBox.style.display = 'block';
            // Redirigir a vreset con el token
            setTimeout(() => {
                window.location.href = 'index.php?pg=vreset&token=' + encodeURIComponent(json.token);
            }, 1000);
        } else {
            msgBox.className = 'alert alert-danger';
            msgBox.textContent = json.msg || 'Código inválido.';
            msgBox.style.display = 'block';
        }
    } catch (e) {
        mostrarErrorCodigoRec('Error de conexión con el servidor.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function guardarNuevaPassword(event) {
    event.preventDefault();
    const token   = document.getElementById('resToken').value;
    const pass    = document.getElementById('resPassword').value;
    const confirm = document.getElementById('resConfirm').value;
    const btn     = document.getElementById('btnReset');

    if (!token || !pass) {
        mostrarErrorReset('El token y la nueva contraseña son obligatorios.');
        return;
    }
    if (pass.length < 6) {
        mostrarErrorReset('La contraseña debe tener al menos 6 caracteres.');
        return;
    }
    if (pass !== confirm) {
        mostrarErrorReset('Las contraseñas no coinciden.');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarErrorReset();

    try {
        const resp = await fetch('controllers/creset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ token, password: pass, confirm_password: confirm }).toString()
        });
        const json = await resp.json();

        const msgBox = document.getElementById('resMsg');
        if (json.ok) {
            msgBox.className = 'alert alert-success';
            msgBox.textContent = json.msg;
            msgBox.style.display = 'block';
            setTimeout(() => {
                window.location.href = 'index.php?pg=login&msg=password_reset';
            }, 1500);
        } else {
            msgBox.className = 'alert alert-danger';
            msgBox.textContent = json.msg;
            msgBox.style.display = 'block';
        }
    } catch (e) {
        mostrarErrorReset('Error de conexión con el servidor.');
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

function mostrarErrorCodigo(msg) {
    const errBox = document.getElementById('regCodeError');
    const errText = document.getElementById('regCodeErrorText');
    if (errBox) errBox.style.display = 'flex';
    if (errText) errText.textContent = msg;
}

function ocultarErrorCodigo() {
    const errBox = document.getElementById('regCodeError');
    if (errBox) errBox.style.display = 'none';
}

function mostrarErrorOlvido(msg) {
    const msgBox = document.getElementById('olvMsg');
    if (msgBox) {
        msgBox.className = 'alert alert-danger';
        msgBox.textContent = msg;
        msgBox.style.display = 'block';
    }
}

function ocultarErrorOlvido() {
    const msgBox = document.getElementById('olvMsg');
    if (msgBox) msgBox.style.display = 'none';
}

function mostrarErrorCodigoRec(msg) {
    const msgBox = document.getElementById('codMsg');
    if (msgBox) {
        msgBox.className = 'alert alert-danger';
        msgBox.textContent = msg;
        msgBox.style.display = 'block';
    }
}

function ocultarErrorCodigoRec() {
    const msgBox = document.getElementById('codMsg');
    if (msgBox) msgBox.style.display = 'none';
}

function mostrarErrorReset(msg) {
    const msgBox = document.getElementById('resMsg');
    if (msgBox) {
        msgBox.className = 'alert alert-danger';
        msgBox.textContent = msg;
        msgBox.style.display = 'block';
    }
}

function ocultarErrorReset() {
    const msgBox = document.getElementById('resMsg');
    if (msgBox) msgBox.style.display = 'none';
}

function siguientePaso() {
    window.location.href = 'index.php?pg=creaUsu';
}