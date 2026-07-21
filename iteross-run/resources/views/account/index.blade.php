<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Личный кабинет | АЙТЕРОСС</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'IBM Plex Sans', system-ui, sans-serif; color: #14161A; background: #F7F8FA; }
    a { text-decoration: none; }

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

<!-- HEADER -->
<header style="background:#FFFFFF;border-bottom:1px solid #E3E6EA;">
  <div style="max-width:1360px;margin:0 auto;padding:16px 32px;display:flex;align-items:center;gap:20px;">
    <a href="{{ url('/') }}" style="font-size:22px;font-weight:700;color:#0B2545;letter-spacing:0.3px;">АЙТЕРОСС</a>
    <div style="flex:1;"></div>
    <a href="{{ route('catalog.index') }}" style="color:#14161A;font-size:14.5px;font-weight:500;transition:color 0.15s;" onmouseover="this.style.color='#1657C4'" onmouseout="this.style.color='#14161A'">Каталог</a>
    <a href="{{ url('/') }}" style="color:#14161A;font-size:14.5px;font-weight:500;transition:color 0.15s;" onmouseover="this.style.color='#1657C4'" onmouseout="this.style.color='#14161A'">На главную</a>
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

      <div id="fav-grid" class="fav-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
        <!-- Cards rendered by JS -->
      </div>
      <div id="fav-empty" style="display:none;text-align:center;padding:48px 0;color:#8891A0;font-size:15px;">Список избранного пуст.</div>
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

  // ── Favorites ──
  var FAVORITES_DATA = [
    { id: 'cnmg', name: 'CNMG120408-GM',       price: '1 190 ₽ / шт.' },
    { id: '16er', name: '16ER-AG60-GM',         price: '1 420 ₽ / шт.' },
    { id: 'somt', name: 'Сверлильные SOMT',     price: '980 ₽ / шт.' },
  ];

  var favoriteIds = FAVORITES_DATA.map(function (f) { return f.id; });

  function renderFavorites() {
    var grid  = document.getElementById('fav-grid');
    var empty = document.getElementById('fav-empty');
    var items = FAVORITES_DATA.filter(function (f) { return favoriteIds.indexOf(f.id) !== -1; });

    if (items.length === 0) {
      grid.style.display  = 'none';
      empty.style.display = 'block';
      return;
    }

    grid.style.display  = 'grid';
    empty.style.display = 'none';

    grid.innerHTML = items.map(function (f) {
      return '<div style="position:relative;background:#fff;border:1px solid #E3E6EA;border-radius:12px;overflow:hidden;">'
        + '<button class="fav-remove-btn" onclick="removeFavorite(\'' + f.id + '\')" aria-label="Убрать из избранного">'
        + '<svg width="17" height="17" viewBox="0 0 24 24" fill="#1657C4"><path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke="#1657C4" stroke-width="1.6"/></svg>'
        + '</button>'
        + '<div style="aspect-ratio:1/1;background:#F7F8FA;display:flex;align-items:center;justify-content:center;padding:24px;">'
        + '<svg width="64" height="64" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="#D6DAE0" stroke-width="1.2"/><path d="M7 12h10M12 7v10" stroke="#D6DAE0" stroke-width="1.2" stroke-linecap="round"/></svg>'
        + '</div>'
        + '<div style="padding:16px 18px 20px;">'
        + '<div style="font-size:15px;font-weight:700;color:#14161A;margin-bottom:6px;">' + f.name + '</div>'
        + '<div style="font-size:15px;color:#14161A;font-weight:600;margin-bottom:14px;">' + f.price + '</div>'
        + '<a href="{{ route('catalog.index') }}" class="fav-card-btn">Подробнее</a>'
        + '</div></div>';
    }).join('');
  }

  window.removeFavorite = function (id) {
    favoriteIds = favoriteIds.filter(function (x) { return x !== id; });
    renderFavorites();
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

  // Init favorites on first render if tab is active
  if (document.getElementById('panel-favorites').classList.contains('active')) {
    renderFavorites();
  }

})();
</script>
</body>
</html>
