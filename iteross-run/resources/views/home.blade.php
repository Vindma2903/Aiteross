<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ data_get($page, 'hero.title', 'АЙТЕРОСС') }}</title>
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
            --soft: #eef4ff;
            --shadow: 0 24px 54px -34px rgba(11, 37, 69, 0.28);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(22, 87, 196, 0.08), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, var(--bg) 100%);
        }

        a { color: inherit; }

        .container,
        .topbar-inner,
        .header-inner,
        .footer-inner {
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

        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .topbar-nav a,
        .topbar-contact a,
        .header-link,
        .footer-column a {
            text-decoration: none;
        }

        .topbar-contact {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .socials {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .social-chip {
            height: 34px;
            min-width: 34px;
            padding: 0 12px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #f7f9fc;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--navy);
            text-decoration: none;
        }

        .callback-button,
        .catalog-button,
        .hero-button,
        .lead-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 20px;
            border-radius: 999px;
            border: 0;
            background: var(--blue);
            color: #fff;
            font: inherit;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: 0.18s ease;
        }

        .callback-button {
            min-height: 40px;
            background: #fff;
            color: var(--text);
            border: 1px solid var(--line);
            font-size: 13px;
            font-weight: 700;
        }

        .callback-button:hover,
        .catalog-button:hover,
        .hero-button:hover,
        .lead-submit:hover {
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
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--navy);
            white-space: nowrap;
        }

        .header-spacer { flex: 1; }

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

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-link {
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .header-count {
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

        main { padding: 24px 0 56px; }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(340px, 0.8fr);
            gap: 0;
            overflow: hidden;
            border-radius: 30px;
            box-shadow: var(--shadow);
            background: var(--panel);
        }

        .hero-copy {
            padding: 44px;
            background:
                linear-gradient(135deg, rgba(11, 37, 69, 0.98), rgba(22, 87, 196, 0.92)),
                #0b2545;
            color: #fff;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.94);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .hero-copy h1 {
            margin: 0 0 16px;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.02;
        }

        .hero-copy p {
            margin: 0;
            max-width: 720px;
            color: rgba(255, 255, 255, 0.82);
            font-size: 16px;
            line-height: 1.75;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .hero-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 20px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .hero-visual {
            position: relative;
            min-height: 420px;
            background: #d9dee6 center/cover no-repeat;
        }

        .hero-visual::after {
            content: "Фото: сменные пластины крупным планом";
            position: absolute;
            left: 24px;
            bottom: 24px;
            padding: 10px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.84);
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
        }

        .benefits {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .benefit-card,
        .section,
        .faq-item,
        .lead-panel {
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .benefit-card {
            min-height: 118px;
            padding: 20px;
            border-radius: 22px;
        }

        .benefit-title {
            margin-top: 14px;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.45;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: var(--soft);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .section {
            margin-top: 26px;
            padding: 30px;
            border-radius: 24px;
        }

        .section-header {
            margin-bottom: 24px;
        }

        .section-header h2 {
            margin: 0 0 10px;
            font-size: 32px;
            color: var(--navy);
        }

        .section-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            max-width: 760px;
        }

        .advantages-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .advantage-card h3,
        .work-card h3,
        .about-stat-value {
            color: var(--navy);
        }

        .advantage-card {
            padding: 18px 14px;
            border-radius: 20px;
        }

        .advantage-card h3 {
            margin: 0 0 8px;
            font-size: 19px;
            line-height: 1.3;
        }

        .advantage-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.65;
        }

        .work-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .work-card {
            display: block;
            overflow: hidden;
            border-radius: 22px;
            border: 1px solid var(--line);
            background: #fff;
            text-decoration: none;
            box-shadow: 0 20px 42px -34px rgba(11, 37, 69, 0.24);
            transition: 0.18s ease;
        }

        .work-card:hover {
            transform: translateY(-3px);
            border-color: #b8cbef;
            box-shadow: 0 24px 52px -34px rgba(22, 87, 196, 0.3);
        }

        .work-card img,
        .work-card-media,
        .about-image {
            width: 100%;
            display: block;
            object-fit: cover;
        }

        .work-card-media {
            aspect-ratio: 16 / 10;
            background: #dce2ea center/cover no-repeat;
        }

        .work-card-body {
            padding: 18px 18px 20px;
        }

        .work-card h3 {
            margin: 0 0 8px;
            font-size: 20px;
            line-height: 1.25;
        }

        .work-card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.65;
        }

        .about {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 0.86fr);
            gap: 28px;
            align-items: center;
        }

        .about p {
            margin: 0 0 12px;
            color: var(--muted);
            line-height: 1.75;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 20px;
        }

        .about-stat {
            padding: 18px 16px;
            border-radius: 18px;
            background: #f7f9fc;
            border: 1px solid #e3e8ef;
        }

        .about-stat-value {
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
        }

        .about-stat-label {
            margin-top: 8px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .about-image {
            min-height: 360px;
            border-radius: 24px;
            background: #d9dee6 center/cover no-repeat;
        }

        .faq-list {
            display: grid;
            gap: 12px;
        }

        .faq-item {
            overflow: hidden;
            border-radius: 18px;
        }

        .faq-question {
            width: 100%;
            padding: 20px 22px;
            border: 0;
            background: transparent;
            text-align: left;
            font: inherit;
            font-size: 17px;
            font-weight: 600;
            color: var(--navy);
            cursor: pointer;
        }

        .faq-answer {
            padding: 0 22px 20px;
            color: var(--muted);
            line-height: 1.7;
        }

        .lead {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 480px);
            gap: 22px;
        }

        .lead-panel {
            padding: 26px;
            border-radius: 24px;
        }

        .lead-panel h2 {
            margin: 0 0 18px;
            font-size: 32px;
            color: var(--navy);
        }

        .lead-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .lead-label {
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .lead-form {
            display: grid;
            gap: 14px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid #d3dbe6;
            background: #fff;
            font: inherit;
            color: var(--text);
        }

        .field textarea {
            min-height: 120px;
            resize: vertical;
        }

        .attach-box {
            padding: 16px;
            border: 1px dashed #c8d3e1;
            border-radius: 16px;
            background: #f7f9fc;
            color: var(--muted);
            font-size: 14px;
        }

        .site-footer {
            padding: 0 0 40px;
        }

        .footer-inner {
            margin-top: 26px;
            padding: 30px;
            border-radius: 24px;
            background: var(--navy);
            color: rgba(255, 255, 255, 0.84);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.8fr 0.8fr 0.8fr;
            gap: 22px;
        }

        .footer-title {
            margin-bottom: 14px;
            color: rgba(255, 255, 255, 0.62);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .footer-brand {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.04em;
        }

        .footer-column {
            display: grid;
            gap: 10px;
        }

        .footer-bottom {
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 14px;
        }

        @media (max-width: 1180px) {
            .benefits,
            .advantages-grid,
            .work-grid,
            .about-stats,
            .footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero,
            .about,
            .lead {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 860px) {
            .topbar-inner,
            .header-inner {
                padding: 14px 0;
                flex-direction: column;
                align-items: stretch;
            }

            .topbar-contact {
                margin-left: 0;
                flex-wrap: wrap;
            }

            .header-spacer,
            .header-search {
                max-width: none;
                flex: initial;
            }

            .hero-copy,
            .section,
            .lead-panel,
            .footer-inner {
                padding: 22px;
            }

            .benefits,
            .advantages-grid,
            .work-grid,
            .about-stats,
            .lead-meta,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero-visual {
                min-height: 300px;
            }
        }
    </style>
</head>
<body>
@php
    $hero = data_get($page, 'hero', []);
    $heroBenefits = data_get($page, 'hero_benefits', []);
    $advantages = data_get($page, 'advantages', []);
    $workTypes = data_get($page, 'work_types', []);
    $workTypeItems = data_get($workTypes, 'items', []);
    $about = data_get($page, 'about', []);
    $faq = data_get($page, 'faq', []);
    $heroImage = asset('home-media/hero.jpg');
    $aboutImage = asset('home-media/about.jpg');
    $workImages = [
        'tokarnye-plastiny' => asset('home-media/hero.jpg'),
        'frezernye-plastiny' => asset('home-media/work-b.jpg'),
        'kanavochnye-plastiny' => asset('home-media/work-c.jpg'),
        'rezbovye-plastiny' => asset('home-media/hero.jpg'),
        'sverlilnye-plastiny' => asset('home-media/work-b.jpg'),
        'obrabotka-nerzhaveyuschih-i-zharoprochnyh-staley' => asset('home-media/work-c.jpg'),
    ];

    $navItems = [
        ['label' => 'О компании', 'href' => '/#about'],
        ['label' => 'Условия покупки', 'href' => '/#about'],
        ['label' => 'Контакты', 'href' => '/#footer'],
    ];

    $footerNavItems = [
        ['label' => 'О компании', 'href' => '/#about'],
        ['label' => 'Доставка', 'href' => '/#about'],
        ['label' => 'Контакты', 'href' => '/#footer'],
    ];

    $headerIcons = [
        'layers' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="6" y="3" width="13" height="13" rx="2" stroke="#1657C4" stroke-width="1.5"/><path d="M3 8v11a2 2 0 0 0 2 2h11" stroke="#1657C4" stroke-width="1.5" stroke-linecap="round"/></svg>',
        'tag' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 11.5V5a2 2 0 0 1 2-2h6.5L21 11.5a2 2 0 0 1 0 2.8l-6.7 6.7a2 2 0 0 1-2.8 0L3 12.8Z" stroke="#1657C4" stroke-width="1.5"/><circle cx="8" cy="8" r="1.4" fill="#1657C4"/></svg>',
        'store' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 21V11M20 21V11M2 11l2.5-7h15L22 11M2 11h20M8 21v-5h8v5" stroke="#1657C4" stroke-width="1.4" stroke-linejoin="round"/><path d="M12 4v3" stroke="#1657C4" stroke-width="1.4"/></svg>',
        'box' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 3 L21 8 V16 L12 21 L3 16 V8 Z" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/><path d="M3 8l9 5 9-5M12 13v8" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/></svg>',
        'gear' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3.2" stroke="#1657C4" stroke-width="1.5"/><path d="M12 3v2.2M12 18.8V21M21 12h-2.2M5.2 12H3M18.4 5.6l-1.6 1.6M7.2 16.8l-1.6 1.6M18.4 18.4l-1.6-1.6M7.2 7.2 5.6 5.6" stroke="#1657C4" stroke-width="1.5" stroke-linecap="round"/></svg>',
    ];
@endphp

<div class="topbar">
    <div class="topbar-inner">
        <nav class="topbar-nav">
            @foreach ($navItems as $item)
                <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
            @endforeach
        </nav>
        <div class="topbar-contact">
            <a href="tel:+74951234567">+7 (495) 123-45-67</a>
            <a href="mailto:info@iteross.ru">info@iteross.ru</a>
            <div class="socials">
                <a href="#" class="social-chip">WhatsApp</a>
                <a href="#" class="social-chip">Telegram</a>
            </div>
            <a href="#lead-form-section" class="callback-button">Заказать обратный звонок</a>
        </div>
    </div>
</div>

<header class="site-header">
    <div class="header-inner">
        <a href="{{ url('/') }}" class="brand">АЙТЕРОСС</a>
        <a href="{{ route('catalog.index') }}" class="catalog-button">Каталог</a>
        <div class="header-search">
            <input type="text" placeholder="Поиск товаров..." aria-label="Поиск товаров">
            <span>Найти</span>
        </div>
        <div class="header-spacer"></div>
        <div class="header-actions">
            <a href="{{ route('favorites.index') }}" class="header-link">
                Избранное
                @if ($favoriteCount > 0)
                    <span class="header-count">{{ $favoriteCount }}</span>
                @endif
            </a>
            <a href="#cart" class="header-link">Корзина</a>
            @auth
                <a href="{{ $accountUrl }}" class="header-link">{{ $accountLabel }}</a>
            @else
                <a href="{{ route('login') }}" class="header-link">Войти</a>
            @endauth
        </div>
    </div>
</header>

<main>
    <div class="container">
        <section class="hero">
            <div class="hero-copy">
                <div class="hero-kicker">Официальный производитель твердосплавного инструмента</div>
                <h1>{{ $hero['title'] ?? '' }}</h1>
                <p>{{ $hero['description'] ?? '' }}</p>
                <div class="hero-actions">
                    <a href="#lead-form-section" class="hero-button">{{ $hero['cta_text'] ?? 'Получить предложение' }}</a>
                    <a href="{{ route('catalog.index') }}" class="hero-link">Смотреть каталог</a>
                </div>
            </div>
            <div class="hero-visual" style="background-image: url('{{ $heroImage }}');"></div>
        </section>

        <section class="benefits">
            @foreach ($heroBenefits as $item)
                <article class="benefit-card">
                    <div class="icon-box">{!! $headerIcons[$item['icon'] ?? 'layers'] ?? $headerIcons['layers'] !!}</div>
                    <div class="benefit-title">{{ $item['text'] ?? '' }}</div>
                </article>
            @endforeach
        </section>

        <section class="section">
            <div class="section-header">
                <h2>Почему выбирают «Айтеросс»</h2>
                <p>{{ $advantages['description'] ?? '' }}</p>
            </div>
            <div class="advantages-grid">
                @foreach (($advantages['items'] ?? []) as $item)
                    <article class="advantage-card">
                        <h3>{{ $item['title'] ?? '' }}</h3>
                        <p>{{ $item['text'] ?? '' }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <h2>{{ $workTypes['title'] ?? 'Виды производимых работ' }}</h2>
                <p>{{ $workTypes['description'] ?? '' }}</p>
            </div>
            <div class="work-grid">
                @foreach ($categories as $category)
                    @php
                        $meta = $workTypeItems[$category->slug] ?? [];
                        $workImage = $workImages[$category->slug] ?? asset('home-media/work-b.jpg');
                    @endphp
                    <a href="{{ route('catalog.index', ['categorySlug' => $category->slug]) }}" class="work-card">
                        <div class="work-card-media" style="background-image: url('{{ $workImage }}');"></div>
                        <div class="work-card-body">
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $meta['description'] ?? $category->name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section" id="about">
            <div class="about">
                <div>
                    <div class="section-header">
                        <h2>{{ $about['title'] ?? 'О компании' }}</h2>
                    </div>
                    <p>{{ $about['description'] ?? '' }}</p>
                    <p>{{ $about['text'] ?? '' }}</p>
                    <div class="about-stats">
                        @foreach (($about['stats'] ?? []) as $item)
                            <div class="about-stat">
                                <div class="about-stat-value">{{ $item['value'] ?? '' }}</div>
                                <div class="about-stat-label">{{ $item['label'] ?? '' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="about-image" style="background-image: url('{{ $aboutImage }}');"></div>
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <h2>{{ $faq['title'] ?? 'Частые вопросы' }}</h2>
            </div>
            <div class="faq-list">
                @foreach (($faq['items'] ?? []) as $index => $item)
                    <details class="faq-item" {{ $index === 0 ? 'open' : '' }}>
                        <summary class="faq-question">{{ $item['question'] ?? '' }}</summary>
                        <div class="faq-answer">{{ $item['answer'] ?? '' }}</div>
                    </details>
                @endforeach
            </div>
        </section>

        <section class="section" id="lead-form-section">
            <div class="lead">
                <div class="lead-panel">
                    <h2>Отправьте заявку на коммерческое предложение</h2>
                    <div class="lead-meta">
                        <div>
                            <div class="lead-label">Телефон</div>
                            <div><a href="tel:+74951234567" style="text-decoration: none;">+7 (495) 123-45-67</a></div>
                            <div style="margin-top: 6px; color: var(--muted);">Пн-Пт: 9:00 - 18:00 (МСК)</div>
                        </div>
                        <div>
                            <div class="lead-label">Email</div>
                            <div><a href="mailto:info@iteross.ru" style="text-decoration: none;">info@iteross.ru</a></div>
                            <div style="margin-top: 6px; color: var(--muted);">Ответ в течение рабочего дня</div>
                        </div>
                        <div>
                            <div class="lead-label">Адрес</div>
                            <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                        </div>
                        <div>
                            <div class="lead-label">Реквизиты</div>
                            <div>ООО «АЙТЕРОСС»</div>
                            <div style="margin-top: 6px; color: var(--muted);">ИНН 7700000000 · ОГРН 1157700000000</div>
                        </div>
                    </div>
                </div>
                <div class="lead-panel">
                    <form class="lead-form">
                        <div class="field">
                            <label>Имя и компания</label>
                            <input type="text" placeholder="Иван Иванов, ООО «Компания»">
                        </div>
                        <div class="field">
                            <label>Телефон</label>
                            <input type="tel" placeholder="+7 (___) ___-__-__">
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <input type="email" placeholder="you@company.ru">
                        </div>
                        <div class="field">
                            <label>Описание задачи</label>
                            <textarea placeholder="Артикул, аналог, объём партии, срок поставки..."></textarea>
                        </div>
                        <div class="attach-box">
                            <strong>Прикрепите файл</strong><br>
                            PDF, DOC, JPG — до 20 МБ
                        </div>
                        <button type="button" class="lead-submit">Получить предложение</button>
                        <p style="margin: 0; color: var(--muted); font-size: 14px;">Нажимая кнопку, вы соглашаетесь на обработку персональных данных</p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<footer class="site-footer" id="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">АЙТЕРОСС</div>
                <p style="margin: 0; line-height: 1.7;">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                <div style="display: flex; gap: 10px; margin-top: 16px;">
                    <a href="#" class="social-chip">Telegram</a>
                    <a href="#" class="social-chip">WhatsApp</a>
                    <a href="#" class="social-chip">VK</a>
                </div>
            </div>
            <div>
                <div class="footer-title">Навигация</div>
                <div class="footer-column">
                    @foreach ($footerNavItems as $item)
                        <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="footer-title">Контакты</div>
                <div class="footer-column">
                    <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                    <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                    <span>г. Москва, Дербеневская ул., 12, стр. 3</span>
                    <span>Пн-Пт, 9:00-18:00</span>
                </div>
            </div>
            <div>
                <div class="footer-title">Реквизиты</div>
                <div class="footer-column">
                    <span>ООО «АЙТЕРОСС»</span>
                    <span>ИНН 7700000000</span>
                    <span>ОГРН 1157700000000</span>
                    <span>КПП 770001001</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">© 2026 ООО «АЙТЕРОСС». Все права защищены.</div>
    </div>
</footer>
</body>
</html>
