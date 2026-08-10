

document.addEventListener('DOMContentLoaded', function() {

    const toggleIcon = document.querySelector('[data-password-target]');
    const passInput = toggleIcon ? document.getElementById(toggleIcon.dataset.passwordTarget) : null;
    
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

    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.querySelector('.left-sidebar, .app-sidebar, .right-sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggleBtn && sidebar) {
        sidebarToggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('show');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            if (sidebar) sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
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
        else if (step === 2) regTitle.textContent = 'Verificación de Perfil';
        else if (step === 3) regTitle.textContent = 'Confirmación';
    }
}
