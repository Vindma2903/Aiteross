@extends('layouts.app', ['title' => 'Вход администратора', 'appName' => 'admin-login'])

@section('content')
    <script>
        window.__ITEROSS__ = {
            csrf: @json(csrf_token()),
            action: @json(route('admin.login.store')),
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
                <h1 class="auth-title">Вход для администратора</h1>
                <p class="auth-subtitle">Доступ только для сотрудников АЙТЕРОСС.</p>

                <div id="app"></div>
            </div>
        </div>
    </div>
@endsection
