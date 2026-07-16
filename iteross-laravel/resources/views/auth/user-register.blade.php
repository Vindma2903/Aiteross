@extends('layouts.app', ['title' => 'Регистрация', 'appName' => 'user-register'])

@section('content')
    <script>
        window.__ITEROSS__ = {
            csrf: @json(csrf_token()),
            action: @json(route('register.store')),
            errors: @json($errors->toArray()),
            old: @json([
                'first_name' => old('first_name', ''),
                'last_name' => old('last_name', ''),
                'company_name' => old('company_name', ''),
                'phone' => old('phone', ''),
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
                <h1 class="auth-title">Регистрация</h1>
                <p class="auth-subtitle">Создайте личный кабинет — работаем только с юридическими лицами.</p>

                <div id="app"></div>

                <div class="auth-footer-link">
                    <a href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
                </div>
            </div>
        </div>
    </div>
@endsection
