<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админка | АЙТЕРОСС</title>
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
            max-width: 760px;
        }
        .content-card {
            background: #FFFFFF;
            border: 1px solid #E3E6EA;
            border-radius: 22px;
            padding: 36px 48px 44px;
            min-height: 690px;
        }
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
            border: 1px solid #B9E7C9;
            background: #FFFFFF;
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
            background: #22C55E;
        }
        .toast__body {
            flex: 1;
            min-width: 0;
        }
        .toast__title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 700;
            color: #14161A;
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
            color: #7E8896;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .toast__close:hover {
            background: #F5F7FB;
            color: #14161A;
        }
        .pages-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
            max-width: 760px;
        }
        .page-tile {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 30px;
            border-radius: 14px;
            text-decoration: none;
            color: #14161A;
            border: 1px solid #E3E6EA;
            background: #fff;
            font-weight: 600;
            min-height: 176px;
            transition: transform 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .page-tile:hover {
            transform: translateY(-1px);
            border-color: #1657C4;
            box-shadow: 0 12px 28px -16px rgba(11, 37, 69, 0.2);
        }
        .page-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #EAF1FB;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .page-tile__label {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
        }
        .placeholder-panel {
            display: grid;
            gap: 20px;
            max-width: 760px;
        }
        .placeholder-box {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 28px;
        }
        .placeholder-box h2 {
            margin: 0 0 12px;
            font-size: 18px;
        }
        .placeholder-box p,
        .placeholder-box li {
            margin: 0;
            color: #5B6470;
            line-height: 1.7;
        }
        .placeholder-box ul {
            margin: 0;
            padding-left: 20px;
        }
        .products-shell {
            display: grid;
            gap: 20px;
        }
        .products-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .products-filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            padding: 18px;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            background: #fff;
        }
        .products-title {
            margin: 0;
            font-size: 20px;
        }
        .primary-button,
        .secondary-button,
        .danger-button {
            min-height: 46px;
            padding: 0 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
        }
        .primary-button {
            border: none;
            background: #1657C4;
            color: #fff;
        }
        .primary-button:hover {
            background: #123F94;
        }
        .secondary-button {
            border: 1.5px solid #1657C4;
            background: #fff;
            color: #1657C4;
        }
        .secondary-button:hover {
            background: #EAF1FB;
        }
        .filter-reset-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 118px;
            white-space: nowrap;
            border-color: #D6DEE8;
            color: #526070;
        }
        .filter-reset-button:hover {
            background: #F5F7FB;
            border-color: #C7D2DF;
            color: #14161A;
        }
        .danger-button {
            border: 1px solid #F0D7D7;
            background: #fff;
            color: #D34040;
        }
        .danger-button:hover {
            background: #FDF4F4;
        }
        .products-table-wrap {
            overflow-x: auto;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            background: #fff;
        }
        .products-table {
            width: 100%;
            min-width: 980px;
            border-collapse: collapse;
        }
        .products-table th,
        .products-table td {
            padding: 16px 18px;
            border-bottom: 1px solid #EDEFF2;
            vertical-align: top;
            text-align: left;
        }
        .products-table th {
            background: #F8FAFD;
            color: #7E8896;
            font-size: 12px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .products-table tr:last-child td {
            border-bottom: none;
        }
        .table-product-name {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .table-product-cell {
            display: grid;
            grid-template-columns: 72px minmax(0, 1fr);
            gap: 14px;
            align-items: start;
        }
        .table-product-image,
        .table-product-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #E3E6EA;
            background: #F5F7FB;
            flex: none;
        }
        .table-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .table-product-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #98A2B3;
        }
        .table-product-desc {
            color: #6A7381;
            font-size: 13px;
            line-height: 1.5;
            max-width: 320px;
        }
        .table-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .table-chip {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            background: #F5F7FB;
            color: #526070;
            font-size: 12px;
            font-weight: 700;
        }
        .table-chip--hidden {
            background: #FFF3E8;
            color: #B26A1F;
        }
        .table-actions {
            position: relative;
            display: inline-flex;
            justify-content: flex-end;
        }
        .table-actions form {
            margin: 0;
        }
        .table-actions-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 30;
            min-width: 220px;
            padding: 8px;
            border: 1px solid #E3E6EA;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 20px 40px -28px rgba(11, 37, 69, 0.4);
            display: none;
        }
        .table-actions.is-open .table-actions-menu {
            display: grid;
            gap: 4px;
        }
        .table-actions-trigger {
            width: 38px;
            height: 38px;
            padding: 0;
            border: 1px solid #D9E1EA;
            border-radius: 10px;
            background: #FFFFFF;
            color: #526070;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .table-actions-trigger:hover {
            background: #F5F7FB;
            color: #0B2545;
        }
        .table-action-item {
            width: 100%;
            min-height: 40px;
            padding: 0 12px;
            border: none;
            border-radius: 10px;
            background: transparent;
            color: #14161A;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
        .table-action-item:hover {
            background: #F5F7FB;
        }
        .table-action-item--danger {
            color: #D34040;
        }
        .table-action-item--danger:hover {
            background: #FDF4F4;
        }
        .link-button {
            border: none;
            background: transparent;
            color: #1657C4;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }
        .link-button:hover {
            color: #123F94;
        }
        .empty-box {
            border: 1px dashed #CBD4DE;
            border-radius: 18px;
            padding: 28px;
            color: #5B6470;
            line-height: 1.7;
            background: #FBFCFE;
        }
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(11, 37, 69, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 2000;
        }
        .modal-backdrop.is-open {
            display: flex;
        }
        .modal-card {
            width: 100%;
            max-width: 760px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            background: #fff;
            border-radius: 22px;
            border: 1px solid #E3E6EA;
            box-shadow: 0 36px 80px -36px rgba(11, 37, 69, 0.45);
            padding: 28px;
        }
        .modal-header {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }
        .modal-header h2 {
            margin: 0 0 8px;
            font-size: 24px;
        }
        .modal-header p {
            margin: 0;
            color: #6A7381;
            line-height: 1.6;
            font-size: 14px;
        }
        .icon-button {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #D8DEE6;
            background: #fff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }
        .icon-button:hover {
            background: #F5F7FB;
        }
        .product-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            align-items: start;
        }
        .field {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            align-self: start;
        }
        .field--full {
            grid-column: 1 / -1;
        }
        .field label {
            font-size: 13px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
            line-height: 1.25;
            margin: 0;
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            background: #fff;
        }
        .field input,
        .field select {
            min-height: 48px;
        }
        .field textarea {
            min-height: 110px;
            resize: vertical;
        }
        .field input[type="file"] {
            min-height: 62px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .filter-input,
        .filter-select {
            min-height: 46px;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #fff;
        }
        .filter-input {
            min-width: 280px;
            flex: 1;
        }
        .filter-select {
            min-width: 220px;
        }
        .filter-input:focus,
        .filter-select:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .toggle-row {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 48px;
            flex-wrap: wrap;
        }
        .field-note {
            color: #6A7381;
            font-size: 13px;
            line-height: 1.5;
            word-break: break-word;
        }
        .field-error {
            color: #D34040;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
        }
        .import-format {
            margin: 0;
            padding-left: 18px;
            color: #5B6470;
            font-size: 13px;
            line-height: 1.6;
        }
        .import-format strong {
            color: #14161A;
        }
        .image-library {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }
        .image-library-option {
            position: relative;
            display: block;
            cursor: pointer;
        }
        .image-library-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .image-library-card,
        .image-library-empty {
            display: grid;
            gap: 8px;
            min-height: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 14px;
            background: #FFFFFF;
            padding: 10px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }
        .image-library-empty {
            align-items: center;
            justify-items: center;
            text-align: center;
            color: #5A6270;
            font-size: 13px;
            line-height: 1.4;
            min-height: 156px;
        }
        .image-library-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 10px;
            background: #F3F6FB;
        }
        .image-library-name {
            color: #2A3140;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.35;
            word-break: break-word;
        }
        .image-library-option input:checked + .image-library-card,
        .image-library-option input:checked + .image-library-empty {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
            transform: translateY(-1px);
        }
        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }
        @media (max-width: 1440px) {
            .sidebar {
                width: 284px;
                padding: 30px 18px;
            }
            .main {
                padding: 28px 32px;
            }
            .content-card {
                padding: 28px 30px 34px;
            }
            .products-filters {
                padding: 16px;
            }
            .filter-input {
                min-width: 220px;
            }
            .filter-select {
                min-width: 180px;
            }
            .products-table {
                min-width: 920px;
            }
            .products-table th,
            .products-table td {
                padding: 14px 14px;
            }
            .table-product-cell {
                grid-template-columns: 60px minmax(0, 1fr);
                gap: 12px;
            }
            .table-product-image,
            .table-product-placeholder {
                width: 60px;
                height: 60px;
                border-radius: 14px;
            }
            .table-product-desc {
                max-width: 250px;
            }
            .modal-backdrop {
                padding: 18px;
            }
            .product-modal-card {
                max-width: 680px;
                max-height: calc(100vh - 36px);
                padding: 24px;
                border-radius: 20px;
            }
            .modal-header {
                gap: 14px;
                margin-bottom: 18px;
            }
            .modal-header h2 {
                font-size: 22px;
                margin-bottom: 6px;
            }
            .modal-header p {
                font-size: 13px;
            }
            .icon-button {
                width: 38px;
                height: 38px;
            }
            .product-form-grid {
                gap: 14px;
            }
            .field label,
            .field-note {
                font-size: 12px;
            }
            .field input,
            .field select,
            .field textarea {
                padding: 11px 13px;
                font-size: 14px;
            }
            .field input,
            .field select,
            .toggle-row {
                min-height: 44px;
            }
            .field input[type="file"] {
                min-height: 58px;
                padding: 10px 12px;
            }
            .field textarea {
                min-height: 96px;
            }
            .image-library {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 10px;
            }
            .image-library-card,
            .image-library-empty {
                padding: 9px;
                border-radius: 12px;
            }
            .image-library-empty {
                min-height: 138px;
            }
            .modal-actions {
                margin-top: 18px;
                gap: 10px;
            }
        }
        @media (max-width: 1100px) {
            .pages-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
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
            .pages-grid,
            .product-form-grid {
                grid-template-columns: 1fr;
            }
            .products-toolbar,
            .modal-header,
            .modal-actions {
                align-items: flex-start;
            }
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

    <div class="shell">
        <aside class="sidebar">
            <div>
                <div class="brand">АЙТЕРОСС</div>
                <p class="sidebar-subtitle">Панель администратора</p>
            </div>

            <nav class="nav">
                <a href="{{ route('admin.dashboard', ['section' => 'pages']) }}" class="nav-link{{ $selectedSection === 'pages' ? ' nav-link--active' : '' }}">Страницы</a>

                <div class="nav-title">УПРАВЛЕНИЕ</div>
                <a href="{{ route('admin.dashboard', ['section' => 'orders']) }}" class="nav-link{{ $selectedSection === 'orders' ? ' nav-link--active' : '' }}">Заявки</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'catalog']) }}" class="nav-link{{ request()->routeIs('admin.pages.editor') && request()->route('page') === 'catalog' ? ' nav-link--active' : '' }}">Категории</a>
                <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link{{ $selectedSection === 'products' ? ' nav-link--active' : '' }}">Товары</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'home']) }}" class="nav-link{{ request()->routeIs('admin.pages.editor') && request()->route('page') === 'home' ? ' nav-link--active' : '' }}">Главная</a>
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
                <div>
                    @if ($selectedSection === 'pages')
                        <h1>Страницы сайта</h1>
                        <p>Выберите страницу, для которой нужно открыть отдельную полноценную страницу редактора.</p>
                    @elseif ($selectedSection === 'orders')
                        <h1>Заявки</h1>
                        <p>Раздел подготовлен под просмотр входящих заявок. Сейчас здесь можно закрепить будущую таблицу, фильтры и карточки обращений.</p>
                    @else
                        <h1>Товары</h1>
                        <p>На этой странице есть таблица товаров и pop-up окно для создания новой позиции.</p>
                    @endif
                </div>
            </section>

            <section class="content-card">
                @if ($selectedSection === 'pages')
                    <div class="pages-grid">
                        @foreach (['delivery', 'product'] as $slug)
                            <a href="{{ route('admin.pages.editor', ['page' => $slug]) }}" class="page-tile">
                                <div class="page-icon">
                                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M4 4h16v16H4z" stroke="#1657C4" stroke-width="1.6"/>
                                        <path d="M4 9h16M9 9v11" stroke="#1657C4" stroke-width="1.6"/>
                                    </svg>
                                </div>
                                <div class="page-tile__label">{{ $staticPages[$slug]['label'] }}</div>
                            </a>
                        @endforeach
                    </div>
                @elseif ($selectedSection === 'orders')
                    <div class="placeholder-panel">
                        <div class="placeholder-box">
                            <h2>Заявки пока не подключены</h2>
                            <p>Сюда можно вывести таблицу входящих заявок из формы сайта, фильтры по статусу и карточку детали обращения.</p>
                        </div>
                        <div class="placeholder-box">
                            <h2>Что уже можно показать дальше</h2>
                            <ul>
                                <li>имя клиента и компания</li>
                                <li>телефон и email</li>
                                <li>комментарий к заявке</li>
                                <li>дата создания и статус обработки</li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="products-shell">
                        <div class="products-toolbar">
                            <h2 class="products-title">Список товаров</h2>
                            <div class="toolbar-actions">
                                <button type="button" class="secondary-button" data-open-import-modal>Импорт из Excel</button>
                                <button type="button" class="primary-button" data-open-create-modal>Создать товар</button>
                            </div>
                        </div>

                        <form method="get" action="{{ route('admin.dashboard') }}" class="products-filters">
                            <input type="hidden" name="section" value="products">
                            <input
                                type="text"
                                name="search"
                                value="{{ $productSearch }}"
                                class="filter-input"
                                placeholder="Поиск по названию или артикулу"
                            >
                            <select name="category" class="filter-select" data-product-category-filter>
                                <option value="">Все категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) $productCategory === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="primary-button">Найти</button>
                            <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="secondary-button filter-reset-button">Сбросить</a>
                        </form>

                        @if ($products->isEmpty())
                            <div class="empty-box">По текущему фильтру товары не найдены. Попробуйте изменить поиск, категорию или создайте новую позицию.</div>
                        @else
                            <div class="products-table-wrap">
                                <table class="products-table">
                                    <thead>
                                        <tr>
                                            <th>Товар</th>
                                            <th>Артикул</th>
                                            <th>Категория</th>
                                            <th>Цена</th>
                                            <th>Остаток</th>
                                            <th>Статус</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <div class="table-product-cell">
                                                        @if ($product->image)
                                                            <div class="table-product-image">
                                                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                                            </div>
                                                        @else
                                                            <div class="table-product-placeholder" aria-hidden="true">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect x="4" y="5" width="16" height="14" rx="3" stroke="currentColor" stroke-width="1.6"/>
                                                                    <circle cx="9" cy="10" r="1.5" fill="currentColor"/>
                                                                    <path d="M7 16l3.2-3.2a1 1 0 0 1 1.4 0L14 15l1.6-1.6a1 1 0 0 1 1.4 0L19 15.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="table-product-name">{{ $product->name }}</div>
                                                            <div class="table-product-desc">{{ $product->description ?: 'Без описания' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><strong>{{ $product->sku }}</strong></td>
                                                <td>{{ $product->category?->name ?? 'Без категории' }}</td>
                                                <td>{{ number_format($product->price, 0, ',', ' ') }} ₽ / {{ $product->unitShortLabel() }}</td>
                                                <td>
                                                    {{ $product->stockLabel() }}
                                                    @if ($product->unitDetailsLabel())
                                                        <div class="table-product-desc">{{ $product->unitDetailsLabel() }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="table-chips">
                                                        <span class="table-chip{{ $product->is_visible ? '' : ' table-chip--hidden' }}">
                                                            {{ $product->is_visible ? 'Виден' : 'Скрыт' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-actions" data-actions-menu>
                                                        <button
                                                            type="button"
                                                            class="table-actions-trigger"
                                                            data-actions-trigger
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                            aria-label="Действия с товаром"
                                                        >
                                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                                <circle cx="5" cy="12" r="1.8" fill="currentColor"/>
                                                                <circle cx="12" cy="12" r="1.8" fill="currentColor"/>
                                                                <circle cx="19" cy="12" r="1.8" fill="currentColor"/>
                                                            </svg>
                                                        </button>
                                                        <div class="table-actions-menu" role="menu">
                                                            <button type="button" class="table-action-item" data-open-edit-modal="edit-product-{{ $product->id }}" role="menuitem">Редактировать</button>
                                                            <form action="{{ route('admin.products.visibility', $product) }}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="is_visible" value="{{ $product->is_visible ? 0 : 1 }}">
                                                                <button type="submit" class="table-action-item" role="menuitem">{{ $product->is_visible ? 'Скрыть в каталоге' : 'Показать в каталоге' }}</button>
                                                            </form>
                                                            <form action="{{ route('admin.products.destroy', $product) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="table-action-item table-action-item--danger" role="menuitem">Удалить</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endif
            </section>
        </main>
    </div>

    @if ($selectedSection === 'products')
        <div class="modal-backdrop" id="import-products-modal" aria-hidden="true">
            <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="import-products-title">
                <div class="modal-header">
                    <div>
                        <h2 id="import-products-title">Импорт товаров</h2>
                        <p>Загрузите Excel или CSV-файл. Если товар с таким артикулом уже есть, он обновится, а новая позиция создастся автоматически.</p>
                    </div>
                    <button type="button" class="icon-button" data-close-import-modal aria-label="Закрыть окно">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.products.import') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="product-form-grid">
                        <div class="field field--full">
                            <label for="import-file">Файл</label>
                            <input id="import-file" type="file" name="file" accept=".xlsx,.csv,.txt" required>
                            <div class="field-note">Поддерживаются файлы `.xlsx`, `.csv`, `.txt` до 10 МБ.</div>
                            @if ($errors->importProducts->has('file'))
                                <div class="field-error">{{ $errors->importProducts->first('file') }}</div>
                            @endif
                        </div>

                        <div class="field field--full">
                            <label>Поддерживаемые колонки</label>
                            <ul class="import-format">
                                <li><strong>Обязательные:</strong> Название, Артикул</li>
                                <li><strong>Дополнительные:</strong> Категория, Цена, Остаток, Единица, Множитель, Описание, Видимость, Фото</li>
                                <li><strong>Для колонки Фото:</strong> можно указать `https://...`, `/storage/product-images/file.jpg`, `product-images/file.jpg` или просто `file.jpg`</li>
                                <li><strong>Можно и на английском:</strong> `name`, `sku`, `category`, `price`, `stock_quantity`, `unit`, `unit_mode`, `unit_multiplier`, `multiplier`, `description`, `is_visible`, `image`, `photo`</li>
                            </ul>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="secondary-button" data-close-import-modal>Отмена</button>
                        <button type="submit" class="primary-button">Загрузить файл</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-backdrop" id="create-product-modal" aria-hidden="true">
            <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="create-product-title">
                <div class="modal-header">
                    <div>
                        <h2 id="create-product-title">Создать товар</h2>
                        <p>Заполните основные поля нового товара. После сохранения он сразу появится в таблице.</p>
                    </div>
                    <button type="button" class="icon-button" data-close-create-modal aria-label="Закрыть окно">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="product-form-grid">
                        <div class="field">
                            <label for="create-name">Название</label>
                            <input id="create-name" type="text" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="field">
                            <label for="create-sku">Артикул</label>
                            <input id="create-sku" type="text" name="sku" value="{{ old('sku') }}" required>
                        </div>

                        <div class="field">
                            <label for="create-category">Категория</label>
                            <select id="create-category" name="category_id">
                                <option value="">Без категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="create-price">Цена, ₽</label>
                            <input id="create-price" type="number" min="0" name="price" value="{{ old('price', 0) }}" required>
                        </div>

                        <div class="field">
                            <label for="create-stock">Остаток</label>
                            <input id="create-stock" type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                        </div>

                        <div class="field">
                            <label for="create-unit-mode">Единица продажи</label>
                            <select id="create-unit-mode" name="unit_mode">
                                <option value="pieces" @selected(old('unit_mode', 'pieces') === 'pieces')>Штуки</option>
                                <option value="packs" @selected(old('unit_mode') === 'packs')>Упаковки</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="create-unit-multiplier">Множитель</label>
                            <input id="create-unit-multiplier" type="number" min="1" name="unit_multiplier" value="{{ old('unit_multiplier', 1) }}" required>
                            <div class="field-note">Если выбраны упаковки, укажите сколько штук в одной упаковке. Для штук оставьте `1`.</div>
                        </div>

                        <div class="field">
                            <label for="create-image">Фотография товара</label>
                            <input id="create-image" type="file" name="image" accept="image/*">
                            <div class="field-note">Можно загрузить новый файл или выбрать уже загруженное изображение ниже.</div>
                        </div>

                        <div class="field field--full">
                            <label>Библиотека загруженных изображений</label>
                            @if ($productImageLibrary->isNotEmpty())
                                <div class="image-library">
                                    <label class="image-library-option">
                                        <input type="radio" name="existing_image" value="" @checked(old('existing_image', '') === '')>
                                        <span class="image-library-empty">Не выбирать из библиотеки</span>
                                    </label>
                                    @foreach ($productImageLibrary as $libraryImage)
                                        <label class="image-library-option">
                                            <input type="radio" name="existing_image" value="{{ $libraryImage['url'] }}" @checked(old('existing_image') === $libraryImage['url'])>
                                            <span class="image-library-card">
                                                <img src="{{ $libraryImage['url'] }}" alt="{{ $libraryImage['name'] }}">
                                                <span class="image-library-name">{{ $libraryImage['name'] }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="field-note">Пока нет загруженных изображений. Сначала загрузите хотя бы одну фотографию товара.</div>
                            @endif
                        </div>

                        <div class="field field--full">
                            <label for="create-description">Описание</label>
                            <textarea id="create-description" name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="field field--full">
                            <label>Видимость на сайте</label>
                            <div class="toggle-row">
                                <label><input type="radio" name="is_visible" value="1" @checked(old('is_visible', '1') == '1')> Показывать</label>
                                <label><input type="radio" name="is_visible" value="0" @checked(old('is_visible') == '0')> Скрыть</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="secondary-button" data-close-create-modal>Отмена</button>
                        <button type="submit" class="primary-button">Создать товар</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($products as $product)
            <div class="modal-backdrop" id="edit-product-{{ $product->id }}" aria-hidden="true">
                <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="edit-product-title-{{ $product->id }}">
                    <div class="modal-header">
                        <div>
                            <h2 id="edit-product-title-{{ $product->id }}">Редактировать товар</h2>
                            <p>зменения сохранятся в базу и сразу отразятся в каталоге и в админке.</p>
                        </div>
                        <button type="button" class="icon-button" data-close-edit-modal="edit-product-{{ $product->id }}" aria-label="Закрыть окно">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="product-form-grid">
                            <div class="field">
                                <label for="name-{{ $product->id }}">Название</label>
                                <input id="name-{{ $product->id }}" type="text" name="name" value="{{ $product->name }}" required>
                            </div>

                            <div class="field">
                                <label for="sku-{{ $product->id }}">Артикул</label>
                                <input id="sku-{{ $product->id }}" type="text" name="sku" value="{{ $product->sku }}" required>
                            </div>

                            <div class="field">
                                <label for="category-{{ $product->id }}">Категория</label>
                                <select id="category-{{ $product->id }}" name="category_id">
                                    <option value="">Без категории</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected((string) $product->category_id === (string) $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="field">
                                <label for="price-{{ $product->id }}">Цена, ₽</label>
                                <input id="price-{{ $product->id }}" type="number" min="0" name="price" value="{{ $product->price }}" required>
                            </div>

                            <div class="field">
                                <label for="stock-{{ $product->id }}">Остаток</label>
                                <input id="stock-{{ $product->id }}" type="number" min="0" name="stock_quantity" value="{{ $product->stock_quantity }}" required>
                            </div>

                            <div class="field">
                                <label for="unit-mode-{{ $product->id }}">Единица продажи</label>
                                <select id="unit-mode-{{ $product->id }}" name="unit_mode">
                                    <option value="pieces" @selected($product->unit_mode === 'pieces')>Штуки</option>
                                    <option value="packs" @selected($product->unit_mode === 'packs')>Упаковки</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="unit-multiplier-{{ $product->id }}">Множитель</label>
                                <input id="unit-multiplier-{{ $product->id }}" type="number" min="1" name="unit_multiplier" value="{{ $product->unit_multiplier }}" required>
                                <div class="field-note">Если выбраны упаковки, укажите сколько штук в одной упаковке. Для штук оставьте `1`.</div>
                            </div>

                            <div class="field">
                                <label for="image-{{ $product->id }}">Новое фото товара</label>
                                <input id="image-{{ $product->id }}" type="file" name="image" accept="image/*">
                                @if ($product->image)
                                    <div class="field-note">Текущее изображение: {{ $product->image }}</div>
                                @endif
                                <div class="field-note">Можно загрузить новый файл или выбрать изображение из библиотеки ниже.</div>
                            </div>

                            <div class="field field--full">
                                <label>Библиотека загруженных изображений</label>
                                @if ($productImageLibrary->isNotEmpty())
                                    <div class="image-library">
                                        <label class="image-library-option">
                                            <input type="radio" name="existing_image" value="" @checked(! $product->image || ! $productImageLibrary->contains(fn ($libraryImage) => $libraryImage['url'] === $product->image))>
                                            <span class="image-library-empty">Оставить текущее изображение без замены</span>
                                        </label>
                                        @foreach ($productImageLibrary as $libraryImage)
                                            <label class="image-library-option">
                                                <input type="radio" name="existing_image" value="{{ $libraryImage['url'] }}" @checked($product->image === $libraryImage['url'])>
                                                <span class="image-library-card">
                                                    <img src="{{ $libraryImage['url'] }}" alt="{{ $libraryImage['name'] }}">
                                                    <span class="image-library-name">{{ $libraryImage['name'] }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="field-note">В библиотеке пока нет загруженных изображений.</div>
                                @endif
                            </div>

                            <div class="field field--full">
                                <label for="description-{{ $product->id }}">Описание</label>
                                <textarea id="description-{{ $product->id }}" name="description">{{ $product->description }}</textarea>
                            </div>

                            <div class="field field--full">
                                <label>Видимость на сайте</label>
                                <div class="toggle-row">
                                    <label><input type="radio" name="is_visible" value="1" @checked($product->is_visible)> Показывать</label>
                                    <label><input type="radio" name="is_visible" value="0" @checked(! $product->is_visible)> Скрыть</label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-actions">
                            <button type="button" class="secondary-button" data-close-edit-modal="edit-product-{{ $product->id }}">Отмена</button>
                            <button type="submit" class="primary-button">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    @if ($selectedSection === 'products')
        <script>
            (function () {
                var modal = document.getElementById('create-product-modal');
                var openButton = document.querySelector('[data-open-create-modal]');
                var importModal = document.getElementById('import-products-modal');
                var importOpenButton = document.querySelector('[data-open-import-modal]');

                function openModal() {
                    if (!modal) {
                        return;
                    }

                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                }

                function closeModal() {
                    if (!modal) {
                        return;
                    }

                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                }

                function openImportModal() {
                    if (!importModal) {
                        return;
                    }

                    importModal.classList.add('is-open');
                    importModal.setAttribute('aria-hidden', 'false');
                }

                function closeImportModal() {
                    if (!importModal) {
                        return;
                    }

                    importModal.classList.remove('is-open');
                    importModal.setAttribute('aria-hidden', 'true');
                }

                if (openButton) {
                    openButton.addEventListener('click', openModal);
                }

                if (importOpenButton) {
                    importOpenButton.addEventListener('click', openImportModal);
                }

                document.querySelectorAll('[data-close-create-modal]').forEach(function (button) {
                    button.addEventListener('click', closeModal);
                });

                document.querySelectorAll('[data-close-import-modal]').forEach(function (button) {
                    button.addEventListener('click', closeImportModal);
                });

                if (modal) {
                    modal.addEventListener('click', function (event) {
                        if (event.target === modal) {
                            closeModal();
                        }
                    });
                }

                if (importModal) {
                    importModal.addEventListener('click', function (event) {
                        if (event.target === importModal) {
                            closeImportModal();
                        }
                    });
                }

                function openNamedModal(modalId) {
                    var targetModal = modalId ? document.getElementById(modalId) : null;
                    if (!targetModal) {
                        return;
                    }

                    targetModal.classList.add('is-open');
                    targetModal.setAttribute('aria-hidden', 'false');
                }

                function closeNamedModal(modalId) {
                    var targetModal = modalId ? document.getElementById(modalId) : null;
                    if (!targetModal) {
                        return;
                    }

                    targetModal.classList.remove('is-open');
                    targetModal.setAttribute('aria-hidden', 'true');
                }

                document.querySelectorAll('[data-open-edit-modal]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        openNamedModal(button.getAttribute('data-open-edit-modal'));
                        closeAllActionMenus();
                    });
                });

                document.querySelectorAll('[data-close-edit-modal]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        closeNamedModal(button.getAttribute('data-close-edit-modal'));
                    });
                });

                document.querySelectorAll('.modal-backdrop[id^="edit-product-"]').forEach(function (editModal) {
                    editModal.addEventListener('click', function (event) {
                        if (event.target === editModal) {
                            closeNamedModal(editModal.id);
                        }
                    });
                });

                function closeAllActionMenus() {
                    document.querySelectorAll('[data-actions-menu].is-open').forEach(function (menu) {
                        menu.classList.remove('is-open');
                        var trigger = menu.querySelector('[data-actions-trigger]');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    });
                }

                document.querySelectorAll('[data-actions-trigger]').forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        event.stopPropagation();
                        var menu = button.closest('[data-actions-menu]');
                        var shouldOpen = menu && !menu.classList.contains('is-open');

                        closeAllActionMenus();

                        if (shouldOpen && menu) {
                            menu.classList.add('is-open');
                            button.setAttribute('aria-expanded', 'true');
                        }
                    });
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('[data-actions-menu]')) {
                        closeAllActionMenus();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeAllActionMenus();
                    }
                });

                var categoryFilter = document.querySelector('[data-product-category-filter]');
                if (categoryFilter && categoryFilter.form) {
                    categoryFilter.addEventListener('change', function () {
                        categoryFilter.form.submit();
                    });
                }

                var toast = document.querySelector('[data-toast]');
                var toastClose = document.querySelector('[data-toast-close]');

                function hideToast() {
                    if (!toast || toast.classList.contains('is-hiding')) {
                        return;
                    }

                    toast.classList.add('is-hiding');

                    window.setTimeout(function () {
                        var stack = document.querySelector('[data-toast-stack]');
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

                if ({{ old('_open_import_modal') === '1' || $errors->importProducts->isNotEmpty() ? 'true' : 'false' }}) {
                    openImportModal();
                }
            })();
        </script>
    @endif
</body>
</html>

