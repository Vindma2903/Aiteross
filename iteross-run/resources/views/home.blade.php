<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg: #f3f5f8;
            --panel: #ffffff;
            --panel-strong: #0b2545;
            --text: #14161a;
            --muted: #5b6470;
            --line: #dde3ea;
            --blue: #1657c4;
            --blue-dark: #123f94;
            --accent: #f0f5ff;
            --shadow: 0 28px 60px -34px rgba(11, 37, 69, 0.28);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(22, 87, 196, 0.08), transparent 32%),
                linear-gradient(180deg, #f8fafc 0%, var(--bg) 100%);
        }

        a { color: inherit; }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(221, 227, 234, 0.9);
        }

        .header-inner,
        .shell,
        .footer-inner {
            width: min(1240px, calc(100% - 32px));
            margin: 0 auto;
        }

        .header-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .brand {
            text-decoration: none;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--panel-strong);
            white-space: nowrap;
        }

        .brand-mark {
            color: var(--blue);
        }

        .catalog-link,
        .action-link,
        .hero-primary,
        .hero-secondary,
        .lead-form button,
        .work-card {
            transition: 0.18s ease;
        }

        .catalog-link,
        .hero-primary,
        .lead-form button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 22px;
            border-radius: 999px;
            border: 0;
            background: var(--blue);
            color: #fff;
            font: inherit;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .catalog-link:hover,
        .hero-primary:hover,
        .lead-form button:hover {
            background: var(--blue-dark);
        }

        .header-spacer {
            flex: 1;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--text);
            font-size: 14px;
            font-weight: 500;
        }

        .action-link:hover {
            color: var(--blue);
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
            padding: 34px 0 56px;
        }

        .hero {
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(11, 37, 69, 0.96), rgba(22, 87, 196, 0.92)),
                #0b2545;
            color: #fff;
            border-radius: 28px;
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: auto -120px -160px auto;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.18), transparent 68%);
        }

        .hero-grid {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.8fr);
            gap: 28px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 34px;
            padding: 0 14px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.94);
            font-size: 13px;
            font-weight: 600;
        }

        .hero h1 {
            margin: 0 0 16px;
            max-width: 760px;
            font-size: clamp(34px, 5vw, 56px);
            line-height: 1.02;
        }

        .hero p {
            margin: 0;
            max-width: 720px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .hero-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 22px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.26);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .hero-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-panel {
            align-self: stretch;
            padding: 24px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .hero-panel h2 {
            margin: 0 0 12px;
            font-size: 18px;
        }

        .hero-points {
            display: grid;
            gap: 14px;
        }

        .hero-point {
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-point strong {
            display: block;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .hero-point span {
            color: rgba(255, 255, 255, 0.72);
            font-size: 14px;
            line-height: 1.5;
        }

        .section {
            margin-top: 26px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .section-header {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
        }

        .section-header h2 {
            margin: 0 0 8px;
            font-size: 30px;
            color: var(--panel-strong);
        }

        .section-header p {
            margin: 0;
            max-width: 720px;
            color: var(--muted);
            line-height: 1.6;
        }

        .work-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 18px;
        }

        .work-card {
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-height: 220px;
            padding: 24px;
            border-radius: 22px;
            border: 1px solid #d9e1eb;
            background:
                linear-gradient(180deg, #ffffff 0%, #f7fafe 100%);
            text-decoration: none;
            box-shadow: 0 20px 42px -34px rgba(11, 37, 69, 0.24);
        }

        .work-card:hover {
            transform: translateY(-3px);
            border-color: #b8cbef;
            box-shadow: 0 24px 52px -34px rgba(22, 87, 196, 0.3);
        }

        .work-card__top {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 12px;
        }

        .work-card__icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: var(--accent);
            color: var(--blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
        }

        .work-card__count {
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            background: #edf3ff;
            color: var(--blue);
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
        }

        .work-card h3 {
            margin: 0;
            font-size: 20px;
            line-height: 1.25;
            color: var(--panel-strong);
        }

        .work-card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.65;
        }

        .work-card__footer {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--blue);
            font-size: 14px;
            font-weight: 700;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }

        .info-card {
            padding: 22px;
            border-radius: 20px;
            background: #f7f9fc;
            border: 1px solid #e3e8ef;
        }

        .info-card strong {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: var(--panel-strong);
        }

        .info-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .lead-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(320px, 420px);
            gap: 22px;
            align-items: start;
        }

        .lead-note {
            color: var(--muted);
            line-height: 1.7;
        }

        .lead-form {
            display: grid;
            gap: 12px;
            padding: 22px;
            border-radius: 20px;
            background: #f7f9fc;
            border: 1px solid #e3e8ef;
        }

        .lead-form input,
        .lead-form textarea {
            width: 100%;
            border: 1px solid #d3dbe6;
            border-radius: 14px;
            padding: 14px 16px;
            font: inherit;
            color: var(--text);
            background: #fff;
        }

        .lead-form textarea {
            min-height: 110px;
            resize: vertical;
        }

        .lead-form small {
            color: var(--muted);
            line-height: 1.5;
        }

        .footer {
            padding: 0 0 40px;
        }

        .footer-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            color: var(--muted);
            font-size: 14px;
        }

        .footer-contacts {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .empty-state {
            padding: 30px;
            border-radius: 22px;
            border: 1px dashed #c9d6e7;
            background: #f8fbff;
            color: var(--muted);
            line-height: 1.7;
        }

        @media (max-width: 980px) {
            .hero-grid,
            .lead-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .header-inner {
                flex-wrap: wrap;
                padding: 14px 0;
            }

            .header-spacer {
                display: none;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .hero,
            .section {
                padding: 22px;
            }

            .section-header {
                align-items: start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="/" class="brand"><span class="brand-mark">АЙ</span>ТЕРОСС</a>
            <a href="{{ route('catalog.index') }}" class="catalog-link">Каталог</a>
            <div class="header-spacer"></div>
            <div class="header-actions">
                <a href="{{ route('favorites.index') }}" class="action-link">
                    Избранное
                    @if ($favoriteCount > 0)
                        <span class="favorite-count">{{ $favoriteCount }}</span>
                    @endif
                </a>
                @auth
                    <a href="{{ route('account') }}" class="action-link">Личный кабинет</a>
                @else
                    <a href="{{ route('login') }}" class="action-link">Войти</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="shell">
        <section class="hero">
            <div class="hero-grid">
                <div>
                    <div class="hero-kicker">Поставка инструмента и оснастки для производства</div>
                    <h1>Подбирайте инструмент по виду работ, а не по статичным страницам.</h1>
                    <p>
                        Главная страница теперь работает через Laravel и данные из базы. В блоке
                        «Виды производимых работ» каждая карточка ведет сразу в каталог с выбранной
                        категорией, чтобы в хлебных крошках отображался корректный путь.
                    </p>
                    <div class="hero-actions">
                        <a href="#work-types" class="hero-primary">Выбрать вид работ</a>
                        <a href="{{ route('catalog.index') }}" class="hero-secondary">Открыть весь каталог</a>
                    </div>
                </div>

                <aside class="hero-panel">
                    <h2>Что изменено</h2>
                    <div class="hero-points">
                        <div class="hero-point">
                            <strong>Один маршрут перехода</strong>
                            <span>Карточки ведут только на `/catalog?category=slug`, без старых `.html` ссылок.</span>
                        </div>
                        <div class="hero-point">
                            <strong>Категории из базы</strong>
                            <span>Состав блока определяется данными каталога, а не захардкоженным HTML.</span>
                        </div>
                        <div class="hero-point">
                            <strong>Корректные хлебные крошки</strong>
                            <span>После перехода выбранный вид работ отображается на странице каталога.</span>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section class="section" id="work-types">
            <div class="section-header">
                <div>
                    <h2>Виды производимых работ</h2>
                    <p>Выберите направление обработки, чтобы открыть каталог сразу с нужной категорией.</p>
                </div>
            </div>

            @if ($categories->isNotEmpty())
                <div class="work-grid">
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('catalog.index', ['categorySlug' => $category->slug]) }}"
                            class="work-card"
                        >
                            <div class="work-card__top">
                                <span class="work-card__icon">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="work-card__count">{{ $category->products_count }} поз.</span>
                            </div>
                            <div>
                                <h3>{{ $category->name }}</h3>
                                <p>
                                    Открыть каталог по категории и показать в хлебных крошках выбранный
                                    вид производимых работ.
                                </p>
                            </div>
                            <span class="work-card__footer">Перейти в каталог →</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    Категории пока не заполнены в базе данных. После добавления категорий этот блок
                    автоматически соберется из БД.
                </div>
            @endif
        </section>

        <section class="section" id="about">
            <div class="section-header">
                <div>
                    <h2>Почему такой сценарий лучше</h2>
                    <p>Статическая главная больше не ломает навигацию и не уводит пользователя на несуществующие `.html` страницы.</p>
                </div>
            </div>
            <div class="info-grid">
                <article class="info-card">
                    <strong>Единая точка входа</strong>
                    <p>Вместо нескольких вариантов перехода используется один Laravel-маршрут каталога.</p>
                </article>
                <article class="info-card">
                    <strong>Управление из админки</strong>
                    <p>Если категории меняются в БД, главная автоматически показывает актуальный список.</p>
                </article>
                <article class="info-card">
                    <strong>Предсказуемая SEO-структура</strong>
                    <p>Каталог и хлебные крошки формируются на сервере, без ссылок на legacy-экспорт.</p>
                </article>
            </div>
        </section>

        <section class="section" id="lead-form-section">
            <div class="section-header">
                <div>
                    <h2>Запрос на подбор</h2>
                    <p>Оставьте контакт и описание задачи, если нужно подобрать инструмент под технологическую операцию.</p>
                </div>
            </div>
            <div class="lead-grid">
                <div class="lead-note">
                    Мы работаем с производственными предприятиями и помогаем подобрать инструмент под
                    конкретный материал, станок и тип обработки. Если категории в каталоге недостаточно,
                    можно описать задачу в свободной форме.
                </div>
                <form class="lead-form">
                    <input type="text" placeholder="Ваше имя">
                    <input type="tel" placeholder="Телефон">
                    <textarea placeholder="Какая операция или инструмент вас интересует"></textarea>
                    <button type="button">Отправить заявку</button>
                    <small>Форма показана как интерфейсный блок. Если нужно, можно подключить реальную отправку отдельной задачей.</small>
                </form>
            </div>
        </section>
    </main>

    <footer class="footer" id="footer">
        <div class="footer-inner">
            <div>© 2026 АЙТЕРОСС</div>
            <div class="footer-contacts">
                <span>+7 (495) 123-45-67</span>
                <span>info@iteross.ru</span>
                <span>Москва</span>
            </div>
        </div>
    </footer>
</body>
</html>
