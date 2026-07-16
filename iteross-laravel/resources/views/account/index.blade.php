@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="dashboard">
        <header class="dashboard-header">
            <div class="dashboard-header__inner">
                <a href="/" class="brand">АЙТЕРОСС</a>
                <div class="dashboard-spacer"></div>
                <a href="/catalog" class="dashboard-link">Каталог</a>
                <a href="/" class="dashboard-link">На главную</a>
            </div>
        </header>

        <div class="dashboard-grid">
            <aside class="sidebar-card">
                <div class="sidebar-title">{{ auth()->user()->name }}</div>
                <div class="sidebar-subtitle">{{ auth()->user()->company_name }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">Выйти</button>
                </form>
            </aside>

            <div class="stack">
                <section class="content-card">
                    <h1 class="section-title">Данные профиля</h1>

                    @if (session('status') === 'profile-updated')
                        <div class="flash-box flash-box--success">Профиль сохранён.</div>
                    @endif

                    <form method="POST" action="{{ route('account.profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="profile-grid">
                            <div class="field">
                                <label>ИМЯ</label>
                                <input name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                            </div>
                            <div class="field">
                                <label>ФАМИЛИЯ</label>
                                <input name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" required>
                            </div>
                        </div>

                        <div class="field">
                            <label>КОМПАНИЯ</label>
                            <input name="company_name" value="{{ old('company_name', auth()->user()->company_name) }}" required>
                        </div>

                        <div class="field">
                            <label>ПОЧТА</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <div class="field" style="margin-bottom: 24px;">
                            <label>ТЕЛЕФОН</label>
                            <input name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                        </div>

                        <button type="submit" class="button-primary" style="max-width: 280px;">Сохранить изменения</button>
                    </form>
                </section>

                <section class="content-card">
                    <h2 class="auth-title" style="font-size: 24px; margin-bottom: 20px;">Смена пароля</h2>

                    @if (session('status') === 'password-updated')
                        <div class="flash-box flash-box--success">Пароль обновлён.</div>
                    @endif

                    <form method="POST" action="{{ route('account.password.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="field">
                            <label>НОВЫЙ ПАРОЛЬ</label>
                            <input type="password" name="password" required>
                        </div>

                        <div class="field" style="margin-bottom: 24px;">
                            <label>ПОВТОРИТЕ НОВЫЙ ПАРОЛЬ</label>
                            <input type="password" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="button-primary" style="max-width: 280px;">Изменить пароль</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
