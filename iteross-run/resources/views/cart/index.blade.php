<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Корзина | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg: #fff;
            --page: #fff;
            --text: #14161a;
            --muted: #5b6470;
            --line: #e3e6ea;
            --line-soft: #edf0f4;
            --blue: #1657c4;
            --blue-dark: #123f94;
            --panel: #ffffff;
            --panel-soft: #f7f8fa;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: var(--text);
            background: var(--page);
        }
        a { color: inherit; }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid var(--line);
        }
        .topbar {
            border-bottom: 1px solid var(--line-soft);
            background: #fff;
        }
        .topbar__inner,
        .navbar,
        .shell,
        .footer-top,
        .footer-bottom {
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }
        .topbar__inner {
            min-height: 58px;
            display: flex;
            align-items: center;
            gap: 28px;
        }
        .topnav,
        .socials,
        .navbar__actions {
            display: flex;
            align-items: center;
        }
        .topnav { gap: 22px; }
        .topnav a,
        .contact-link,
        .nav-link,
        .footer-col a {
            text-decoration: none;
            transition: color 0.15s ease, background 0.15s ease, border-color 0.15s ease;
        }
        .topnav a,
        .contact-link--muted {
            color: var(--muted);
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
        }
        .topnav a:hover,
        .contact-link--muted:hover,
        .nav-link:hover,
        .footer-col a:hover {
            color: var(--blue);
        }
        .contact-link--phone {
            color: var(--text);
            font-size: 14.5px;
            font-weight: 600;
            white-space: nowrap;
        }
        .topbar-spacer,
        .navbar-search {
            flex: 1;
        }
        .socials { gap: 8px; }
        .socials a {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f1f3f6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            text-decoration: none;
        }
        .socials a:hover { background: #e3e6ea; }

        .callback-button,
        .catalog-button,
        .primary-button,
        .secondary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }
        .callback-button,
        .catalog-button,
        .primary-button {
            background: var(--blue);
            color: #fff;
        }
        .callback-button {
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }
        .callback-button:hover,
        .catalog-button:hover,
        .primary-button:hover {
            background: var(--blue-dark);
        }
        .navbar {
            min-height: 74px;
            display: flex;
            align-items: center;
            gap: 20px;
            background: #fff;
        }
        .brand {
            text-decoration: none;
            flex: none;
            font-size: 22px;
            font-weight: 700;
            color: #0b2545;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .catalog-button {
            padding: 12px 22px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1.5px solid var(--blue);
            border-radius: 999px;
            padding: 0 6px 0 20px;
            height: 46px;
        }
        .search-box input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--text);
        }
        .search-button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: var(--blue);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .search-button:hover { background: var(--blue-dark); }
        .navbar__actions {
            gap: 18px;
            flex: none;
        }
        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--text);
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
        }
        .nav-link svg {
            width: 19px;
            height: 19px;
        }
        .nav-link--active {
            color: var(--blue);
            font-weight: 600;
        }

        .shell {
            padding-top: 32px;
            padding-bottom: 100px;
        }
        .breadcrumbs {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
            color: #8891a0;
            font-size: 14px;
        }
        .breadcrumbs a {
            text-decoration: none;
            color: inherit;
        }
        .breadcrumbs a:hover { color: var(--blue); }
        .page-header {
            margin-bottom: 28px;
        }
        .page-header h1 {
            margin: 0 0 8px;
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
        }
        .page-header p {
            margin: 0;
            max-width: 980px;
            color: #6b7480;
            font-size: 15px;
            line-height: 1.7;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 32px;
            align-items: start;
        }
        .cart-table {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow-x: auto;
        }
        .cart-head,
        .cart-row {
            display: grid;
            grid-template-columns: 96px 1.6fr 1fr 140px 130px 40px;
            gap: 16px;
            align-items: center;
            min-width: 780px;
        }
        .cart-head {
            padding: 16px 24px;
            background: var(--panel-soft);
            border-bottom: 1px solid var(--line);
        }
        .cart-head span {
            font-size: 12px;
            font-weight: 700;
            color: #8891a0;
            letter-spacing: 0.3px;
        }
        .cart-row {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line-soft);
        }
        .cart-row:last-child {
            border-bottom: none;
        }
        .product-thumb {
            width: 72px;
            height: 72px;
            border-radius: 9px;
            overflow: hidden;
            border: 1px solid var(--line);
            background: var(--panel-soft);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-thumb__placeholder {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(180deg, #edf2f9 0%, #dde6f3 100%);
        }
        .product-meta a {
            display: block;
            margin-bottom: 4px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }
        .product-meta a:hover { color: var(--blue); }
        .product-meta div {
            font-size: 13px;
            color: #8891a0;
            line-height: 1.5;
        }
        .price-cell,
        .sum-cell {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }
        .sum-cell {
            text-align: right;
            font-weight: 700;
        }
        .price-cell--muted,
        .sum-cell--muted {
            color: #8891a0;
            font-weight: 500;
        }
        .qty-box {
            display: flex;
            align-items: center;
            border: 1.5px solid #d6dae0;
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }
        .qty-button {
            width: 34px;
            height: 40px;
            border: none;
            background: #fff;
            font-size: 17px;
            color: var(--text);
            cursor: pointer;
        }
        .qty-button:hover { background: #f1f3f6; }
        .qty-value {
            width: 40px;
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }
        .remove-button {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .remove-button:hover { background: #fbeaea; }
        .summary-card {
            position: sticky;
            top: 100px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 26px;
        }
        .summary-card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }
        .summary-row,
        .summary-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .summary-row {
            margin-bottom: 12px;
            font-size: 14.5px;
            color: #6b7480;
        }
        .summary-row strong,
        .summary-total strong {
            color: var(--text);
        }
        .summary-total {
            margin: 20px 0 22px;
            padding-top: 18px;
            border-top: 1px solid var(--line-soft);
        }
        .summary-total span {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }
        .summary-total strong {
            font-size: 20px;
            font-weight: 700;
        }
        .primary-button,
        .secondary-button {
            width: 100%;
            min-height: 50px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: 700;
        }
        .secondary-button {
            margin-top: 12px;
            background: #fff;
            color: var(--blue);
            border: 1.5px solid var(--line);
            font-weight: 600;
        }
        .secondary-button:hover {
            border-color: var(--blue);
            background: #f7faff;
        }
        .summary-note {
            margin: 18px 0 0;
            color: #8891a0;
            font-size: 12.5px;
            line-height: 1.6;
        }

        .empty-state {
            max-width: 700px;
            margin: 0 auto;
            padding: 40px 0 40px;
            text-align: center;
        }
        .empty-state[hidden],
        .cart-layout[hidden] {
            display: none !important;
        }
        .empty-state__icon {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: #f1f3f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .empty-state h2 {
            margin: 0 0 10px;
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
        }
        .empty-state p {
            margin: 0 0 26px;
            font-size: 15px;
            color: #6b7480;
            line-height: 1.7;
        }

        .site-footer {
            background: #33363c;
        }
        .footer-top {
            padding-top: 64px;
            padding-bottom: 32px;
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr 1fr;
            gap: 40px;
        }
        .footer-brand {
            margin-bottom: 16px;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }
        .footer-text {
            margin: 0 0 20px;
            max-width: 280px;
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255,255,255,0.6);
        }
        .footer-socials {
            display: flex;
            gap: 10px;
        }
        .footer-socials a {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: rgba(255,255,255,0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .footer-socials a:hover { background: rgba(255,255,255,0.2); }
        .footer-title {
            margin-bottom: 18px;
            font-size: 13.5px;
            font-weight: 700;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.5px;
        }
        .footer-col {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 15px;
            color: rgba(255,255,255,0.8);
        }
        .footer-col a {
            color: inherit;
        }
        .footer-col--muted {
            gap: 8px;
            font-size: 13.5px;
            line-height: 1.6;
            color: rgba(255,255,255,0.6);
        }
        .footer-bottom {
            padding-top: 24px;
            padding-bottom: 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }

        @media (max-width: 1100px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
            .summary-card {
                position: static;
            }
        }

        @media (max-width: 900px) {
            .topbar__inner,
            .navbar {
                flex-wrap: wrap;
                gap: 16px;
            }
            .navbar__actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            .footer-top {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .shell {
                padding-top: 24px;
                padding-bottom: 72px;
            }
            .page-header h1 {
                font-size: 24px;
            }
            .footer-top {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="topbar">
            <div class="topbar__inner">
                <nav class="topnav">
                    <a href="/#about">О компании</a>
                    <a href="/#about">Условия покупки</a>
                    <a href="/#footer">Контакты</a>
                </nav>

                <div class="topbar-spacer"></div>

                <a href="tel:+74951234567" class="contact-link contact-link--phone">+7 (495) 123-45-67</a>
                <a href="mailto:info@iteross.ru" class="contact-link contact-link--muted">info@iteross.ru</a>

                <div class="socials">
                    <a href="#" aria-label="MAX"><span style="font-size: 12px; font-weight: 700; letter-spacing: -0.3px;">MAX</span></a>
                    <a href="#" aria-label="Telegram">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="#" aria-label="WeChat">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M9.5 3.5C5.4 3.5 2 6.3 2 9.8c0 2 1.1 3.7 2.8 4.9L4 17l2.4-1.2c.7.2 1.4.3 2.1.3h.3a5.9 5.9 0 0 1-.2-1.6c0-3.6 3.4-6.5 7.6-6.5h.2C15.7 5 12.9 3.5 9.5 3.5Z" stroke="#5B6470" stroke-width="1.4" stroke-linejoin="round"/><circle cx="7" cy="8.8" r="0.9" fill="#5B6470"/><circle cx="12" cy="8.8" r="0.9" fill="#5B6470"/><path d="M16.5 9.8c-3.6 0-6.5 2.4-6.5 5.4 0 3 2.9 5.4 6.5 5.4.6 0 1.2-.1 1.8-.2L20.5 21.5l-.7-2.3c1.5-1 2.4-2.4 2.4-4 0-3-2.9-5.4-6.5-5.4Z" stroke="#5B6470" stroke-width="1.4" stroke-linejoin="round"/><circle cx="14.3" cy="14.6" r="0.8" fill="#5B6470"/><circle cx="18.7" cy="14.6" r="0.8" fill="#5B6470"/></svg>
                    </a>
                </div>

                <a href="/#lead-form-section" class="callback-button">Заказать обратный звонок</a>
            </div>
        </div>

        <div class="navbar">
            <a href="/" class="brand">АЙТЕРОСС</a>
            <a href="{{ route('catalog.index') }}" class="catalog-button">Каталог</a>

            <div class="navbar-search">
                <div class="search-box">
                    <input type="text" placeholder="Поиск товаров...">
                    <button type="button" class="search-button" aria-label="Найти">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="1.8"/><path d="M20 20 16.2 16.2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </div>

            <div class="navbar__actions">
                <a href="{{ route('favorites.index') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"/></svg>
                    Избранное
                </a>
                <a href="{{ route('cart.index') }}" class="nav-link nav-link--active">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20.5" r="1.4" fill="#1657C4"/><circle cx="17" cy="20.5" r="1.4" fill="#1657C4"/></svg>
                    Корзина
                </a>
                @auth
                    <a href="{{ auth()->user()?->role === \App\Modules\Identity\Infrastructure\Persistence\Eloquent\User::ROLE_ADMIN ? route('admin.dashboard') : route('account') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                        {{ auth()->user()?->role === \App\Modules\Identity\Infrastructure\Persistence\Eloquent\User::ROLE_ADMIN ? 'Админка' : 'Личный кабинет' }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                        Войти
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="shell">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
            <a href="/">Главная</a>
            <span>/</span>
            <span>Корзина</span>
        </nav>

        <section class="page-header">
            <h1>Корзина</h1>
            <p>Минимальная партия — 10 шт. по каждой позиции. Оплата на сайте не производится: заказ оформляется заявкой, менеджер свяжется для подтверждения и счёта.</p>
        </section>

        <section class="empty-state" data-empty-state hidden>
            <div class="empty-state__icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#8891A0" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20.5" r="1.4" fill="#8891A0"/><circle cx="17" cy="20.5" r="1.4" fill="#8891A0"/></svg>
            </div>
            <h2>Корзина пуста</h2>
            <p>Добавьте пластины из каталога, чтобы сформировать заявку на поставку.</p>
            <a href="{{ route('catalog.index') }}" class="primary-button" style="width:auto; padding: 0 28px;">Перейти в каталог</a>
        </section>

        <section class="cart-layout" data-cart-layout hidden>
            <div class="cart-table">
                <div class="cart-head">
                    <span></span>
                    <span>ТОВАР</span>
                    <span>ЦЕНА ЗА ШТ.</span>
                    <span>КОЛИЧЕСТВО</span>
                    <span style="text-align:right;">СУММА</span>
                    <span></span>
                </div>
                <div data-cart-items></div>
            </div>

            <aside class="summary-card">
                <h2>Итого по заявке</h2>

                <div class="summary-row">
                    <span>Позиций</span>
                    <strong data-items-count>0</strong>
                </div>
                <div class="summary-row">
                    <span>Штук всего</span>
                    <strong data-total-qty>0</strong>
                </div>

                <div class="summary-total">
                    <span>Сумма</span>
                    <strong data-total-label>0 ₽</strong>
                </div>

                <a href="/#lead-form-section" class="primary-button">Оформить заявку</a>
                <a href="{{ route('catalog.index') }}" class="secondary-button">Продолжить выбор товаров</a>

                <p class="summary-note">Цены по позициям без указанной стоимости уточняются менеджером при обработке заявки. Оплата производится по счёту после согласования.</p>
            </aside>
        </section>
    </main>

    <footer class="site-footer" id="footer">
        <div class="footer-top">
            <div>
                <div class="footer-brand">АЙТЕРОСС</div>
                <p class="footer-text">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Telegram">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#fff" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#fff"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <div class="footer-title">НАВИГАЦИЯ</div>
                <div class="footer-col">
                    <a href="{{ route('catalog.index') }}">Каталог</a>
                    <a href="/#about">О компании</a>
                    <a href="{{ route('delivery') }}">Доставка</a>
                    <a href="/#footer">Контакты</a>
                </div>
            </div>
            <div>
                <div class="footer-title">КОНТАКТЫ</div>
                <div class="footer-col">
                    <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                    <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                    <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 13.5px;">Пн-Пт, 9:00-18:00</div>
                </div>
            </div>
            <div>
                <div class="footer-title">РЕКВИЗИТЫ</div>
                <div class="footer-col footer-col--muted">
                    <div>ООО «АЙТЕРОСС»</div>
                    <div>ИНН 7700000000</div>
                    <div>ОГРН 1157700000000</div>
                    <div>КПП 770001001</div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">© {{ now()->year }} ООО «АЙТЕРОСС». Все права защищены.</div>
    </footer>

    <template id="cart-row-template">
        <div class="cart-row">
            <a class="product-thumb" data-item-link>
                <div class="product-thumb__placeholder" data-item-placeholder></div>
                <img data-item-image hidden alt="">
            </a>
            <div class="product-meta">
                <a data-item-link-title></a>
                <div data-item-material></div>
            </div>
            <div class="price-cell" data-item-price></div>
            <div class="qty-box">
                <button type="button" class="qty-button" data-item-dec aria-label="Меньше">−</button>
                <span class="qty-value" data-item-qty></span>
                <button type="button" class="qty-button" data-item-inc aria-label="Больше">+</button>
            </div>
            <div class="sum-cell" data-item-sum></div>
            <button type="button" class="remove-button" data-item-remove aria-label="Удалить">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M9 6V4h6v2M6 6l1 15h10l1-15" stroke="#8891A0" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    </template>

    <script>
        (() => {
            const CART_KEY = 'aiteross_cart';
            const DEFAULT_ITEMS = [
                { sku: 'CNMG120408-GM', material: 'Сталь, нержавеющая сталь', price: 1190, qty: 20, url: '{{ route('catalog.index') }}' },
                { sku: 'APMT1604PDER-M2', material: 'Чугун, алюминий', price: 1640, qty: 10, url: '{{ route('catalog.index') }}' },
                { sku: 'MGMN300-M-GM', material: 'Сталь, жаропрочные сплавы', price: null, qty: 10, url: '{{ route('catalog.products.show', ['slug' => 'mgmn-300']) }}' },
            ];

            const emptyState = document.querySelector('[data-empty-state]');
            const cartLayout = document.querySelector('[data-cart-layout]');
            const itemsRoot = document.querySelector('[data-cart-items]');
            const rowTemplate = document.querySelector('#cart-row-template');
            const itemsCountNode = document.querySelector('[data-items-count]');
            const totalQtyNode = document.querySelector('[data-total-qty]');
            const totalLabelNode = document.querySelector('[data-total-label]');

            const formatCurrency = (value) => `${value.toLocaleString('ru-RU')} ₽`;

            const readCart = () => {
                try {
                    const raw = window.localStorage.getItem(CART_KEY);

                    if (!raw) {
                        window.localStorage.setItem(CART_KEY, JSON.stringify(DEFAULT_ITEMS));

                        return [...DEFAULT_ITEMS];
                    }

                    const parsed = JSON.parse(raw);

                    return Array.isArray(parsed) ? parsed : [...DEFAULT_ITEMS];
                } catch (error) {
                    return [...DEFAULT_ITEMS];
                }
            };

            let items = readCart();

            const persist = () => {
                window.localStorage.setItem(CART_KEY, JSON.stringify(items));
            };

            const renderSummary = () => {
                const totalQty = items.reduce((sum, item) => sum + Number(item.qty || 0), 0);
                const totalPrice = items.reduce((sum, item) => sum + (item.price ? item.price * item.qty : 0), 0);
                const hasUnknownPrice = items.some((item) => item.price === null || item.price === undefined);

                itemsCountNode.textContent = String(items.length);
                totalQtyNode.textContent = String(totalQty);
                totalLabelNode.textContent = totalPrice > 0
                    ? (hasUnknownPrice ? `${formatCurrency(totalPrice)}+` : formatCurrency(totalPrice))
                    : 'По запросу';
            };

            const render = () => {
                const isEmpty = items.length === 0;

                emptyState.hidden = !isEmpty;
                cartLayout.hidden = isEmpty;
                itemsRoot.innerHTML = '';

                if (isEmpty) {
                    renderSummary();
                    return;
                }

                items.forEach((item) => {
                    const fragment = rowTemplate.content.cloneNode(true);
                    const row = fragment.querySelector('.cart-row');
                    const link = fragment.querySelector('[data-item-link]');
                    const titleLink = fragment.querySelector('[data-item-link-title]');
                    const material = fragment.querySelector('[data-item-material]');
                    const image = fragment.querySelector('[data-item-image]');
                    const placeholder = fragment.querySelector('[data-item-placeholder]');
                    const price = fragment.querySelector('[data-item-price]');
                    const qty = fragment.querySelector('[data-item-qty]');
                    const sum = fragment.querySelector('[data-item-sum]');
                    const dec = fragment.querySelector('[data-item-dec]');
                    const inc = fragment.querySelector('[data-item-inc]');
                    const remove = fragment.querySelector('[data-item-remove]');

                    link.href = item.url || '{{ route('catalog.index') }}';
                    titleLink.href = item.url || '{{ route('catalog.index') }}';
                    titleLink.textContent = item.sku || 'Товар';
                    material.textContent = item.material || '';

                    if (item.image) {
                        image.src = item.image;
                        image.alt = item.sku || 'Товар';
                        image.hidden = false;
                        placeholder.hidden = true;
                    }

                    if (item.price) {
                        price.textContent = formatCurrency(item.price);
                        sum.textContent = formatCurrency(item.price * item.qty);
                    } else {
                        price.textContent = 'По запросу';
                        price.classList.add('price-cell--muted');
                        sum.textContent = 'По запросу';
                        sum.classList.add('sum-cell--muted');
                    }

                    qty.textContent = String(item.qty || 1);

                    dec.addEventListener('click', () => {
                        item.qty = Math.max(1, Number(item.qty || 1) - 1);
                        persist();
                        render();
                    });

                    inc.addEventListener('click', () => {
                        item.qty = Number(item.qty || 1) + 1;
                        persist();
                        render();
                    });

                    remove.addEventListener('click', () => {
                        items = items.filter((entry) => entry !== item);
                        persist();
                        render();
                    });

                    itemsRoot.appendChild(row);
                });

                renderSummary();
            };

            render();
        })();
    </script>
</body>
</html>
