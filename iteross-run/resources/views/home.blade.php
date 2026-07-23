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
        .account-menu {
            position: relative;
            flex: none;
        }
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
        .account-menu-trigger:hover {
            color: #0B2545;
        }
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
        .account-menu.is-open .account-menu-panel {
            display: block;
        }
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
        .account-menu-logout:hover {
            background: #F4F7FB;
            color: #1657C4;
        }
        .account-menu-logout {
            border: none;
            font-family: inherit;
            cursor: pointer;
        }
        .account-menu-form {
            margin: 0;
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
        .proposal-modal {
            position: fixed;
            inset: 0;
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(11, 37, 69, 0.46);
        }
        .proposal-modal.is-open {
            display: flex;
        }
        .proposal-modal-card {
            width: min(100%, 560px);
            border-radius: 22px;
            background: #FFFFFF;
            box-shadow: 0 32px 80px rgba(11, 37, 69, 0.24);
            overflow: hidden;
        }
        .proposal-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 28px 28px 0;
        }
        .proposal-modal-header h3 {
            margin: 0 0 8px;
            color: #0B2545;
            font-size: 28px;
            line-height: 1.1;
        }
        .proposal-modal-header p {
            margin: 0;
            color: #5B6470;
            font-size: 15px;
            line-height: 1.6;
        }
        .proposal-modal-close {
            width: 42px;
            height: 42px;
            border: 1px solid #D8DEE6;
            border-radius: 50%;
            background: #FFFFFF;
            color: #3A4048;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex: none;
        }
        .proposal-modal-close:hover {
            background: #F5F7FB;
        }
        .proposal-modal-form {
            display: grid;
            gap: 16px;
            padding: 24px 28px 28px;
        }
        .proposal-modal-field {
            display: grid;
            gap: 8px;
        }
        .proposal-modal-field label {
            color: #6A7381;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .proposal-modal-field input,
        .proposal-modal-field textarea {
            width: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 12px;
            background: #FFFFFF;
            padding: 14px 16px;
            color: #14161A;
            font-size: 15px;
            font-family: inherit;
            outline: none;
        }
        .proposal-modal-field textarea {
            min-height: 132px;
            resize: vertical;
        }
        .proposal-modal-field input:focus,
        .proposal-modal-field textarea:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .proposal-modal-submit {
            min-height: 52px;
            border-radius: 14px;
            background: #1657C4;
            color: #FFFFFF;
            font-size: 15px;
            font-weight: 700;
        }
        .proposal-modal-submit:hover {
            background: #123F94;
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
            grid-template-columns: minmax(0, 1fr) minmax(340px, 0.82fr);
            gap: 20px;
            padding-top: 56px;
            padding-bottom: 64px;
        }
        .lead-copy {
            padding: 6px 0 0;
        }
        .lead-copy h2 {
            margin: 0;
            max-width: 420px;
            color: #14161A;
            font-size: 31px;
            line-height: 1.2;
            font-weight: 700;
        }
        .lead-copy p {
            margin: 0 0 28px;
            color: #5B6470;
            line-height: 1.75;
        }
        .lead-copy-accent {
            width: 56px;
            height: 3px;
            border-radius: 999px;
            background: #1657C4;
            margin: 18px 0 26px;
        }
        .lead-meta {
            display: grid;
            gap: 2px;
            overflow: hidden;
            border-radius: 12px;
            background: #E8EDF5;
            border: 1px solid #E4E9F1;
            margin-bottom: 24px;
        }
        .lead-meta-item {
            background: #F7F9FC;
            padding: 22px 18px 20px;
        }
        .lead-meta-label {
            margin-bottom: 8px;
            color: #8A96A8;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .lead-meta-value {
            color: #14161A;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.4;
        }
        .lead-meta-subtext {
            margin-top: 6px;
            color: #94A0B2;
            font-size: 13.5px;
            line-height: 1.5;
        }
        .lead-form-panel {
            background: #F7F9FC;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 30px;
            max-width: 540px;
            width: 100%;
            justify-self: end;
        }
        .lead-form {
            display: grid;
            gap: 14px;
        }
        .lead-form-feedback {
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            line-height: 1.5;
        }
        .lead-form-feedback--success {
            background: #EAF7EE;
            border: 1px solid #B7DFC0;
            color: #1F6B33;
        }
        .lead-form-feedback--error {
            background: #FFF3F3;
            border: 1px solid #F2CACA;
            color: #A33A3A;
        }
        .lead-form-feedback ul {
            margin: 0;
            padding-left: 18px;
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
        .field input.is-invalid,
        .field textarea.is-invalid {
            border-color: #D05353;
            box-shadow: 0 0 0 4px rgba(208, 83, 83, 0.12);
        }
        .field-error {
            margin-top: 8px;
            color: #B03D3D;
            font-size: 13px;
            line-height: 1.5;
        }
        .file-box {
            border: 1.5px dashed #C9D3E0;
            border-radius: 12px;
            background: #FFFFFF;
            padding: 18px 16px;
            color: #5B6470;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.15s ease, background 0.15s ease, box-shadow 0.15s ease;
        }
        .file-box:hover {
            border-color: #1657C4;
            background: #F8FBFF;
        }
        .file-box:focus-within {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .file-box input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        .file-box strong {
            display: block;
            color: #1657C4;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .file-box span {
            display: block;
        }
        .file-box-name {
            margin-top: 10px;
            color: #14161A;
            font-weight: 600;
            line-height: 1.5;
        }
        .file-box.is-invalid {
            border-color: #D05353;
            box-shadow: 0 0 0 4px rgba(208, 83, 83, 0.12);
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
        .cookie-banner.is-hidden {
            display: none;
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
            .proposal-modal {
                padding: 16px;
            }
            .proposal-modal-header,
            .proposal-modal-form {
                padding-left: 20px;
                padding-right: 20px;
            }
            .proposal-modal-header h3 {
                font-size: 24px;
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
                <a href="#" class="social-circle" aria-label="Viber">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3.5c4.7 0 8.5 3.3 8.5 7.5 0 4.7-4 8.5-8.9 8.5-.7 0-1.5-.1-2.2-.3L5 20.5l1.4-3.6C4.9 15.6 3.5 13.4 3.5 11c0-4.2 3.8-7.5 8.5-7.5Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/><path d="M8.4 8.7c.2-.4.5-.5.8-.5h.5c.2 0 .4 0 .6.4.2.5.6 1.6.7 1.7.1.2.1.4 0 .5-.1.2-.2.3-.4.4-.2.2-.3.3-.2.6.2.4.9 1.1 1.9 1.6.2.1.4.1.6-.1.2-.2.5-.6.7-.8.1-.2.3-.2.5-.1.2.1 1.2.6 1.4.7.2.1.3.2.3.4 0 .2 0 .8-.3 1.2-.3.4-1.1.6-1.9.4-1.3-.3-2.5-1.1-3.5-2.1-.8-.8-1.4-1.6-1.7-2.5-.2-.4-.1-.8 0-1.1Z" fill="#5B6470"/></svg>
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
                    <div class="account-menu" data-account-menu>
                        <button type="button" class="account-menu-trigger" data-account-menu-trigger aria-expanded="false" aria-haspopup="true">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                            {{ $accountLabel }}
                        </button>
                        <div class="account-menu-panel" data-account-menu-panel>
                            <a href="{{ $accountUrl }}" class="account-menu-item">
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
                        <button type="button" class="hero-primary" data-open-proposal-modal>Заказать звонок</button>
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
                    <div class="lead-copy-accent"></div>

                    <div class="lead-meta">
                        <div class="lead-meta-item">
                            <div class="lead-meta-label">Телефон</div>
                            <div class="lead-meta-value"><a href="tel:+74951234567" style="color: inherit; text-decoration: none;">+7 (495) 123-45-67</a></div>
                            <div class="lead-meta-subtext">Пн–Пт: 9:00 – 18:00 (МСК)</div>
                        </div>
                        <div class="lead-meta-item">
                            <div class="lead-meta-label">Email</div>
                            <div class="lead-meta-value"><a href="mailto:info@iteross.ru" style="color: inherit; text-decoration: none;">info@iteross.ru</a></div>
                            <div class="lead-meta-subtext">Ответ в течение рабочего дня</div>
                        </div>
                        <div class="lead-meta-item">
                            <div class="lead-meta-label">Адрес</div>
                            <div class="lead-meta-value">г. Москва, Дербеневская ул., 12, стр. 3</div>
                        </div>
                        <div class="lead-meta-item">
                            <div class="lead-meta-label">Реквизиты</div>
                            <div class="lead-meta-value">ООО «АЙТЕРОСС»</div>
                            <div class="lead-meta-subtext">ИНН 7700000000 · ОГРН 1157700000000</div>
                        </div>
                    </div>

                </div>

                <div class="lead-form-panel">
                    <form class="lead-form" method="POST" action="{{ route('lead-requests.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (session('status'))
                            <div class="lead-form-feedback lead-form-feedback--success">{{ session('status') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="lead-form-feedback lead-form-feedback--error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="field">
                            <label>Имя и компания</label>
                            <input
                                type="text"
                                name="company_name"
                                value="{{ old('company_name') }}"
                                placeholder="Иван Иванов, ООО «Компания»"
                                class="@error('company_name') is-invalid @enderror"
                            >
                            @error('company_name')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label>Телефон</label>
                            <input
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+7 (___) ___-__-__"
                                class="@error('phone') is-invalid @enderror"
                            >
                            @error('phone')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@company.ru"
                                class="@error('email') is-invalid @enderror"
                            >
                            @error('email')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field">
                            <label>Описание задачи</label>
                            <textarea
                                name="task_description"
                                placeholder="Артикул, аналог, объём партии, срок поставки..."
                                class="@error('task_description') is-invalid @enderror"
                            >{{ old('task_description') }}</textarea>
                            @error('task_description')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="file-box @error('attachment') is-invalid @enderror">
                            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <strong>Прикрепите файл</strong>
                            <span>PDF, DOC, JPG — до 20 МБ</span>
                            <span class="file-box-name" data-file-name>Файл не выбран</span>
                        </label>
                        @error('attachment')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="lead-submit">Получить предложение</button>
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

    <div class="proposal-modal" data-proposal-modal aria-hidden="true">
        <div class="proposal-modal-card" role="dialog" aria-modal="true" aria-labelledby="proposal-modal-title">
            <div class="proposal-modal-header">
                <div>
                    <h3 id="proposal-modal-title">Получить предложение</h3>
                    <p>Оставьте контакты, и мы свяжемся с вами, чтобы обсудить задачу и подготовить предложение.</p>
                </div>
                <button type="button" class="proposal-modal-close" data-close-proposal-modal aria-label="Закрыть окно">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form class="proposal-modal-form">
                <div class="proposal-modal-field">
                    <label for="proposal-name">Имя</label>
                    <input id="proposal-name" type="text" name="name" placeholder="Иван Иванов" required>
                </div>

                <div class="proposal-modal-field">
                    <label for="proposal-phone">Номер телефона</label>
                    <input id="proposal-phone" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required>
                </div>

                <div class="proposal-modal-field">
                    <label for="proposal-description">Описание задачи</label>
                    <textarea id="proposal-description" name="description" placeholder="Опишите задачу, если хотите"></textarea>
                </div>

                <button type="submit" class="proposal-modal-submit">Заказать звонок</button>
            </form>
        </div>
    </div>

    <div class="cookie-banner" data-cookie-banner hidden>
        <p>Мы используем cookie для корректной работы сайта. Подробнее — в <a href="#">Политике конфиденциальности</a>.</p>
        <button type="button" class="cookie-button" data-cookie-accept>Ок</button>
    </div>
</div>

<script>
    (function () {
        var menu = document.querySelector('[data-account-menu]');
        var trigger = document.querySelector('[data-account-menu-trigger]');

        if (!menu || !trigger) {
            return;
        }

        function openMenu() {
            menu.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
        }

        function closeMenu() {
            menu.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
        }

        trigger.addEventListener('click', function (event) {
            event.stopPropagation();

            if (menu.classList.contains('is-open')) {
                closeMenu();
                return;
            }

            openMenu();
        });

        document.addEventListener('click', function (event) {
            if (!menu.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });
    })();

    (function () {
        document.querySelectorAll('.file-box input[type="file"]').forEach(function (input) {
            input.addEventListener('change', function () {
                var fileNameElement = input.closest('.file-box')?.querySelector('[data-file-name]');
                if (!fileNameElement) {
                    return;
                }

                fileNameElement.textContent = input.files && input.files[0]
                    ? input.files[0].name
                    : 'Файл не выбран';
            });
        });
    })();

    (function () {
        var modal = document.querySelector('[data-proposal-modal]');
        var openButton = document.querySelector('[data-open-proposal-modal]');
        var closeButton = document.querySelector('[data-close-proposal-modal]');

        if (!modal || !openButton || !closeButton) {
            return;
        }

        function openModal() {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        openButton.addEventListener('click', function () {
            openModal();
        });

        closeButton.addEventListener('click', function () {
            closeModal();
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });
    })();

    (function () {
        var banner = document.querySelector('[data-cookie-banner]');
        var acceptButton = document.querySelector('[data-cookie-accept]');

        if (!banner || !acceptButton) {
            return;
        }

        function hideBanner() {
            banner.hidden = true;
            banner.classList.add('is-hidden');
        }

        function showBanner() {
            banner.hidden = false;
            banner.classList.remove('is-hidden');
        }

        try {
            if (window.localStorage.getItem('iteross_cookie_ok') !== '1') {
                showBanner();
            } else {
                hideBanner();
            }
        } catch (error) {
            showBanner();
        }

        acceptButton.addEventListener('click', function () {
            try {
                window.localStorage.setItem('iteross_cookie_ok', '1');
            } catch (error) {}

            hideBanner();
        });
    })();
</script>
</body>
</html>
