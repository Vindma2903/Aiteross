<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактор страниц | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg: #f4f6f8;
            --surface: #ffffff;
            --line: #e3e6ea;
            --text: #14161a;
            --muted: #6b7480;
            --blue: #1657c4;
            --danger: #c43d3d;
            --shadow: 0 20px 40px -24px rgba(11, 37, 69, 0.18);
        }

        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'IBM Plex Sans', system-ui, sans-serif; background: var(--bg); color: var(--text); }
        .shell { min-height: 100vh; display: flex; }
        .sidebar {
            width: 320px;
            flex: none;
            padding: 34px 24px;
            background: #fff;
            border-right: 1px solid var(--line);
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
            border-top: 1px solid var(--line);
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
            color: var(--text);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.15s ease, color 0.15s ease;
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
            border-top: 1px solid var(--line);
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
        .main { flex: 1; min-width: 0; padding: 32px; }
        .editor-wrap { max-width: 1440px; margin: 0 auto; }
        .hero, .card { background: var(--surface); border: 1px solid var(--line); border-radius: 20px; box-shadow: var(--shadow); }
        .hero { padding: 28px; margin-bottom: 24px; }
        .hero h1 { margin: 0 0 10px; font-size: 32px; }
        .hero p { margin: 0; color: var(--muted); line-height: 1.6; max-width: 920px; }
        .card { padding: 24px; }
        .back-link { display: inline-flex; gap: 8px; align-items: center; color: var(--blue); text-decoration: none; font-weight: 600; margin-bottom: 16px; }
        .toast-stack {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 3000;
            display: grid;
            gap: 12px;
            pointer-events: none;
        }
        .toast {
            width: min(360px, calc(100vw - 32px));
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid #b9e7c9;
            background: #fff;
            box-shadow: 0 24px 48px -28px rgba(11, 37, 69, 0.35);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            pointer-events: auto;
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .toast.is-hiding {
            opacity: 0;
            transform: translateY(-10px);
        }
        .toast__accent {
            width: 10px;
            min-width: 10px;
            align-self: stretch;
            border-radius: 999px;
            background: #22c55e;
        }
        .toast__body {
            flex: 1;
            min-width: 0;
        }
        .toast__title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 700;
            color: #14161a;
        }
        .toast__message {
            margin: 0;
            color: #526070;
            font-size: 14px;
            line-height: 1.5;
        }
        .toast__close {
            width: 28px;
            height: 28px;
            padding: 0;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: #7e8896;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .toast__close:hover {
            background: #f5f7fb;
            color: #14161a;
        }
        .panel-list { display: grid; gap: 20px; }
        .panel { border: 1px solid var(--line); border-radius: 16px; padding: 22px; }
        .panel--home {
            position: relative;
            border: 2px solid #dbe6f7;
            border-radius: 22px;
            padding: 26px;
            background:
                linear-gradient(180deg, rgba(22, 87, 196, 0.04) 0%, rgba(22, 87, 196, 0) 120px),
                #fff;
        }
        .panel--home + .panel--home {
            margin-top: 4px;
        }
        .panel-marker {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 12px;
            margin-bottom: 14px;
            border-radius: 999px;
            background: #1657c4;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .panel h2 { margin: 0 0 8px; font-size: 22px; }
        .panel p { margin: 0 0 18px; color: var(--muted); line-height: 1.6; }
        .panel-subnote {
            margin: -6px 0 18px;
            padding: 12px 14px;
            border-left: 4px solid #1657c4;
            border-radius: 0 12px 12px 0;
            background: #f4f8ff;
            color: #45607f;
            font-size: 14px;
            line-height: 1.6;
        }
        .field-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .field { display: flex; flex-direction: column; gap: 8px; }
        .field--full { grid-column: 1 / -1; }
        .field label { font-size: 13px; font-weight: 700; color: #778191; text-transform: uppercase; letter-spacing: .04em; }
        .field input, .field textarea, .field select { width: 100%; padding: 12px 14px; border: 1.5px solid #d6dae0; border-radius: 10px; font: inherit; color: var(--text); background: #fff; }
        .field textarea { min-height: 108px; resize: vertical; }
        .repeater { display: grid; gap: 14px; }
        .repeater-item { border: 1px solid var(--line); border-radius: 14px; padding: 16px; background: #fbfcfd; }
        .repeater-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 14px; }
        .repeater-title { font-size: 16px; font-weight: 700; }
        .button-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-top: 18px; }
        .button-primary, .button-secondary, .button-danger {
            min-height: 44px;
            border-radius: 10px;
            border: none;
            padding: 0 16px;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }
        .button-primary { background: var(--blue); color: #fff; }
        .button-secondary { background: #eef3fb; color: var(--blue); }
        .button-danger { background: #fff3f3; color: var(--danger); border: 1px solid #f1c7c7; }
        .note { color: var(--muted); font-size: 14px; line-height: 1.6; }
        .readonly { background: #f5f7fa !important; color: #6b7480; }
        .catalog-list { display: grid; gap: 12px; }
        .catalog-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fbfcfd;
        }
        .catalog-name-input {
            width: 100%;
            min-height: 46px;
            padding: 12px 14px;
            border: 1.5px solid #d6dae0;
            border-radius: 10px;
            background: #fff;
            color: var(--text);
            font: inherit;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .catalog-name-input:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }

        @media (max-width: 960px) {
            .shell { flex-direction: column; }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--line);
            }
            .main { padding: 20px; }
            .field-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
@if (session('status'))
    <div class="toast-stack" data-toast-stack>
        <div class="toast" data-toast>
            <div class="toast__accent" aria-hidden="true"></div>
            <div class="toast__body">
                <p class="toast__title">Готово</p>
                <p class="toast__message">{{ session('status') }}</p>
            </div>
            <button type="button" class="toast__close" data-toast-close aria-label="Закрыть уведомление">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>
@endif

@php
    $homeIcons = \App\Modules\Admin\Domain\HomePageContent::ICON_OPTIONS;
    $homeWorkTypeItems = collect($catalogCategories ?? [])->map(function ($category) use ($homePageContent) {
        $meta = $homePageContent['work_types']['items'][$category->slug] ?? [];

        return [
            'name' => $category->name,
            'slug' => $category->slug,
            'icon' => $meta['icon'] ?? 'turn',
            'image' => $meta['image'] ?? '',
            'description' => $meta['description'] ?? '',
        ];
    })->values();
@endphp

<div class="shell">
    <aside class="sidebar">
        <div>
            <div class="brand">АЙТЕРОСС</div>
            <p class="sidebar-subtitle">Панель администратора</p>
        </div>

        <nav class="nav">
            <a href="{{ route('admin.dashboard', ['section' => 'pages']) }}" class="nav-link{{ $selectedSection === 'pages' ? ' nav-link--active' : '' }}">Страницы</a>

            <div class="nav-title">УПРАВЛЕНИЕ</div>
            <a href="{{ route('admin.dashboard', ['section' => 'orders']) }}" class="nav-link">Заявки</a>
            <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link">Товары</a>
            <a href="{{ route('admin.pages.editor', ['page' => 'catalog']) }}" class="nav-link{{ $selectedEditor === 'catalog' ? ' nav-link--active' : '' }}">Категории</a>
            <a href="{{ route('admin.pages.editor', ['page' => 'home']) }}" class="nav-link{{ $selectedEditor === 'home' ? ' nav-link--active' : '' }}">Главная</a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="logout-button">Выйти</button>
            </form>
        </div>
    </aside>

<main class="main">
    <div class="editor-wrap">
    <section class="hero">
        <h1>Редактор: {{ $selectedEditorMeta['label'] }}</h1>
        <p>
            @if ($selectedEditor === 'home')
                Здесь настраивается фактический контент главной страницы: первый экран, преимущества, блок видов работ, блок компании и FAQ.
            @elseif ($selectedEditor === 'catalog')
                Здесь настраиваются категории каталога, которые используются и на главной, и на странице каталога.
            @else
                Для этой страницы пока доступен только базовый просмотр структуры.
            @endif
        </p>
    </section>

    <section class="card">
        @if ($selectedEditor !== 'home')
            <a href="{{ route('admin.dashboard', ['section' => 'pages']) }}" class="back-link">← К выбору страниц</a>
        @endif

        @if ($selectedEditor === 'home')
            <form action="{{ route('admin.pages.update', ['page' => 'home']) }}" method="post">
                @csrf

                <div class="panel-list">
                    <section class="panel panel--home">
                        <div class="panel-marker">Блок 1</div>
                        <h2>Первый экран</h2>
                        <p>Фоновая фотография, основной заголовок, описание и кнопка первого экрана.</p>
                        <div class="panel-subnote">Этот блок отвечает за самую верхнюю часть главной страницы, которую пользователь видит первой после открытия сайта.</div>
                        <div class="field-grid">
                            <div class="field field--full">
                                <label for="hero_title">Заголовок</label>
                                <input id="hero_title" type="text" name="hero[title]" value="{{ old('hero.title', $homePageContent['hero']['title']) }}">
                            </div>
                            <div class="field field--full">
                                <label for="hero_description">Описание</label>
                                <textarea id="hero_description" name="hero[description]">{{ old('hero.description', $homePageContent['hero']['description']) }}</textarea>
                            </div>
                            <div class="field">
                                <label for="hero_cta_text">Текст кнопки</label>
                                <input id="hero_cta_text" type="text" name="hero[cta_text]" value="{{ old('hero.cta_text', $homePageContent['hero']['cta_text']) }}">
                            </div>
                            <div class="field">
                                <label for="hero_background_image">URL фотографии</label>
                                <input id="hero_background_image" type="text" name="hero[background_image]" value="{{ old('hero.background_image', $homePageContent['hero']['background_image']) }}">
                            </div>
                        </div>
                    </section>

                    <section class="panel panel--home">
                        <div class="panel-marker">Шапка</div>
                        <h2>Верхнее меню</h2>
                        <p>Пункты верхней навигации в шапке сайта.</p>
                        <div class="panel-subnote">Эти ссылки отображаются в верхней полосе сайта и ведут к разделам страницы или другим адресам.</div>
                        <div class="repeater" data-repeater="header-nav">
                            @foreach (old('header_nav', $homePageContent['header_nav']) as $index => $item)
                                <div class="repeater-item" data-repeater-item>
                                    <div class="repeater-head">
                                        <div class="repeater-title">Пункт {{ $index + 1 }}</div>
                                        <button type="button" class="button-danger" data-remove-item>Удалить</button>
                                    </div>
                                    <div class="field-grid">
                                        <div class="field">
                                            <label>Название</label>
                                            <input type="text" name="header_nav[{{ $index }}][label]" value="{{ $item['label'] }}">
                                        </div>
                                        <div class="field">
                                            <label>Ссылка</label>
                                            <input type="text" name="header_nav[{{ $index }}][href]" value="{{ $item['href'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="button-row">
                            <button type="button" class="button-secondary" data-add-item="header-nav">Добавить пункт</button>
                        </div>
                    </section>

                    <section class="panel panel--home">
                        <div class="panel-marker">Блок 1.1</div>
                        <h2>Иконки и тезисы под первым экраном</h2>
                        <p>Небольшие преимущества с иконками в первом блоке.</p>
                        <div class="panel-subnote">Это короткие карточки под первым экраном: иконка плюс короткий тезис.</div>
                        <div class="repeater" data-repeater="hero-benefits">
                            @foreach (old('hero_benefits', $homePageContent['hero_benefits']) as $index => $item)
                                <div class="repeater-item" data-repeater-item>
                                    <div class="repeater-head">
                                        <div class="repeater-title">Преимущество {{ $index + 1 }}</div>
                                        <button type="button" class="button-danger" data-remove-item>Удалить</button>
                                    </div>
                                    <div class="field-grid">
                                        <div class="field">
                                            <label>Иконка</label>
                                            <select name="hero_benefits[{{ $index }}][icon]">
                                                @foreach ($homeIcons['header'] as $iconValue => $iconLabel)
                                                    <option value="{{ $iconValue }}" @selected($item['icon'] === $iconValue)>{{ $iconLabel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>Текст</label>
                                            <input type="text" name="hero_benefits[{{ $index }}][text]" value="{{ $item['text'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="button-row">
                            <button type="button" class="button-secondary" data-add-item="hero-benefits">Добавить тезис</button>
                        </div>
                    </section>

                    <section class="panel panel--home">
                        <div class="panel-marker">Блок 2</div>
                        <h2>Второй блок</h2>
                        <p>Заголовок, описание и карточки преимуществ с иконками.</p>
                        <div class="panel-subnote">Здесь настраивается следующий информационный блок после первого экрана: заголовок, текст и карточки преимуществ.</div>
                        <div class="field-grid">
                            <div class="field">
                                <label>Заголовок блока</label>
                                <input type="text" name="advantages[title]" value="{{ old('advantages.title', $homePageContent['advantages']['title']) }}">
                            </div>
                            <div class="field field--full">
                                <label>Описание блока</label>
                                <textarea name="advantages[description]">{{ old('advantages.description', $homePageContent['advantages']['description']) }}</textarea>
                            </div>
                        </div>

                        <div class="repeater" data-repeater="advantages-items" style="margin-top: 18px;">
                            @foreach (old('advantages.items', $homePageContent['advantages']['items']) as $index => $item)
                                <div class="repeater-item" data-repeater-item>
                                    <div class="repeater-head">
                                        <div class="repeater-title">Карточка {{ $index + 1 }}</div>
                                        <button type="button" class="button-danger" data-remove-item>Удалить</button>
                                    </div>
                                    <div class="field-grid">
                                        <div class="field">
                                            <label>Иконка</label>
                                            <select name="advantages[items][{{ $index }}][icon]">
                                                @foreach ($homeIcons['advantage'] as $iconValue => $iconLabel)
                                                    <option value="{{ $iconValue }}" @selected($item['icon'] === $iconValue)>{{ $iconLabel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>Заголовок</label>
                                            <input type="text" name="advantages[items][{{ $index }}][title]" value="{{ $item['title'] }}">
                                        </div>
                                        <div class="field field--full">
                                            <label>Текст</label>
                                            <textarea name="advantages[items][{{ $index }}][text]">{{ $item['text'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="button-row">
                            <button type="button" class="button-secondary" data-add-item="advantages-items">Добавить карточку</button>
                        </div>
                    </section>

                    <section class="panel panel--home">
                        <div class="panel-marker">Блок 3</div>
                        <h2>Виды производимых работ</h2>
                        <p>Названия берутся из БД. Здесь настраиваются иконки, фотографии и описания карточек.</p>
                        <div class="panel-subnote">Названия карточек приходят из категорий каталога. Здесь редактируется только внешний вид и описание каждой карточки.</div>
                        <div class="field-grid">
                            <div class="field">
                                <label>Заголовок блока</label>
                                <input type="text" name="work_types[title]" value="{{ old('work_types.title', $homePageContent['work_types']['title']) }}">
                            </div>
                            <div class="field field--full">
                                <label>Описание блока</label>
                                <textarea name="work_types[description]">{{ old('work_types.description', $homePageContent['work_types']['description']) }}</textarea>
                            </div>
                        </div>

                        <div class="repeater" style="margin-top: 18px;">
                            @foreach ($homeWorkTypeItems as $index => $item)
                                <div class="repeater-item">
                                    <div class="repeater-head">
                                        <div class="repeater-title">{{ $item['name'] }}</div>
                                    </div>
                                    <div class="field-grid">
                                        <input type="hidden" name="work_types[items][{{ $index }}][slug]" value="{{ $item['slug'] }}">
                                        <div class="field">
                                            <label>Slug категории</label>
                                            <input type="text" class="readonly" value="{{ $item['slug'] }}" readonly>
                                        </div>
                                        <div class="field">
                                            <label>Иконка</label>
                                            <select name="work_types[items][{{ $index }}][icon]">
                                                @foreach ($homeIcons['work_type'] as $iconValue => $iconLabel)
                                                    <option value="{{ $iconValue }}" @selected($item['icon'] === $iconValue)>{{ $iconLabel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>URL фотографии</label>
                                            <input type="text" name="work_types[items][{{ $index }}][image]" value="{{ $item['image'] }}">
                                        </div>
                                        <div class="field field--full">
                                            <label>Описание</label>
                                            <textarea name="work_types[items][{{ $index }}][description]">{{ $item['description'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="panel panel--home">
                        <div class="panel-marker">Блок 4</div>
                        <h2>Блок компании</h2>
                        <p>Заголовок, тексты, фотография и статистические показатели компании.</p>
                        <div class="panel-subnote">Это раздел «О компании»: основной текст, фото и цифры вроде «300+ позиций в каталоге».</div>
                        <div class="field-grid">
                            <div class="field">
                                <label>Заголовок</label>
                                <input type="text" name="about[title]" value="{{ old('about.title', $homePageContent['about']['title']) }}">
                            </div>
                            <div class="field field--full">
                                <label>Подзаголовок</label>
                                <textarea name="about[description]">{{ old('about.description', $homePageContent['about']['description']) }}</textarea>
                            </div>
                            <div class="field field--full">
                                <label>Основной текст</label>
                                <textarea name="about[text]">{{ old('about.text', $homePageContent['about']['text']) }}</textarea>
                            </div>
                            <div class="field">
                                <label>URL фотографии</label>
                                <input type="text" name="about[image]" value="{{ old('about.image', $homePageContent['about']['image']) }}">
                            </div>
                        </div>

                        <div class="repeater" data-repeater="about-stats" style="margin-top: 18px;">
                            @foreach (old('about.stats', $homePageContent['about']['stats']) as $index => $item)
                                <div class="repeater-item" data-repeater-item>
                                    <div class="repeater-head">
                                        <div class="repeater-title">Показатель {{ $index + 1 }}</div>
                                        <button type="button" class="button-danger" data-remove-item>Удалить</button>
                                    </div>
                                    <div class="field-grid">
                                        <div class="field">
                                            <label>Значение</label>
                                            <input type="text" name="about[stats][{{ $index }}][value]" value="{{ $item['value'] }}">
                                        </div>
                                        <div class="field">
                                            <label>Подпись</label>
                                            <input type="text" name="about[stats][{{ $index }}][label]" value="{{ $item['label'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="button-row">
                            <button type="button" class="button-secondary" data-add-item="about-stats">Добавить показатель</button>
                        </div>
                    </section>

                    <section class="panel panel--home">
                        <div class="panel-marker">Блок 5</div>
                        <h2>Частые вопросы</h2>
                        <p>Редактирование в формате вопрос-ответ.</p>
                        <div class="panel-subnote">Каждая запись ниже - это отдельный вопрос и ответ, который будет показан в FAQ на главной странице.</div>
                        <div class="field-grid">
                            <div class="field">
                                <label>Заголовок блока</label>
                                <input type="text" name="faq[title]" value="{{ old('faq.title', $homePageContent['faq']['title']) }}">
                            </div>
                            <div class="field field--full">
                                <label>Описание блока</label>
                                <textarea name="faq[description]">{{ old('faq.description', $homePageContent['faq']['description']) }}</textarea>
                            </div>
                        </div>

                        <div class="repeater" data-repeater="faq-items" style="margin-top: 18px;">
                            @foreach (old('faq.items', $homePageContent['faq']['items']) as $index => $item)
                                <div class="repeater-item" data-repeater-item>
                                    <div class="repeater-head">
                                        <div class="repeater-title">Вопрос {{ $index + 1 }}</div>
                                        <button type="button" class="button-danger" data-remove-item>Удалить</button>
                                    </div>
                                    <div class="field-grid">
                                        <div class="field field--full">
                                            <label>Вопрос</label>
                                            <input type="text" name="faq[items][{{ $index }}][question]" value="{{ $item['question'] }}">
                                        </div>
                                        <div class="field field--full">
                                            <label>Ответ</label>
                                            <textarea name="faq[items][{{ $index }}][answer]">{{ $item['answer'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="button-row">
                            <button type="button" class="button-secondary" data-add-item="faq-items">Добавить вопрос</button>
                        </div>
                    </section>

                    <div class="button-row">
                        <button type="submit" class="button-primary">Сохранить изменения</button>
                        <div class="note">Изменения сразу применяются к главной странице сайта.</div>
                    </div>
                </div>
            </form>
        @elseif ($selectedEditor === 'catalog')
            @php($isCatalogEditor = true)
            <form action="{{ route('admin.catalog.categories.update') }}" method="post">
                @csrf
                <div class="panel-list">
                    @foreach (($editorDefinition['sections'] ?? []) as $section)
                        <section class="panel">
                            <h2>{{ $section['title'] }}</h2>

                            @if (!empty($section['fields']))
                                <div class="field-grid">
                                    @foreach ($section['fields'] as $field)
                                        <div class="field {{ $field['type'] === 'textarea' ? 'field--full' : '' }}">
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

                            @if (!empty($section['categories']))
                                <div class="catalog-list" data-category-list>
                                    @foreach ($section['categories'] as $index => $category)
                                        <div class="catalog-row" data-category-row>
                                            <input type="text" class="catalog-name-input" name="categories[{{ $index }}][name]" value="{{ $category['label'] }}">
                                            <button type="button" class="button-danger" data-category-remove>Удалить</button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="button-row">
                                    <button type="button" class="button-secondary" data-category-add>Добавить категорию</button>
                                </div>
                            @endif
                        </section>
                    @endforeach

                    <div class="button-row">
                        <button type="submit" class="button-primary">Сохранить категории</button>
                        <div class="note">Категории сохраняются в БД и используются на главной и в каталоге.</div>
                    </div>
                </div>
            </form>
        @else
            <div class="panel-list">
                @foreach (($editorDefinition['sections'] ?? []) as $section)
                    <section class="panel">
                        <h2>{{ $section['title'] }}</h2>
                        @if (!empty($section['fields']))
                            <div class="field-grid">
                                @foreach ($section['fields'] as $field)
                                    <div class="field {{ $field['type'] === 'textarea' ? 'field--full' : '' }}">
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
                    </section>
                @endforeach
            </div>
        @endif
    </section>
    </div>
</main>
</div>

<template id="tpl-header-nav">
    <div class="repeater-item" data-repeater-item>
        <div class="repeater-head">
            <div class="repeater-title">Новый пункт</div>
            <button type="button" class="button-danger" data-remove-item>Удалить</button>
        </div>
        <div class="field-grid">
            <div class="field">
                <label>Название</label>
                <input type="text" data-name-template="header_nav[__INDEX__][label]" value="">
            </div>
            <div class="field">
                <label>Ссылка</label>
                <input type="text" data-name-template="header_nav[__INDEX__][href]" value="/#about">
            </div>
        </div>
    </div>
</template>

<template id="tpl-hero-benefits">
    <div class="repeater-item" data-repeater-item>
        <div class="repeater-head">
            <div class="repeater-title">Новое преимущество</div>
            <button type="button" class="button-danger" data-remove-item>Удалить</button>
        </div>
        <div class="field-grid">
            <div class="field">
                <label>Иконка</label>
                <select data-name-template="hero_benefits[__INDEX__][icon]">
                    @foreach ($homeIcons['header'] as $iconValue => $iconLabel)
                        <option value="{{ $iconValue }}">{{ $iconLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Текст</label>
                <input type="text" data-name-template="hero_benefits[__INDEX__][text]" value="">
            </div>
        </div>
    </div>
</template>

<template id="tpl-advantages-items">
    <div class="repeater-item" data-repeater-item>
        <div class="repeater-head">
            <div class="repeater-title">Новая карточка</div>
            <button type="button" class="button-danger" data-remove-item>Удалить</button>
        </div>
        <div class="field-grid">
            <div class="field">
                <label>Иконка</label>
                <select data-name-template="advantages[items][__INDEX__][icon]">
                    @foreach ($homeIcons['advantage'] as $iconValue => $iconLabel)
                        <option value="{{ $iconValue }}">{{ $iconLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Заголовок</label>
                <input type="text" data-name-template="advantages[items][__INDEX__][title]" value="">
            </div>
            <div class="field field--full">
                <label>Текст</label>
                <textarea data-name-template="advantages[items][__INDEX__][text]"></textarea>
            </div>
        </div>
    </div>
</template>

<template id="tpl-about-stats">
    <div class="repeater-item" data-repeater-item>
        <div class="repeater-head">
            <div class="repeater-title">Новый показатель</div>
            <button type="button" class="button-danger" data-remove-item>Удалить</button>
        </div>
        <div class="field-grid">
            <div class="field">
                <label>Значение</label>
                <input type="text" data-name-template="about[stats][__INDEX__][value]" value="">
            </div>
            <div class="field">
                <label>Подпись</label>
                <input type="text" data-name-template="about[stats][__INDEX__][label]" value="">
            </div>
        </div>
    </div>
</template>

<template id="tpl-faq-items">
    <div class="repeater-item" data-repeater-item>
        <div class="repeater-head">
            <div class="repeater-title">Новый вопрос</div>
            <button type="button" class="button-danger" data-remove-item>Удалить</button>
        </div>
        <div class="field-grid">
            <div class="field field--full">
                <label>Вопрос</label>
                <input type="text" data-name-template="faq[items][__INDEX__][question]" value="">
            </div>
            <div class="field field--full">
                <label>Ответ</label>
                <textarea data-name-template="faq[items][__INDEX__][answer]"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
    const repeaterMap = {
        'header-nav': { templateId: 'tpl-header-nav', selector: '[data-repeater="header-nav"]' },
        'hero-benefits': { templateId: 'tpl-hero-benefits', selector: '[data-repeater="hero-benefits"]' },
        'advantages-items': { templateId: 'tpl-advantages-items', selector: '[data-repeater="advantages-items"]' },
        'about-stats': { templateId: 'tpl-about-stats', selector: '[data-repeater="about-stats"]' },
        'faq-items': { templateId: 'tpl-faq-items', selector: '[data-repeater="faq-items"]' },
    };

    function bindRemoveButtons(root = document) {
        root.querySelectorAll('[data-remove-item]').forEach((button) => {
            if (button.dataset.bound === '1') {
                return;
            }

            button.dataset.bound = '1';
            button.addEventListener('click', () => {
                button.closest('[data-repeater-item]')?.remove();
            });
        });
    }

    document.querySelectorAll('[data-add-item]').forEach((button) => {
        button.addEventListener('click', () => {
            const type = button.dataset.addItem;
            const config = repeaterMap[type];

            if (!config) {
                return;
            }

            const list = document.querySelector(config.selector);
            const template = document.getElementById(config.templateId);

            if (!list || !template) {
                return;
            }

            const fragment = template.content.cloneNode(true);
            const item = fragment.querySelector('[data-repeater-item]');
            const index = list.querySelectorAll('[data-repeater-item]').length;

            item.querySelectorAll('[data-name-template]').forEach((field) => {
                field.name = field.dataset.nameTemplate.replace(/__INDEX__/g, index);
            });

            list.appendChild(fragment);
            bindRemoveButtons(list);
        });
    });

    let categoryIndex = document.querySelectorAll('[data-category-row]').length;

    document.querySelectorAll('[data-category-add]').forEach((button) => {
        button.addEventListener('click', () => {
            const list = document.querySelector('[data-category-list]');

            if (!list) {
                return;
            }

            const row = document.createElement('div');
            row.className = 'catalog-row';
            row.setAttribute('data-category-row', '');
            row.innerHTML = `
                <input type="text" class="catalog-name-input" name="categories[${categoryIndex}][name]" value="Новая категория">
                <button type="button" class="button-danger" data-category-remove>Удалить</button>
            `;

            list.appendChild(row);
            categoryIndex += 1;
            bindCategoryRemove(row.querySelector('[data-category-remove]'));
        });
    });

    function bindCategoryRemove(button) {
        if (!button || button.dataset.bound === '1') {
            return;
        }

        button.dataset.bound = '1';
        button.addEventListener('click', () => {
            button.closest('[data-category-row]')?.remove();
        });
    }

    document.querySelectorAll('[data-category-remove]').forEach(bindCategoryRemove);
    bindRemoveButtons();

    const toast = document.querySelector('[data-toast]');
    const toastClose = document.querySelector('[data-toast-close]');

    function hideToast() {
        if (!toast || toast.classList.contains('is-hiding')) {
            return;
        }

        toast.classList.add('is-hiding');

        window.setTimeout(() => {
            const stack = document.querySelector('[data-toast-stack]');
            if (stack) {
                stack.remove();
            }
        }, 220);
    }

    if (toast) {
        window.setTimeout(hideToast, 3200);
    }

    if (toastClose) {
        toastClose.addEventListener('click', hideToast);
    }
</script>
</body>
</html>
