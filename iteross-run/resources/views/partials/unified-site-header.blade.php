@php
    use App\Modules\Admin\Application\UseCases\GetHeaderContent;
    use App\Modules\Admin\Application\UseCases\GetHomePageContent;
    use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
    use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;

    $siteHeaderContent = app(GetHomePageContent::class)->handle();
    $siteHeaderNav = data_get($siteHeaderContent, 'header_nav', []);
    $siteHeaderData = app(GetHeaderContent::class)->handle();
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

        @php
            $sitePhone = data_get($siteHeaderData, 'phone', '+7 (495) 123-45-67');
            $siteEmail = data_get($siteHeaderData, 'email', 'info@iteross.ru');
            $siteSocials = data_get($siteHeaderData, 'socials', []);
            $siteSocialSvgs = [
                'telegram'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>',
                'max'       => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="#5B6470" stroke-width="1.6"/><path d="M7 17V7l5 5 5-5v10" stroke="#5B6470" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                'vichat'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3C7 3 3 6.6 3 11c0 2.4 1.2 4.5 3 6l-.8 2.8L8 18.6c1.2.5 2.6.9 4 .9 5 0 9-3.6 9-8s-4-8.5-9-8.5Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/><path d="M8.5 10.5h.01M12 10.5h.01M15.5 10.5h.01" stroke="#5B6470" stroke-width="2" stroke-linecap="round"/></svg>',
                'whatsapp'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M20.5 3.5A11.9 11.9 0 0 0 12 0C5.4 0 0 5.4 0 12c0 2.1.5 4.2 1.6 6L0 24l6.2-1.6A12 12 0 0 0 12 24c6.6 0 12-5.4 12-12 0-3.2-1.2-6.2-3.5-8.5ZM12 22c-1.8 0-3.6-.5-5.2-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A10 10 0 0 1 2 12C2 6.5 6.5 2 12 2s10 4.5 10 10-4.5 10-10 10Zm5.5-7.5c-.3-.1-1.8-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1a8 8 0 0 1-2.4-1.5 9 9 0 0 1-1.6-2c-.2-.3 0-.5.1-.6l.5-.5.3-.5v-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4C7.6 9 7 9.7 7 11.1s1 2.7 1.2 2.9c.1.2 2 3 4.9 4.2.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.3-.2-.6-.3Z" fill="#5B6470"/></svg>',
                'viber'     => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M11.4 0C8.9.1 3.4.8 1 6.4c-1 2.5-1 5.3-1 7.6 0 1.9.1 5.3 1.7 7.5l.1.1v2.9c0 .5.4.7.8.5l2.7-1.1c1 .3 5.7 1.5 10.3-.1 2.6-.9 5.9-3.3 6.7-8.5.8-5.7-.3-9.4-2.6-11.4A13 13 0 0 0 11.4 0Zm.2 2c2 0 4.2.5 5.8 1.8 1.9 1.6 2.7 4.6 2 9.5-.6 4.2-3.2 6.1-5.2 6.8-3.9 1.4-8 .4-9 .1l-.2-.1L3 21v-2.4l-.2-.2C1.5 16.9 1 14 1 14c-.1-2.2 0-4.8.9-6.9C3.8 2.7 8.7 2 11.6 2ZM8.3 5C8 5 7.6 5.2 7.3 5.3 6.9 5.5 6 6.4 6 8.3c0 2 1.2 3.9 1.4 4.2 0 0 2.3 3.6 5.7 4.9.6.2 1 .3 1.4.4.6.1 1.1.1 1.5 0 .7-.1 2.2-.9 2.5-1.8.2-.5.2-1 .1-1.2-.1-.1-.2-.1-.4-.2-.3-.2-2-1-2.3-1.1-.3-.1-.5-.2-.7 0-.2.2-.8.9-1 1.1-.2.2-.3.2-.5.1-.3-.1-1-.4-2-1.3a7.5 7.5 0 0 1-1.4-1.9c-.1-.2 0-.4.1-.5l.5-.5c.1-.2.2-.3.3-.5v-.5l-1-2.3c-.1-.4-.3-.5-.5-.5H8.3Z" fill="#5B6470"/></svg>',
            ];
            $siteSocialLabels = ['telegram' => 'Телеграм', 'max' => 'Max', 'vichat' => 'Вичат', 'whatsapp' => 'WhatsApp', 'viber' => 'Viber'];
        @endphp
        <a href="tel:{{ preg_replace('/[^+\d]/', '', $sitePhone) }}" class="topbar-phone">{{ $sitePhone }}</a>
        <a href="mailto:{{ $siteEmail }}" class="topbar-email">{{ $siteEmail }}</a>

        <div class="social-row">
            @foreach ($siteSocials as $social)
                @if (!empty($social['enabled']))
                    <a href="{{ $social['href'] ?? '#' }}" class="social-circle" aria-label="{{ $siteSocialLabels[$social['type']] ?? $social['type'] }}">{!! $siteSocialSvgs[$social['type']] ?? '' !!}</a>
                @endif
            @endforeach
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
                <span class="header-count" data-favorites-count @if ($siteFavoriteCount <= 0) hidden @endif>{{ $siteFavoriteCount }}</span>
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
