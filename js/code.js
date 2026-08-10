document.addEventListener('DOMContentLoaded', function() {

    const themeBtn = document.getElementById('themeToggleBtn');

    if (themeBtn) {
        themeBtn.addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark-mode');
            localStorage.setItem('simu-theme', isDark ? 'dark' : 'light');
        });
    }
});
