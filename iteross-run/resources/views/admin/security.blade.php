<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Безопасность | Админка | АЙТЕРОСС</title>
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
        .btn-danger {
            background: transparent;
            color: #D34040;
            border: 1.5px solid #F0D7D7;
        }
        .btn-danger:hover {
            background: #FDF4F4;
        }
        .qr-block {
            background: #F8FAFF;
            border: 1px solid #D7E1F0;
            border-radius: 14px;
            padding: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .qr-block img {
            width: 200px;
            height: 200px;
            display: block;
            margin: 0 auto 16px;
        }
        .qr-hint {
            font-size: 13.5px;
            color: #6B7480;
            margin: 0;
            line-height: 1.55;
        }
        .steps {
            counter-reset: step;
            list-style: none;
            padding: 0;
            margin: 0 0 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .steps li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            color: #4A5260;
            line-height: 1.5;
        }
        .steps li::before {
            counter-increment: step;
            content: counter(step);
            min-width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #EAF1FB;
            color: #1657C4;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: none;
            margin-top: 1px;
        }
        .input-row {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }
        .input-row .field-wrap {
            flex: 1;
        }
        label.field-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
            margin-bottom: 7px;
        }
        input.code-input {
            width: 100%;
            height: 48px;
            border: 1.5px solid #D6DAE0;
            border-radius: 12px;
            padding: 0 14px;
            font-size: 20px;
            font-family: inherit;
            font-weight: 600;
            letter-spacing: 5px;
            text-align: center;
            outline: none;
            background: #fff;
        }
        input.code-input:focus {
            border-color: #1657C4;
        }
        .alert {
            border-radius: 12px;
            padding: 13px 16px;
            margin-bottom: 18px;
            font-size: 14px;
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
                <a href="{{ route('admin.pages.editor', ['page' => 'catalog']) }}" class="nav-link">Категории</a>
                <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link">Товары</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'home']) }}" class="nav-link">Главная</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'delivery']) }}" class="nav-link">Доставка</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'product']) }}" class="nav-link">Карточка товара</a>

                <div class="nav-title">АККАУНТ</div>
                <a href="{{ route('admin.security') }}" class="nav-link nav-link--active">Безопасность</a>
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
                <h1>Безопасность</h1>
                <p>Управление двухфакторной аутентификацией для вашего аккаунта администратора.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" style="max-width: 620px;">{{ session('success') }}</div>
            @endif

            @if ($errors->has('confirm_code') || $errors->has('disable_code'))
                <div class="alert alert-error" style="max-width: 620px;">
                    {{ $errors->first('confirm_code') ?: $errors->first('disable_code') }}
                </div>
            @endif

            @if (! $user->two_factor_enabled && ! $setupSecret)
                {{-- 2FA отключена, предлагаем включить --}}
                <div class="section-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L3 7V12C3 16.55 7.08 20.74 12 22C16.92 20.74 21 16.55 21 12V7L12 2Z" fill="#EAF1FB" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M12 8V12M12 16H12.01" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="card-title">Google Authenticator</p>
                            <p class="card-desc">Двухфакторная аутентификация</p>
                        </div>
                    </div>

                    <div class="status-row">
                        <span class="status-label">Статус</span>
                        <span class="badge badge--off">Отключена</span>
                    </div>

                    <p style="font-size: 14px; color: #6B7480; margin: 0 0 20px; line-height: 1.6;">
                        После включения при каждом входе в систему потребуется вводить 6-значный код из приложения Google Authenticator.
                    </p>

                    <form action="{{ route('admin.security.2fa.setup') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Включить 2FA</button>
                    </form>
                </div>

            @elseif (! $user->two_factor_enabled && $setupSecret)
                {{-- Показываем QR-код для настройки --}}
                <div class="section-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L3 7V12C3 16.55 7.08 20.74 12 22C16.92 20.74 21 16.55 21 12V7L12 2Z" fill="#EAF1FB" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M9 12L11 14L15 10" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="card-title">Настройка Google Authenticator</p>
                            <p class="card-desc">Отсканируйте QR-код и введите код для подтверждения</p>
                        </div>
                    </div>

                    <ol class="steps">
                        <li>Установите приложение <strong>Google Authenticator</strong> на телефон (iOS или Android)</li>
                        <li>Откройте приложение, нажмите «+» и выберите «Сканировать QR-код»</li>
                        <li>Отсканируйте QR-код ниже</li>
                        <li>Введите 6-значный код из приложения для подтверждения</li>
                    </ol>

                    <div class="qr-block">
                        <img src="{{ $qrDataUri }}" alt="QR-код для Google Authenticator">
                        <p class="qr-hint">Если не можете отсканировать, добавьте аккаунт вручную в приложении.<br>Ключ: <strong style="letter-spacing: 2px;">{{ $setupSecret }}</strong></p>
                    </div>

                    <form action="{{ route('admin.security.2fa.confirm') }}" method="post">
                        @csrf
                        <div class="input-row">
                            <div class="field-wrap">
                                <label class="field-label" for="confirm_code">КОД ИЗ ПРИЛОЖЕНИЯ</label>
                                <input
                                    id="confirm_code"
                                    name="confirm_code"
                                    type="text"
                                    class="code-input"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    maxlength="6"
                                    placeholder="000000"
                                    autofocus
                                    required
                                >
                            </div>
                            <button type="submit" class="btn btn-primary">Подтвердить</button>
                        </div>
                    </form>

                    <div class="divider"></div>

                    <form action="{{ route('admin.security.2fa.setup') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="font-size: 13.5px; padding: 10px 16px;">
                            Сгенерировать новый QR-код
                        </button>
                    </form>
                </div>

            @else
                {{-- 2FA включена --}}
                <div class="section-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L3 7V12C3 16.55 7.08 20.74 12 22C16.92 20.74 21 16.55 21 12V7L12 2Z" fill="#E6F9F0" stroke="#1A7A4A" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M9 12L11 14L15 10" stroke="#1A7A4A" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="card-title">Google Authenticator</p>
                            <p class="card-desc">Двухфакторная аутентификация</p>
                        </div>
                    </div>

                    <div class="status-row">
                        <span class="status-label">Статус</span>
                        <span class="badge badge--on">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="4" fill="#1A7A4A"/>
                            </svg>
                            Включена
                        </span>
                    </div>

                    <p style="font-size: 14px; color: #6B7480; margin: 0 0 20px; line-height: 1.6;">
                        При каждом входе потребуется код из Google Authenticator. Для отключения введите текущий код из приложения.
                    </p>

                    <div class="divider"></div>

                    <p style="font-size: 13.5px; font-weight: 700; color: #8891A0; margin: 0 0 12px; letter-spacing: 0.3px;">ОТКЛЮЧИТЬ 2FA</p>

                    <form action="{{ route('admin.security.2fa.disable') }}" method="post">
                        @csrf
                        <div class="input-row">
                            <div class="field-wrap">
                                <label class="field-label" for="disable_code">КОД ИЗ ПРИЛОЖЕНИЯ</label>
                                <input
                                    id="disable_code"
                                    name="disable_code"
                                    type="text"
                                    class="code-input"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    maxlength="6"
                                    placeholder="000000"
                                    required
                                >
                            </div>
                            <button type="submit" class="btn btn-danger">Отключить</button>
                        </div>
                    </form>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
