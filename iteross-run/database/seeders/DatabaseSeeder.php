<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(AdminUserSeeder::class);

        User::query()->updateOrCreate([
            'email' => 'v9957820668@gmail.com',
        ], [
            'name' => 'Обычный пользователь',
            'first_name' => 'Обычный',
            'last_name' => 'Пользователь',
            'company' => 'АЙТЕРОСС',
            'phone' => '+7 (999) 582-06-68',
            'role' => User::ROLE_USER,
            'email' => 'v9957820668@gmail.com',
            'password' => 'Art29031705%',
        ]);
    }
}
