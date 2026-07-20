<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\GetHomePageContent;
use App\Modules\Catalog\Application\UseCases\GetCatalogCategories;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function __invoke(
        Request $request,
        GetCatalogCategories $getCatalogCategories,
        GetFavoriteProductIdsForRequest $getFavoriteProductIdsForRequest,
        GetHomePageContent $getHomePageContent,
    ): Response {
        $homeHtml = file_get_contents(public_path('home.html'));
        $categories = $getCatalogCategories->handle();
        $homePageContent = $getHomePageContent->handle();

        $replacements = [
            './Р С™Р В°РЎвЂљР В°Р В»Р С•Р С–.dc.html' => route('catalog.index'),
            'Р С™Р В°РЎвЂљР В°Р В»Р С•Р С–.dc.html' => route('catalog.index'),
            './Каталог.dc.html' => route('catalog.index'),
            'Каталог.dc.html' => route('catalog.index'),
            './Р вЂњР В»Р В°Р Р†Р Р…Р В°РЎРЏ Р С’Р в„ўР СћР вЂўР В Р С›Р РЋР РЋ.dc.html#about' => '/#about',
            './Р вЂњР В»Р В°Р Р†Р Р…Р В°РЎРЏ Р С’Р в„ўР СћР вЂўР В Р С›Р РЋР РЋ.dc.html#footer' => '/#footer',
            './Р вЂњР В»Р В°Р Р†Р Р…Р В°РЎРЏ Р С’Р в„ўР СћР вЂўР В Р С›Р РЋР РЋ.dc.html#lead-form-section' => '/#lead-form-section',
            './Р вЂњР В»Р В°Р Р†Р Р…Р В°РЎРЏ Р С’Р в„ўР СћР вЂўР В Р С›Р РЋР РЋ.dc.html' => '/',
            './Главная АЙТЕРОСС.dc.html#about' => '/#about',
            './Главная АЙТЕРОСС.dc.html#footer' => '/#footer',
            './Главная АЙТЕРОСС.dc.html#lead-form-section' => '/#lead-form-section',
            './Главная АЙТЕРОСС.dc.html' => '/',
            './Р С’Р Р†РЎвЂљР С•РЎР‚Р С‘Р В·Р В°РЎвЂ Р С‘РЎРЏ.dc.html' => route('login'),
            './Р В Р ВµР С–Р С‘РЎРѓРЎвЂљРЎР‚Р В°РЎвЂ Р С‘РЎРЏ.dc.html' => route('register'),
            './Р вЂєР С‘РЎвЂЎР Р…РЎвЂ№Р в„– Р С”Р В°Р В±Р С‘Р Р…Р ВµРЎвЂљ.dc.html' => route('account'),
            './Авторизация.dc.html' => route('login'),
            './Регистрация.dc.html' => route('register'),
            './Личный кабинет.dc.html' => route('account'),
        ];

        $homeHtml = str_replace(array_keys($replacements), array_values($replacements), $homeHtml);

        $authPayload = [
            'authenticated' => auth()->check(),
            'user' => auth()->user() ? [
                'name' => auth()->user()->name,
                'first_name' => auth()->user()->first_name,
                'role' => auth()->user()->role,
            ] : null,
            'favoritesCount' => count($getFavoriteProductIdsForRequest->handle($request)),
            'urls' => [
                'login' => route('login'),
                'account' => route('account'),
                'admin' => route('admin.dashboard'),
                'logout' => route('logout'),
                'catalog' => route('catalog.index'),
                'favorites' => route('favorites.index'),
            ],
            'categories' => $categories->map(fn (Category $category) => [
                'name' => $category->name,
                'slug' => $category->slug,
                'productsCount' => $category->products_count,
            ])->values()->all(),
            'page' => $homePageContent,
            'csrf' => csrf_token(),
        ];

        $script = <<<'HTML'
<script>
window.__ITEROSS_AUTH__ = __AUTH_PAYLOAD__;

(function () {
  const auth = window.__ITEROSS_AUTH__ || {};
  const page = auth.page || {};
  const catalogSectionTitle = 'Каталог металлорежущего инструмента';

  function escapeHtml(value) {
    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function scrollToLeadForm() {
    const target = document.getElementById('lead-form-section');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function iconSet(type, name) {
    const blue = '#1657C4';
    const navy = '#0B2545';
    const icons = {
      header: {
        layers: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none"><rect x="6" y="3" width="13" height="13" rx="2" stroke="' + blue + '" stroke-width="1.5"/><path d="M3 8v11a2 2 0 0 0 2 2h11" stroke="' + blue + '" stroke-width="1.5" stroke-linecap="round"/></svg>',
        tag: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M3 11.5V5a2 2 0 0 1 2-2h6.5L21 11.5a2 2 0 0 1 0 2.8l-6.7 6.7a2 2 0 0 1-2.8 0L3 12.8Z" stroke="' + blue + '" stroke-width="1.5"/><circle cx="8" cy="8" r="1.4" fill="' + blue + '"/></svg>',
        store: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M4 21V11M20 21V11M2 11l2.5-7h15L22 11M2 11h20M8 21v-5h8v5" stroke="' + blue + '" stroke-width="1.4" stroke-linejoin="round"/><path d="M12 4v3" stroke="' + blue + '" stroke-width="1.4"/></svg>',
        box: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M12 3 L21 8 V16 L12 21 L3 16 V8 Z" stroke="' + blue + '" stroke-width="1.5" stroke-linejoin="round"/><path d="M3 8l9 5 9-5M12 13v8" stroke="' + blue + '" stroke-width="1.5" stroke-linejoin="round"/></svg>',
        gear: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3.2" stroke="' + blue + '" stroke-width="1.5"/><path d="M12 3v2.2M12 18.8V21M21 12h-2.2M5.2 12H3M18.4 5.6l-1.6 1.6M7.2 16.8l-1.6 1.6M18.4 18.4l-1.6-1.6M7.2 7.2 5.6 5.6" stroke="' + blue + '" stroke-width="1.5" stroke-linecap="round"/></svg>'
      },
      advantage: {
        doc: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M7 3h7l4 4v14H7z" stroke="' + navy + '" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 3v4h4M9 12h6M9 16h6" stroke="' + navy + '" stroke-width="1.6" stroke-linecap="round"/></svg>',
        box: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M3 8l9-5 9 5-9 5-9-5z" stroke="' + navy + '" stroke-width="1.6" stroke-linejoin="round"/><path d="M3 8v8l9 5 9-5V8M12 13v8" stroke="' + navy + '" stroke-width="1.6" stroke-linejoin="round"/></svg>',
        swap: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M4 7h13l-3-3M20 17H7l3 3" stroke="' + navy + '" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        truck: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M2 6h11v10H2zM13 10h5l3 3v3h-8z" stroke="' + navy + '" stroke-width="1.6" stroke-linejoin="round"/><circle cx="6.5" cy="18" r="1.7" stroke="' + navy + '" stroke-width="1.6"/><circle cx="17" cy="18" r="1.7" stroke="' + navy + '" stroke-width="1.6"/></svg>',
        support: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="' + navy + '" stroke-width="1.6"/><circle cx="12" cy="12" r="3.4" stroke="' + navy + '" stroke-width="1.6"/><path d="M5.5 5.5l3 3M18.5 5.5l-3 3M5.5 18.5l3-3M18.5 18.5l-3-3" stroke="' + navy + '" stroke-width="1.6"/></svg>',
        shield: '<svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z" stroke="' + navy + '" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="' + navy + '" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>'
      },
      workType: {
        turn: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="7.5" stroke="' + navy + '" stroke-width="1.4"/><circle cx="12" cy="12" r="2.6" fill="' + navy + '"/></svg>',
        mill: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 3l2 4 4.5.6-3.2 3.2 1 4.4L12 13l-4.3 2.2 1-4.4L5.5 7.6 10 7z" stroke="' + navy + '" stroke-width="1.4" stroke-linejoin="round"/></svg>',
        groove: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="4" y="9" width="16" height="6" rx="1.5" stroke="' + navy + '" stroke-width="1.4"/><path d="M9 9v6M14 9v6" stroke="' + navy + '" stroke-width="1.4"/></svg>',
        thread: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M8 3c4 2 4 4 0 6s-4 4 0 6 4 4 0 6" stroke="' + navy + '" stroke-width="1.4"/></svg>',
        drill: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 2v14M8 12l4 4 4-4" stroke="' + navy + '" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="19" r="2.4" stroke="' + navy + '" stroke-width="1.4"/></svg>',
        shield: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z" stroke="' + navy + '" stroke-width="1.5" stroke-linejoin="round"/></svg>'
      }
    };

    return (icons[type] && icons[type][name]) || '';
  }

  function buildUserMenu(link) {
    if (!auth.authenticated || !link || link.dataset.authEnhanced === '1') {
      return;
    }

    link.dataset.authEnhanced = '1';

    const wrapper = document.createElement('div');
    wrapper.style.position = 'relative';
    wrapper.style.display = 'flex';
    wrapper.style.alignItems = 'center';

    const button = document.createElement('button');
    button.type = 'button';
    button.style.width = '44px';
    button.style.height = '44px';
    button.style.border = '1px solid #D6DAE0';
    button.style.borderRadius = '999px';
    button.style.background = '#F7F8FA';
    button.style.display = 'flex';
    button.style.alignItems = 'center';
    button.style.justifyContent = 'center';
    button.style.cursor = 'pointer';
    button.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.6" stroke="#1657C4" stroke-width="1.7"></circle><path d="M4.5 20c1.4-3.8 4.6-5.8 7.5-5.8s6.1 2 7.5 5.8" stroke="#1657C4" stroke-width="1.7" stroke-linecap="round"></path></svg>';

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
    const isAdmin = auth.user && auth.user.role === 'admin';
    accountLink.href = isAdmin ? auth.urls.admin : auth.urls.account;
    accountLink.textContent = isAdmin ? 'Админка' : 'Личный кабинет';
    accountLink.style.display = 'block';
    accountLink.style.padding = '10px 12px';
    accountLink.style.borderRadius = '10px';
    accountLink.style.textDecoration = 'none';
    accountLink.style.color = '#14161A';
    accountLink.style.fontSize = '14px';
    accountLink.style.fontWeight = '600';

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
    const links = Array.from(document.querySelectorAll('a'));

    const favoriteLink = links.find((anchor) => anchor.getAttribute('href') === '#wish');
    if (favoriteLink) {
      favoriteLink.setAttribute('href', auth.urls.favorites);
    }

    const catalogLink = links.find((anchor) => (anchor.textContent || '').trim() === 'Каталог');
    if (catalogLink) {
      catalogLink.setAttribute('href', auth.urls.catalog);
    }

    const loginLink = links.find((anchor) => {
      const href = anchor.getAttribute('href');
      return href === '#login' || href === auth.urls.login;
    });

    if (loginLink) {
      if (!auth.authenticated) {
        loginLink.setAttribute('href', auth.urls.login);
      } else {
        buildUserMenu(loginLink);
      }
    }
  }

  function patchNavigation() {
    const navItems = Array.isArray(page.header_nav) ? page.header_nav : [];
    const headerNav = document.querySelector('header[data-screen-label="Header"] nav');
    const footerNavTitle = Array.from(document.querySelectorAll('footer div')).find((node) => {
      return (node.textContent || '').trim() === 'НАВИГАЦИЯ';
    });
    const footerNavContainer = footerNavTitle ? footerNavTitle.nextElementSibling : null;

    if (headerNav && navItems.length > 0) {
      headerNav.innerHTML = navItems.map((item) => {
        return '<a href="' + escapeHtml(item.href) + '" style="text-decoration: none; color: #5B6470; font-size: 14.5px; font-weight: 500; white-space: nowrap;">' + escapeHtml(item.label) + '</a>';
      }).join('');
    }

    if (footerNavContainer && navItems.length > 0) {
      footerNavContainer.innerHTML = navItems.map((item) => {
        return '<a href="' + escapeHtml(item.href) + '" style="font-size: 15px; color: rgba(255,255,255,0.8); text-decoration: none;">' + escapeHtml(item.label) + '</a>';
      }).join('');
    }
  }

  function hideCatalogSection() {
    const section = Array.from(document.querySelectorAll('section')).find((node) => {
      return (node.textContent || '').includes(catalogSectionTitle);
    });

    if (section) {
      section.remove();
    }
  }

  function renderHero() {
    const section = document.querySelector('section[data-screen-label="Hero"]');
    if (!section) {
      return;
    }

    const hero = page.hero || {};
    const benefits = Array.isArray(page.hero_benefits) ? page.hero_benefits : [];

    section.innerHTML = `
      <div style="position: relative; min-height: 580px; background: linear-gradient(90deg, rgba(11,37,69,0.88) 0%, rgba(11,37,69,0.64) 48%, rgba(11,37,69,0.18) 100%), url('${escapeHtml(hero.background_image || '')}') center/cover no-repeat;">
        <div style="max-width: 1360px; margin: 0 auto; padding: 88px 32px 72px; display: grid; grid-template-columns: minmax(0, 700px);">
          <div>
            <div style="display: inline-flex; align-items: center; gap: 10px; padding: 9px 16px; border-radius: 999px; background: rgba(255,255,255,0.1); color: #fff; font-size: 13px; font-weight: 600; margin-bottom: 22px;">Металлообработка и серийные поставки</div>
            <h1 style="margin: 0 0 18px; color: #fff; font-size: clamp(40px, 5vw, 66px); line-height: 1.03; letter-spacing: -0.03em;">${escapeHtml(hero.title)}</h1>
            <p style="margin: 0; max-width: 620px; color: rgba(255,255,255,0.86); font-size: 18px; line-height: 1.7;">${escapeHtml(hero.description)}</p>
            <div style="display: flex; flex-wrap: wrap; gap: 14px; margin-top: 30px;">
              <button type="button" data-hero-cta style="background: #1657C4; color: #fff; border: none; border-radius: 999px; padding: 15px 28px; font-size: 15px; font-weight: 700; cursor: pointer;">${escapeHtml(hero.cta_text || 'Оставить заявку')}</button>
              <a href="${escapeHtml(auth.urls.catalog)}" style="display: inline-flex; align-items: center; justify-content: center; padding: 15px 28px; border-radius: 999px; background: rgba(255,255,255,0.12); color: #fff; text-decoration: none; font-size: 15px; font-weight: 700;">Открыть каталог</a>
            </div>
          </div>
        </div>
      </div>
      <div style="max-width: 1360px; margin: -44px auto 0; padding: 0 32px 0; position: relative; z-index: 2;">
        <div style="display: grid; grid-template-columns: repeat(${Math.max(benefits.length, 1)}, minmax(0, 1fr)); gap: 14px;">
          ${benefits.map((item) => `
            <div style="min-height: 96px; border-radius: 20px; background: #fff; border: 1px solid #E3E6EA; box-shadow: 0 24px 48px -32px rgba(11,37,69,0.28); padding: 18px 20px; display: flex; align-items: center; gap: 14px;">
              <div style="width: 56px; height: 56px; border-radius: 16px; background: #EEF4FF; display: flex; align-items: center; justify-content: center; flex: none;">${iconSet('header', item.icon)}</div>
              <div style="font-size: 15px; font-weight: 600; color: #14161A; line-height: 1.45;">${escapeHtml(item.text)}</div>
            </div>
          `).join('')}
        </div>
      </div>
    `;

    const ctaButton = section.querySelector('[data-hero-cta]');
    if (ctaButton) {
      ctaButton.addEventListener('click', scrollToLeadForm);
    }
  }

  function renderAdvantages() {
    const section = document.querySelector('section[data-screen-label="Advantages"]');
    if (!section) {
      return;
    }

    const advantages = page.advantages || {};
    const items = Array.isArray(advantages.items) ? advantages.items : [];

    section.innerHTML = `
      <div style="max-width: 1360px; margin: 0 auto; padding: 94px 32px 24px;">
        <div style="max-width: 720px; margin-bottom: 34px;">
          <h2 style="margin: 0 0 14px; font-size: clamp(34px, 4vw, 48px); line-height: 1.08; color: #14161A;">${escapeHtml(advantages.title)}</h2>
          <p style="margin: 0; color: #5B6470; font-size: 17px; line-height: 1.7;">${escapeHtml(advantages.description)}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px;">
          ${items.map((item) => `
            <article style="padding: 24px; border-radius: 22px; border: 1px solid #E3E6EA; background: #fff; box-shadow: 0 20px 40px -30px rgba(11,37,69,0.18);">
              <div style="width: 54px; height: 54px; border-radius: 16px; background: #F4F7FB; display: flex; align-items: center; justify-content: center; margin-bottom: 18px;">${iconSet('advantage', item.icon)}</div>
              <h3 style="margin: 0 0 10px; font-size: 20px; line-height: 1.3; color: #14161A;">${escapeHtml(item.title)}</h3>
              <p style="margin: 0; color: #5B6470; font-size: 15px; line-height: 1.65;">${escapeHtml(item.text)}</p>
            </article>
          `).join('')}
        </div>
      </div>
    `;
  }

  function renderWorkCards() {
    const section = document.querySelector('section[data-screen-label="Types of work"]') || Array.from(document.querySelectorAll('section')).find((node) => {
      return (node.textContent || '').includes('Виды производимых работ');
    });

    if (!section || !Array.isArray(auth.categories) || auth.categories.length === 0) {
      return;
    }

    const workTypes = page.work_types || {};
    const workTypeItems = workTypes.items || {};

    section.innerHTML = `
      <div style="max-width: 1360px; margin: 0 auto; padding: 88px 32px;">
        <div style="max-width: 700px; margin-bottom: 34px;">
          <h2 style="margin: 0 0 14px; font-size: clamp(34px, 4vw, 46px); line-height: 1.08; color: #14161A;">${escapeHtml(workTypes.title || 'Виды производимых работ')}</h2>
          <p style="margin: 0; color: #5B6470; font-size: 17px; line-height: 1.7;">${escapeHtml(workTypes.description || '')}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px;">
          ${auth.categories.map((category) => {
            const meta = workTypeItems[category.slug] || {};
            const href = auth.urls.catalog.replace(/\/$/, '') + '/' + encodeURIComponent(category.slug);
            return `
              <a href="${escapeHtml(href)}" style="text-decoration: none; border: 1px solid #E3E6EA; border-radius: 20px; background: #fff; overflow: hidden; color: inherit; box-shadow: 0 18px 40px -32px rgba(11,37,69,0.3);">
                <div style="aspect-ratio: 16 / 10; background: #EEF1F4 url('${escapeHtml(meta.image || '')}') center/cover no-repeat;"></div>
                <div style="padding: 22px 22px 24px;">
                  <div style="display: inline-flex; width: 42px; height: 42px; border-radius: 12px; background: #F3F6FA; align-items: center; justify-content: center; margin-bottom: 14px;">${iconSet('workType', meta.icon || 'turn')}</div>
                  <h3 style="margin: 0 0 10px; font-size: 20px; line-height: 1.3; color: #14161A; text-transform: uppercase;">${escapeHtml(category.name)}</h3>
                  <p style="margin: 0; color: #5B6470; font-size: 15px; line-height: 1.65;">${escapeHtml(meta.description || category.name)}</p>
                </div>
              </a>
            `;
          }).join('')}
        </div>
      </div>
    `;
  }

  function renderAbout() {
    const section = document.querySelector('section[data-screen-label="About company"]') || document.getElementById('about');
    if (!section) {
      return;
    }

    const about = page.about || {};
    const stats = Array.isArray(about.stats) ? about.stats : [];

    section.id = 'about';
    section.innerHTML = `
      <div style="max-width: 1360px; margin: 0 auto; padding: 94px 32px;">
        <div style="display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(380px, 0.95fr); gap: 34px; align-items: stretch;">
          <div style="padding: 18px 0;">
            <h2 style="margin: 0 0 12px; font-size: clamp(34px, 4vw, 46px); line-height: 1.08; color: #14161A;">${escapeHtml(about.title)}</h2>
            <p style="margin: 0 0 18px; color: #1657C4; font-size: 17px; font-weight: 600; line-height: 1.6;">${escapeHtml(about.description)}</p>
            <p style="margin: 0; color: #4F5965; font-size: 16px; line-height: 1.75; max-width: 720px;">${escapeHtml(about.text)}</p>
            <div style="display: grid; grid-template-columns: repeat(${Math.max(stats.length, 1)}, minmax(0, 1fr)); gap: 14px; margin-top: 28px;">
              ${stats.map((item) => `
                <div style="padding: 18px 16px; border: 1px solid #E3E6EA; border-radius: 18px; background: #fff;">
                  <div style="font-size: 34px; font-weight: 700; color: #0B2545; line-height: 1;">${escapeHtml(item.value)}</div>
                  <div style="margin-top: 8px; color: #5B6470; font-size: 14px; line-height: 1.5;">${escapeHtml(item.label)}</div>
                </div>
              `).join('')}
            </div>
          </div>
          <div style="min-height: 460px; border-radius: 26px; background: #E7EBF0 url('${escapeHtml(about.image || '')}') center/cover no-repeat;"></div>
        </div>
      </div>
    `;
  }

  function renderFaq() {
    const section = document.querySelector('section[data-screen-label="FAQ"]');
    if (!section) {
      return;
    }

    const faq = page.faq || {};
    const items = Array.isArray(faq.items) ? faq.items : [];

    section.innerHTML = `
      <div style="max-width: 1360px; margin: 0 auto; padding: 76px 32px 94px;">
        <div style="max-width: 760px; margin-bottom: 28px;">
          <h2 style="margin: 0 0 12px; font-size: clamp(34px, 4vw, 46px); line-height: 1.08; color: #14161A;">${escapeHtml(faq.title)}</h2>
          <p style="margin: 0; color: #5B6470; font-size: 17px; line-height: 1.7;">${escapeHtml(faq.description)}</p>
        </div>
        <div style="display: grid; gap: 14px;">
          ${items.map((item) => `
            <details style="border: 1px solid #E3E6EA; border-radius: 18px; background: #fff; padding: 0 22px;">
              <summary style="list-style: none; cursor: pointer; padding: 22px 0; font-size: 18px; font-weight: 700; color: #14161A;">${escapeHtml(item.question)}</summary>
              <div style="padding: 0 0 20px; color: #5B6470; font-size: 15px; line-height: 1.7;">${escapeHtml(item.answer)}</div>
            </details>
          `).join('')}
        </div>
      </div>
    `;
  }

  function boot() {
    enhanceHeader();
    patchNavigation();
    hideCatalogSection();
    renderHero();
    renderAdvantages();
    renderWorkCards();
    renderAbout();
    renderFaq();

    const observer = new MutationObserver(function () {
      enhanceHeader();
      patchNavigation();
    });

    observer.observe(document.documentElement, { childList: true, subtree: true });
    setTimeout(function () {
      observer.disconnect();
      enhanceHeader();
      patchNavigation();
    }, 3000);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
</script>
HTML;

        $script = str_replace(
            '__AUTH_PAYLOAD__',
            json_encode($authPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            $script,
        );

        $homeHtml = str_replace('</body>', $script.'</body>', $homeHtml);

        return response($homeHtml, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
