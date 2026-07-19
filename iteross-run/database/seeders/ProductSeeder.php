<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Твердосплавная пластина CNMG 120408',
                'slug' => 'cnmg-120408',
                'sku' => 'CNMG-120408-MA',
                'category' => 'Токарные пластины',
                'description' => 'Универсальная токарная пластина для черновой и получистовой обработки стали.',
                'price' => 890,
            ],
            [
                'name' => 'Фреза концевая 10 мм',
                'slug' => 'endmill-10mm',
                'sku' => 'EM-10-4F',
                'category' => 'Фрезерные пластины',
                'description' => 'Четырёхзаходная концевая фреза для стали и нержавеющих сплавов.',
                'price' => 2150,
            ],
            [
                'name' => 'Сверло твердосплавное 8 мм',
                'slug' => 'drill-8mm',
                'sku' => 'DR-08-CARB',
                'category' => 'Сверлильные пластины',
                'description' => 'Сверло для стабильного сверления металла с внутренним подводом СОЖ.',
                'price' => 3490,
            ],
            [
                'name' => 'Резьбовая пластина 16ER AG60',
                'slug' => '16er-ag60',
                'sku' => '16ER-AG60',
                'category' => 'Резьбовые пластины',
                'description' => 'Пластина для наружной резьбы с универсальной геометрией.',
                'price' => 1290,
            ],
        ];

        foreach ($products as $product) {
            $category = Category::query()
                ->where('name', $product['category'])
                ->first();

            unset($product['category']);

            Product::query()->updateOrCreate(
                ['sku' => $product['sku']],
                $product + ['category_id' => $category?->id],
            );
        }
    }
}
