@extends('layouts.app', ['title' => 'Админка'])

@section('content')
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="brand" style="display: inline-block; margin-bottom: 6px;">АЙТЕРОСС</div>
            <div class="sidebar-subtitle">Панель администратора</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Выйти</button>
            </form>
        </aside>

        <main class="admin-main">
            <div class="admin-panel">
                <h1 class="section-title">Панель администратора</h1>

                <div class="admin-stat-grid">
                    <div class="admin-stat">
                        <div class="admin-stat__label">Пользователи</div>
                        <div class="admin-stat__value">{{ \App\Models\User::where('role', 'user')->count() }}</div>
                    </div>
                    <div class="admin-stat">
                        <div class="admin-stat__label">Администраторы</div>
                        <div class="admin-stat__value">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                    </div>
                    <div class="admin-stat">
                        <div class="admin-stat__label">Текущий пользователь</div>
                        <div class="admin-stat__value" style="font-size: 18px;">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
