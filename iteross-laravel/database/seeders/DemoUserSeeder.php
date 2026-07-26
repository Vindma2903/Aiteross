<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@iteross.ru'],
            [
                'first_name' => 'Иван',
                'last_name' => 'Иванов',
                'company_name' => 'ООО ИТЕРОСС',
                'phone' => '+7 (999) 111-22-33',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_USER,
            ]
        );
    }
}
