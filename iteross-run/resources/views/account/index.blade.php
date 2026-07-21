<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Личный кабинет | АЙТЕРОСС</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'IBM Plex Sans', system-ui, sans-serif; color: #14161A; background: #F7F8FA; }
    a { text-decoration: none; }

    /* ── Header (same as home page) ── */
    .container { max-width: 1360px; margin: 0 auto; padding-left: 20px; padding-right: 20px; }
    .topbar { border-bottom: 1px solid #EDEFF2; background: #FFFFFF; }
    .topbar-inner { min-height: 58px; display: flex; align-items: center; gap: 28px; }
    .topbar-nav { display: flex; align-items: center; gap: 22px; flex-wrap: wrap; }
    .topbar-nav a { color: #5B6470; font-size: 14.5px; font-weight: 500; white-space: nowrap; text-decoration: none; transition: color 0.15s ease; }
    .topbar-nav a:hover { color: #0B2545; }
    .topbar-spacer { flex: 1; }
    .topbar-phone { color: #14161A; font-size: 14.5px; font-weight: 600; white-space: nowrap; text-decoration: none; }
    .topbar-email { color: #5B6470; font-size: 14.5px; font-weight: 500; white-space: nowrap; text-decoration: none; transition: color 0.15s ease; }
    .topbar-email:hover { color: #0B2545; }
    .social-row { display: flex; align-items: center; gap: 8px; }
    .social-circle { width: 32px; height: 32px; border-radius: 50%; background: #F1F3F6; display: inline-flex; align-items: center; justify-content: center; flex: none; transition: background 0.15s ease; text-decoration: none; }
    .social-circle:hover { background: #E3E6EA; }
    .callback-button { min-height: 40px; padding: 10px 18px; border-radius: 100px; background: #1657C4; color: #fff; font-size: 14px; font-weight: 600; white-space: nowrap; border: none; cursor: pointer; font-family: inherit; transition: background 0.15s ease; text-decoration: none; display: inline-flex; align-items: center; }
    .callback-button:hover { background: #123F94; }
    .site-header { position: sticky; top: 0; z-index: 100; background: #FFFFFF; border-bottom: 1px solid #E3E6EA; box-shadow: 0 4px 16px rgba(11,37,69,0.08); }
    .header-inner { min-height: 74px; display: flex; align-items: center; gap: 20px; }
    .brand { text-decoration: none; flex: none; }
    .brand-name { color: #0B2545; font-size: 22px; font-weight: 700; letter-spacing: 0.3px; white-space: nowrap; }
    .catalog-button { display: inline-flex; align-items: center; background: #1657C4; color: #fff; padding: 12px 22px; border-radius: 100px; font-size: 15px; font-weight: 600; white-space: nowrap; flex: none; text-decoration: none; border: none; cursor: pointer; font-family: inherit; transition: background 0.15s ease; }
    .catalog-button:hover { background: #123F94; }
    .header-search { flex: 1; min-width: 180px; }
    .search-box { display: flex; align-items: center; gap: 10px; background: #fff; border: 1.5px solid #1657C4; border-radius: 100px; padding: 0 6px 0 20px; height: 46px; }
    .search-box input { flex: 1; min-width: 0; border: none; background: transparent; outline: none; font-size: 14.5px; font-family: inherit; color: #14161A; }
    .search-submit { width: 38px; height: 38px; border-radius: 50%; border: none; background: #1657C4; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; flex: none; transition: background 0.15s ease; }
    .search-submit:hover { background: #123F94; }
    .header-actions { display: flex; align-items: center; gap: 20px; flex: none; }
    .header-link { display: inline-flex; align-items: center; gap: 7px; color: #14161A; font-size: 14.5px; font-weight: 500; white-space: nowrap; text-decoration: none; transition: color 0.15s ease; }
    .header-link:hover { color: #0B2545; }
    .header-count { min-width: 18px; height: 18px; padding: 0 6px; border-radius: 999px; background: #1657C4; color: #fff; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; }
    .account-menu { position: relative; flex: none; }
    .account-menu-trigger { display: inline-flex; align-items: center; gap: 7px; border: none; background: transparent; padding: 0; color: #14161A; font-size: 14.5px; font-weight: 500; font-family: inherit; cursor: pointer; white-space: nowrap; }
    .account-menu-trigger:hover { color: #0B2545; }
    .account-menu-panel { position: absolute; top: calc(100% + 14px); right: 0; min-width: 220px; padding: 10px; border-radius: 16px; border: 1px solid #E3E6EA; background: #FFFFFF; box-shadow: 0 24px 48px -24px rgba(11,37,69,0.22); display: none; z-index: 130; }
    .account-menu.is-open .account-menu-panel { display: block; }
    .account-menu-item, .account-menu-logout { width: 100%; display: flex; align-items: center; gap: 10px; min-height: 44px; padding: 0 14px; border-radius: 12px; color: #14161A; text-decoration: none; background: #FFFFFF; font-size: 14px; font-weight: 600; transition: background 0.15s ease, color 0.15s ease; }
    .account-menu-item:hover, .account-menu-logout:hover { background: #F4F7FB; color: #1657C4; }
    .account-menu-logout { border: none; font-family: inherit; cursor: pointer; }
    .account-menu-form { margin: 0; }
    .proposal-modal { position: fixed; inset: 0; z-index: 500; display: none; align-items: center; justify-content: center; padding: 24px; background: rgba(11,37,69,0.46); }
    .proposal-modal.is-open { display: flex; }
    .proposal-modal-card { width: min(100%, 560px); border-radius: 22px; background: #FFFFFF; box-shadow: 0 32px 80px rgba(11,37,69,0.24); overflow: hidden; }
    .proposal-modal-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; padding: 28px 28px 0; }
    .proposal-modal-header h3 { margin: 0 0 8px; color: #0B2545; font-size: 28px; line-height: 1.1; }
    .proposal-modal-header p { margin: 0; color: #5B6470; font-size: 15px; line-height: 1.6; }
    .proposal-modal-close { width: 42px; height: 42px; border: 1px solid #D8DEE6; border-radius: 50%; background: #FFFFFF; color: #3A4048; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; flex: none; }
    .proposal-modal-close:hover { background: #F5F7FB; }
    .proposal-modal-form { display: grid; gap: 16px; padding: 24px 28px 28px; }
    .proposal-modal-field { display: grid; gap: 8px; }
    .proposal-modal-field label { color: #6A7381; font-size: 13px; font-weight: 700; letter-spacing: 0.2px; }
    .proposal-modal-field input, .proposal-modal-field textarea { width: 100%; border: 1.5px solid #D6DAE0; border-radius: 12px; background: #FFFFFF; padding: 14px 16px; color: #14161A; font-size: 15px; font-family: inherit; outline: none; box-sizing: border-box; }
    .proposal-modal-field textarea { min-height: 132px; resize: vertical; }
    .proposal-modal-field input:focus, .proposal-modal-field textarea:focus { border-color: #1657C4; box-shadow: 0 0 0 4px rgba(22,87,196,0.12); }
    .proposal-modal-submit { min-height: 52px; border-radius: 14px; background: #1657C4; color: #FFFFFF; font-size: 15px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; transition: background 0.15s; }
    .proposal-modal-submit:hover { background: #123F94; }
    @media (max-width: 1400px) { .topbar-email { display: none; } }
    @media (max-width: 980px) {
        .topbar-inner, .header-inner { padding-top: 14px; padding-bottom: 14px; flex-wrap: wrap; }
        .topbar-spacer { display: none; }
        .header-actions { flex-wrap: wrap; }
        .header-search { order: 10; width: 100%; flex-basis: 100%; }
    }
    @media (max-width: 760px) {
        .container { padding-left: 16px; padding-right: 16px; }
        .topbar-inner, .header-inner { gap: 14px; }
    }

    .tab-btn {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 12px; border-radius: 9px;
      font-size: 14.5px; border: none; cursor: pointer;
      width: 100%; text-align: left; font-family: inherit;
      background: transparent; color: #3A4048; font-weight: 500;
      transition: background 0.15s, color 0.15s;
    }
    .tab-btn:hover { background: #F5F7FB; }
    .tab-btn.active { background: #EAF1FB; color: #1657C4; font-weight: 600; }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    .order-row {
      display: flex; align-items: center; justify-content: space-between;
      gap: 16px; width: 100%; text-align: left; background: none;
      border: none; border-bottom: 1px solid #EDEFF2;
      padding: 20px 24px; cursor: pointer; font-family: inherit;
      transition: background 0.15s;
    }
    .order-row:hover { background: #F7F8FA; }
    .order-row:last-child { border-bottom: none; }

    .status-badge {
      font-size: 13px; font-weight: 700; padding: 6px 14px;
      border-radius: 100px; white-space: nowrap;
    }

    .fav-card-btn {
      display: block; text-align: center;
      background: #fff; color: #1657C4; border: 1.5px solid #1657C4;
      padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600;
      text-decoration: none; cursor: pointer; font-family: inherit;
      transition: background 0.15s, color 0.15s; width: 100%;
    }
    .fav-card-btn:hover { background: #1657C4; color: #fff; }

    .fav-remove-btn {
      position: absolute; top: 12px; right: 12px;
      width: 34px; height: 34px; border-radius: 50%;
      border: none; background: #fff;
      box-shadow: 0 2px 8px rgba(11,37,69,0.12);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; z-index: 2;
    }

    .field-input {
      width: 100%; height: 48px; border: 1.5px solid #D6DAE0;
      border-radius: 9px; padding: 0 14px; font-size: 15px;
      font-family: inherit; outline: none; background: #fff;
      transition: border-color 0.15s;
    }
    .field-input:focus { border-color: #1657C4; }

    .save-btn {
      background: #1657C4; color: #fff; border: none;
      padding: 13px 24px; border-radius: 9px;
      font-size: 15px; font-weight: 700; cursor: pointer;
      font-family: inherit; transition: background 0.15s;
    }
    .save-btn:hover { background: #123F94; }

    .back-btn {
      display: flex; align-items: center; gap: 8px;
      background: none; border: none; padding: 0; margin-bottom: 20px;
      cursor: pointer; font-family: inherit;
      color: #1657C4; font-size: 14.5px; font-weight: 600;
    }
    .back-btn:hover { color: #123F94; }

    @media (max-width: 900px) {
      .main-grid { grid-template-columns: 1fr !important; }
      .aside-sticky { position: static !important; }
      .fav-grid { grid-template-columns: repeat(2, 1fr) !important; }
      .detail-grid { grid-template-columns: 1fr !important; }
      .name-grid { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 600px) {
      .fav-grid { grid-template-columns: 1fr !important; }
      .main-wrap { padding: 24px 16px !important; }
    }
  </style>
</head>
<body>
@php
  $profileName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: ($user->name ?? 'Пользователь');
  $firstName = $user->first_name ?? $user->name ?? '';
  $lastName  = $user->last_name ?? '';
  $email     = $user->email ?? '';
  $phone     = $user->phone ?? '';
  $company   = $user->company ?? '';
@endphp

@php
  $headerNav = [
      ['label' => 'О компании',      'href' => '/#about'],
      ['label' => 'Условия покупки', 'href' => '/#about'],
      ['label' => 'Контакты',        'href' => '/#footer'],
  ];
@endphp

<!-- Topbar -->
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

    <button type="button" class="callback-button" data-open-proposal-modal>Заказать обратный звонок</button>
  </div>
</div>

<!-- Site header -->
<header class="site-header">
  <div class="container header-inner">
    <a href="{{ url('/') }}" class="brand">
      <div class="brand-name">АЙТЕРОСС</div>
    </a>

    <a href="{{ route('catalog.index') }}" class="catalog-button">Каталог</a>

    <div class="header-search">
      <div class="search-box">
        <input type="text" placeholder="Поиск товаров..." aria-label="Поиск товаров" autocomplete="off">
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
      <div class="account-menu" data-account-menu>
        <button type="button" class="account-menu-trigger" data-account-menu-trigger aria-expanded="false" aria-haspopup="true">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
          Личный кабинет
        </button>
        <div class="account-menu-panel" data-account-menu-panel>
          <a href="{{ route('account') }}" class="account-menu-item">
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
    </div>
  </div>
</header>

<!-- MAIN GRID -->
<div class="main-wrap main-grid" style="max-width:1360px;margin:0 auto;padding:40px 32px;display:grid;grid-template-columns:260px 1fr;gap:32px;align-items:start;">

  <!-- SIDEBAR -->
  <aside class="aside-sticky" style="background:#fff;border:1px solid #E3E6EA;border-radius:14px;padding:24px;position:sticky;top:24px;">
    <div style="width:52px;height:52px;border-radius:50%;background:#EAF1FB;display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
    </div>
    <div style="font-size:16px;font-weight:700;color:#14161A;margin-bottom:2px;">{{ $profileName }}</div>
    <div style="font-size:13.5px;color:#8891A0;margin-bottom:20px;">{{ $company ?: 'Личный аккаунт' }}</div>

    <nav style="display:flex;flex-direction:column;gap:4px;">
      <button class="tab-btn active" data-tab="orders">Мои заявки</button>
      <button class="tab-btn" data-tab="favorites">Избранное</button>
      <button class="tab-btn" data-tab="profile">Данные профиля</button>
      <form action="{{ route('logout') }}" method="post" style="margin:0;">
        @csrf
        <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:9px;font-size:14.5px;border:none;cursor:pointer;width:100%;text-align:left;font-family:inherit;background:transparent;color:#C43D3D;font-weight:500;margin-top:10px;border-top:1px solid #E3E6EA;padding-top:16px;transition:background 0.15s;" onmouseover="this.style.background='#FBEAEA'" onmouseout="this.style.background='transparent'">
          Выйти
        </button>
      </form>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div>

    <!-- ═══ ORDERS LIST ═══ -->
    <div class="tab-panel active" id="panel-orders">
      <div id="orders-list">
        <h1 style="font-size:28px;font-weight:700;color:#14161A;margin:0 0 24px;">Мои заявки</h1>

        <div style="background:#fff;border:1px solid #E3E6EA;border-radius:14px;overflow:hidden;">
          <button class="order-row" onclick="openOrder('1042')">
            <div>
              <div style="font-size:15.5px;font-weight:700;color:#14161A;margin-bottom:4px;">Заявка № 1042</div>
              <div style="font-size:13.5px;color:#8891A0;">CNMG120408-GM, 50 шт. · 12.07.2026</div>
            </div>
            <div style="display:flex;align-items:center;gap:16px;flex:none;">
              <span class="status-badge" style="background:#FDF3E3;color:#B8791E;">Формируем заказ</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="#8891A0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
          </button>
          <button class="order-row" onclick="openOrder('1038')">
            <div>
              <div style="font-size:15.5px;font-weight:700;color:#14161A;margin-bottom:4px;">Заявка № 1038</div>
              <div style="font-size:13.5px;color:#8891A0;">APMT1604PDER-M2, 20 шт. · 05.07.2026</div>
            </div>
            <div style="display:flex;align-items:center;gap:16px;flex:none;">
              <span class="status-badge" style="background:#EAF1FB;color:#1657C4;">В доставке</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="#8891A0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
          </button>
          <button class="order-row" onclick="openOrder('1021')">
            <div>
              <div style="font-size:15.5px;font-weight:700;color:#14161A;margin-bottom:4px;">Заявка № 1021</div>
              <div style="font-size:13.5px;color:#8891A0;">MGMN300-M-GM, 30 шт. · 28.06.2026</div>
            </div>
            <div style="display:flex;align-items:center;gap:16px;flex:none;">
              <span class="status-badge" style="background:#EAF6EC;color:#2E7D32;">Доставлено</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="#8891A0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
          </button>
        </div>
      </div>

      <!-- ═══ ORDER DETAIL ═══ -->
      <div id="order-detail" style="display:none;">
        <button class="back-btn" onclick="backToOrders()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#1657C4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          К списку заявок
        </button>

        <div style="background:#fff;border:1px solid #E3E6EA;border-radius:14px;padding:32px;max-width:720px;">
          <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:24px;">
            <h1 id="detail-title" style="font-size:24px;font-weight:700;color:#14161A;margin:0;"></h1>
            <span id="detail-badge" class="status-badge"></span>
          </div>

          <!-- Status tracker -->
          <div id="status-tracker" style="display:flex;align-items:center;gap:0;margin-bottom:28px;">
            <div style="display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;">
              <div id="step1-dot" style="width:12px;height:12px;border-radius:50%;"></div>
              <span id="step1-label" style="font-size:12px;font-weight:600;">Формируем заказ</span>
            </div>
            <div id="line1" style="height:2px;flex:1;margin-bottom:20px;"></div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;">
              <div id="step2-dot" style="width:12px;height:12px;border-radius:50%;"></div>
              <span id="step2-label" style="font-size:12px;font-weight:600;">В доставке</span>
            </div>
            <div id="line2" style="height:2px;flex:1;margin-bottom:20px;"></div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;">
              <div id="step3-dot" style="width:12px;height:12px;border-radius:50%;"></div>
              <span id="step3-label" style="font-size:12px;font-weight:600;">Доставлено</span>
            </div>
          </div>

          <!-- Product row -->
          <div style="display:flex;gap:20px;padding:20px;background:#F7F8FA;border-radius:12px;margin-bottom:24px;">
            <div style="width:88px;height:88px;background:#fff;border-radius:10px;flex:none;display:flex;align-items:center;justify-content:center;border:1px solid #E3E6EA;">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="#D6DAE0" stroke-width="1.5"/><path d="M7 12h10M12 7v10" stroke="#D6DAE0" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div id="detail-item" style="font-size:16px;font-weight:700;color:#14161A;margin-bottom:6px;"></div>
              <div id="detail-meta" style="font-size:14.5px;color:#6B7480;"></div>
            </div>
          </div>

          <div class="detail-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div>
              <div style="font-size:12.5px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:6px;">СУММА ЗАКАЗА</div>
              <div id="detail-total" style="font-size:15.5px;color:#14161A;font-weight:600;"></div>
            </div>
            <div>
              <div style="font-size:12.5px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:6px;">АДРЕС ДОСТАВКИ</div>
              <div id="detail-address" style="font-size:15.5px;color:#14161A;font-weight:600;"></div>
            </div>
            <div>
              <div style="font-size:12.5px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:6px;">МЕНЕДЖЕР</div>
              <div id="detail-manager" style="font-size:15.5px;color:#14161A;font-weight:600;"></div>
            </div>
            <div>
              <div style="font-size:12.5px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:6px;">ТРЕК-НОМЕР</div>
              <div id="detail-tracking" style="font-size:15.5px;color:#14161A;font-weight:600;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══ FAVORITES ═══ -->
    <div class="tab-panel" id="panel-favorites">
      <h1 style="font-size:28px;font-weight:700;color:#14161A;margin:0 0 24px;">Избранное</h1>

      @if($favorites->isEmpty())
        <div style="text-align:center;padding:48px 0;color:#8891A0;font-size:15px;">Список избранного пуст.</div>
      @else
        <div id="fav-grid" class="fav-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
          @foreach($favorites as $product)
            <div id="fav-{{ $product->id }}" style="position:relative;background:#fff;border:1px solid #E3E6EA;border-radius:12px;overflow:hidden;">
              <button
                class="fav-remove-btn"
                onclick="removeFavorite({{ $product->id }}, '{{ route('favorites.toggle', $product) }}')"
                aria-label="Убрать из избранного"
              >
                <svg width="17" height="17" viewBox="0 0 24 24" fill="#1657C4"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"/></svg>
              </button>
              <div style="aspect-ratio:1/1;background:#F7F8FA;display:flex;align-items:center;justify-content:center;padding:24px;">
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:contain;">
                @else
                  <svg width="64" height="64" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="#D6DAE0" stroke-width="1.2"/><path d="M7 12h10M12 7v10" stroke="#D6DAE0" stroke-width="1.2" stroke-linecap="round"/></svg>
                @endif
              </div>
              <div style="padding:16px 18px 20px;">
                <div style="font-size:15px;font-weight:700;color:#14161A;margin-bottom:6px;">{{ $product->name }}</div>
                <div style="font-size:15px;color:#14161A;font-weight:600;margin-bottom:14px;">{{ number_format($product->price, 0, ',', ' ') }} ₽ / шт.</div>
                <a href="{{ route('catalog.index') }}" class="fav-card-btn">Подробнее</a>
              </div>
            </div>
          @endforeach
        </div>
        <div id="fav-empty" style="display:none;text-align:center;padding:48px 0;color:#8891A0;font-size:15px;">Список избранного пуст.</div>
      @endif
    </div>

    <!-- ═══ PROFILE ═══ -->
    <div class="tab-panel" id="panel-profile">
      <h1 style="font-size:28px;font-weight:700;color:#14161A;margin:0 0 24px;">Данные профиля</h1>

      <!-- Personal info -->
      <div style="background:#fff;border:1px solid #E3E6EA;border-radius:14px;padding:32px;max-width:560px;margin-bottom:24px;">
        <h2 style="font-size:17px;font-weight:700;color:#14161A;margin:0 0 20px;">Личные данные</h2>

        <div class="name-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
          <div>
            <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">ИМЯ</label>
            <input class="field-input" id="inp-firstname" type="text" value="{{ $firstName }}">
          </div>
          <div>
            <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">ФАМИЛИЯ</label>
            <input class="field-input" id="inp-lastname" type="text" value="{{ $lastName }}">
          </div>
        </div>

        <div style="margin-bottom:16px;">
          <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">ПОЧТА</label>
          <input class="field-input" id="inp-email" type="email" value="{{ $email }}">
        </div>

        <div style="margin-bottom:24px;">
          <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">ТЕЛЕФОН</label>
          <input class="field-input" id="inp-phone" type="text" value="{{ $phone }}">
        </div>

        <button class="save-btn" onclick="saveProfile()">Сохранить изменения</button>
        <span id="profile-saved" style="display:none;margin-left:14px;font-size:14px;color:#2E7D32;font-weight:600;">Сохранено</span>
      </div>

      <!-- Password change -->
      <div style="background:#fff;border:1px solid #E3E6EA;border-radius:14px;padding:32px;max-width:560px;">
        <h2 style="font-size:17px;font-weight:700;color:#14161A;margin:0 0 20px;">Смена пароля</h2>

        <div style="margin-bottom:16px;">
          <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">ТЕКУЩИЙ ПАРОЛЬ</label>
          <input class="field-input" id="inp-pass-current" type="password" placeholder="••••••••">
        </div>

        <div style="margin-bottom:16px;">
          <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">НОВЫЙ ПАРОЛЬ</label>
          <input class="field-input" id="inp-pass-new" type="password" placeholder="••••••••">
        </div>

        <div style="margin-bottom:24px;">
          <label style="display:block;font-size:13px;font-weight:700;color:#8891A0;letter-spacing:0.3px;margin-bottom:8px;">ПОВТОРИТЕ НОВЫЙ ПАРОЛЬ</label>
          <input class="field-input" id="inp-pass-confirm" type="password" placeholder="••••••••">
        </div>

        <button class="save-btn" onclick="savePassword()">Изменить пароль</button>
        <span id="password-saved" style="display:none;margin-left:14px;font-size:14px;color:#2E7D32;font-weight:600;">Пароль изменён</span>
      </div>
    </div>

  </div>
</div>

<script>
(function () {

  // ── Tab switching ──
  var tabBtns = document.querySelectorAll('.tab-btn[data-tab]');
  var tabPanels = document.querySelectorAll('.tab-panel');

  tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var target = btn.getAttribute('data-tab');
      tabBtns.forEach(function (b) { b.classList.remove('active'); });
      tabPanels.forEach(function (p) { p.classList.remove('active'); });
      btn.classList.add('active');
      document.getElementById('panel-' + target).classList.add('active');
      if (target === 'favorites') renderFavorites();
    });
  });

  // ── Orders data ──
  var ORDERS = {
    '1042': { title: 'Заявка № 1042', item: 'CNMG120408-GM', qty: 50, date: '12.07.2026', status: 'forming',   total: '59 400 ₽',  address: 'г. Санкт-Петербург, Промышленная ул., 25', manager: 'Анна Смирнова',    tracking: '—' },
    '1038': { title: 'Заявка № 1038', item: 'APMT1604PDER-M2', qty: 20, date: '05.07.2026', status: 'shipping',  total: '32 800 ₽',  address: 'г. Москва, Ленинский пр-т, 15',            manager: 'Дмитрий Ковалёв', tracking: 'СДЭК 1234567890' },
    '1021': { title: 'Заявка № 1021', item: 'MGMN300-M-GM',    qty: 30, date: '28.06.2026', status: 'delivered', total: '29 400 ₽',  address: 'г. Казань, ул. Заводская, 8',              manager: 'Анна Смирнова',    tracking: 'СДЭК 0987654321' },
  };

  var STATUS_META = {
    forming:   { label: 'Формируем заказ', bg: '#FDF3E3', color: '#B8791E' },
    shipping:  { label: 'В доставке',      bg: '#EAF1FB', color: '#1657C4' },
    delivered: { label: 'Доставлено',      bg: '#EAF6EC', color: '#2E7D32' },
  };

  var STEP_ORDER = ['forming', 'shipping', 'delivered'];

  window.openOrder = function (number) {
    var o = ORDERS[number];
    if (!o) return;
    var meta    = STATUS_META[o.status];
    var stepIdx = STEP_ORDER.indexOf(o.status);

    function stepColor(i) { return i <= stepIdx ? meta.color : '#D6DAE0'; }

    document.getElementById('detail-title').textContent   = o.title;
    document.getElementById('detail-badge').textContent   = meta.label;
    document.getElementById('detail-badge').style.background = meta.bg;
    document.getElementById('detail-badge').style.color   = meta.color;
    document.getElementById('detail-item').textContent    = o.item;
    document.getElementById('detail-meta').textContent    = o.qty + ' шт. · дата заявки ' + o.date;
    document.getElementById('detail-total').textContent   = o.total;
    document.getElementById('detail-address').textContent = o.address;
    document.getElementById('detail-manager').textContent = o.manager;
    document.getElementById('detail-tracking').textContent = o.tracking;

    ['step1-dot','step2-dot','step3-dot'].forEach(function (id, i) {
      var el = document.getElementById(id);
      el.style.background = stepColor(i);
    });
    ['step1-label','step2-label','step3-label'].forEach(function (id, i) {
      var el = document.getElementById(id);
      el.style.color = stepColor(i);
    });
    document.getElementById('line1').style.background = stepIdx >= 1 ? meta.color : '#E3E6EA';
    document.getElementById('line2').style.background = stepIdx >= 2 ? meta.color : '#E3E6EA';

    document.getElementById('orders-list').style.display   = 'none';
    document.getElementById('order-detail').style.display  = 'block';
  };

  window.backToOrders = function () {
    document.getElementById('orders-list').style.display  = 'block';
    document.getElementById('order-detail').style.display = 'none';
  };

  // ── Favorites: remove via real API ──
  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  window.removeFavorite = function (productId, toggleUrl) {
    fetch(toggleUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
      if (!data.ok) return;
      var card  = document.getElementById('fav-' + productId);
      var grid  = document.getElementById('fav-grid');
      var empty = document.getElementById('fav-empty');
      if (card) card.remove();
      if (grid && grid.children.length === 0) {
        grid.style.display  = 'none';
        if (empty) empty.style.display = 'block';
      }
    });
  };

  // ── Profile save ──
  window.saveProfile = function () {
    var el = document.getElementById('profile-saved');
    el.style.display = 'inline';
    setTimeout(function () { el.style.display = 'none'; }, 2500);
  };

  window.savePassword = function () {
    var el = document.getElementById('password-saved');
    document.getElementById('inp-pass-current').value = '';
    document.getElementById('inp-pass-new').value = '';
    document.getElementById('inp-pass-confirm').value = '';
    el.style.display = 'inline';
    setTimeout(function () { el.style.display = 'none'; }, 2500);
  };


  // ── Account menu (same as home page) ──
  (function () {
    var menu    = document.querySelector('[data-account-menu]');
    var trigger = document.querySelector('[data-account-menu-trigger]');
    if (!menu || !trigger) return;

    function openMenu()  { menu.classList.add('is-open');    trigger.setAttribute('aria-expanded', 'true'); }
    function closeMenu() { menu.classList.remove('is-open'); trigger.setAttribute('aria-expanded', 'false'); }

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      menu.classList.contains('is-open') ? closeMenu() : openMenu();
    });
    document.addEventListener('click', function (e) {
      if (!menu.contains(e.target)) closeMenu();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMenu();
    });
  })();

  // ── Proposal modal ──
  (function () {
    var modal   = document.getElementById('proposalModal');
    var closeBtn = modal ? modal.querySelector('[data-close-proposal-modal]') : null;
    if (!modal) return;

    function openModal()  { modal.classList.add('is-open');    document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.classList.remove('is-open'); document.body.style.overflow = ''; }

    document.querySelectorAll('[data-open-proposal-modal]').forEach(function (btn) {
      btn.addEventListener('click', function (e) { e.preventDefault(); openModal(); });
    });
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
  })();

})();
</script>

<!-- Proposal modal -->
<div class="proposal-modal" id="proposalModal" role="dialog" aria-modal="true" aria-label="Заказать обратный звонок">
  <div class="proposal-modal-card">
    <div class="proposal-modal-header">
      <div>
        <h3>Заказать<br>обратный звонок</h3>
        <p>Оставьте свои контакты — мы перезвоним<br>в течение 30 минут</p>
      </div>
      <button class="proposal-modal-close" data-close-proposal-modal aria-label="Закрыть">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 2L14 14M14 2L2 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>
    <form class="proposal-modal-form" onsubmit="return false;">
      <div class="proposal-modal-field">
        <label>Имя</label>
        <input type="text" placeholder="Ваше имя" autocomplete="name">
      </div>
      <div class="proposal-modal-field">
        <label>Телефон</label>
        <input type="tel" placeholder="+7 (___) ___-__-__" autocomplete="tel">
      </div>
      <div class="proposal-modal-field">
        <label>Комментарий</label>
        <textarea placeholder="Опишите вашу задачу или вопрос"></textarea>
      </div>
      <button type="submit" class="proposal-modal-submit">Отправить заявку</button>
    </form>
  </div>
</div>
</body>
</html>
