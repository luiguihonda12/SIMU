document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('sidebarToggleBtn');
    const sidebar = document.querySelector('.left-sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    const closeMenu = function () {
        if (sidebar) sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('show');
    };

    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            if (overlay) overlay.classList.toggle('show');
        });
    }
    if (overlay) overlay.addEventListener('click', closeMenu);
    document.querySelectorAll('.nav-item-link').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });
});
