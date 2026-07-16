# Iteross Laravel Auth

Laravel backend skeleton for the existing Iteross auth pages.

Stack:
- Laravel 12 style structure
- Blade templates
- Vue 3
- Pinia
- Session-based authentication
- Roles: `admin`, `user`

## What is included

- Separate login pages for user and admin
- User registration
- Session login/logout
- Role middleware
- User dashboard and admin dashboard routes
- Vue + Pinia auth forms mounted inside Blade templates

## Project structure

- `app/Http/Controllers/Auth/*`
- `app/Http/Middleware/EnsureRole.php`
- `app/Models/User.php`
- `database/migrations/*`
- `database/seeders/AdminUserSeeder.php`
- `resources/views/*`
- `resources/js/*`
- `routes/web.php`

## Required local setup

This workspace does not currently have `php` or `composer`, so the app was scaffolded manually and not executed here.

To run locally:

1. Install PHP 8.2+ and Composer.
2. Create a fresh Laravel app or use this folder as a base.
3. Install dependencies:

```bash
composer install
npm install
```

4. Copy environment file:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in `.env`.
6. Run migrations and seed admin:

```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

7. Start dev servers:

```bash
php artisan serve
npm run dev
```

## Default routes

- `/login` user login
- `/register` user registration
- `/admin/login` admin login
- `/account` user account
- `/admin` admin dashboard
- `/logout` logout

## Default seeded admin

- Email: `admin@iteross.ru`
- Password: `password`

Change it immediately after first login.
