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

    (function () {
        var input = document.querySelector('.header-search input');
        var btn = document.querySelector('.search-submit');
        if (!input || !btn) return;

        function doSearch() {
            var q = input.value.trim();
            if (!q) return;
            window.location.href = '{{ route('catalog.index') }}?search=' + encodeURIComponent(q);
        }

        btn.addEventListener('click', doSearch);
        input.addEventListener('keydown', function (e) { if (e.key === 'Enter') doSearch(); });
    })();
</script>
