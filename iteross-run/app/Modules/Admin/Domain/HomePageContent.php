<?php

namespace App\Modules\Admin\Domain;

final class HomePageContent
{
    public const ICON_OPTIONS = [
        'header' => [
            'layers' => 'Слои',
            'tag' => 'Метка',
            'store' => 'Склад',
            'box' => 'Коробка',
            'gear' => 'Шестеренка',
        ],
        'advantage' => [
            'doc' => 'Документ',
            'box' => 'Коробка',
            'swap' => 'Обмен',
            'truck' => 'Грузовик',
            'support' => 'Поддержка',
            'shield' => 'Щит',
        ],
        'work_type' => [
            'turn' => 'Токарная',
            'mill' => 'Фрезерная',
            'groove' => 'Канавочная',
            'thread' => 'Резьбовая',
            'drill' => 'Сверлильная',
        ],
    ];

    public static function defaults(): array
    {
        return [
            'header_nav' => [
                ['label' => 'О компании', 'href' => '/#about'],
                ['label' => 'Условия покупки', 'href' => '/#about'],
                ['label' => 'Контакты', 'href' => '/#footer'],
            ],
            'hero' => [
                'title' => 'Твердосплавные пластины для станков с ЧПУ',
                'description' => 'Поставки, подбор аналогов и стабильные партии от 10 шт. для производств, которым важна предсказуемость.',
                'cta_text' => 'Получить предложение',
                'background_image' => 'https://images.unsplash.com/photo-1666618090858-fbcee636bd3e?fm=jpg&q=80&w=1600&auto=format&fit=crop',
            ],
            'hero_benefits' => [
                ['icon' => 'layers', 'text' => 'Линейка продукции на все задачи'],
                ['icon' => 'tag', 'text' => 'Низкая цена'],
                ['icon' => 'store', 'text' => 'Склад и офис продаж в Москве'],
                ['icon' => 'box', 'text' => 'Оперативная доставка'],
                ['icon' => 'gear', 'text' => 'Инженер-технолог для сложных задач'],
            ],
            'advantages' => [
                'title' => 'Почему с нами работают производства',
                'description' => 'Подбираем инструмент под реальную задачу, а не просто отгружаем позиции со склада.',
                'items' => [
                    [
                        'icon' => 'doc',
                        'title' => 'Только юридическим лицам',
                        'text' => 'Работаем по договору и счёту, с закрывающими документами для бухгалтерии.',
                    ],
                    [
                        'icon' => 'box',
                        'title' => 'Партии от 10 шт.',
                        'text' => 'Удобно для тестовых закупок и планового пополнения склада.',
                    ],
                    [
                        'icon' => 'swap',
                        'title' => 'Подбор аналогов',
                        'text' => 'Подберём замену пластинам Sandvik, ISCAR, Walter и Kennametal.',
                    ],
                    [
                        'icon' => 'truck',
                        'title' => 'Поставка по всей России',
                        'text' => 'Отгружаем транспортными компаниями в любой регион.',
                    ],
                    [
                        'icon' => 'support',
                        'title' => 'Техническая консультация',
                        'text' => 'Инженер поможет выбрать геометрию, покрытие и марку сплава.',
                    ],
                    [
                        'icon' => 'shield',
                        'title' => 'Стабильное наличие',
                        'text' => 'Держим ходовые позиции, чтобы не срывать сроки производства.',
                    ],
                ],
            ],
            'work_types' => [
                'title' => 'Виды производимых работ',
                'description' => 'Твердосплавные сменные пластины по типу обработки на станках с ЧПУ.',
                'items' => [
                    'tokarnye-plastiny' => [
                        'icon' => 'turn',
                        'image' => 'https://images.unsplash.com/photo-1666618090858-fbcee636bd3e?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                        'description' => 'Точение валов, втулок и тел вращения на станках с ЧПУ.',
                    ],
                    'frezernye-plastiny' => [
                        'icon' => 'mill',
                        'image' => 'https://images.unsplash.com/photo-1570207344214-c60ad57f3c00?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                        'description' => 'Торцевое и концевое фрезерование корпусных деталей, плоскостей и пазов.',
                    ],
                    'kanavochnye-plastiny' => [
                        'icon' => 'groove',
                        'image' => 'https://images.unsplash.com/photo-1776090188130-26c7253ff423?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                        'description' => 'Протачивание канавок, отрезка и обработка узких пазов.',
                    ],
                    'rezbovye-plastiny' => [
                        'icon' => 'thread',
                        'image' => 'https://images.unsplash.com/photo-1666618090858-fbcee636bd3e?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                        'description' => 'Нарезание наружной и внутренней резьбы различного профиля.',
                    ],
                    'sverlilnye-plastiny' => [
                        'icon' => 'drill',
                        'image' => 'https://images.unsplash.com/photo-1570207344214-c60ad57f3c00?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                        'description' => 'Сверление отверстий в стали, чугуне и нержавеющих сталях.',
                    ],
                    'obrabotka-nerzhaveyuschih-i-zharoprochnyh-staley' => [
                        'icon' => 'shield',
                        'image' => 'https://images.unsplash.com/photo-1776090188130-26c7253ff423?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                        'description' => 'Подбор пластин и режимов резания для труднообрабатываемых материалов.',
                    ],
                ],
            ],
            'about' => [
                'title' => 'О компании',
                'description' => 'Поставляем твердосплавный инструмент для металлообработки и помогаем производствам удерживать стабильность в закупках.',
                'text' => 'Работаем с юридическими лицами по всей России. Подбираем аналоги, консультируем по режимам резания и закрываем потребность как в ходовых, так и в специальных позициях.',
                'image' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?fm=jpg&q=80&w=1200&auto=format&fit=crop',
                'stats' => [
                    ['value' => '300+', 'label' => 'позиций в каталоге'],
                    ['value' => '10+', 'label' => 'лет в B2B-поставках'],
                    ['value' => '100%', 'label' => 'работа по договору и счёту'],
                ],
            ],
            'faq' => [
                'title' => 'Частые вопросы',
                'description' => 'Собрали ответы на вопросы, которые чаще всего возникают перед первой закупкой.',
                'items' => [
                    [
                        'question' => 'Какая минимальная партия заказа?',
                        'answer' => 'Минимальная партия — 10 пластин по одному артикулу.',
                    ],
                    [
                        'question' => 'Как оформить заказ?',
                        'answer' => 'Выберите нужные позиции в каталоге и отправьте заявку через форму на сайте.',
                    ],
                    [
                        'question' => 'Есть ли доставка по России?',
                        'answer' => 'Да, отгружаем транспортными компаниями в любой регион России.',
                    ],
                    [
                        'question' => 'Как подобрать аналог пластины?',
                        'answer' => 'Укажите артикул текущего поставщика в комментарии к заявке, и инженер подберёт аналог.',
                    ],
                ],
            ],
        ];
    }
}
