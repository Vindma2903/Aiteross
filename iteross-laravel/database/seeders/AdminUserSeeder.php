<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@iteross.ru'],
            [
                'first_name' => 'Админ',
                'last_name' => 'Iteross',
                'company_name' => 'ООО АЙТЕРОСС',
                'phone' => '+7 (999) 000-00-00',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
            ]
        );
    }
}
