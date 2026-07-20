<?php

namespace Database\Seeders;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Токарные пластины', 'slug' => 'tokarnye-plastiny'],
            ['name' => 'Фрезерные пластины', 'slug' => 'frezernye-plastiny'],
            ['name' => 'Канавочные пластины', 'slug' => 'kanavochnye-plastiny'],
            ['name' => 'Резьбовые пластины', 'slug' => 'rezbovye-plastiny'],
            ['name' => 'Сверлильные пластины', 'slug' => 'sverlilnye-plastiny'],
            ['name' => 'Обработка нержавеющих и жаропрочных сталей', 'slug' => 'obrabotka-nerzhaveyuschih-i-zharoprochnyh-staley'],
        ];

        foreach ($categories as $index => $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
