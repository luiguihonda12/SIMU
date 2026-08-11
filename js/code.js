document.addEventListener('DOMContentLoaded', function () {


    /* ======================================================
       MODO OSCURO
       ====================================================== */

    const themeBtn =
        document.getElementById('themeToggleBtn');


    if (themeBtn) {

        themeBtn.addEventListener(
            'click',
            function () {

                const isDark =
                    document.documentElement.classList.toggle(
                        'dark-mode'
                    );


                localStorage.setItem(
                    'simu-theme',
                    isDark ? 'dark' : 'light'
                );

            }
        );

    }



    /* ======================================================
       MENÚ DE USUARIO
       ====================================================== */

    const userMenuBtn =
        document.getElementById('userMenuBtn');

    const userDropdown =
        document.getElementById('userDropdown');


    if (userMenuBtn && userDropdown) {


        /* Abrir / cerrar menú */

        userMenuBtn.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                userDropdown.classList.toggle(
                    'show'
                );

            }
        );


        /* Evitar que un click dentro lo cierre */

        userDropdown.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

            }
        );


        /* Cerrar haciendo click fuera */

        document.addEventListener(
            'click',
            function () {

                userDropdown.classList.remove(
                    'show'
                );

            }
        );


        /* Cerrar con tecla ESC */

        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    userDropdown.classList.remove(
                        'show'
                    );

                }

            }
        );

    }



    /* ======================================================
       MENÚS DESPLEGABLES DEL SIDEBAR
       ====================================================== */

    const dropdownButtons =
        document.querySelectorAll(
            '.sidebar-dropdown-btn'
        );


    dropdownButtons.forEach(
        function (button) {


            button.addEventListener(
                'click',
                function () {


                    const currentDropdown =
                        button.closest(
                            '.sidebar-dropdown'
                        );


                    if (!currentDropdown) {
                        return;
                    }


                    /*
                     * Cerrar los otros menús.
                     */

                    document
                        .querySelectorAll(
                            '.sidebar-dropdown.open'
                        )
                        .forEach(
                            function (dropdown) {

                                if (
                                    dropdown !==
                                    currentDropdown
                                ) {

                                    dropdown.classList.remove(
                                        'open'
                                    );

                                }

                            }
                        );


                    /*
                     * Abrir / cerrar
                     * el menú seleccionado.
                     */

                    currentDropdown.classList.toggle(
                        'open'
                    );

                }
            );

        }
    );



    /* ======================================================
       SIDEBAR EN MÓVILES
       ====================================================== */

    const sidebarToggleBtn =
        document.getElementById(
            'sidebarToggleBtn'
        );


    const sidebar =
        document.querySelector(
            '.app-sidebar'
        );


    const sidebarOverlay =
        document.getElementById(
            'sidebarOverlay'
        );


    if (
        sidebarToggleBtn &&
        sidebar &&
        sidebarOverlay
    ) {


        /* Abrir sidebar */

        sidebarToggleBtn.addEventListener(
            'click',
            function () {

                sidebar.classList.add(
                    'show'
                );

                sidebarOverlay.classList.add(
                    'show'
                );

            }
        );


        /* Cerrar sidebar */

        sidebarOverlay.addEventListener(
            'click',
            function () {

                sidebar.classList.remove(
                    'show'
                );

                sidebarOverlay.classList.remove(
                    'show'
                );

            }
        );


        /* Cerrar al seleccionar una vista */

        const sidebarLinks =
            sidebar.querySelectorAll(
                'a'
            );


        sidebarLinks.forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        sidebar.classList.remove(
                            'show'
                        );

                        sidebarOverlay.classList.remove(
                            'show'
                        );

                    }
                );

            }
        );

    }


});