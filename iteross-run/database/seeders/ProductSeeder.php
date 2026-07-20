<?php

namespace Database\Seeders;

use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Product;
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
                'category_slug' => 'tokarnye-plastiny',
                'description' => 'Универсальная токарная пластина для черновой и получистовой обработки стали.',
                'price' => 890,
                'stock_quantity' => 120,
                'is_visible' => true,
            ],
            [
                'name' => 'Фреза концевая 10 мм',
                'slug' => 'endmill-10mm',
                'sku' => 'EM-10-4F',
                'category_slug' => 'frezernye-plastiny',
                'description' => 'Четырехзаходная концевая фреза для стали и нержавеющих сплавов.',
                'price' => 2150,
                'stock_quantity' => 40,
                'is_visible' => true,
            ],
            [
                'name' => 'Фрезерная пластина APMT 1604',
                'slug' => 'apmt-1604',
                'sku' => 'APMT-1604-PDER',
                'category_slug' => 'frezernye-plastiny',
                'description' => 'Сменная пластина для торцевого и плечевого фрезерования.',
                'price' => 1180,
                'stock_quantity' => 80,
                'is_visible' => true,
            ],
            [
                'name' => 'Канавочная пластина MGMN 300',
                'slug' => 'mgmn-300',
                'sku' => 'MGMN-300-M',
                'category_slug' => 'kanavochnye-plastiny',
                'description' => 'Пластина для точения канавок и отрезки на токарных операциях.',
                'price' => 760,
                'stock_quantity' => 65,
                'is_visible' => true,
            ],
            [
                'name' => 'Резьбовая пластина 16ER AG60',
                'slug' => '16er-ag60',
                'sku' => '16ER-AG60',
                'category_slug' => 'rezbovye-plastiny',
                'description' => 'Пластина для наружной резьбы с универсальной геометрией.',
                'price' => 1290,
                'stock_quantity' => 48,
                'is_visible' => true,
            ],
            [
                'name' => 'Сверло твердосплавное 8 мм',
                'slug' => 'drill-8mm',
                'sku' => 'DR-08-CARB',
                'category_slug' => 'sverlilnye-plastiny',
                'description' => 'Сверло для стабильного сверления металла с внутренним подводом СОЖ.',
                'price' => 3490,
                'stock_quantity' => 26,
                'is_visible' => true,
            ],
            [
                'name' => 'Сверлильная пластина SPMG 090408',
                'slug' => 'spmg-090408',
                'sku' => 'SPMG-090408',
                'category_slug' => 'sverlilnye-plastiny',
                'description' => 'Сменная пластина для корпусных сверл со стабильным отводом стружки.',
                'price' => 980,
                'stock_quantity' => 54,
                'is_visible' => true,
            ],
            [
                'name' => 'Пластина для обработки жаропрочных сталей SNMG 190612',
                'slug' => 'snmg-190612-hrsa',
                'sku' => 'SNMG-190612-HRSA',
                'category_slug' => 'obrabotka-nerzhaveyuschih-i-zharoprochnyh-staley',
                'description' => 'Пластина для нержавеющих и жаропрочных сталей на сложных режимах резания.',
                'price' => 1540,
                'stock_quantity' => 32,
                'is_visible' => true,
            ],
        ];

        foreach ($products as $product) {
            $category = Category::query()
                ->where('slug', $product['category_slug'])
                ->first();

            Product::query()->updateOrCreate(
                ['sku' => $product['sku']],
                [
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'is_visible' => $product['is_visible'],
                    'category_id' => $category?->id,
                ],
            );
        }
    }
}
