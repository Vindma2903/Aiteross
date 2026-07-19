<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Токарные пластины',
            'Фрезерные пластины',
            'Канавочные пластины',
            'Резьбовые пластины',
            'Сверлильные пластины',
        ];

        foreach ($categories as $index => $name) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
