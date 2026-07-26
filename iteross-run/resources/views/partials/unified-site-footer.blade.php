@php
    $siteFooterNavItems = [
        ['label' => 'Каталог', 'href' => route('catalog.index')],
        ['label' => 'О компании', 'href' => url('/#about')],
        ['label' => 'Контакты', 'href' => url('/#footer')],
    ];
@endphp

<footer class="unified-site-footer" id="footer">
    <div class="container unified-site-footer__top">
        <div class="unified-site-footer__grid">
            <div>
                <div class="unified-site-footer__brand">АЙТЕРОСС</div>
                <p class="unified-site-footer__copy">Поставка твердосплавного инструмента для металлообработки. Работаем с юридическими лицами по всей России.</p>
                <div class="unified-site-footer__socials">
                    <a href="#" class="social-circle" aria-label="Telegram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 4.5 3 11.3c-.5.2-.5.9 0 1.1l4.4 1.5 1.7 5.3c.2.5.8.6 1.1.2l2.4-2.6 4.5 3.3c.5.4 1.2.1 1.3-.5l3-13.6c.1-.6-.5-1.1-1-.8Z" stroke="#5B6470" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="#" class="social-circle" aria-label="WhatsApp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z" stroke="#5B6470" stroke-width="1.6"/><path d="M8.5 8.8c.3-.6.6-.6.9-.6h.6c.2 0 .5 0 .7.5.2.6.7 1.8.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.2.7.3.5 1.1 1.4 2.3 2 .3.2.5.1.7-.1.2-.2.7-.7.9-1 .2-.2.4-.2.6-.1.2.1 1.5.7 1.7.8.2.1.4.2.4.4 0 .2 0 1-.4 1.4-.4.5-1.4.8-2.4.5-1.6-.4-3.1-1.3-4.3-2.5-1-1-1.7-2-2.1-3-.2-.5-.1-1 .1-1.4Z" fill="#5B6470"/></svg>
                    </a>
                    <a href="#" class="social-circle" aria-label="VK">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 6c.3 8 4 13 11 13h1v-4l3 4h2c0-3-2-4-2-6 0-1 2-2 2-7h-3c0 3-2 6-3 6-1 0-1-3-1-6H8c0 3 1 6 0 6-1 0-2-3-2-6H4z" stroke="#5B6470" stroke-width="1.2" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <div class="unified-site-footer__title">НАВИГАЦИЯ</div>
                <div class="unified-site-footer__nav">
                    @foreach ($siteFooterNavItems as $item)
                        <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="unified-site-footer__title">КОНТАКТЫ</div>
                <div class="unified-site-footer__contact">
                    <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                    <a href="mailto:info@iteross.ru">info@iteross.ru</a>
                    <div>г. Москва, Дербеневская ул., 12, стр. 3</div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 13.5px;">Пн-Пт, 9:00-18:00</div>
                </div>
            </div>

            <div>
                <div class="unified-site-footer__title">РЕКВИЗИТЫ</div>
                <div class="unified-site-footer__legal">
                    <div>ООО «АЙТЕРОСС»</div>
                    <div>ИНН 7700000000</div>
                    <div>ОГРН 1157700000000</div>
                    <div>КПП 770001001</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container unified-site-footer__bottom">© 2026 ООО «АЙТЕРОСС». Все права защищены.</div>
</footer>
