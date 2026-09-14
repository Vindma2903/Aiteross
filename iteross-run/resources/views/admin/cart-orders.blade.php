<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Заявки из корзины | Админка | АЙТЕРОСС</title>
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
            padding: 10px 32px 28px;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge--on {
            background: #E6F9F0;
            color: #1A7A4A;
        }
        .badge--off {
            background: #EAF1FB;
            color: #1657C4;
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            white-space: nowrap;
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
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }
        .orders-table th {
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
            padding: 18px 10px 12px;
            border-bottom: 1px solid #E3E6EA;
            white-space: nowrap;
        }
        .orders-table td {
            padding: 16px 10px;
            border-bottom: 1px solid #EDEFF2;
            font-size: 14px;
            vertical-align: top;
        }
        .orders-table tr:last-child td {
            border-bottom: none;
        }
        .contact-name {
            font-weight: 700;
            margin-bottom: 3px;
        }
        .contact-line {
            color: #6B7480;
            font-size: 13px;
        }
        .comment-line {
            margin-top: 6px;
            color: #6B7480;
            font-size: 12.5px;
            line-height: 1.5;
            max-width: 260px;
        }
        .items-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 220px;
        }
        .item-line {
            font-size: 13.5px;
            line-height: 1.4;
        }
        .item-line span {
            color: #8891A0;
        }
        .totals-cell {
            white-space: nowrap;
            font-weight: 700;
        }
        .totals-cell small {
            display: block;
            font-weight: 500;
            color: #8891A0;
            font-size: 12px;
            margin-top: 2px;
        }
        .date-cell {
            white-space: nowrap;
            color: #6B7480;
            font-size: 13px;
        }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #8891A0;
            font-size: 14.5px;
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
                <a href="{{ route('admin.cart-orders') }}" class="nav-link nav-link--active">Заявки из корзины</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'catalog']) }}" class="nav-link">Категории</a>
                <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link">Товары</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'header']) }}" class="nav-link">Шапка</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'home']) }}" class="nav-link">Главная</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'delivery']) }}" class="nav-link">Доставка</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'product']) }}" class="nav-link">Карточка товара</a>

                <div class="nav-title">НАСТРОЙКИ</div>
                <a href="{{ route('admin.mail-server') }}" class="nav-link">Почтовый сервер</a>

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
                <h1>Заявки из корзины</h1>
                <p>Заявки, которые посетители оформляют из корзины на сайте: контакты и список товаров. Дублируются письмом на почту.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="section-card">
                @if ($cartOrderRequests->isEmpty())
                    <div class="empty-state">Пока нет ни одной заявки из корзины.</div>
                @else
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Контакт</th>
                                <th>Состав заявки</th>
                                <th>Итого</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartOrderRequests as $cartOrderRequest)
                                <tr>
                                    <td class="date-cell">{{ $cartOrderRequest->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div class="contact-name">{{ $cartOrderRequest->name }}</div>
                                        <div class="contact-line">{{ $cartOrderRequest->phone }}</div>
                                        @if ($cartOrderRequest->email)
                                            <div class="contact-line">{{ $cartOrderRequest->email }}</div>
                                        @endif
                                        @if ($cartOrderRequest->comment)
                                            <div class="comment-line">{{ $cartOrderRequest->comment }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="items-list">
                                            @foreach ($cartOrderRequest->items as $item)
                                                <div class="item-line">
                                                    {{ $item['name'] ?? $item['sku'] ?? 'Товар' }}
                                                    <span>× {{ $item['qty'] ?? 1 }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="totals-cell">
                                        {{ $cartOrderRequest->total_price > 0 ? number_format($cartOrderRequest->total_price, 0, ',', ' ').' ₽'.($cartOrderRequest->has_unknown_price ? '+' : '') : 'По запросу' }}
                                        <small>{{ $cartOrderRequest->total_quantity }} шт., {{ count($cartOrderRequest->items) }} поз.</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $cartOrderRequest->isProcessed() ? 'badge--on' : 'badge--off' }}">
                                            {{ $cartOrderRequest->statusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.cart-orders.toggle-status', $cartOrderRequest) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn {{ $cartOrderRequest->isProcessed() ? 'btn-secondary' : 'btn-primary' }}">
                                                {{ $cartOrderRequest->isProcessed() ? 'Вернуть в новые' : 'Отметить обработанной' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
