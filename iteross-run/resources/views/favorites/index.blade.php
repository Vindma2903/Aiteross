<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Избранное | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg: #ffffff;
            --page: #f7f8fa;
            --text: #14161a;
            --muted: #5b6470;
            --line: #e3e6ea;
            --line-soft: #edf0f4;
            --blue: #1657c4;
            --blue-dark: #11459c;
            --shadow: 0 24px 48px -24px rgba(11, 37, 69, 0.16);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: var(--text);
            background: var(--page);
        }

        .topbar {
            border-bottom: 1px solid var(--line-soft);
            background: #fff;
        }

        .topbar__inner,
        .navbar,
        .shell,
        .cta-inner,
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

        .favorite-count {
            min-width: 18px;
            height: 18px;
            padding: 0 6px;
            border-radius: 999px;
            background: var(--blue);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .shell {
            padding-top: 32px;
            padding-bottom: 90px;
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
            color: #8891a0;
        }

        .breadcrumbs a:hover { color: var(--blue); }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            margin: 0 0 12px;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .page-header p {
            margin: 0;
            max-width: 720px;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.65;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .product-card {
            position: relative;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow);
        }

        .wish-form {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 2;
        }

        .wish-button {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: none;
            background: #fff;
            box-shadow: 0 2px 8px rgba(11, 37, 69, 0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .wish-button svg {
            width: 17px;
            height: 17px;
        }

        .wish-button path {
            stroke: var(--blue);
            stroke-width: 1.6;
            fill: var(--blue);
        }

        .product-link {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-media {
            aspect-ratio: 1 / 1;
            background: linear-gradient(180deg, #fff 0%, #f7f8fa 100%);
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .product-media__shape {
            width: min(200px, 100%);
            aspect-ratio: 1 / 1;
            border-radius: 24px;
            background:
                radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0) 38%),
                linear-gradient(135deg, #d9dee7 0%, #eef1f6 48%, #c8d0db 100%);
            border: 1px solid #d6dce6;
            position: relative;
            transform: rotate(-12deg);
        }

        .product-media__shape::before,
        .product-media__shape::after {
            content: "";
            position: absolute;
            inset: 18% 18%;
            border-radius: 20px;
            border: 14px solid #a7b4c6;
        }

        .product-media__shape::after {
            inset: 36% 36%;
            border-width: 0;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
        }

        .product-body {
            padding: 18px 18px 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-sku {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .product-title {
            margin: 0 0 8px;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.45;
            color: #2c3340;
        }

        .product-meta {
            margin-top: auto;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .product-price {
            margin-top: 12px;
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }

        .product-actions {
            padding: 0 18px 18px;
        }

        .secondary-button {
            width: 100%;
            min-height: 42px;
            border-radius: 8px;
            border: 1.5px solid var(--blue);
            background: #fff;
            color: var(--blue);
            font-size: 14px;
            font-weight: 600;
        }

        .secondary-button:hover {
            background: var(--blue);
            color: #fff;
        }

        .empty-state {
            background: #fff;
            border: 1px dashed #c8d0da;
            border-radius: 18px;
            padding: 36px 28px;
            color: #5b6470;
            font-size: 15px;
            line-height: 1.7;
        }

        .empty-state a {
            color: var(--blue);
        }

        .cta {
            background: #eff4fc;
            border-top: 1px solid #dbe5f4;
            border-bottom: 1px solid #dbe5f4;
        }

        .cta-inner {
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            padding-top: 28px;
            padding-bottom: 28px;
        }

        .cta h2 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 700;
        }

        .cta p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.65;
            max-width: 760px;
        }

        .primary-button {
            min-height: 52px;
            padding: 0 26px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }

        .site-footer {
            background: #0b2545;
            color: rgba(255, 255, 255, 0.78);
        }

        .footer-top {
            padding-top: 46px;
            padding-bottom: 34px;
            display: grid;
            grid-template-columns: 1.6fr 0.8fr 1fr 1fr;
            gap: 32px;
        }

        .footer-brand {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 14px;
        }

        .footer-text {
            margin: 0;
            max-width: 380px;
            font-size: 14.5px;
            line-height: 1.7;
        }

        .footer-socials {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .footer-socials a {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .footer-col {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 14.5px;
        }

        .footer-col a {
            color: rgba(255, 255, 255, 0.78);
        }

        .footer-label {
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.42);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .footer-requisites {
            gap: 6px;
            line-height: 1.7;
        }

        .footer-bottom {
            min-height: 58px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.52);
        }

        @media (max-width: 1280px) {
            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1180px) {
            .topbar__inner,
            .navbar {
                gap: 14px;
            }

            .navbar {
                flex-wrap: wrap;
                padding-top: 14px;
                padding-bottom: 14px;
            }

            .navbar-search {
                order: 3;
                flex-basis: 100%;
            }

            .footer-top {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1080px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .cta-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 860px) {
            .topbar {
                display: none;
            }

            .navbar__actions {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 720px) {
            .topbar__inner,
            .navbar,
            .shell,
            .cta-inner,
            .footer-top,
            .footer-bottom {
                padding-left: 16px;
                padding-right: 16px;
            }

            .page-header h1 {
                font-size: 30px;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .footer-top {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="topbar__inner">
                <nav class="topnav">
                    <a href="/#about">О компании</a>
                    <a href="{{ route('catalog.index') }}">Каталог</a>
                    <a href="/#about">Условия покупки</a>
                    <a href="/#footer">Контакты</a>
                </nav>

                <div class="topbar-spacer"></div>

                <a href="tel:+74951234567" class="contact-link contact-link--phone">+7 (495) 123-45-67</a>
                <a href="mailto:info@iteross.ru" class="contact-link contact-link--muted">info@iteross.ru</a>

                <div class="socials">
                    <a href="#" aria-label="MAX">
                        <span style="font-size: 12px; font-weight: 700; letter-spacing: -0.3px;">MAX</span>
                    </a>
                    <a href="#" aria-label="Telegram">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"></path></svg>
                    </a>
                    <a href="#" aria-label="WeChat">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M9.5 3.5C5.4 3.5 2 6.3 2 9.8c0 2 1.1 3.7 2.8 4.9L4 17l2.4-1.2c.7.2 1.4.3 2.1.3h.3a5.9 5.9 0 0 1-.2-1.6c0-3.6 3.4-6.5 7.6-6.5h.2C15.7 5 12.9 3.5 9.5 3.5Z" stroke="#5B6470" stroke-width="1.4" stroke-linejoin="round"></path><circle cx="7" cy="8.8" r="0.9" fill="#5B6470"></circle><circle cx="12" cy="8.8" r="0.9" fill="#5B6470"></circle><path d="M16.5 9.8c-3.6 0-6.5 2.4-6.5 5.4 0 3 2.9 5.4 6.5 5.4.6 0 1.2-.1 1.8-.2L20.5 21.5l-.7-2.3c1.5-1 2.4-2.4 2.4-4 0-3-2.9-5.4-6.5-5.4Z" stroke="#5B6470" stroke-width="1.4" stroke-linejoin="round"></path><circle cx="14.3" cy="14.6" r="0.8" fill="#5B6470"></circle><circle cx="18.7" cy="14.6" r="0.8" fill="#5B6470"></circle></svg>
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
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="1.8"></circle><path d="M20 20 16.2 16.2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"></path></svg>
                    </button>
                </div>
            </div>

            <div class="navbar__actions">
                <a href="{{ route('favorites.index') }}" class="nav-link" data-favorites-link>
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"></path></svg>
                    Избранное
                    <span class="favorite-count" data-favorites-count @if ($products->count() === 0) hidden @endif>{{ $products->count() }}</span>
                </a>
                <a href="#cart" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="10" cy="20.5" r="1.4" fill="#1657C4"></circle><circle cx="17" cy="20.5" r="1.4" fill="#1657C4"></circle></svg>
                    Корзина
                </a>
                @auth
                    <a href="{{ auth()->user()?->role === \App\Modules\Identity\Infrastructure\Persistence\Eloquent\User::ROLE_ADMIN ? route('admin.dashboard') : route('account') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"></circle><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"></path></svg>
                        {{ auth()->user()?->role === \App\Modules\Identity\Infrastructure\Persistence\Eloquent\User::ROLE_ADMIN ? 'Админка' : 'Личный кабинет' }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"></circle><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"></path></svg>
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
            <span>Избранное</span>
        </nav>

        <section class="page-header">
            <h1>Избранное</h1>
            <p>Список сохранённых позиций. Здесь отображаются товары, которые вы отметили по иконке сердца.</p>
        </section>

        @if ($products->isEmpty())
            <div class="empty-state" data-empty-state>
                В избранном пока нет товаров. Перейдите в <a href="{{ route('catalog.index') }}">каталог</a> и добавьте нужные позиции по иконке сердца.
            </div>
        @else
            <section class="product-grid" data-favorites-grid>
                @foreach ($products as $product)
                    <article class="product-card" data-favorite-card data-product-id="{{ $product->id }}">
                        <form action="{{ route('favorites.toggle', $product) }}" method="post" class="wish-form" data-favorite-form data-product-id="{{ $product->id }}">
                            @csrf
                            <button type="submit" class="wish-button" data-favorite-button aria-label="Убрать из избранного">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z"></path>
                                </svg>
                            </button>
                        </form>

                        <a href="{{ route('catalog.index', ['categorySlug' => $product->category?->slug]) }}" class="product-link">
                            <div class="product-media">
                                <div class="product-media__shape"></div>
                            </div>
                            <div class="product-body">
                                <div class="product-sku">{{ $product->sku }}</div>
                                <h2 class="product-title">{{ $product->name }}</h2>
                                <div class="product-meta">
                                    @if ($product->category)
                                        {{ $product->category->name }}<br>
                                    @endif
                                    {{ \Illuminate\Support\Str::limit($product->description ?? '', 80) }}
                                </div>
                                <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽ / шт.</div>
                            </div>
                        </a>

                        <div class="product-actions">
                            <a href="{{ route('catalog.index', ['categorySlug' => $product->category?->slug]) }}" class="secondary-button">Подробнее</a>
                        </div>
                    </article>
                @endforeach
            </section>
            <div class="empty-state" data-empty-state hidden>
                В избранном пока нет товаров. Перейдите в <a href="{{ route('catalog.index') }}">каталог</a> и добавьте нужные позиции по иконке сердца.
            </div>
        @endif
    </main>

    <section class="cta">
        <div class="cta-inner">
            <div>
                <h2>Не нашли нужную позицию?</h2>
                <p>Пришлите артикул аналога, и мы подберем замену и рассчитаем стоимость партии от 10 шт.</p>
            </div>
            <a href="/#lead-form-section" class="primary-button">Получить предложение</a>
        </div>
    </section>

    <footer id="footer" class="site-footer">
        <div class="footer-top">
            <div>
                <div class="footer-brand">АЙТЕРОСС</div>
                <p class="footer-text">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Telegram">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"></path></svg>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#fff" stroke-width="1.6"></path><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#fff"></path></svg>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <div class="footer-label">Навигация</div>
                <a href="{{ route('catalog.index') }}">Каталог</a>
                <a href="/#about">О компании</a>
                <a href="{{ route('delivery') }}">Доставка</a>
                <a href="/#footer">Контакты</a>
            </div>

            <div class="footer-col">
                <div class="footer-label">Контакты</div>
                <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                <div style="color: rgba(255,255,255,0.5); font-size: 13.5px;">Пн-Пт, 9:00-18:00</div>
            </div>

            <div class="footer-col footer-requisites">
                <div class="footer-label">Реквизиты</div>
                <div>ООО «АЙТЕРОСС»</div>
                <div>ИНН 7700000000</div>
                <div>ОГРН 1157700000000</div>
                <div>КПП 770001001</div>
            </div>
        </div>

        <div class="footer-bottom">© 2026 ООО «АЙТЕРОСС». Все права защищены.</div>
    </footer>

    <script>
        (function () {
            const grid = document.querySelector('[data-favorites-grid]');
            const emptyStateNodes = document.querySelectorAll('[data-empty-state]');
            const countNode = document.querySelector('[data-favorites-count]');

            function updateFavoritesCount(count) {
                if (!countNode) {
                    return;
                }

                countNode.textContent = String(count);
                countNode.hidden = count <= 0;
            }

            function syncEmptyState() {
                if (!grid) {
                    return;
                }

                const hasCards = grid.querySelectorAll('[data-favorite-card]').length > 0;
                grid.hidden = !hasCards;

                emptyStateNodes.forEach(function (node) {
                    node.hidden = hasCards;
                });
            }

            async function handleFavoriteSubmit(form) {
                const button = form.querySelector('[data-favorite-button]');
                const token = form.querySelector('input[name="_token"]');

                if (!button || !token) {
                    form.submit();
                    return;
                }

                button.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token.value,
                        },
                        body: JSON.stringify({}),
                        credentials: 'same-origin',
                    });

                    if (!response.ok) {
                        throw new Error('Favorite toggle failed');
                    }

                    const payload = await response.json();

                    if (!payload.isFavorite) {
                        form.closest('[data-favorite-card]')?.remove();
                    }

                    updateFavoritesCount(Number(payload.favoritesCount || 0));
                    syncEmptyState();
                } catch (error) {
                    form.submit();
                } finally {
                    button.disabled = false;
                }
            }

            document.querySelectorAll('[data-favorite-form]').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    handleFavoriteSubmit(form);
                });
            });

            syncEmptyState();
        })();
    </script>
</body>
</html>
