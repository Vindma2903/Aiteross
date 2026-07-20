<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Http\Requests\UpdateCatalogCategoriesRequest;
use App\Modules\Admin\Http\Requests\UpdateCatalogFiltersRequest;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\CatalogFilterGroup;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\CatalogFilterOption;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCatalogController extends Controller
{
    public function updateCategories(UpdateCatalogCategoriesRequest $request): RedirectResponse
    {
        $categories = collect($request->validated('categories'))
            ->map(fn (array $category, int $index) => [
                'name' => trim($category['name']),
                'slug' => Str::slug($category['name']),
                'sort_order' => $index + 1,
            ])
            ->filter(fn (array $category) => $category['name'] !== '' && $category['slug'] !== '')
            ->values();

        $keptIds = [];

        foreach ($categories as $categoryData) {
            $category = Category::query()->updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'sort_order' => $categoryData['sort_order'],
                ],
            );

            $keptIds[] = $category->id;
        }

        $categoriesToDelete = Category::query();

        if ($keptIds !== []) {
            $categoriesToDelete->whereNotIn('id', $keptIds);
        }

        $categoriesToDelete->delete();

        return redirect()
            ->route('admin.pages.editor', ['page' => 'catalog'])
            ->with('status', 'Категории каталога сохранены.');
    }

    public function updateFilters(UpdateCatalogFiltersRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $keptGroupIds = [];
            $keptOptionIds = [];

            foreach ($request->validated('groups') as $groupData) {
                $group = isset($groupData['id'])
                    ? CatalogFilterGroup::query()->findOrFail($groupData['id'])
                    : new CatalogFilterGroup();

                $group->fill([
                    'name' => trim($groupData['name']),
                    'slug' => $group->exists ? $group->slug : Str::slug($groupData['name']),
                    'sort_order' => (int) $groupData['sort_order'],
                    'is_enabled' => (bool) ($groupData['is_enabled'] ?? false),
                ]);
                $group->save();

                $keptGroupIds[] = $group->id;

                foreach ($groupData['options'] as $optionData) {
                    $option = isset($optionData['id'])
                        ? CatalogFilterOption::query()
                            ->where('group_id', $group->id)
                            ->findOrFail($optionData['id'])
                        : new CatalogFilterOption(['group_id' => $group->id]);

                    $option->fill([
                        'group_id' => $group->id,
                        'name' => trim($optionData['name']),
                        'slug' => $option->exists ? $option->slug : $this->buildOptionSlug($optionData['name'], $group->id),
                        'sort_order' => (int) $optionData['sort_order'],
                    ]);
                    $option->save();

                    $keptOptionIds[] = $option->id;
                }
            }

            CatalogFilterOption::query()
                ->when($keptOptionIds !== [], fn ($query) => $query->whereNotIn('id', $keptOptionIds))
                ->delete();

            CatalogFilterGroup::query()
                ->when($keptGroupIds !== [], fn ($query) => $query->whereNotIn('id', $keptGroupIds))
                ->delete();
        });

        return redirect()
            ->route('admin.pages.editor', ['page' => 'catalog'])
            ->with('status', 'Фильтры каталога сохранены.');
    }

    private function buildOptionSlug(string $name, int $groupId): string
    {
        $slug = Str::slug($name);

        return $slug !== '' ? $slug : 'group-'.$groupId.'-option-'.Str::lower(Str::random(6));
    }
}
