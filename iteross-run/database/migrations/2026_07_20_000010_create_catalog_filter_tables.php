<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_filter_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('catalog_filter_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('catalog_filter_groups')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['group_id', 'slug']);
        });

        Schema::create('catalog_filter_option_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('catalog_filter_option_id')->constrained('catalog_filter_options')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'catalog_filter_option_id'], 'product_filter_option_unique');
        });

        $groups = [
            'radius-re' => ['name' => 'Радиус при вершине RE', 'options' => ['0.2', '0.4', '0.8', '1.2', '1.6', '2.4']],
            'shape' => ['name' => 'Форма пластины', 'options' => ['Ромб 80° (C***)']],
            'size' => ['name' => 'Размер пластины', 'options' => ['09', '12', '16', '19', '25']],
            'material' => ['name' => 'Обрабатываемый материал', 'options' => ['P', 'M', 'K', 'N', 'S', 'H']],
            'processing-type' => ['name' => 'Тип обработки', 'options' => ['Чистовая', 'Получистовая', 'Черновая']],
            'alloy' => ['name' => 'Сплав пластины', 'options' => ['GPT6130', 'GS3115', 'GS3125', 'GS3210', 'GS3220', 'GS4130', 'GST7115', 'GST7120', 'GST7130', 'H010']],
            'chipbreaker' => ['name' => 'Стружколом', 'options' => ['BF', 'BM', 'BS', 'CM', 'EF', 'EL', 'EM', 'ER', 'ESM', 'FP', 'FS', 'FT']],
        ];

        $now = now();
        $groupIds = [];
        $sort = 1;

        foreach ($groups as $slug => $group) {
            $groupId = DB::table('catalog_filter_groups')->insertGetId([
                'name' => $group['name'],
                'slug' => $slug,
                'is_enabled' => true,
                'sort_order' => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $groupIds[$slug] = $groupId;

            foreach ($group['options'] as $index => $optionName) {
                DB::table('catalog_filter_options')->insert([
                    'group_id' => $groupId,
                    'name' => $optionName,
                    'slug' => Str::slug($optionName) !== '' ? Str::slug($optionName) : 'option-'.($index + 1),
                    'sort_order' => $index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_filter_option_product');
        Schema::dropIfExists('catalog_filter_options');
        Schema::dropIfExists('catalog_filter_groups');
    }
};
