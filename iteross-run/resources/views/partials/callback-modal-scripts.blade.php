<script>
    (function () {
        function formatSize(bytes) {
            return bytes >= 1048576
                ? (bytes / 1048576).toFixed(1).replace('.', ',') + ' МБ'
                : Math.max(1, Math.round(bytes / 1024)) + ' КБ';
        }

        document.querySelectorAll('.file-box input[type="file"]').forEach(function (input) {
            var box = input.closest('.file-box');
            var fileNameElement = box ? box.querySelector('[data-file-name]') : null;
            var errorElement = box ? box.nextElementSibling : null;
            if (errorElement && !errorElement.hasAttribute('data-file-error')) {
                errorElement = null;
            }

            var maxFiles = parseInt(input.dataset.maxFiles || '10', 10);
            var maxTotalBytes = parseFloat(input.dataset.maxTotalMb || '20') * 1048576;

            function showError(message) {
                if (!errorElement) {
                    return;
                }
                errorElement.textContent = message;
                errorElement.hidden = message === '';
                box.classList.toggle('is-invalid', message !== '');
            }

            input.addEventListener('change', function () {
                if (!fileNameElement) {
                    return;
                }

                var files = Array.prototype.slice.call(input.files || []);
                var totalBytes = files.reduce(function (sum, file) { return sum + file.size; }, 0);

                if (files.length > maxFiles) {
                    input.value = '';
                    fileNameElement.textContent = 'Файлы не выбраны';
                    showError('Можно прикрепить не более ' + maxFiles + ' файлов.');
                    return;
                }

                if (totalBytes > maxTotalBytes) {
                    input.value = '';
                    fileNameElement.textContent = 'Файлы не выбраны';
                    showError('Общий размер файлов не должен превышать ' + (maxTotalBytes / 1048576) + ' МБ.');
                    return;
                }

                showError('');

                if (files.length === 0) {
                    fileNameElement.textContent = 'Файлы не выбраны';
                    return;
                }

                fileNameElement.innerHTML = '';
                files.forEach(function (file) {
                    var line = document.createElement('div');
                    line.textContent = file.name + ' (' + formatSize(file.size) + ')';
                    fileNameElement.appendChild(line);
                });
            });
        });
    })();

    (function () {
        var modal = document.querySelector('[data-proposal-modal]');
        var openButtons = document.querySelectorAll('[data-open-proposal-modal]');
        var closeButton = document.querySelector('[data-close-proposal-modal]');
        var shouldOpenModal = @json(session('open_callback_modal') || $errors->callbackRequest->any());

        if (!modal || !closeButton) {
            return;
        }

        function openModal() {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        openButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                openModal();
            });
        });

        closeButton.addEventListener('click', function () {
            closeModal();
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        if (shouldOpenModal) {
            openModal();
        }
    })();
</script>
