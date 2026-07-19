<?php

use App\Application\Favorites\FavoriteService;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request, FavoriteService $favoriteService) {
    $homeHtml = file_get_contents(public_path('home.html'));

    $authPayload = [
        'authenticated' => auth()->check(),
        'user' => auth()->user() ? [
            'name' => auth()->user()->name,
            'first_name' => auth()->user()->first_name,
        ] : null,
        'favoritesCount' => count($favoriteService->favoriteProductIds($request)),
        'urls' => [
            'login' => route('login'),
            'account' => route('account'),
            'logout' => route('logout'),
            'catalog' => route('catalog.index'),
            'favorites' => route('favorites.index'),
        ],
        'csrf' => csrf_token(),
    ];

    $authScript = <<<'HTML'
<script>
window.__ITEROSS_AUTH__ = __AUTH_PAYLOAD__;

(function () {
  function buildUserMenu(link) {
    const auth = window.__ITEROSS_AUTH__;
    if (!auth || !auth.authenticated || !link || link.dataset.authEnhanced === '1') {
      return;
    }

    link.dataset.authEnhanced = '1';

    const wrapper = document.createElement('div');
    wrapper.style.position = 'relative';
    wrapper.style.display = 'flex';
    wrapper.style.alignItems = 'center';
    wrapper.style.flex = 'none';

    const button = document.createElement('button');
    button.type = 'button';
    button.setAttribute('aria-label', 'Профиль пользователя');
    button.style.width = '44px';
    button.style.height = '44px';
    button.style.border = '1px solid #D6DAE0';
    button.style.borderRadius = '999px';
    button.style.background = '#F7F8FA';
    button.style.display = 'flex';
    button.style.alignItems = 'center';
    button.style.justifyContent = 'center';
    button.style.cursor = 'pointer';
    button.style.transition = 'background 0.15s ease, border-color 0.15s ease';
    button.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"></circle><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"></path></svg>';
    button.addEventListener('mouseenter', function () {
      button.style.background = '#EEF4FF';
      button.style.borderColor = '#B7CCF3';
    });
    button.addEventListener('mouseleave', function () {
      button.style.background = '#F7F8FA';
      button.style.borderColor = '#D6DAE0';
    });

    const menu = document.createElement('div');
    menu.hidden = true;
    menu.style.position = 'absolute';
    menu.style.top = '56px';
    menu.style.right = '0';
    menu.style.minWidth = '220px';
    menu.style.padding = '14px';
    menu.style.borderRadius = '14px';
    menu.style.border = '1px solid #E3E6EA';
    menu.style.background = '#FFFFFF';
    menu.style.boxShadow = '0 24px 48px -24px rgba(11, 37, 69, 0.32)';
    menu.style.zIndex = '250';

    const userName = document.createElement('div');
    userName.textContent = auth.user && (auth.user.first_name || auth.user.name) ? (auth.user.first_name || auth.user.name) : 'Пользователь';
    userName.style.fontSize = '14px';
    userName.style.fontWeight = '700';
    userName.style.color = '#14161A';
    userName.style.marginBottom = '10px';

    const accountLink = document.createElement('a');
    accountLink.href = auth.urls.account;
    accountLink.textContent = 'Личный кабинет';
    accountLink.style.display = 'block';
    accountLink.style.padding = '10px 12px';
    accountLink.style.borderRadius = '10px';
    accountLink.style.textDecoration = 'none';
    accountLink.style.color = '#14161A';
    accountLink.style.fontSize = '14px';
    accountLink.style.fontWeight = '600';
    accountLink.addEventListener('mouseenter', function () {
      accountLink.style.background = '#F5F7FB';
    });
    accountLink.addEventListener('mouseleave', function () {
      accountLink.style.background = 'transparent';
    });

    const logoutForm = document.createElement('form');
    logoutForm.method = 'post';
    logoutForm.action = auth.urls.logout;
    logoutForm.style.marginTop = '6px';

    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = auth.csrf;

    const logoutButton = document.createElement('button');
    logoutButton.type = 'submit';
    logoutButton.textContent = 'Выйти';
    logoutButton.style.width = '100%';
    logoutButton.style.border = 'none';
    logoutButton.style.background = 'transparent';
    logoutButton.style.textAlign = 'left';
    logoutButton.style.padding = '10px 12px';
    logoutButton.style.borderRadius = '10px';
    logoutButton.style.color = '#C0392B';
    logoutButton.style.fontSize = '14px';
    logoutButton.style.fontWeight = '600';
    logoutButton.style.cursor = 'pointer';
    logoutButton.addEventListener('mouseenter', function () {
      logoutButton.style.background = '#FFF5F5';
    });
    logoutButton.addEventListener('mouseleave', function () {
      logoutButton.style.background = 'transparent';
    });

    logoutForm.appendChild(token);
    logoutForm.appendChild(logoutButton);

    menu.appendChild(userName);
    menu.appendChild(accountLink);
    menu.appendChild(logoutForm);

    button.addEventListener('click', function (event) {
      event.preventDefault();
      menu.hidden = !menu.hidden;
    });

    document.addEventListener('click', function (event) {
      if (!wrapper.contains(event.target)) {
        menu.hidden = true;
      }
    });

    wrapper.appendChild(button);
    wrapper.appendChild(menu);
    link.replaceWith(wrapper);
  }

  function enhanceHeader() {
    const auth = window.__ITEROSS_AUTH__;
    const favoriteLink = Array.from(document.querySelectorAll('a')).find(function (anchor) {
      return anchor.getAttribute('href') === '#wish';
    });
    if (favoriteLink) {
      favoriteLink.setAttribute('href', auth.urls.favorites);
      const existingBadge = favoriteLink.querySelector('[data-favorites-count]');
      if (existingBadge) {
        existingBadge.remove();
      }
      if (auth.favoritesCount > 0) {
        const badge = document.createElement('span');
        badge.dataset.favoritesCount = '1';
        badge.textContent = String(auth.favoritesCount);
        badge.style.display = 'inline-flex';
        badge.style.alignItems = 'center';
        badge.style.justifyContent = 'center';
        badge.style.minWidth = '18px';
        badge.style.height = '18px';
        badge.style.padding = '0 6px';
        badge.style.borderRadius = '999px';
        badge.style.background = '#1657C4';
        badge.style.color = '#fff';
        badge.style.fontSize = '11px';
        badge.style.fontWeight = '700';
        favoriteLink.appendChild(badge);
      }
    }

    const catalogLink = Array.from(document.querySelectorAll('a')).find(function (anchor) {
      return anchor.textContent && anchor.textContent.trim() === 'Каталог';
    });
    if (catalogLink) {
      catalogLink.setAttribute('href', auth.urls.catalog);
    }

    const loginLink = Array.from(document.querySelectorAll('a')).find(function (anchor) {
      return anchor.getAttribute('href') === '#login' || anchor.getAttribute('href') === auth.urls.login;
    });

    if (!loginLink) {
      return false;
    }

    if (!auth || !auth.authenticated) {
      loginLink.setAttribute('href', auth.urls.login);
      return true;
    }

    buildUserMenu(loginLink);
    return true;
  }

  function boot() {
    if (enhanceHeader()) {
      return;
    }

    const observer = new MutationObserver(function () {
      if (enhanceHeader()) {
        observer.disconnect();
      }
    });

    observer.observe(document.documentElement, { childList: true, subtree: true });

    setTimeout(function () {
      observer.disconnect();
      enhanceHeader();
    }, 8000);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
</script>
HTML;

    $authScript = str_replace('__AUTH_PAYLOAD__', json_encode($authPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $authScript);
    $homeHtml = str_replace('</body>', $authScript.'</body>', $homeHtml);

    return response($homeHtml, 200)->header('Content-Type', 'text/html; charset=UTF-8');
});

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', function (Request $request) {
        return view('account.index', [
            'user' => $request->user(),
        ]);
    })->name('account');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/pages/{page}', [AdminDashboardController::class, 'editor'])->name('admin.pages.editor');
    Route::post('/admin/catalog/categories', [AdminDashboardController::class, 'updateCatalogCategories'])->name('admin.catalog.categories.update');
    Route::post('/admin/products', [AdminDashboardController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/admin/products/{product}', [AdminDashboardController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminDashboardController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::get('/admin/legacy-products', [AdminDashboardController::class, 'legacyProducts'])->name('admin.legacy.products');
    Route::get('/admin/static-preview/{page}', [AdminDashboardController::class, 'preview'])->name('admin.static.preview');
    Route::get('/admin/legacy-editor/{page}', [AdminDashboardController::class, 'legacyEditor'])->name('admin.legacy.editor');
    Route::get('/admin/static-resource/{path}', [AdminDashboardController::class, 'resource'])
        ->where('path', '.*')
        ->name('admin.static.resource');
});
