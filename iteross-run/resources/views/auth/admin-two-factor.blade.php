<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Подтверждение входа | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background:
                radial-gradient(circle at top left, rgba(22, 87, 196, 0.18), transparent 32%),
                linear-gradient(180deg, #F5F8FF 0%, #EEF1F5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid #E3E6EA;
            backdrop-filter: blur(10px);
        }
        .header__inner {
            max-width: 1360px;
            margin: 0 auto;
            padding: 18px 20px;
        }
        .brand {
            text-decoration: none;
            font-size: 22px;
            font-weight: 700;
            color: #0B2545;
            letter-spacing: 0.3px;
        }
        .auth {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
        }
        .card {
            width: 100%;
            max-width: 460px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #D7E1F0;
            border-radius: 20px;
            box-shadow: 0 30px 70px -36px rgba(11, 37, 69, 0.4);
            padding: 40px;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            background: #E8F0FF;
            color: #1657C4;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 18px 0 8px;
        }
        p {
            font-size: 15px;
            color: #6B7480;
            margin: 0 0 30px;
            line-height: 1.55;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            height: 52px;
            border: 1.5px solid #D6DAE0;
            border-radius: 12px;
            padding: 0 16px;
            font-size: 22px;
            font-family: inherit;
            font-weight: 600;
            letter-spacing: 6px;
            text-align: center;
            outline: none;
            background: #fff;
        }
        input:focus {
            border-color: #1657C4;
        }
        .field {
            margin-bottom: 28px;
        }
        .error-list {
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 18px;
            font-size: 14px;
            background: #FFF1F2;
            color: #9F1239;
            border: 1px solid #FDA4AF;
        }
        .submit-button {
            width: 100%;
            background: #14161A;
            color: #fff;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }
        .submit-button:hover {
            background: #0B2545;
        }
        .footer-link {
            text-align: center;
            margin-top: 22px;
        }
        .footer-link a {
            font-size: 14.5px;
            color: #1657C4;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-link a:hover {
            text-decoration: underline;
        }
        .icon-shield {
            display: block;
            margin: 0 0 20px;
        }
    </style>
    @include('partials.unified-site-header-styles')
    @include('partials.unified-site-footer-styles')
</head>
<body>
    @include('partials.unified-site-header')
    {{--
    <header class="header">
        <div class="header__inner">
            <a href="/" class="brand">АЙТЕРОСС</a>
        </div>
    </header>

    --}}
    <main class="auth">
        <div class="card">
            <svg class="icon-shield" width="44" height="44" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L3 7V12C3 16.55 7.08 20.74 12 22C16.92 20.74 21 16.55 21 12V7L12 2Z" fill="#E8F0FF" stroke="#1657C4" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="M9 12L11 14L15 10" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <div class="eyebrow">2FA</div>
            <h1>Подтверждение входа</h1>
            <p>Откройте Google Authenticator и введите 6-значный код для аккаунта АЙТЕРОСС.</p>

            @if ($errors->any())
                <div class="error-list">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.two-factor.store') }}" method="post">
                @csrf
                <div class="field">
                    <label for="code">КОД ИЗ ПРИЛОЖЕНИЯ</label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        placeholder="000000"
                        autofocus
                        required
                    >
                </div>

                <button type="submit" class="submit-button">Подтвердить</button>
            </form>

            <div class="footer-link">
                <a href="{{ route('admin.login') }}">Вернуться к входу</a>
            </div>
        </div>
    </main>
    @include('partials.unified-site-footer')
    @include('partials.unified-site-header-scripts')
</body>
</html>
