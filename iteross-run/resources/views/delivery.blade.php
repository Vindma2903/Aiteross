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
            background: #fff;
            border-bottom: 1px solid rgba(221, 227, 234, 0.85);
        }

        .topbar-inner {
            min-height: 58px;
            display: flex;
            align-items: center;
            gap: 18px;
            color: var(--muted);
            font-size: 14px;
        }

        .topbar-nav,
        .socials,
        .header-actions {
            display: flex;
            align-items: center;
        }

        .topbar-nav { gap: 22px; }
        .socials { gap: 8px; }
        .header-actions { gap: 16px; }

        .topbar-contact {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .topbar a,
        .header-link,
        .footer-link {
            text-decoration: none;
        }

        .social-chip,
        .button,
        .ghost-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            font-weight: 600;
            transition: 0.18s ease;
            text-decoration: none;
        }

        .social-chip {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f1f3f6;
            color: #5b6470;
            border: 0;
        }

        .social-chip:hover {
            background: #e3e6ea;
        }

        .button,
        .ghost-button {
            min-height: 44px;
            padding: 0 20px;
        }

        .button {
            background: var(--blue);
            color: #fff;
        }

        .ghost-button {
            min-height: 40px;
            background: #fff;
            color: var(--text);
            border: 1px solid var(--line);
            font-size: 13px;
            font-weight: 700;
        }

        .button:hover,
        .ghost-button:hover {
            background: var(--blue-dark);
            color: #fff;
            border-color: var(--blue-dark);
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(221, 227, 234, 0.9);
        }

        .header-inner {
            min-height: 84px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .brand {
            text-decoration: none;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: var(--navy);
            white-space: nowrap;
        }

        .header-search {
            flex: 1 1 360px;
            max-width: 460px;
            height: 48px;
            padding: 0 14px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #f7f9fc;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            font: inherit;
            color: var(--text);
        }

        .header-link {
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

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
        <div class="topbar-inner">
            <nav class="topbar-nav">
                <a href="{{ url('/#about') }}">О компании</a>
                <a href="{{ route('delivery') }}">Доставка</a>
                <a href="{{ url('/#footer') }}">Контакты</a>
            </nav>

            <div class="topbar-contact">
                <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                <div class="socials">
                    <a href="#" class="social-chip" aria-label="MAX">
                        <span style="font-size: 12px; font-weight: 700;">MAX</span>
                    </a>
                    <a href="#" class="social-chip" aria-label="Telegram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="#" class="social-chip" aria-label="WeChat">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M9.5 3.5C5.4 3.5 2 6.3 2 9.8c0 2 1.1 3.7 2.8 4.9L4 17l2.4-1.2c.7.2 1.4.3 2.1.3h.3a5.9 5.9 0 0 1-.2-1.6c0-3.6 3.4-6.5 7.6-6.5h.2C15.7 5 12.9 3.5 9.5 3.5Z" stroke="#5B6470" stroke-width="1.4" stroke-linejoin="round"/><circle cx="7" cy="8.8" r="0.9" fill="#5B6470"/><circle cx="12" cy="8.8" r="0.9" fill="#5B6470"/><path d="M16.5 9.8c-3.6 0-6.5 2.4-6.5 5.4 0 3 2.9 5.4 6.5 5.4.6 0 1.2-.1 1.8-.2L20.5 21.5l-.7-2.3c1.5-1 2.4-2.4 2.4-4 0-3-2.9-5.4-6.5-5.4Z" stroke="#5B6470" stroke-width="1.4" stroke-linejoin="round"/><circle cx="14.3" cy="14.6" r="0.8" fill="#5B6470"/><circle cx="18.7" cy="14.6" r="0.8" fill="#5B6470"/></svg>
                    </a>
                </div>
                <a class="ghost-button" href="{{ url('/#lead-form-section') }}">Заказать обратный звонок</a>
            </div>
        </div>
    </div>

    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ url('/') }}">АЙТЕРОСС</a>
            <a class="button" href="{{ route('catalog.index') }}">Каталог</a>

            <label class="header-search" aria-label="Поиск">
                <input type="text" placeholder="Поиск товаров...">
            </label>

            <div class="header-actions">
                <a class="header-link" href="{{ route('favorites.index') }}">Избранное</a>
                @auth
                    <a class="header-link" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('account') }}">
                        {{ auth()->user()->role === 'admin' ? 'Админка' : 'Личный кабинет' }}
                    </a>
                @else
                    <a class="header-link" href="{{ route('login') }}">Войти</a>
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
