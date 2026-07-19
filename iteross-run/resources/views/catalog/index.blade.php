<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Каталог | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #F7F8FA;
        }
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #FFFFFF;
            border-bottom: 1px solid #E3E6EA;
            box-shadow: 0 4px 16px rgba(11, 37, 69, 0.08);
        }
        .topbar {
            border-bottom: 1px solid #EDEFF2;
        }
        .topbar__inner,
        .navbar {
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }
        .topbar__inner {
            min-height: 57px;
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
        .topnav {
            gap: 22px;
        }
        .topnav a,
        .contact-link,
        .nav-link {
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .topnav a,
        .contact-link--muted {
            color: #5B6470;
            font-size: 14.5px;
            font-weight: 500;
        }
        .topnav a:hover,
        .contact-link--muted:hover,
        .nav-link:hover {
            color: #0B2545;
        }
        .contact-link--phone {
            color: #14161A;
            font-size: 14.5px;
            font-weight: 600;
            white-space: nowrap;
        }
        .topbar-spacer,
        .navbar-search {
            flex: 1;
        }
        .socials {
            gap: 8px;
        }
        .socials a {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F1F3F6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #5B6470;
            text-decoration: none;
        }
        .socials a:hover {
            background: #E3E6EA;
        }
        .callback-button,
        .catalog-button,
        .chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }
        .callback-button {
            padding: 10px 18px;
            border-radius: 999px;
            background: #1657C4;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }
        .callback-button:hover,
        .catalog-button:hover {
            background: #123F94;
        }
        .navbar {
            min-height: 74px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .brand {
            text-decoration: none;
            flex: none;
            font-size: 22px;
            font-weight: 700;
            color: #0B2545;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .catalog-button {
            padding: 12px 22px;
            border-radius: 999px;
            background: #1657C4;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1.5px solid #1657C4;
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
            color: #14161A;
        }
        .search-button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: #1657C4;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .search-button:hover {
            background: #123F94;
        }
        .navbar__actions {
            gap: 18px;
            flex: none;
        }
        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #14161A;
            font-size: 14.5px;
            font-weight: 500;
            white-space: nowrap;
        }
        .nav-link svg {
            width: 19px;
            height: 19px;
        }
        .nav-link--active {
            color: #1657C4;
        }
        .favorite-count {
            min-width: 18px;
            height: 18px;
            padding: 0 6px;
            border-radius: 999px;
            background: #1657C4;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .shell {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 20px 56px;
        }
        .hero {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            box-shadow: 0 24px 48px -24px rgba(11, 37, 69, 0.16);
            padding: 28px;
            margin-bottom: 22px;
        }
        .hero h1 {
            margin: 0 0 10px;
            font-size: 32px;
        }
        .hero p {
            margin: 0;
            color: #5B6470;
            font-size: 15px;
            line-height: 1.6;
            max-width: 780px;
        }
        .status {
            margin-bottom: 18px;
            border-radius: 12px;
            padding: 14px 16px;
            background: #ECFDF5;
            color: #166534;
            border: 1px solid #86EFAC;
            font-size: 14px;
        }
        .categories {
            margin-bottom: 24px;
            background: #FFFFFF;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 20px 40px -28px rgba(11, 37, 69, 0.2);
        }
        .categories h2 {
            margin: 0 0 16px;
            font-size: 24px;
        }
        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            padding: 0 18px;
            border-radius: 999px;
            border: 1px solid #D6DAE0;
            background: #F8FAFD;
            color: #14161A;
            font-size: 14px;
            font-weight: 600;
        }
        .category-count {
            min-width: 24px;
            height: 24px;
            padding: 0 8px;
            border-radius: 999px;
            background: #EAF1FB;
            color: #1657C4;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            box-shadow: 0 20px 40px -28px rgba(11, 37, 69, 0.2);
            padding: 22px;
            display: flex;
            flex-direction: column;
            min-height: 280px;
        }
        .top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }
        .sku {
            color: #8891A0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .heart-button {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            border: 1px solid #D6DAE0;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .heart-button svg {
            width: 18px;
            height: 18px;
        }
        .heart-button--active {
            border-color: #1657C4;
            background: #EEF4FF;
        }
        .heart-button--active path {
            fill: #1657C4;
            stroke: #1657C4;
        }
        .title {
            margin: 0 0 12px;
            font-size: 20px;
            line-height: 1.3;
        }
        .description {
            margin: 0 0 18px;
            color: #5B6470;
            font-size: 14px;
            line-height: 1.6;
        }
        .bottom {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .price {
            font-size: 24px;
            font-weight: 700;
            color: #0B2545;
        }
        .chip {
            min-height: 42px;
            padding: 0 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #D6DAE0;
            color: #14161A;
            background: #fff;
        }
        @media (max-width: 1180px) {
            .topbar__inner,
            .navbar {
                flex-wrap: wrap;
                padding-top: 12px;
                padding-bottom: 12px;
            }
            .navbar-search {
                order: 3;
                flex-basis: 100%;
            }
        }
        @media (max-width: 860px) {
            .topnav,
            .socials {
                display: none;
            }
            .navbar__actions {
                width: 100%;
                justify-content: space-between;
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
                    <a href="#" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#5B6470" stroke-width="1.6"></path><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#5B6470"></path></svg>
                    </a>
                    <a href="#" aria-label="Telegram">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"></path></svg>
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
                <a href="{{ route('favorites.index') }}" class="nav-link nav-link--active">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"></path></svg>
                    Избранное
                    @if (count($favoriteProductIds) > 0)
                        <span class="favorite-count">{{ count($favoriteProductIds) }}</span>
                    @endif
                </a>

                <a href="#cart" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="10" cy="20.5" r="1.4" fill="#1657C4"></circle><circle cx="17" cy="20.5" r="1.4" fill="#1657C4"></circle></svg>
                    Корзина
                </a>

                @auth
                    <a href="{{ route('account') }}" class="nav-link">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"></circle><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"></path></svg>
                        Личный кабинет
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

    <div class="shell">
        <section class="hero">
            <h1>Каталог инструмента</h1>
            <p>Добавляйте товары в избранное по нажатию на иконку сердца. Функция работает и для гостей: товар сохранится на сессию и после входа будет перенесён в избранное пользователя.</p>
        </section>

        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        @if ($categories->isNotEmpty())
            <section class="categories">
                <h2>Категории</h2>
                <div class="category-list">
                    @foreach ($categories as $category)
                        <div class="category-pill">
                            <span>{{ $category->name }}</span>
                            <span class="category-count">{{ $category->products_count }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="grid">
            @foreach ($products as $product)
                <article class="card">
                    <div class="top">
                        <div>
                            <div class="sku">{{ $product->sku }}</div>
                            @if ($product->category)
                                <div class="sku" style="margin-top: 8px;">{{ $product->category->name }}</div>
                            @endif
                        </div>
                        <form action="{{ route('favorites.toggle', $product) }}" method="post">
                            @csrf
                            @php($isFavorite = in_array($product->id, $favoriteProductIds, true))
                            <button type="submit" class="heart-button {{ $isFavorite ? 'heart-button--active' : '' }}" aria-label="{{ $isFavorite ? 'Убрать из избранного' : 'Добавить в избранное' }}">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <h2 class="title">{{ $product->name }}</h2>
                    <p class="description">{{ $product->description }}</p>

                    <div class="bottom">
                        <div class="price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
                        <a href="{{ route('favorites.index') }}" class="chip">Открыть избранное</a>
                    </div>
                </article>
            @endforeach
        </section>
    </div>
</body>
</html>
