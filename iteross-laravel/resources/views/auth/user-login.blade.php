@extends('layouts.app', ['title' => 'Авторизация', 'appName' => 'user-login'])

@section('content')
    <script>
        window.__ITEROSS__ = {
            csrf: @json(csrf_token()),
            action: @json(route('login.store')),
            errors: @json($errors->toArray()),
            old: @json([
                'email' => old('email', ''),
            ]),
        };
    </script>

    <div class="auth-shell">
        <header class="simple-header">
            <div class="simple-header__inner">
                <a href="/" class="brand">АЙТЕРОСС</a>
            </div>
        </header>

        <div class="auth-center">
            <div class="auth-card">
                <h1 class="auth-title">Вход в личный кабинет</h1>
                <p class="auth-subtitle">Доступ для юридических лиц: история заявок, избранное и статусы заказов.</p>

                <div id="app"></div>

                <div class="auth-footer-link">
                    <a href="{{ route('register') }}">Ещё не зарегистрированы? Регистрация</a>
                </div>
            </div>
        </div>
    </div>
@endsection
