<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Избранное | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'IBM Plex Sans', system-ui, sans-serif; color: #14161A; background: #F7F8FA; }
        .shell { max-width: 1120px; margin: 0 auto; padding: 32px 20px 56px; }
        .header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 28px; }
        .brand { text-decoration: none; font-size: 22px; font-weight: 700; color: #0B2545; letter-spacing: 0.3px; }
        .links { display: flex; gap: 12px; flex-wrap: wrap; }
        .chip { display: inline-flex; align-items: center; min-height: 42px; padding: 0 18px; border-radius: 999px; text-decoration: none; font-size: 14px; font-weight: 600; border: 1px solid #D6DAE0; color: #14161A; background: #fff; }
        .hero { background: #fff; border: 1px solid #E3E6EA; border-radius: 18px; box-shadow: 0 24px 48px -24px rgba(11, 37, 69, 0.16); padding: 28px; margin-bottom: 22px; }
        .hero h1 { margin: 0 0 10px; font-size: 30px; }
        .hero p { margin: 0; color: #5B6470; font-size: 15px; line-height: 1.6; max-width: 720px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
        .card { background: #fff; border: 1px solid #E3E6EA; border-radius: 18px; box-shadow: 0 20px 40px -28px rgba(11, 37, 69, 0.2); padding: 22px; }
        .top { display: flex; align-items: flex-start; justify-content: space-between; gap: 14px; margin-bottom: 12px; }
        .sku { color: #8891A0; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; }
        .title { margin: 0 0 12px; font-size: 20px; line-height: 1.3; }
        .description { margin: 0 0 18px; color: #5B6470; font-size: 14px; line-height: 1.6; }
        .price { font-size: 24px; font-weight: 700; color: #0B2545; }
        .empty { background: #fff; border: 1px dashed #C8D0DA; border-radius: 18px; padding: 36px 28px; color: #5B6470; font-size: 15px; line-height: 1.7; }
        .heart-button { width: 42px; height: 42px; border-radius: 999px; border: 1px solid #D6DAE0; background: #EEF4FF; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; }
        .heart-button path { fill: #1657C4; stroke: #1657C4; }
    </style>
</head>
<body>
    <div class="shell">
        <div class="header">
            <a href="/" class="brand">АЙТЕРОСС</a>
            <div class="links">
                <a href="{{ route('catalog.index') }}" class="chip">Каталог</a>
                @auth
                    <a href="{{ route('account') }}" class="chip">Личный кабинет</a>
                @else
                    <a href="{{ route('login') }}" class="chip">Войти</a>
                @endauth
            </div>
        </div>

        <section class="hero">
            <h1>Избранное</h1>
            <p>Сюда попадают товары, которые пользователь добавил по иконке сердца. Для гостя список живёт на сессии, после входа переносится в профиль.</p>
        </section>

        @if ($products->isEmpty())
            <div class="empty">
                В избранном пока нет товаров. Перейдите в <a href="{{ route('catalog.index') }}">каталог</a> и добавьте нужные позиции по иконке сердца.
            </div>
        @else
            <section class="grid">
                @foreach ($products as $product)
                    <article class="card">
                        <div class="top">
                            <div class="sku">{{ $product->sku }}</div>
                            <form action="{{ route('favorites.toggle', $product) }}" method="post">
                                @csrf
                                <button type="submit" class="heart-button" aria-label="Убрать из избранного">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 20s-7-4.4-9.5-9C1 8 2 4.5 5.5 4c2-.3 4 .8 6.5 3.3C14.5 4.8 16.5 3.7 18.5 4 22 4.5 23 8 21.5 11 19 15.6 12 20 12 20Z" stroke-width="1.6"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <h2 class="title">{{ $product->name }}</h2>
                        <p class="description">{{ $product->description }}</p>
                        <div class="price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
                    </article>
                @endforeach
            </section>
        @endif
    </div>
</body>
</html>
