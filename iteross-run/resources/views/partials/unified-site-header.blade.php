@php
    use App\Modules\Admin\Application\UseCases\GetHomePageContent;
    use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
    use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;

    $siteHeaderContent = app(GetHomePageContent::class)->handle();
    $siteHeaderNav = data_get($siteHeaderContent, 'header_nav', []);
    $siteFavoriteCount = count(app(GetFavoriteProductIdsForRequest::class)->handle(request()));
    $siteUser = auth()->user();
    $siteAccountUrl = $siteUser?->role === User::ROLE_ADMIN ? route('admin.dashboard') : route('account');
    $siteAccountLabel = $siteUser?->role === User::ROLE_ADMIN ? 'Админка' : 'Личный кабинет';
@endphp

<div class="topbar">
    <div class="topbar-inner">
        <nav class="topbar-nav">
            @foreach ($siteHeaderNav as $item)
                <a href="{{ $item['href'] ?? '/' }}">{{ $item['label'] ?? '' }}</a>
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

        <a href="{{ url('/#lead-form-section') }}" class="callback-button">Заказать обратный звонок</a>
    </div>
</div>

<header class="site-header">
    <div class="header-inner">
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
                @if ($siteFavoriteCount > 0)
                    <span class="header-count">{{ $siteFavoriteCount }}</span>
                @endif
            </a>
            {{-- <a href="{{ route('cart.index') }}" class="header-link">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><path d="M4 5h2l1.6 10.2a2 2 0 0 0 2 1.8h7.8a2 2 0 0 0 2-1.6L20.4 8H6.5" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20.5" r="1.4" fill="#1657C4"/><circle cx="17" cy="20.5" r="1.4" fill="#1657C4"/></svg>
                Корзина
            </a> --}}
            @auth
                <div class="account-menu" data-account-menu>
                    <button type="button" class="account-menu-trigger" data-account-menu-trigger aria-expanded="false" aria-haspopup="true">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"/><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"/></svg>
                        {{ $siteAccountLabel }}
                    </button>
                    <div class="account-menu-panel" data-account-menu-panel>
                        <a href="{{ $siteAccountUrl }}" class="account-menu-item">
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
