<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ data_get($page, 'hero.title', 'АЙТЕРОСС') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Sans+Condensed:wght@600;700&display=swap');

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
        ::selection { background: #0B2545; color: #fff; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-shell {
            min-height: 100vh;
            width: 100%;
            background: #FFFFFF;
        }
        .container {
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
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
        .footer-nav a,
        .footer-contact a,
        .social-circle,
        .hero-secondary,
        .work-card,
        .header-link,
        .section-link {
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
        .footer-nav a:hover,
        .footer-contact a:hover,
        .section-link:hover {
            color: #0B2545;
        }
        .topbar-spacer {
            flex: 1;
        }
        .topbar-phone {
            color: #14161A;
            font-size: 14.5px;
            font-weight: 600;
            white-space: nowrap;
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
        .social-circle:hover {
            background: #E3E6EA;
        }
        .callback-button,
        .catalog-button,
        .hero-primary,
        .lead-submit,
        .cookie-button {
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease, transform 0.15s ease;
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
        .hero-primary:hover,
        .lead-submit:hover {
            background: #123F94;
        }
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
        .search-submit:hover {
            background: #123F94;
        }
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
        .header-count {
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
        .hero {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .hero-surface {
            position: relative;
            min-height: 560px;
            background: linear-gradient(115deg, #0B2545 0%, #123A63 55%, #1B4A7A 100%);
        }
        .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.55;
            mix-blend-mode: luminosity;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(11,37,69,0.94) 0%, rgba(11,37,69,0.82) 38%, rgba(11,37,69,0.35) 68%, rgba(11,37,69,0.1) 100%);
        }
        .hero-inner {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: center;
            padding-top: 88px;
            padding-bottom: 88px;
        }
        .hero-copy {
            max-width: 620px;
            animation: fadeUp 0.5s ease;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            color: #fff;
            padding: 7px 14px;
            border-radius: 100px;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 22px;
        }
        .hero-title {
            margin: 0 0 20px;
            color: #fff;
            font-size: 50px;
            line-height: 1.12;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .hero-text {
            margin: 0 0 32px;
            max-width: 540px;
            color: rgba(255,255,255,0.82);
            font-size: 18px;
            line-height: 1.6;
        }
        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        .hero-primary,
        .hero-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 58px;
            padding: 0 32px;
            border-radius: 10px;
            font-size: 17px;
            font-weight: 600;
            white-space: nowrap;
        }
        .hero-primary {
            background: #1657C4;
            color: #fff;
        }
        .hero-secondary {
            padding-left: 26px;
            padding-right: 26px;
            border: 1.5px solid rgba(255,255,255,0.4);
            color: #fff;
            transition: border-color 0.15s ease;
        }
        .hero-secondary:hover {
            border-color: #fff;
        }
        .hero-photo-note {
            position: absolute;
            right: 32px;
            bottom: 18px;
            color: rgba(255,255,255,0.4);
            font-size: 12.5px;
        }
        .benefits {
            border-bottom: 1px solid #E3E6EA;
            background: #FFFFFF;
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 28px;
            padding-top: 48px;
            padding-bottom: 48px;
        }
        .benefit-card {
            background: #EEF1FA;
            border-radius: 16px;
            padding: 24px 22px;
            aspect-ratio: 4 / 3.4;
            display: flex;
            flex-direction: column;
        }
        .benefit-icon {
            height: 40px;
            display: flex;
            align-items: flex-start;
            margin-bottom: 40px;
            flex: none;
        }
        .benefit-text {
            color: #14161A;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 600;
        }
        .section {
            border-bottom: 1px solid #E3E6EA;
            background: #FFFFFF;
        }
        .section-inner {
            padding-top: 56px;
            padding-bottom: 64px;
        }
        .section-title {
            margin: 0 0 28px;
            color: #14161A;
            font-size: 28px;
            font-weight: 700;
        }
        .catalog-grid,
        .advantage-grid,
        .faq-grid,
        .footer-grid {
            display: grid;
            gap: 24px;
        }
        .catalog-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-top: 40px;
        }
        .types-header {
            max-width: 640px;
            margin-bottom: 16px;
        }
        .types-title {
            margin: 0 0 14px;
            font-size: 36px;
            font-weight: 700;
            color: #14161A;
            letter-spacing: -0.3px;
        }
        .types-divider {
            width: 64px;
            height: 3px;
            background: #1657C4;
            margin-bottom: 18px;
        }
        .types-text {
            margin: 0;
            font-size: 17px;
            color: #4B535E;
            line-height: 1.6;
        }
        .work-card {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.15s ease, transform 0.15s ease;
        }
        .work-card:hover {
            box-shadow: 0 16px 32px -16px rgba(11,37,69,0.2);
            transform: translateY(-2px);
        }
        .work-card-media {
            aspect-ratio: 16 / 10;
            background: #EEF0F2;
            overflow: hidden;
        }
        .work-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .work-card-body {
            padding: 24px 26px 28px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .work-card-title {
            color: #14161A;
            font-size: 18px;
            line-height: 1.35;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            margin: 0 0 10px;
        }
        .work-card-text {
            margin: 0;
            color: #6B7480;
            font-size: 14.5px;
            line-height: 1.55;
            flex: 1;
        }
        .advantage-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .advantage-card {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 16px;
            padding: 28px 24px;
        }
        .advantage-icon {
            width: 44px;
            height: 44px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .advantage-card h3 {
            margin: 0 0 10px;
            color: #14161A;
            font-size: 18px;
            line-height: 1.35;
            font-weight: 700;
        }
        .advantage-card p {
            margin: 0;
            color: #5B6470;
            line-height: 1.7;
        }
        .about-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(360px, 0.85fr);
            gap: 32px;
            align-items: center;
        }
        .about-copy p {
            margin: 0 0 16px;
            color: #5B6470;
            line-height: 1.75;
        }
        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 28px;
        }
        .about-stat {
            background: #EEF1FA;
            border-radius: 16px;
            padding: 20px 18px;
        }
        .about-stat-value {
            color: #0B2545;
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
        }
        .about-stat-label {
            margin-top: 8px;
            color: #5B6470;
            font-size: 14px;
            line-height: 1.55;
        }
        .about-visual img {
            width: 100%;
            min-height: 420px;
            object-fit: cover;
            border-radius: 18px;
            display: block;
        }
        .faq-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .faq-item {
            border: 1px solid #E3E6EA;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
        }
        .faq-item summary {
            list-style: none;
            cursor: pointer;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            color: #14161A;
            font-size: 17px;
            line-height: 1.45;
            font-weight: 600;
        }
        .faq-item summary::-webkit-details-marker {
            display: none;
        }
        .faq-item summary::after {
            content: "+";
            color: #1657C4;
            font-size: 24px;
            line-height: 1;
            flex: none;
            transition: transform 0.15s ease;
        }
        .faq-item[open] summary::after {
            transform: rotate(45deg);
        }
        .faq-answer {
            padding: 0 24px 22px;
            color: #5B6470;
            line-height: 1.75;
        }
        .lead-section {
            background: #FFFFFF;
        }
        .lead-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.92fr) minmax(380px, 0.88fr);
            gap: 24px;
            padding-top: 56px;
            padding-bottom: 64px;
        }
        .lead-copy {
            background: #0B2545;
            color: #fff;
            border-radius: 18px;
            padding: 36px 32px;
        }
        .lead-copy h2 {
            margin: 0 0 18px;
            font-size: 30px;
            line-height: 1.2;
            font-weight: 700;
        }
        .lead-copy p {
            margin: 0 0 28px;
            color: rgba(255,255,255,0.78);
            line-height: 1.75;
        }
        .lead-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }
        .lead-meta-label {
            margin-bottom: 8px;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .lead-form-panel {
            background: #F7F9FC;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 30px;
        }
        .lead-form {
            display: grid;
            gap: 14px;
        }
        .field label {
            display: block;
            margin-bottom: 8px;
            color: #5B6470;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.4px;
        }
        .field input,
        .field textarea {
            width: 100%;
            border: 1.5px solid #D8DEE6;
            border-radius: 12px;
            background: #FFFFFF;
            padding: 14px 16px;
            font-size: 15px;
            font-family: inherit;
            color: #14161A;
            outline: none;
        }
        .field textarea {
            min-height: 118px;
            resize: vertical;
        }
        .field input:focus,
        .field textarea:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .file-box {
            border: 1.5px dashed #C9D3E0;
            border-radius: 12px;
            background: #FFFFFF;
            padding: 18px 16px;
            color: #5B6470;
            font-size: 14px;
            line-height: 1.6;
        }
        .lead-submit {
            min-height: 50px;
            border-radius: 10px;
            background: #1657C4;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }
        .lead-disclaimer {
            margin: 0;
            color: #5B6470;
            font-size: 14px;
            line-height: 1.6;
        }
        .site-footer {
            background: #0B2545;
            color: rgba(255,255,255,0.8);
        }
        .footer-top {
            padding-top: 48px;
            padding-bottom: 36px;
        }
        .footer-grid {
            grid-template-columns: 1.3fr 0.8fr 0.8fr 0.8fr;
            gap: 28px;
        }
        .footer-brand {
            color: #fff;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.4px;
            margin-bottom: 18px;
        }
        .footer-copy {
            margin: 0;
            color: rgba(255,255,255,0.72);
            line-height: 1.75;
        }
        .footer-socials {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
        }
        .footer-title {
            margin-bottom: 18px;
            color: rgba(255,255,255,0.45);
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .footer-nav,
        .footer-contact,
        .footer-legal-stack {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .footer-nav a,
        .footer-contact a {
            color: rgba(255,255,255,0.8);
            font-size: 15px;
            transition: color 0.15s ease;
        }
        .footer-contact,
        .footer-legal-stack {
            color: rgba(255,255,255,0.8);
            font-size: 15px;
            line-height: 1.7;
        }
        .footer-legal-stack {
            gap: 8px;
            color: rgba(255,255,255,0.6);
            font-size: 13.5px;
            line-height: 1.6;
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 24px;
            padding-bottom: 24px;
            color: rgba(255,255,255,0.4);
            font-size: 13px;
        }
        .cookie-banner {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 300;
            width: min(92vw, 560px);
            background: #1657C4;
            border-radius: 14px;
            box-shadow: 0 20px 48px -12px rgba(11,37,69,0.4);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .cookie-banner p {
            flex: 1;
            min-width: 220px;
            margin: 0;
            color: #fff;
            font-size: 14.5px;
            line-height: 1.5;
        }
        .cookie-banner a {
            color: #fff;
            text-decoration: underline;
        }
        .cookie-button {
            min-height: 44px;
            padding: 0 28px;
            border-radius: 9px;
            background: #14161A;
            color: #fff;
            font-size: 14.5px;
            font-weight: 700;
            white-space: nowrap;
        }
        .cookie-button:hover {
            background: #000000;
        }

        @media (max-width: 1400px) {
            .topbar-email { display: none; }
        }
        @media (max-width: 1260px) {
            .benefits-grid,
            .catalog-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .advantage-grid,
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .about-grid,
            .lead-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 980px) {
            .topbar-inner,
            .header-inner {
                padding-top: 14px;
                padding-bottom: 14px;
                flex-wrap: wrap;
            }
            .topbar-spacer {
                display: none;
            }
            .header-actions,
            .topbar-contact {
                flex-wrap: wrap;
            }
            .header-search {
                order: 10;
                width: 100%;
                flex-basis: 100%;
            }
            .hero-title {
                font-size: 40px;
            }
            .lead-meta,
            .about-stats {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 760px) {
            .container {
                padding-left: 16px;
                padding-right: 16px;
            }
            .topbar-inner,
            .header-inner {
                gap: 14px;
            }
            .benefits-grid,
            .catalog-grid,
            .advantage-grid,
            .about-stats,
            .lead-meta,
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .hero-inner,
            .section-inner,
            .lead-grid,
            .footer-top {
                padding-top: 32px;
                padding-bottom: 32px;
            }
            .hero-surface,
            .hero-inner {
                min-height: auto;
            }
            .hero-title {
                font-size: 34px;
                line-height: 1.15;
            }
            .hero-text {
                font-size: 16px;
            }
            .hero-primary,
            .hero-secondary {
                width: 100%;
            }
            .hero-photo-note {
                position: static;
                margin-top: 18px;
                padding-bottom: 24px;
                padding-left: 16px;
            }
            .lead-copy,
            .lead-form-panel {
                padding: 24px 20px;
            }
            .about-visual img {
                min-height: 280px;
            }
            .cookie-banner {
                right: 16px;
                bottom: 16px;
                left: 16px;
                width: auto;
                padding: 18px;
            }
        }
    </style>
</head>
<body>
@php
    $headerNav = data_get($page, 'header_nav', []);
    $hero = data_get($page, 'hero', []);
    $heroBenefits = data_get($page, 'hero_benefits', []);
    $advantages = data_get($page, 'advantages', []);
    $workTypes = data_get($page, 'work_types', []);
    $workTypeItems = data_get($workTypes, 'items', []);
    $about = data_get($page, 'about', []);
    $faq = data_get($page, 'faq', []);

    $footerNavItems = [
        ['label' => 'О компании', 'href' => url('/#about')],
        ['label' => 'Доставка', 'href' => route('delivery')],
        ['label' => 'Контакты', 'href' => url('/#footer')],
    ];

    $benefitIcons = [
        'layers' => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none"><rect x="6" y="3" width="13" height="13" rx="2" stroke="#1657C4" stroke-width="1.5"/><path d="M3 8v11a2 2 0 0 0 2 2h11" stroke="#1657C4" stroke-width="1.5" stroke-linecap="round"/></svg>',
        'tag' => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none"><path d="M3 11.5V5a2 2 0 0 1 2-2h6.5L21 11.5a2 2 0 0 1 0 2.8l-6.7 6.7a2 2 0 0 1-2.8 0L3 12.8Z" stroke="#1657C4" stroke-width="1.5"/><circle cx="8" cy="8" r="1.4" fill="#1657C4"/></svg>',
        'store' => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none"><path d="M4 21V11M20 21V11M2 11l2.5-7h15L22 11M2 11h20M8 21v-5h8v5" stroke="#1657C4" stroke-width="1.4" stroke-linejoin="round"/><path d="M12 4v3" stroke="#1657C4" stroke-width="1.4"/></svg>',
        'box' => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none"><path d="M12 3 L21 8 V16 L12 21 L3 16 V8 Z" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/><path d="M3 8l9 5 9-5M12 13v8" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/></svg>',
        'gear' => '<svg width="44" height="44" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3.2" stroke="#1657C4" stroke-width="1.5"/><path d="M12 3v2.2M12 18.8V21M21 12h-2.2M5.2 12H3M18.4 5.6l-1.6 1.6M7.2 16.8l-1.6 1.6M18.4 18.4l-1.6-1.6M7.2 7.2 5.6 5.6" stroke="#1657C4" stroke-width="1.5" stroke-linecap="round"/></svg>',
    ];

    $advantageIcons = [
        'doc' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M7 3h7l4 4v14H7z" stroke="#0B2545" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 3v4h4M9 12h6M9 16h6" stroke="#0B2545" stroke-width="1.6" stroke-linecap="round"/></svg>',
        'box' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 8l9-5 9 5-9 5-9-5z" stroke="#0B2545" stroke-width="1.6" stroke-linejoin="round"/><path d="M3 8v8l9 5 9-5V8M12 13v8" stroke="#0B2545" stroke-width="1.6" stroke-linejoin="round"/></svg>',
        'swap' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 7h13l-3-3M20 17H7l3 3" stroke="#0B2545" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'truck' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M2 6h11v10H2zM13 10h5l3 3v3h-8z" stroke="#0B2545" stroke-width="1.6" stroke-linejoin="round"/><circle cx="6.5" cy="18" r="1.7" stroke="#0B2545" stroke-width="1.6"/><circle cx="17" cy="18" r="1.7" stroke="#0B2545" stroke-width="1.6"/></svg>',
        'support' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#0B2545" stroke-width="1.6"/><circle cx="12" cy="12" r="3.4" stroke="#0B2545" stroke-width="1.6"/><path d="M5.5 5.5l3 3M18.5 5.5l-3 3M5.5 18.5l3-3M18.5 18.5l-3-3" stroke="#0B2545" stroke-width="1.6"/></svg>',
        'shield' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z" stroke="#0B2545" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="#0B2545" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    ];

    $heroImage = $hero['background_image'] ?? 'https://images.unsplash.com/photo-1776090188130-26c7253ff423?fm=jpg&q=80&w=1600&auto=format&fit=crop';
@endphp

<div class="page-shell">
    <div class="topbar">
        <div class="container topbar-inner">
            <nav class="topbar-nav">
                @foreach ($headerNav as $item)
                    <a href="{{ $item['href'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                @endforeach
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

            <a href="#lead-form-section" class="callback-button">Заказать обратный звонок</a>
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
                    @if ($favoriteCount > 0)
                        <span class="header-count">{{ $favoriteCount }}</span>
                    @endif
                </a>
                <a href="#cart" class="header-link">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20.5" r="1.4" fill="#1657C4"/><circle cx="17" cy="20.5" r="1.4" fill="#1657C4"/></svg>
                    Корзина
                </a>
                @auth
                    <a href="{{ $accountUrl }}" class="header-link">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                        {{ $accountLabel }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="header-link">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                        Войти
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-surface">
            <img src="{{ $heroImage }}" alt="" class="hero-image">
            <div class="hero-overlay"></div>

            <div class="container hero-inner">
                <div class="hero-copy">
                    <div class="hero-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9L22 9.5L16 14.5L18 22L12 17.8L6 22L8 14.5L2 9.5L9.5 9Z" fill="#fff"/></svg>
                        Официальный поставщик твердосплавного инструмента
                    </div>
                    <h1 class="hero-title">{{ $hero['title'] ?? '' }}</h1>
                    <p class="hero-text">{{ $hero['description'] ?? '' }}</p>

                    <div class="hero-actions">
                        <a href="#lead-form-section" class="hero-primary">{{ $hero['cta_text'] ?? 'Получить предложение' }}</a>
                        <a href="{{ route('catalog.index') }}" class="hero-secondary">Смотреть каталог</a>
                    </div>
                </div>
            </div>

            <div class="hero-photo-note">Фото: сменные пластины крупным планом</div>
        </div>
    </section>

    <section class="benefits">
        <div class="container">
            <div class="benefits-grid">
                @foreach ($heroBenefits as $item)
                    <div class="benefit-card">
                        <div class="benefit-icon">{!! $benefitIcons[$item['icon'] ?? 'layers'] ?? $benefitIcons['layers'] !!}</div>
                        <span class="benefit-text">{{ $item['text'] ?? '' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="catalog">
        <div class="container section-inner">
            <div class="types-header">
                <h2 class="types-title">{{ $workTypes['title'] ?? 'Виды производимых работ' }}</h2>
                <div class="types-divider"></div>
                <p class="types-text">{{ $workTypes['description'] ?? 'Твердосплавные сменные пластины по типу обработки на станках с ЧПУ.' }}</p>
            </div>
            <div class="catalog-grid">
                @foreach ($categories as $category)
                    @php
                        $meta = $workTypeItems[$category->slug] ?? [];
                        $image = $meta['image'] ?? $heroImage;
                    @endphp
                    <a href="{{ route('catalog.index', ['categorySlug' => $category->slug]) }}" class="work-card">
                        <div class="work-card-media">
                            <img src="{{ $image }}" alt="{{ $category->name }}">
                        </div>
                        <div class="work-card-body">
                            <div class="work-card-title">{{ $category->name }}</div>
                            <p class="work-card-text">{{ $meta['description'] ?? $category->name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container section-inner">
            <h2 class="section-title">{{ $advantages['title'] ?? 'Почему с нами работают производства' }}</h2>
            <div class="advantage-grid">
                @foreach (($advantages['items'] ?? []) as $item)
                    <article class="advantage-card">
                        <div class="advantage-icon">{!! $advantageIcons[$item['icon'] ?? 'doc'] ?? $advantageIcons['doc'] !!}</div>
                        <h3>{{ $item['title'] ?? '' }}</h3>
                        <p>{{ $item['text'] ?? '' }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="about">
        <div class="container section-inner">
            <div class="about-grid">
                <div class="about-copy">
                    <h2 class="section-title">{{ $about['title'] ?? 'О компании' }}</h2>
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

                <div class="about-visual">
                    <img src="{{ $about['image'] ?? $heroImage }}" alt="О компании">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container section-inner">
            <h2 class="section-title">{{ $faq['title'] ?? 'Частые вопросы' }}</h2>
            <div class="faq-grid">
                @foreach (($faq['items'] ?? []) as $index => $item)
                    <details class="faq-item" @if ($index === 0) open @endif>
                        <summary>{{ $item['question'] ?? '' }}</summary>
                        <div class="faq-answer">{{ $item['answer'] ?? '' }}</div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="lead-section" id="lead-form-section">
        <div class="container">
            <div class="lead-grid">
                <div class="lead-copy">
                    <h2>Отправьте заявку на коммерческое предложение</h2>
                    <p>Укажите артикулы, аналоги, объём партии и сроки поставки. Менеджер свяжется с вами и подготовит предложение под задачу.</p>

                    <div class="lead-meta">
                        <div>
                            <div class="lead-meta-label">Телефон</div>
                            <div><a href="tel:+74951234567" style="color: #fff; text-decoration: none;">+7 (495) 123-45-67</a></div>
                            <div style="margin-top: 6px; color: rgba(255,255,255,0.55); font-size: 13.5px;">Пн–Пт, 9:00–18:00</div>
                        </div>
                        <div>
                            <div class="lead-meta-label">Email</div>
                            <div><a href="mailto:info@iteross.ru" style="color: #fff; text-decoration: none;">info@iteross.ru</a></div>
                            <div style="margin-top: 6px; color: rgba(255,255,255,0.55); font-size: 13.5px;">Ответ в течение рабочего дня</div>
                        </div>
                        <div>
                            <div class="lead-meta-label">Адрес</div>
                            <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                        </div>
                        <div>
                            <div class="lead-meta-label">Реквизиты</div>
                            <div>ООО «АЙТЕРОСС»</div>
                            <div style="margin-top: 6px; color: rgba(255,255,255,0.55); font-size: 13.5px;">ИНН 7700000000 · ОГРН 1157700000000</div>
                        </div>
                    </div>
                </div>

                <div class="lead-form-panel">
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
                        <div class="file-box">
                            <strong>Прикрепите файл</strong><br>
                            PDF, DOC, JPG — до 20 МБ
                        </div>
                        <button type="button" class="lead-submit">Получить предложение</button>
                        <p class="lead-disclaimer">Нажимая кнопку, вы соглашаетесь на обработку персональных данных.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer" id="footer">
        <div class="container footer-top">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">АЙТЕРОСС</div>
                    <p class="footer-copy">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                    <div class="footer-socials">
                        <a href="#" class="social-circle" aria-label="Telegram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        </a>
                        <a href="#" class="social-circle" aria-label="WhatsApp">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#5B6470" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#5B6470"/></svg>
                        </a>
                        <a href="#" class="social-circle" aria-label="VK">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 6c.3 8 4 13 11 13h1v-4l3 4h2c0-3-2-4-2-6 0-1 2-2 2-7h-3c0 3-2 6-3 6-1 0-1-3-1-6H8c0 3 1 6 0 6-1 0-2-3-2-6H4z" stroke="#5B6470" stroke-width="1.2" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="footer-title">НАВИГАЦИЯ</div>
                    <div class="footer-nav">
                        @foreach ($footerNavItems as $item)
                            <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="footer-title">КОНТАКТЫ</div>
                    <div class="footer-contact">
                        <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                        <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                        <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                        <div style="color: rgba(255,255,255,0.5); font-size: 13.5px;">Пн–Пт, 9:00–18:00</div>
                    </div>
                </div>

                <div>
                    <div class="footer-title">РЕКВИЗИТЫ</div>
                    <div class="footer-legal-stack">
                        <div>ООО «АЙТЕРОСС»</div>
                        <div>ИНН 7700000000</div>
                        <div>ОГРН 1157700000000</div>
                        <div>КПП 770001001</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container footer-bottom">© 2026 ООО «АЙТЕРОСС». Все права защищены.</div>
    </footer>

    <div class="cookie-banner" data-cookie-banner hidden>
        <p>Мы используем cookie для корректной работы сайта. Подробнее — в <a href="#">Политике конфиденциальности</a>.</p>
        <button type="button" class="cookie-button" data-cookie-accept>Ок</button>
    </div>
</div>

<script>
    (function () {
        var banner = document.querySelector('[data-cookie-banner]');
        var acceptButton = document.querySelector('[data-cookie-accept]');

        if (!banner || !acceptButton) {
            return;
        }

        try {
            if (window.localStorage.getItem('iteross_cookie_ok') !== '1') {
                banner.hidden = false;
            }
        } catch (error) {
            banner.hidden = false;
        }

        acceptButton.addEventListener('click', function () {
            try {
                window.localStorage.setItem('iteross_cookie_ok', '1');
            } catch (error) {}

            banner.hidden = true;
        });
    })();
</script>
</body>
</html>
