<script>
    (function () {
        var menu = document.querySelector('[data-account-menu]');
        var trigger = document.querySelector('[data-account-menu-trigger]');

        if (!menu || !trigger) {
            return;
        }

        function closeMenu() {
            menu.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
        }

        function openMenu() {
            menu.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
        }

        trigger.addEventListener('click', function (event) {
            event.stopPropagation();

            if (menu.classList.contains('is-open')) {
                closeMenu();
                return;
            }

            openMenu();
        });

        document.addEventListener('click', function (event) {
            if (!menu.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });
    })();
</script>
