<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Личный кабинет | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #F7F8FA;
        }
        .shell {
            max-width: 1120px;
            margin: 0 auto;
            padding: 32px 20px 56px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }
        .brand {
            text-decoration: none;
            font-size: 22px;
            font-weight: 700;
            color: #0B2545;
            letter-spacing: 0.3px;
        }
        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .chip,
        .logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }
        .chip {
            background: #fff;
            color: #14161A;
            border: 1px solid #D6DAE0;
        }
        .logout {
            border: none;
            background: #14161A;
            color: #fff;
            cursor: pointer;
        }
        .hero,
        .card {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            box-shadow: 0 24px 48px -24px rgba(11, 37, 69, 0.16);
        }
        .hero {
            padding: 28px;
            margin-bottom: 20px;
        }
        .hero h1 {
            margin: 0 0 10px;
            font-size: 30px;
            line-height: 1.2;
        }
        .hero p {
            margin: 0;
            color: #5B6470;
            font-size: 15px;
            line-height: 1.6;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }
        .card {
            padding: 22px;
        }
        .label {
            margin-bottom: 8px;
            color: #8891A0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.4px;
        }
        .value {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="header">
            <a href="/" class="brand">АЙТЕРОСС</a>
            <div class="actions">
                <a href="{{ route('favorites.index') }}" class="chip">Избранное</a>
                <a href="{{ route('catalog.index') }}" class="chip">Каталог</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout">Выйти</button>
                </form>
            </div>
        </div>

        <section class="hero">
            <h1>{{ $user->first_name ?: $user->name }}, личный кабинет готов</h1>
            <p>Здесь можно показать историю заявок, реквизиты компании, сохранённые товары и статусы заказов.</p>
        </section>

        <section class="grid">
            <div class="card">
                <div class="label">ИМЯ</div>
                <div class="value">{{ $user->first_name }} {{ $user->last_name }}</div>
            </div>

            <div class="card">
                <div class="label">КОМПАНИЯ</div>
                <div class="value">{{ $user->company }}</div>
            </div>

            <div class="card">
                <div class="label">ПОЧТА</div>
                <div class="value">{{ $user->email }}</div>
            </div>

            <div class="card">
                <div class="label">ТЕЛЕФОН</div>
                <div class="value">{{ $user->phone }}</div>
            </div>
        </section>
    </div>
</body>
</html>
