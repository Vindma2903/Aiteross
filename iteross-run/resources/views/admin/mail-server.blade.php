<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Почтовый сервер | Админка | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #FFFFFF;
        }
        .shell {
            width: 100%;
            min-height: 100vh;
            display: flex;
            background: #FFFFFF;
        }
        .sidebar {
            width: 320px;
            flex: none;
            padding: 34px 24px;
            background: #FFFFFF;
            border-right: 1px solid #E3E6EA;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .brand {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
            color: #0B2545;
        }
        .sidebar-subtitle {
            margin: 6px 0 0;
            color: #8891A0;
            line-height: 1.6;
            font-size: 13px;
        }
        .nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .nav-title {
            padding: 18px 14px 8px;
            margin-top: 8px;
            border-top: 1px solid #E3E6EA;
            color: #8891A0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            min-height: 52px;
            padding: 0 14px;
            border-radius: 14px;
            color: #14161A;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .nav-link:hover {
            background: #F5F7FB;
        }
        .nav-link--active {
            background: #EAF1FB;
            color: #1657C4;
        }
        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #E3E6EA;
        }
        .logout-button {
            width: 100%;
            min-height: 52px;
            border: 1px solid #F0D7D7;
            border-radius: 14px;
            background: transparent;
            color: #D34040;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }
        .logout-button:hover {
            background: #FDF4F4;
        }
        .main {
            flex: 1;
            min-width: 0;
            padding: 36px 48px;
        }
        .hero {
            margin-bottom: 36px;
        }
        .hero h1 {
            margin: 0 0 10px;
            font-size: 26px;
        }
        .hero p {
            margin: 0;
            color: #8891A0;
            line-height: 1.6;
            font-size: 14.5px;
        }
        .section-card {
            background: #FFFFFF;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 28px 32px;
            max-width: 620px;
        }
        .section-card + .section-card {
            margin-top: 20px;
        }
        .card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }
        .card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #EAF1FB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }
        .card-title {
            font-size: 17px;
            font-weight: 700;
            margin: 0 0 3px;
        }
        .card-desc {
            font-size: 13.5px;
            color: #8891A0;
            margin: 0;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }
        .badge--on {
            background: #E6F9F0;
            color: #1A7A4A;
        }
        .badge--off {
            background: #F5F5F7;
            color: #8891A0;
        }
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }
        .status-label {
            font-size: 14.5px;
            color: #6B7480;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-primary {
            background: #14161A;
            color: #fff;
        }
        .btn-primary:hover {
            background: #0B2545;
        }
        .btn-secondary {
            background: #EAF1FB;
            color: #1657C4;
        }
        .btn-secondary:hover {
            background: #DCE9FA;
        }
        .field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }
        .field {
            min-width: 0;
        }
        .field--full {
            grid-column: 1 / -1;
        }
        label.field-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
            margin-bottom: 7px;
        }
        .field input,
        .field select {
            width: 100%;
            height: 48px;
            border: 1.5px solid #D6DAE0;
            border-radius: 12px;
            padding: 0 14px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            background: #fff;
            color: #14161A;
        }
        .field input:focus,
        .field select:focus {
            border-color: #1657C4;
        }
        .field-hint {
            margin: 6px 0 0;
            font-size: 12.5px;
            color: #8891A0;
            line-height: 1.5;
        }
        .input-row {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }
        .input-row .field-wrap {
            flex: 1;
        }
        .alert {
            border-radius: 12px;
            padding: 13px 16px;
            margin-bottom: 18px;
            font-size: 14px;
            max-width: 620px;
        }
        .alert-success {
            background: #E6F9F0;
            color: #1A7A4A;
            border: 1px solid #A7DFC2;
        }
        .alert-error {
            background: #FFF1F2;
            color: #9F1239;
            border: 1px solid #FDA4AF;
        }
        .divider {
            height: 1px;
            background: #E3E6EA;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="shell">
        <aside class="sidebar">
            <div>
                <div class="brand">АЙТЕРОСС</div>
                <p class="sidebar-subtitle">Панель администратора</p>
            </div>

            <nav class="nav">
                <div class="nav-title">УПРАВЛЕНИЕ</div>
                <a href="{{ route('admin.dashboard', ['section' => 'orders']) }}" class="nav-link">Заявки</a>
                <a href="{{ route('admin.cart-orders') }}" class="nav-link">Заявки из корзины</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'catalog']) }}" class="nav-link">Категории</a>
                <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link">Товары</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'header']) }}" class="nav-link">Шапка</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'home']) }}" class="nav-link">Главная</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'delivery']) }}" class="nav-link">Доставка</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'product']) }}" class="nav-link">Карточка товара</a>

                <div class="nav-title">НАСТРОЙКИ</div>
                <a href="{{ route('admin.mail-server') }}" class="nav-link nav-link--active">Почтовый сервер</a>

                <div class="nav-title">АККАУНТ</div>
                <a href="{{ route('admin.security') }}" class="nav-link">Безопасность</a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-button">Выйти</button>
                </form>
            </div>
        </aside>

        <main class="main">
            <div class="hero">
                <h1>Почтовый сервер</h1>
                <p>Настройки SMTP-сервера, через который сайт отправляет письма: заявки с сайта, обратную связь и другие уведомления.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if (session('mail_test_error'))
                <div class="alert alert-error">{{ session('mail_test_error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <div class="section-card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6H20C21.1 6 22 6.9 22 8V16C22 17.1 21.1 18 20 18H4C2.9 18 2 17.1 2 16V8C2 6.9 2.9 6 4 6Z" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/>
                            <path d="M22 8L12 14L2 8" stroke="#1657C4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <p class="card-title">SMTP-сервер</p>
                        <p class="card-desc">Данные почтового ящика для отправки писем</p>
                    </div>
                </div>

                <div class="status-row">
                    <span class="status-label">Статус</span>
                    @if ($settings['host'])
                        <span class="badge badge--on">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="4" fill="#1A7A4A"/>
                            </svg>
                            Настроен
                        </span>
                    @else
                        <span class="badge badge--off">Не настроен</span>
                    @endif
                </div>

                <form action="{{ route('admin.mail-server.update') }}" method="post">
                    @csrf

                    <div class="field-grid">
                        <div class="field field--full">
                            <label class="field-label" for="host">SMTP-ХОСТ</label>
                            <input id="host" name="host" type="text" value="{{ old('host', $settings['host']) }}" placeholder="smtp.yandex.ru" required>
                        </div>

                        <div class="field">
                            <label class="field-label" for="port">ПОРТ</label>
                            <input id="port" name="port" type="number" min="1" max="65535" value="{{ old('port', $settings['port']) }}" required>
                        </div>

                        <div class="field">
                            <label class="field-label" for="encryption">ШИФРОВАНИЕ</label>
                            <select id="encryption" name="encryption">
                                <option value="tls" @selected(old('encryption', $settings['encryption']) === 'tls')>TLS (STARTTLS, обычно порт 587)</option>
                                <option value="ssl" @selected(old('encryption', $settings['encryption']) === 'ssl')>SSL (обычно порт 465)</option>
                                <option value="none" @selected(old('encryption', $settings['encryption']) === 'none')>Без шифрования</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="field-label" for="username">ЛОГИН (EMAIL)</label>
                            <input id="username" name="username" type="text" value="{{ old('username', $settings['username']) }}" placeholder="noreply@iteross.ru">
                        </div>

                        <div class="field">
                            <label class="field-label" for="password">ПАРОЛЬ</label>
                            <input id="password" name="password" type="password" value="" placeholder="{{ $hasPassword ? '••••••••  (оставьте пустым, чтобы не менять)' : 'Пароль или пароль приложения' }}" autocomplete="new-password">
                        </div>

                        <div class="field field--full">
                            <div class="field-hint">Для Gmail, Яндекс.Почты и других сервисов обычно нужен «пароль приложения», а не обычный пароль от ящика.</div>
                        </div>

                        <div class="field">
                            <label class="field-label" for="from_address">EMAIL ОТПРАВИТЕЛЯ</label>
                            <input id="from_address" name="from_address" type="email" value="{{ old('from_address', $settings['from_address']) }}" placeholder="noreply@iteross.ru" required>
                        </div>

                        <div class="field">
                            <label class="field-label" for="from_name">ИМЯ ОТПРАВИТЕЛЯ</label>
                            <input id="from_name" name="from_name" type="text" value="{{ old('from_name', $settings['from_name']) }}" placeholder="АЙТЕРОСС" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>

            <div class="section-card">
                <div class="card-header">
                    <div>
                        <p class="card-title">Проверка отправки</p>
                        <p class="card-desc">Отправьте тестовое письмо, чтобы убедиться, что настройки работают</p>
                    </div>
                </div>

                <form action="{{ route('admin.mail-server.test') }}" method="post">
                    @csrf
                    <div class="input-row">
                        <div class="field-wrap">
                            <label class="field-label" for="test_email">EMAIL ДЛЯ ПРОВЕРКИ</label>
                            <input id="test_email" name="test_email" type="email" value="{{ old('test_email', auth()->user()->email) }}" required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Отправить тестовое письмо</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
