<?php

namespace Database\Seeders;

use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@iteross.ru',
        ], [
            'name' => 'Админ Iteross',
            'first_name' => 'Админ',
            'last_name' => 'Iteross',
            'company' => 'АЙТЕРОСС',
            'phone' => '+7 (999) 000-00-00',
            'role' => User::ROLE_ADMIN,
            'password' => 'password',
        ]);
    }
}
