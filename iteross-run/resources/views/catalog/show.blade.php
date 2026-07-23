<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #FFFFFF;
            min-width: 320px;
        }
        a { color: inherit; }
        img { display: block; max-width: 100%; }
        button, input { font: inherit; }
        .page-shell { min-height: 100vh; width: 100%; background: #FFFFFF; }
        .container { max-width: 1360px; margin: 0 auto; padding: 0 20px; }
        .topbar { border-bottom: 1px solid #EDEFF2; background: #FFFFFF; }
        .topbar-inner {
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 28px;
        }
        .topbar-nav,
        .social-row,
        .header-actions {
            display: flex;
            align-items: center;
        }
        .topbar-nav {
            gap: 22px;
            flex-wrap: wrap;
        }
        .topbar-nav a,
        .topbar-email,
        .header-action,
        .footer-link,
        .footer-contact a {
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .topbar-nav a,
        .topbar-email {
            color: #5B6470;
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
        }
        .topbar-nav a:hover,
        .topbar-email:hover,
        .header-action:hover,
        .footer-link:hover,
        .footer-contact a:hover {
            color: #0B2545;
        }
        .topbar-spacer { flex: 1; }
        .topbar-phone {
            color: #14161A;
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 600;
            white-space: nowrap;
        }
        .social-row { gap: 8px; }
        .social-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F1F3F6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s ease;
        }
        .social-circle:hover { background: #E3E6EA; }
        .callback-button,
        .catalog-button,
        .search-button,
        .buy-button,
        .cta-button {
            border: none;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }
        .callback-button {
            min-height: 40px;
            padding: 10px 18px;
            border-radius: 100px;
            background: #1657C4;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }
        .callback-button:hover,
        .catalog-button:hover,
        .search-button:hover,
        .buy-button:hover,
        .cta-button:hover {
            background: #123F94;
        }
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #FFFFFF;
            border-bottom: 1px solid #E3E6EA;
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
            font-size: 22px;
            font-weight: 700;
            color: #0B2545;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .catalog-button {
            display: inline-flex;
            align-items: center;
            background: #1657C4;
            color: #fff;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 100px;
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
            flex: none;
        }
        .search-shell {
            flex: 1;
            min-width: 220px;
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
            border: none;
            background: transparent;
            outline: none;
            font-size: 14.5px;
            color: #14161A;
        }
        .search-button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #1657C4;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }
        .header-actions {
            gap: 16px;
            flex: none;
        }
        .header-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #14161A;
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
        }
        .header-action svg { flex: none; }
        .breadcrumbs {
            padding: 28px 0 0;
            font-size: 14px;
            color: #8891A0;
        }
        .breadcrumbs a {
            color: #8891A0;
            text-decoration: none;
        }
        .breadcrumbs a:hover { color: #1657C4; }
        .breadcrumbs span { margin: 0 6px; }
        .product-section {
            padding: 24px 0 90px;
            display: grid;
            grid-template-columns: 460px minmax(0, 1fr);
            gap: 56px;
            align-items: start;
        }
        .product-photo-column {
            position: sticky;
            top: 100px;
        }
        .product-photo {
            aspect-ratio: 1 / 1;
            border-radius: 14px;
            overflow: hidden;
            background: #F7F8FA;
            border: 1px solid #E3E6EA;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-photo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .product-photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            color: #5B6470;
            background: linear-gradient(180deg, #FFFFFF 0%, #EEF2F7 100%);
            font-size: 18px;
            font-weight: 600;
        }
        .product-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .sku-line {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .sku-label {
            font-size: 12.5px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.5px;
        }
        .sku-value {
            font-size: 15px;
            font-weight: 700;
            color: #14161A;
        }
        .copy-button,
        .favorite-button,
        .qty-button,
        .analog-arrow {
            cursor: pointer;
            transition: border-color 0.15s ease, background 0.15s ease;
        }
        .copy-button {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid #E3E6EA;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .copy-button:hover,
        .favorite-button:hover {
            border-color: #1657C4;
        }
        .copy-status {
            font-size: 13px;
            color: #1F8A4C;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.15s ease;
        }
        .copy-status.is-visible { opacity: 1; }
        .stock-label {
            font-size: 14px;
            color: #3A4048;
            font-weight: 600;
        }
        .product-title {
            font-size: 27px;
            font-weight: 700;
            color: #14161A;
            margin: 0 0 22px;
            letter-spacing: -0.2px;
            text-transform: uppercase;
            line-height: 1.35;
        }
        .product-actions-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        .qty-box {
            display: flex;
            align-items: center;
            border: 1.5px solid #D6DAE0;
            border-radius: 9px;
            overflow: hidden;
        }
        .qty-button {
            width: 38px;
            height: 46px;
            border: none;
            background: #fff;
            font-size: 18px;
            color: #14161A;
        }
        .qty-button:hover { background: #F1F3F6; }
        .qty-value {
            width: 44px;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            color: #14161A;
        }
        .buy-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #1657C4;
            color: #fff;
            text-decoration: none;
            padding: 0 26px;
            height: 46px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: 700;
            white-space: nowrap;
        }
        .favorite-form { margin: 0; }
        .favorite-button {
            width: 46px;
            height: 46px;
            border-radius: 9px;
            border: 1.5px solid #D6DAE0;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .favorite-button svg {
            width: 19px;
            height: 19px;
            stroke: #1657C4;
            stroke-width: 1.6;
            fill: none;
        }
        .favorite-button--active {
            border-color: #1657C4;
            background: #F2F6FF;
        }
        .favorite-button--active svg { fill: #1657C4; }
        .spec-list {
            display: flex;
            flex-direction: column;
        }
        .spec-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
            padding: 11px 0;
            border-bottom: 1px dotted #D6DAE0;
        }
        .spec-name {
            font-size: 15px;
            color: #3A4048;
            flex: none;
            white-space: nowrap;
        }
        .spec-fill {
            flex: 1;
            border-bottom: 1px dotted #D6DAE0;
            margin-bottom: 4px;
            min-width: 20px;
        }
        .spec-value {
            font-size: 15px;
            color: #14161A;
            font-weight: 600;
            text-align: right;
        }
        .description-block {
            padding-top: 16px;
            color: #4B535E;
            font-size: 15px;
            line-height: 1.7;
        }
        .analogs-section {
            padding: 0 0 90px;
        }
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #14161A;
            margin: 0 0 24px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .analogs-shell { position: relative; }
        .analog-arrow {
            position: absolute;
            top: 78px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #E3E6EA;
            background: #fff;
            box-shadow: 0 4px 12px rgba(11, 37, 69, 0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        .analog-arrow:hover { border-color: #1657C4; }
        .analog-arrow--prev { left: -18px; }
        .analog-arrow--next { right: -18px; }
        .analogs-track {
            display: flex;
            gap: 18px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-bottom: 2px;
        }
        .analogs-track::-webkit-scrollbar { display: none; }
        .analog-card {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            flex: 0 0 200px;
            width: 200px;
        }
        .analog-media {
            aspect-ratio: 1 / 1;
            border-radius: 8px;
            overflow: hidden;
            background: #F7F8FA;
            border: 1px solid #E3E6EA;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .analog-media img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .analog-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #5B6470;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }
        .analog-sku {
            font-size: 12.5px;
            color: #8891A0;
            margin-bottom: 4px;
        }
        .analog-title {
            font-size: 14px;
            font-weight: 700;
            color: #14161A;
            margin-bottom: 4px;
            line-height: 1.3;
        }
        .analog-stock {
            font-size: 13px;
            color: #1657C4;
            font-weight: 600;
        }
        .cta-strip {
            background: #F7F8FA;
            border-top: 1px solid #E3E6EA;
        }
        .cta-inner {
            padding: 44px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }
        .cta-title {
            font-size: 21px;
            font-weight: 700;
            color: #14161A;
            margin: 0 0 6px;
        }
        .cta-text {
            font-size: 15px;
            color: #4B535E;
            margin: 0;
        }
        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #1657C4;
            color: #fff;
            text-decoration: none;
            padding: 15px 26px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            white-space: nowrap;
        }
        .site-footer {
            background: #33363C;
        }
        .footer-grid {
            padding: 64px 20px 32px;
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr;
            gap: 40px;
        }
        .footer-brand {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
        }
        .footer-text {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
            margin: 0 0 20px;
            max-width: 320px;
        }
        .footer-caption {
            font-size: 13.5px;
            font-weight: 700;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.5px;
            margin-bottom: 18px;
        }
        .footer-links,
        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .footer-link,
        .footer-contact,
        .footer-contact a {
            font-size: 15px;
            color: rgba(255,255,255,0.8);
        }
        .footer-meta {
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 13px;
            color: rgba(255,255,255,0.45);
        }
        @media (max-width: 1120px) {
            .header-inner {
                flex-wrap: wrap;
                padding: 14px 0;
            }
            .header-actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            .product-section {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            .product-photo-column {
                position: static;
            }
        }
        @media (max-width: 760px) {
            .topbar-inner,
            .header-inner {
                gap: 14px;
            }
            .topbar-inner {
                padding: 12px 0;
                flex-wrap: wrap;
            }
            .search-shell,
            .header-actions {
                width: 100%;
            }
            .product-title {
                font-size: 22px;
            }
            .analog-arrow {
                display: none;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 520px) {
            .container {
                padding: 0 16px;
            }
            .breadcrumbs {
                padding-top: 22px;
            }
            .product-section,
            .analogs-section {
                padding-bottom: 64px;
            }
            .spec-row {
                flex-wrap: wrap;
            }
            .spec-fill {
                display: none;
            }
            .spec-value {
                width: 100%;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    @php($isFavorite = in_array($product->id, $favoriteProductIds, true))
    <div class="page-shell">
        <header class="site-header">
            <div class="topbar">
                <div class="container topbar-inner">
                    <nav class="topbar-nav">
                        <a href="{{ url('/#about') }}">О компании</a>
                        <a href="{{ route('delivery') }}">Условия покупки</a>
                        <a href="{{ url('/#footer') }}">Контакты</a>
                    </nav>
                    <div class="topbar-spacer"></div>
                    <a href="tel:+74951234567" class="topbar-phone">+7 (495) 123-45-67</a>
                    <a href="mailto:info@iteross.ru" class="topbar-email">info@iteross.ru</a>
                    <div class="social-row">
                        <a href="#" aria-label="WhatsApp" class="social-circle">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#5B6470" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#5B6470"/></svg>
                        </a>
                        <a href="#" aria-label="Telegram" class="social-circle">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                    <a href="{{ url('/#lead-form-section') }}" class="callback-button">Заказать обратный звонок</a>
                </div>
            </div>

            <div class="container header-inner">
                <a href="{{ url('/') }}" class="brand">
                    <div class="brand-name">АЙТЕРОСС</div>
                </a>

                <a href="{{ route('catalog.index') }}" class="catalog-button">Каталог</a>

                <div class="search-shell">
                    <div class="search-box">
                        <input type="text" placeholder="Поиск товаров..." aria-label="Поиск товаров">
                        <button type="button" class="search-button" aria-label="Найти">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="#fff" stroke-width="1.8"/><path d="M20 20 L16.2 16.2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </button>
                    </div>
                </div>

                <div class="header-actions">
                    <a href="{{ route('favorites.index') }}" class="header-action">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"/></svg>
                        Избранное
                    </a>
                    @auth
                        <a href="{{ route('account') }}" class="header-action">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                            Личный кабинет
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-action">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                            Войти
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main>
            <section class="container breadcrumbs">
                <a href="{{ url('/') }}">Главная</a>
                <span>/</span>
                <a href="{{ route('catalog.index') }}">Каталог</a>
                @if ($product->category)
                    <span>/</span>
                    <a href="{{ route('catalog.index', ['categorySlug' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                @endif
                <span>/</span>
                <span style="color: #14161A;">{{ $product->name }}</span>
            </section>

            <section class="container product-section">
                <div class="product-photo-column">
                    <div class="product-photo">
                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-photo-placeholder">{{ $product->name }}</div>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="product-topline">
                        <div class="sku-line">
                            <span class="sku-label">АРТИКУЛ:</span>
                            <span class="sku-value" data-sku-value>{{ $product->sku }}</span>
                            <button type="button" class="copy-button" aria-label="Копировать артикул" data-copy-sku>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="9" y="9" width="11" height="11" rx="1.5" stroke="#5B6470" stroke-width="1.6"/><path d="M5 15V6a1 1 0 0 1 1-1h9" stroke="#5B6470" stroke-width="1.6" stroke-linecap="round"/></svg>
                            </button>
                            <span class="copy-status" data-copy-status>Скопировано</span>
                        </div>
                        <span class="stock-label">{{ $product->stockLabel() }}</span>
                    </div>

                    <h1 class="product-title">{{ $product->sku }} | {{ $product->name }}</h1>

                    <div class="product-actions-row">
                        <div class="qty-box">
                            <button type="button" class="qty-button" aria-label="Меньше" data-qty-dec>−</button>
                            <span class="qty-value" data-qty-value>1</span>
                            <button type="button" class="qty-button" aria-label="Больше" data-qty-inc>+</button>
                        </div>

                        <a href="{{ url('/#lead-form-section') }}" class="buy-button">Получить предложение</a>

                        <form action="{{ route('favorites.toggle', $product) }}" method="post" class="favorite-form">
                            @csrf
                            <button type="submit" class="favorite-button {{ $isFavorite ? 'favorite-button--active' : '' }}" aria-label="{{ $isFavorite ? 'Убрать из избранного' : 'Добавить в избранное' }}">
                                <svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z"></path></svg>
                            </button>
                        </form>
                    </div>

                    <div class="spec-list">
                        <div class="spec-row">
                            <span class="spec-name">Наименование</span>
                            <span class="spec-fill"></span>
                            <span class="spec-value">{{ $product->name }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-name">Артикул</span>
                            <span class="spec-fill"></span>
                            <span class="spec-value">{{ $product->sku }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-name">Категория</span>
                            <span class="spec-fill"></span>
                            <span class="spec-value">{{ $product->category?->name ?? 'Без категории' }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-name">Цена</span>
                            <span class="spec-fill"></span>
                            <span class="spec-value">{{ number_format($product->price, 0, ',', ' ') }} ₽ / {{ $product->unitShortLabel() }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-name">Единица продажи</span>
                            <span class="spec-fill"></span>
                            <span class="spec-value">{{ $product->unitDetailsLabel() ?? $product->unitLabel() }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-name">Наличие</span>
                            <span class="spec-fill"></span>
                            <span class="spec-value">{{ $product->stockLabel() }}</span>
                        </div>
                        @foreach ($product->filterOptions->groupBy('group.name') as $groupName => $options)
                            <div class="spec-row">
                                <span class="spec-name">{{ $groupName }}</span>
                                <span class="spec-fill"></span>
                                <span class="spec-value">{{ $options->pluck('name')->implode(', ') }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if ($product->description)
                        <div class="description-block">{{ $product->description }}</div>
                    @endif
                </div>
            </section>

            @if ($analogProducts->isNotEmpty())
                <section class="container analogs-section">
                    <h2 class="section-title">Аналоги</h2>
                    <div class="analogs-shell">
                        <button type="button" class="analog-arrow analog-arrow--prev" aria-label="Назад" data-analog-prev>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#14161A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="analog-arrow analog-arrow--next" aria-label="Вперёд" data-analog-next>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="#14161A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>

                        <div class="analogs-track" data-analogs-track>
                            @foreach ($analogProducts as $analog)
                                @php($analogProduct = $analog['product'])
                                <a href="{{ route('catalog.products.show', ['slug' => $analogProduct->slug]) }}" class="analog-card">
                                    <div class="analog-media">
                                        @if ($analog['imageUrl'])
                                            <img src="{{ $analog['imageUrl'] }}" alt="{{ $analogProduct->name }}">
                                        @else
                                            <div class="analog-placeholder">{{ $analogProduct->name }}</div>
                                        @endif
                                    </div>
                                    <div class="analog-sku">Арт: {{ $analogProduct->sku }}</div>
                                    <div class="analog-title">{{ $analogProduct->name }}</div>
                                    <div class="analog-stock">Склад: {{ $analogProduct->stockLabel() }}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <section class="cta-strip">
                <div class="container cta-inner">
                    <div>
                        <h2 class="cta-title">Нужен аналог или другая партия?</h2>
                        <p class="cta-text">Пришлите артикул, и мы подберём замену и подготовим коммерческое предложение в тот же день.</p>
                    </div>
                    <a href="{{ url('/#lead-form-section') }}" class="cta-button">Получить предложение</a>
                </div>
            </section>
        </main>

        <footer class="site-footer" id="footer">
            <div class="container footer-grid">
                <div>
                    <div class="footer-brand">АЙТЕРОСС</div>
                    <p class="footer-text">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                    <div class="social-row">
                        <a href="#" aria-label="Telegram" class="social-circle">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        </a>
                        <a href="#" aria-label="WhatsApp" class="social-circle">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#fff" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#fff"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="footer-caption">НАВИГАЦИЯ</div>
                    <div class="footer-links">
                        <a href="{{ route('catalog.index') }}" class="footer-link">Каталог</a>
                        <a href="{{ url('/#about') }}" class="footer-link">О компании</a>
                        <a href="{{ route('delivery') }}" class="footer-link">Доставка</a>
                        <a href="{{ url('/#footer') }}" class="footer-link">Контакты</a>
                    </div>
                </div>

                <div>
                    <div class="footer-caption">КОНТАКТЫ</div>
                    <div class="footer-contact">
                        <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                        <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                        <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                        <div style="color: rgba(255,255,255,0.5); font-size: 13.5px;">Пн-Пт, 9:00-18:00</div>
                    </div>
                </div>
            </div>
            <div class="container footer-meta">© {{ now()->year }} АЙТЕРОСС. Все права защищены.</div>
        </footer>
    </div>

    <script>
        (() => {
            const qtyValue = document.querySelector('[data-qty-value]');
            const decButton = document.querySelector('[data-qty-dec]');
            const incButton = document.querySelector('[data-qty-inc]');
            const copyButton = document.querySelector('[data-copy-sku]');
            const copyStatus = document.querySelector('[data-copy-status]');
            const skuValue = document.querySelector('[data-sku-value]');
            const analogsTrack = document.querySelector('[data-analogs-track]');
            const prevButton = document.querySelector('[data-analog-prev]');
            const nextButton = document.querySelector('[data-analog-next]');

            if (qtyValue && decButton && incButton) {
                let qty = 1;
                const renderQty = () => {
                    qtyValue.textContent = String(qty);
                };

                decButton.addEventListener('click', () => {
                    qty = Math.max(1, qty - 1);
                    renderQty();
                });

                incButton.addEventListener('click', () => {
                    qty += 1;
                    renderQty();
                });
            }

            if (copyButton && copyStatus && skuValue) {
                copyButton.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(skuValue.textContent.trim());
                        copyStatus.classList.add('is-visible');
                        window.setTimeout(() => copyStatus.classList.remove('is-visible'), 1600);
                    } catch (error) {
                        copyStatus.textContent = 'Не удалось скопировать';
                        copyStatus.classList.add('is-visible');
                        window.setTimeout(() => {
                            copyStatus.textContent = 'Скопировано';
                            copyStatus.classList.remove('is-visible');
                        }, 1600);
                    }
                });
            }

            if (analogsTrack && prevButton && nextButton) {
                const scrollByCard = (direction) => {
                    analogsTrack.scrollBy({ left: direction * 218, behavior: 'smooth' });
                };

                prevButton.addEventListener('click', () => scrollByCard(-1));
                nextButton.addEventListener('click', () => scrollByCard(1));
            }
        })();
    </script>
</body>
</html>
