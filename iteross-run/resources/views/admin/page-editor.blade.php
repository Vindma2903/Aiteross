<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $selectedEditorMeta['label'] }} | Админка АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #FFFFFF;
        }
        .shell {
            width: 100%;
            min-height: 100vh;
            display: flex;
            background: #FFFFFF;
        }
        .sidebar {
            width: 320px;
            flex: none;
            padding: 34px 24px;
            background: #FFFFFF;
            border-right: 1px solid #E3E6EA;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .brand {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
            color: #0B2545;
        }
        .sidebar-subtitle {
            margin: 6px 0 0;
            color: #8891A0;
            line-height: 1.6;
            font-size: 13px;
        }
        .nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .nav-title {
            padding: 18px 14px 8px;
            margin-top: 8px;
            border-top: 1px solid #E3E6EA;
            color: #8891A0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            min-height: 52px;
            padding: 0 14px;
            border-radius: 14px;
            color: #14161A;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
        }
        .nav-link:hover {
            background: #F5F7FB;
        }
        .nav-link--active {
            background: #EAF1FB;
            color: #1657C4;
        }
        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #E3E6EA;
        }
        .logout-button {
            width: 100%;
            min-height: 52px;
            border: 1px solid #F0D7D7;
            border-radius: 14px;
            background: transparent;
            color: #D34040;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }
        .logout-button:hover {
            background: #FDF4F4;
        }
        .main {
            flex: 1;
            min-width: 0;
            padding: 36px 48px;
        }
        .hero {
            margin-bottom: 28px;
        }
        .hero h1 {
            margin: 0 0 14px;
            font-size: 26px;
        }
        .hero p {
            margin: 0;
            color: #8891A0;
            line-height: 1.6;
            font-size: 14.5px;
            max-width: 720px;
        }
        .content-card {
            background: #FFFFFF;
            border: 1px solid #E3E6EA;
            border-radius: 22px;
            padding: 36px 48px 44px;
            min-height: 690px;
        }
        .editor-shell {
            display: grid;
            gap: 22px;
            max-width: 920px;
        }
        .editor-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            color: #1657C4;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
        }
        .editor-form,
        .editor-panels {
            display: grid;
            gap: 20px;
        }
        .editor-panel {
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            background: #fff;
            padding: 28px;
        }
        .editor-panel h2 {
            margin: 0 0 18px;
            font-size: 18px;
        }
        .field-grid {
            display: grid;
            gap: 16px;
        }
        .field {
            display: grid;
            gap: 8px;
        }
        .field label {
            font-size: 13px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
        }
        .field input,
        .field textarea {
            width: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            box-sizing: border-box;
            background: #fff;
        }
        .field input {
            height: 48px;
            padding-top: 0;
            padding-bottom: 0;
        }
        .field textarea {
            min-height: 96px;
            resize: vertical;
        }
        .toggle-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 24px;
        }
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid #EDEFF2;
        }
        .toggle-row span {
            font-size: 15px;
            color: #14161A;
        }
        .toggle {
            position: relative;
            width: 44px;
            height: 24px;
            border-radius: 999px;
            background: #1657C4;
            flex: none;
        }
        .toggle::after {
            content: "";
            position: absolute;
            top: 2px;
            left: 22px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
        }
        .editor-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .category-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .category-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .category-name-input {
            flex: 1;
            height: 44px;
            border: 1.5px solid #D6DAE0;
            border-radius: 9px;
            padding: 0 14px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: inherit;
            color: #14161A;
            background: #FFFFFF;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }
        .category-name-input:hover {
            border-color: #BCD0F1;
            background: #FCFDFF;
        }
        .category-name-input:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .category-add-product {
            height: 44px;
            padding: 0 14px;
            background: #EAF1FB;
            color: #1657C4;
            border: none;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            flex: none;
        }
        .category-add-product:hover {
            background: #D9E7FA;
        }
        .category-remove {
            width: 44px;
            height: 44px;
            border-radius: 9px;
            border: none;
            background: #FBEAEA;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex: none;
        }
        .category-remove:hover {
            background: #F5D5D5;
        }
        .category-add {
            margin-top: 14px;
            width: fit-content;
            min-height: 44px;
            padding: 0 18px;
            background: #fff;
            color: #1657C4;
            border: 1.5px solid #1657C4;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }
        .category-add:hover {
            background: #EAF1FB;
        }
        .save-button {
            min-height: 48px;
            padding: 0 22px;
            border: none;
            border-radius: 12px;
            background: #1657C4;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }
        .save-note {
            font-size: 14px;
            color: #2E7D32;
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .shell {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #E3E6EA;
            }
            .main {
                padding: 28px 20px;
            }
            .content-card {
                padding: 28px 20px 32px;
                min-height: auto;
            }
            .toggle-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <aside class="sidebar">
            <div>
                <div class="brand">АЙТЕРОСС</div>
                <p class="sidebar-subtitle">Панель администратора</p>
            </div>

            <nav class="nav">
                <a href="{{ route('admin.dashboard', ['section' => 'pages']) }}" class="nav-link nav-link--active">Страницы</a>

                <div class="nav-title">УПРАВЛЕНИЕ</div>
                <a href="{{ route('admin.dashboard', ['section' => 'orders']) }}" class="nav-link">Заявки</a>
                <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link">Товары</a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-button">Выйти</button>
                </form>
            </div>
        </aside>

        <main class="main">
            <section class="hero">
                <h1>Редактор: {{ $selectedEditorMeta['label'] }}</h1>
                <p>Это отдельная полноценная страница настроек для выбранного раздела. Для каталога сохранение категорий уже подключено к базе данных и фронту.</p>
            </section>

            <section class="content-card">
                <div class="editor-shell">
                    <a href="{{ route('admin.dashboard', ['section' => 'pages']) }}" class="editor-link">← К выбору страниц</a>

                    @if (session('status'))
                        <div class="save-note">{{ session('status') }}</div>
                    @endif

                    @php($isCatalogEditor = $selectedEditor === 'catalog')

                    <form class="editor-form" action="{{ $isCatalogEditor ? route('admin.catalog.categories.update') : '#' }}" method="post">
                        @if ($isCatalogEditor)
                            @csrf
                        @endif

                        <div class="editor-panels">
                            @foreach (($editorDefinition['sections'] ?? []) as $section)
                                <section class="editor-panel">
                                    <h2>{{ $section['title'] }}</h2>

                                    @if (!empty($section['categories']))
                                        <div class="category-list" data-category-list>
                                            @foreach ($section['categories'] as $index => $category)
                                                <div class="category-row" data-category-row>
                                                    <input
                                                        type="text"
                                                        class="category-name-input"
                                                        value="{{ $category['label'] }}"
                                                        @if ($isCatalogEditor) name="categories[{{ $index }}][name]" @endif
                                                    >
                                                    <button type="button" class="category-add-product">+ Товар</button>
                                                    <button type="button" class="category-remove" aria-label="Удалить категорию" data-category-remove>
                                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                            <path d="M4 6h16M9 6V4h6v2M6 6l1 15h10l1-15" stroke="#C43D3D" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="category-add" data-category-add>+ Добавить категорию</button>
                                    @endif

                                    @if (!empty($section['fields']))
                                        <div class="field-grid">
                                            @foreach ($section['fields'] as $field)
                                                <div class="field">
                                                    <label>{{ $field['label'] }}</label>
                                                    @if ($field['type'] === 'textarea')
                                                        <textarea>{{ $field['value'] }}</textarea>
                                                    @else
                                                        <input type="text" value="{{ $field['value'] }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (!empty($section['toggles']))
                                        <div class="toggle-grid">
                                            @foreach ($section['toggles'] as $toggle)
                                                <div class="toggle-row">
                                                    <span>{{ $toggle }}</span>
                                                    <div class="toggle" aria-hidden="true"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </section>
                            @endforeach

                            <div class="editor-actions">
                                <button type="{{ $isCatalogEditor ? 'submit' : 'button' }}" class="save-button">Сохранить изменения</button>
                                <div class="save-note">
                                    {{ $isCatalogEditor ? 'Категории каталога сохраняются в базу и сразу отображаются на фронте.' : 'Открыта отдельная полноценная страница редактора.' }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
    <script>
        var categoryIndex = document.querySelectorAll('[data-category-row]').length;

        document.querySelectorAll('[data-category-add]').forEach(function (button) {
            button.addEventListener('click', function () {
                var list = button.previousElementSibling;
                if (!list || !list.hasAttribute('data-category-list')) {
                    return;
                }

                var row = document.createElement('div');
                row.className = 'category-row';
                row.setAttribute('data-category-row', '');
                row.innerHTML =
                    '<input type="text" class="category-name-input" name="categories[' + categoryIndex + '][name]" value="Новая категория">' +
                    '<button type="button" class="category-add-product">+ Товар</button>' +
                    '<button type="button" class="category-remove" aria-label="Удалить категорию" data-category-remove>' +
                        '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
                            '<path d="M4 6h16M9 6V4h6v2M6 6l1 15h10l1-15" stroke="#C43D3D" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>' +
                        '</svg>' +
                    '</button>';

                list.appendChild(row);
                categoryIndex += 1;
                bindCategoryRemove(row.querySelector('[data-category-remove]'));
            });
        });

        function bindCategoryRemove(button) {
            if (!button) {
                return;
            }

            button.addEventListener('click', function () {
                var row = button.closest('[data-category-row]');
                if (row) {
                    row.remove();
                }
            });
        }

        document.querySelectorAll('[data-category-remove]').forEach(bindCategoryRemove);
    </script>
</body>
</html>
