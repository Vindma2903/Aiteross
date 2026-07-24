<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Доставка | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg: #f3f5f8;
            --panel: #ffffff;
            --navy: #0b2545;
            --text: #14161a;
            --muted: #5b6470;
            --line: #dde3ea;
            --blue: #1657c4;
            --blue-dark: #123f94;
            --footer: #33363c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(22, 87, 196, 0.08), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, var(--bg) 100%);
        }

        a { color: inherit; }

        .container {
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }

        .topbar-inner,
        .header-inner,
        .hero-block,
        .cards,
        .terms,
        .cta,
        .footer-inner,
        .footer-legal {
            width: min(1360px, calc(100% - 32px));
            margin: 0 auto;
        }

        .topbar {
            border-bottom: 1px solid #EDEFF2;
            background: #FFFFFF;
        }
        .topbar-inner {
            min-height: 58px;
            display: flex;
            align-items: center;
            gap: 28px;
        }
        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
        }
        .topbar-nav a,
        .topbar-email,
        .footer-link,
        .social-circle,
        .header-link {
            text-decoration: none;
        }
        .topbar-nav a {
            color: #5B6470;
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
            transition: color 0.15s ease;
        }
        .topbar-nav a:hover,
        .topbar-email:hover,
        .header-link:hover,
        .footer-link:hover {
            color: #0B2545;
        }
        .topbar-spacer { flex: 1; }
        .topbar-phone {
            color: #14161A;
            font-size: 14.5px;
            font-weight: 600;
            white-space: nowrap;
            text-decoration: none;
        }
        .topbar-email {
            color: #5B6470;
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
            transition: color 0.15s ease;
        }
        .social-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .social-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F1F3F6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: none;
            transition: background 0.15s ease;
        }
        .social-circle:hover { background: #E3E6EA; }
        .callback-button,
        .catalog-button,
        .button {
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease;
        }
        .callback-button {
            min-height: 40px;
            padding: 10px 18px;
            border-radius: 100px;
            background: #1657C4;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }
        .callback-button:hover,
        .catalog-button:hover,
        .button:hover { background: #123F94; }
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #FFFFFF;
            border-bottom: 1px solid #E3E6EA;
            box-shadow: 0 4px 16px rgba(11, 37, 69, 0.08);
        }
        .header-inner {
            min-height: 74px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .brand {
            text-decoration: none;
            flex: none;
        }
        .brand-name {
            color: #0B2545;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .catalog-button {
            display: inline-flex;
            align-items: center;
            background: #1657C4;
            color: #fff;
            padding: 12px 22px;
            border-radius: 100px;
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
            flex: none;
            text-decoration: none;
        }
        .header-search {
            flex: 1;
            min-width: 180px;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1.5px solid #1657C4;
            border-radius: 100px;
            padding: 0 6px 0 20px;
            height: 46px;
        }
        .search-box input {
            flex: 1;
            min-width: 0;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14.5px;
            font-family: inherit;
            color: #14161A;
        }
        .search-submit {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: #1657C4;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex: none;
            transition: background 0.15s ease;
        }
        .search-submit:hover { background: #123F94; }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: none;
        }
        .header-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #14161A;
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
            transition: color 0.15s ease;
        }
        .header-link:hover { color: #1657C4; }
        .account-menu { position: relative; flex: none; }
        .account-menu-trigger {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: none;
            background: transparent;
            padding: 0;
            color: #14161A;
            font-size: 14.5px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            white-space: nowrap;
        }
        .account-menu-trigger:hover { color: #0B2545; }
        .account-menu-panel {
            position: absolute;
            top: calc(100% + 14px);
            right: 0;
            min-width: 220px;
            padding: 10px;
            border-radius: 16px;
            border: 1px solid #E3E6EA;
            background: #FFFFFF;
            box-shadow: 0 24px 48px -24px rgba(11, 37, 69, 0.22);
            display: none;
            z-index: 130;
        }
        .account-menu.is-open .account-menu-panel { display: block; }
        .account-menu-item,
        .account-menu-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 44px;
            padding: 0 14px;
            border-radius: 12px;
            color: #14161A;
            text-decoration: none;
            background: #FFFFFF;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .account-menu-item:hover,
        .account-menu-logout:hover { background: #F4F7FB; color: #1657C4; }
        .account-menu-logout { border: none; font-family: inherit; cursor: pointer; }
        .account-menu-form { margin: 0; }

        main {
            padding: 32px 0 56px;
        }

        .hero-block {
            padding-bottom: 36px;
        }

        .breadcrumbs {
            font-size: 14px;
            color: #8891a0;
            margin-bottom: 18px;
        }

        .breadcrumbs a {
            text-decoration: none;
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(34px, 4vw, 42px);
            line-height: 1.1;
            letter-spacing: -0.03em;
        }

        .lead {
            max-width: 760px;
            margin: 0;
            font-size: 17px;
            line-height: 1.65;
            color: #4b535e;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            padding-bottom: 48px;
        }

        .card {
            background: var(--panel);
            border: 1px solid #e3e6ea;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 24px 54px -34px rgba(11, 37, 69, 0.18);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 18px;
            border-radius: 10px;
            background: #eaf1fb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card h2 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .card p {
            margin: 0;
            color: #6b7480;
            font-size: 14.5px;
            line-height: 1.65;
        }

        .terms {
            margin-bottom: 48px;
            padding: 44px 48px;
            border-radius: 20px;
            background: var(--navy);
            color: #fff;
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) minmax(280px, 0.9fr);
            gap: 48px;
        }

        .terms h2,
        .cta h2 {
            margin: 0 0 24px;
            font-size: 24px;
        }

        .term-list {
            display: grid;
            gap: 16px;
        }

        .term-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            color: rgba(255, 255, 255, 0.92);
            line-height: 1.6;
        }

        .term-panel {
            padding: 28px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .term-panel-label {
            margin-bottom: 14px;
            font-size: 13px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.05em;
        }

        .term-panel-body {
            display: grid;
            gap: 12px;
            font-size: 15.5px;
        }

        .cta-box {
            background: #f7f8fa;
            border-top: 1px solid #e3e6ea;
            padding: 56px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .cta p {
            margin: 0;
            color: #4b535e;
            font-size: 15.5px;
        }

        footer {
            margin-top: 56px;
            background: var(--footer);
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-inner {
            padding: 64px 0 24px;
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr 1fr;
            gap: 40px;
        }

        .footer-title {
            margin-bottom: 18px;
            font-size: 13.5px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.05em;
        }

        .footer-stack {
            display: grid;
            gap: 12px;
        }

        .footer-note {
            max-width: 280px;
            margin: 0 0 20px;
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.6);
        }

        .footer-legal {
            padding: 24px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
        }

        @media (max-width: 1100px) {
            .cards,
            .terms,
            .footer-inner {
                grid-template-columns: 1fr;
            }

            .header-inner,
            .topbar-inner {
                flex-wrap: wrap;
            }

            .header-search {
                max-width: none;
                flex-basis: 100%;
                order: 2;
            }
        }

        @media (max-width: 720px) {
            .topbar-inner,
            .header-inner,
            .hero-block,
            .cards,
            .terms,
            .cta,
            .footer-inner,
            .footer-legal {
                width: min(100% - 24px, 1360px);
            }

            .topbar-contact,
            .header-actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .cta-box,
            .terms {
                padding: 28px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="container topbar-inner">
            <nav class="topbar-nav">
                <a href="{{ url('/#about') }}">О компании</a>
                <a href="{{ route('delivery') }}">Доставка</a>
                <a href="{{ url('/#footer') }}">Контакты</a>
            </nav>

            <div class="topbar-spacer"></div>

            <a href="tel:+74951234567" class="topbar-phone">+7 (495) 123-45-67</a>
            <a href="mailto:info@iteross.ru" class="topbar-email">info@iteross.ru</a>

            <div class="social-row">
                <a href="#" class="social-circle" aria-label="WhatsApp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#5B6470" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#5B6470"/></svg>
                </a>
                <a href="#" class="social-circle" aria-label="Telegram">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                </a>
            </div>

            <a href="{{ url('/#lead-form-section') }}" class="callback-button">Заказать обратный звонок</a>
        </div>
    </div>

    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ url('/') }}" class="brand">
                <div class="brand-name">АЙТЕРОСС</div>
            </a>

            <a href="{{ route('catalog.index') }}" class="catalog-button">Каталог</a>

            <div class="header-search">
                <div class="search-box">
                    <input type="text" placeholder="Поиск товаров..." aria-label="Поиск товаров">
                    <button type="button" class="search-submit" aria-label="Найти">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="1.8"/><path d="M20 20L16.2 16.2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </div>

            <div class="header-actions">
                <a href="{{ route('favorites.index') }}" class="header-link">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"/></svg>
                    Избранное
                </a>
                <a href="{{ route('cart.index') }}" class="header-link">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20.5" r="1.4" fill="#1657C4"/><circle cx="17" cy="20.5" r="1.4" fill="#1657C4"/></svg>
                    Корзина
                </a>
                @auth
                    <div class="account-menu" data-account-menu>
                        <button type="button" class="account-menu-trigger" data-account-menu-trigger aria-expanded="false" aria-haspopup="true">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                            {{ auth()->user()->role === 'admin' ? 'Админка' : 'Личный кабинет' }}
                        </button>
                        <div class="account-menu-panel" data-account-menu-panel>
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('account') }}" class="account-menu-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.4" stroke="#1657C4" stroke-width="1.7"/><path d="M4.8 19.5c1.5-3.7 4.6-5.6 7.2-5.6 2.6 0 5.7 1.9 7.2 5.6" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                                Профиль
                            </a>
                            <form action="{{ route('logout') }}" method="post" class="account-menu-form">
                                @csrf
                                <button type="submit" class="account-menu-logout">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M10 6H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h3" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/><path d="M13 8l4 4-4 4M17 12H9" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="header-link">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                        Войти
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="hero-block">
            <div class="breadcrumbs">
                <a href="{{ url('/') }}">Главная</a>
                <span> / </span>
                <span style="color: #14161a;">Доставка</span>
            </div>

            <h1>Доставка</h1>
            <p class="lead">Доставка осуществляется только транспортными компаниями СДЭК, ПЭК и Деловые линии. Самовывоза пока нет. Минимальная партия упаковки — 10 штук.</p>
        </section>

        <section class="cards">
            <article class="card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 12h18M3 12l4-7h10l4 7M3 12v6a1 1 0 0 0 1 1h1m14-7v6a1 1 0 0 1-1 1h-1" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="8" cy="19" r="1.6" stroke="#1657C4" stroke-width="1.5"/><circle cx="16" cy="19" r="1.6" stroke="#1657C4" stroke-width="1.5"/></svg>
                </div>
                <h2>Транспортные компании</h2>
                <p>Доставка осуществляется только через СДЭК, ПЭК и Деловые линии. Подходящую транспортную компанию согласовываем при оформлении заказа.</p>
            </article>

            <article class="card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 17h1a2 2 0 0 0 4 0h6a2 2 0 0 0 4 0h1v-5l-3-5h-4v10M4 17V8h9v9" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h2>Отправка по России</h2>
                <p>Отправляем заказы по России только транспортными компаниями. Стоимость и сроки доставки зависят от перевозчика и города получателя.</p>
            </article>

            <article class="card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h2>Самовывоз</h2>
                <p>Самовывоза пока нет.</p>
            </article>
        </section>

        <section class="terms">
            <div>
                <h2>Условия доставки</h2>
                <div class="term-list">
                    <div class="term-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 12.5L9.5 18L20 6" stroke="#5FA8FF" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Минимальная партия упаковки — 10 штук.</span>
                    </div>
                    <div class="term-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 12.5L9.5 18L20 6" stroke="#5FA8FF" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Точная стоимость и срок доставки указываются в коммерческом предложении после обработки заявки.</span>
                    </div>
                    <div class="term-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 12.5L9.5 18L20 6" stroke="#5FA8FF" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Отгрузка выполняется на юридическое лицо с полным комплектом счетов и закрывающих документов.</span>
                    </div>
                </div>
            </div>

            <aside class="term-panel">
                <div class="term-panel-label">СКЛАД В САНКТ-ПЕТЕРБУРГЕ</div>
                <div class="term-panel-body">
                    <div>г. Санкт-Петербург, Промышленная ул., 25</div>
                    <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                    <div style="color: rgba(255,255,255,0.55); font-size: 13.5px;">Пн–Пт, 9:00–18:00</div>
                </div>
            </aside>
        </section>

        <section class="cta">
            <div class="cta-box">
                <div>
                    <h2>Остались вопросы по доставке?</h2>
                    <p>Оставьте заявку, и менеджер уточнит адрес, сроки и стоимость поставки под ваш заказ.</p>
                </div>
                <a class="button" href="{{ url('/#lead-form-section') }}">Получить предложение</a>
            </div>
        </section>
    </main>

    <footer id="footer">
        <div class="footer-inner">
            <div>
                <div style="margin-bottom: 16px; font-size: 18px; font-weight: 700; color: #fff;">АЙТЕРОСС</div>
                <p class="footer-note">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                <div class="socials">
                    <a href="#" class="social-chip" aria-label="Telegram">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="#" class="social-chip" aria-label="WhatsApp">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#5B6470" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#5B6470"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <div class="footer-title">НАВИГАЦИЯ</div>
                <div class="footer-stack">
                    <a class="footer-link" href="{{ route('catalog.index') }}">Каталог</a>
                    <a class="footer-link" href="{{ url('/#about') }}">О компании</a>
                    <a class="footer-link" href="{{ route('delivery') }}">Доставка</a>
                    <a class="footer-link" href="{{ url('/#footer') }}">Контакты</a>
                </div>
            </div>

            <div>
                <div class="footer-title">КОНТАКТЫ</div>
                <div class="footer-stack">
                    <a class="footer-link" href="tel:+74951234567">+7 (495) 123-45-67</a>
                    <a class="footer-link" href="mailto:info@iteross.ru">info@iteross.ru</a>
                    <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 13.5px;">Пн–Пт, 9:00–18:00</div>
                </div>
            </div>

            <div>
                <div class="footer-title">РЕКВИЗИТЫ</div>
                <div class="footer-stack" style="gap: 8px; font-size: 13.5px; color: rgba(255,255,255,0.6); line-height: 1.6;">
                    <div>ООО «АЙТЕРОСС»</div>
                    <div>ИНН 7700000000</div>
                    <div>ОГРН 1157700000000</div>
                    <div>КПП 770001001</div>
                </div>
            </div>
        </div>
        <div class="footer-legal">© 2026 ООО «АЙТЕРОСС». Все права защищены.</div>
    </footer>
</body>
</html>
