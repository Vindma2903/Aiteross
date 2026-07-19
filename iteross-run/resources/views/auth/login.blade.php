<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #F7F8FA;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: #FFFFFF;
            border-bottom: 1px solid #E3E6EA;
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
            max-width: 440px;
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 16px;
            box-shadow: 0 24px 48px -20px rgba(11, 37, 69, 0.15);
            padding: 40px;
        }
        h1 {
            font-size: 26px;
            font-weight: 700;
            margin: 0 0 8px;
        }
        p {
            font-size: 15px;
            color: #6B7480;
            margin: 0 0 32px;
            line-height: 1.5;
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
            height: 50px;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 0 16px;
            font-size: 15.5px;
            font-family: inherit;
            outline: none;
        }
        input:focus {
            border-color: #1657C4;
        }
        .field {
            margin-bottom: 18px;
        }
        .field--last {
            margin-bottom: 28px;
        }
        .password-field {
            position: relative;
        }
        .password-field input {
            padding-right: 52px;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            border: none;
            padding: 0;
            background: transparent;
            color: #6B7480;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .password-toggle svg {
            display: block;
            flex: none;
        }
        .password-toggle svg[hidden] {
            display: none;
        }
        .password-toggle:hover {
            color: #1657C4;
            background: transparent;
        }
        .password-toggle:focus-visible {
            outline: 2px solid #1657C4;
            outline-offset: 2px;
            border-radius: 6px;
        }
        .status {
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
            font-size: 14px;
            background: #ECFDF5;
            color: #166534;
            border: 1px solid #86EFAC;
        }
        .error-list {
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
            font-size: 14px;
            background: #FFF1F2;
            color: #9F1239;
            border: 1px solid #FDA4AF;
        }
        .submit-button {
            width: 100%;
            background: #1657C4;
            color: #fff;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }
        .submit-button:hover {
            background: #123F94;
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
    </style>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="brand">АЙТЕРОСС</a>
        </div>
    </header>

    <main class="auth">
        <div class="card">
            <h1>Вход в личный кабинет</h1>
            <p>Введите почту и пароль, чтобы открыть личный кабинет.</p>

            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="error-list">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="field">
                    <label for="email">ПОЧТА</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@company.ru" required>
                </div>

                <div class="field field--last">
                    <label for="password">ПАРОЛЬ</label>
                    <div class="password-field">
                        <input id="password" name="password" type="password" placeholder="••••••••" required>
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Показать пароль" aria-pressed="false">
                            <svg data-eye-open viewBox="0 0 24 24" width="22" height="22" fill="none" aria-hidden="true">
                                <path d="M2 12C3.73 8.11 7.53 5.5 12 5.5C16.47 5.5 20.27 8.11 22 12C20.27 15.89 16.47 18.5 12 18.5C7.53 18.5 3.73 15.89 2 12Z" stroke="currentColor" stroke-width="1.7"/>
                                <circle cx="12" cy="12" r="3.25" stroke="currentColor" stroke-width="1.7"/>
                            </svg>
                            <svg data-eye-closed viewBox="0 0 24 24" width="22" height="22" fill="none" aria-hidden="true" hidden>
                                <path d="M3 3L21 21" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                <path d="M10.58 10.58C10.21 10.95 10 11.46 10 12C10 13.1 10.9 14 12 14C12.54 14 13.05 13.79 13.42 13.42" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                <path d="M6.72 6.72C4.8 8.01 3.21 9.8 2 12C3.73 15.89 7.53 18.5 12 18.5C14.15 18.5 16.14 17.9 17.84 16.86" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                <path d="M9.88 5.73C10.57 5.58 11.28 5.5 12 5.5C16.47 5.5 20.27 8.11 22 12C21.19 13.82 19.96 15.39 18.44 16.61" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-button">Войти</button>
            </form>

            <div class="footer-link">
                <a href="/register">Ещё не зарегистрированы? Регистрация</a>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (toggle) {
            var input = document.getElementById(toggle.getAttribute('data-password-toggle'));
            if (!input) {
                return;
            }

            var eyeOpen = toggle.querySelector('[data-eye-open]');
            var eyeClosed = toggle.querySelector('[data-eye-closed]');

            toggle.addEventListener('click', function () {
                var willShowPassword = input.type === 'password';
                input.type = willShowPassword ? 'text' : 'password';
                toggle.setAttribute('aria-pressed', willShowPassword ? 'true' : 'false');
                toggle.setAttribute('aria-label', willShowPassword ? 'Скрыть пароль' : 'Показать пароль');

                if (eyeOpen && eyeClosed) {
                    eyeOpen.hidden = willShowPassword;
                    eyeClosed.hidden = !willShowPassword;
                }
            });
        });
    </script>
</body>
</html>
