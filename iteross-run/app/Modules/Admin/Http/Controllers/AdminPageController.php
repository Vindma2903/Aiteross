<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\GetHomePageContent;
use App\Modules\Admin\Application\UseCases\GetProductPageSettings;
use App\Modules\Admin\Application\UseCases\UpdateProductPageSettings;
use App\Modules\Admin\Application\UseCases\UpdateHomePageContent;
use App\Modules\Admin\Http\Controllers\Concerns\InteractsWithStaticAdminPages;
use App\Modules\Admin\Http\Requests\UpdateHomePageContentRequest;
use App\Modules\Catalog\Application\UseCases\GetCatalogFilterGroups;
use App\Modules\Catalog\Infrastructure\Persistence\Eloquent\Category;
use App\Modules\Identity\Infrastructure\Persistence\Eloquent\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminPageController extends Controller
{
    use InteractsWithStaticAdminPages;

    public function editor(
        string $page,
        GetHomePageContent $getHomePageContent,
        GetProductPageSettings $getProductPageSettings,
        GetCatalogFilterGroups $getCatalogFilterGroups,
    ): View
    {
        abort_unless(isset($this->staticPages()[$page]), 404);

        $homePageContent = $page === 'home' ? $getHomePageContent->handle() : null;
        $productPageSettings = $page === 'product' ? $getProductPageSettings->handle() : null;

        return view('admin.page-editor', [
            'userCount' => User::query()->where('role', User::ROLE_USER)->count(),
            'adminCount' => User::query()->where('role', User::ROLE_ADMIN)->count(),
            'staticPages' => $this->staticPages(),
            'selectedSection' => 'pages',
            'selectedEditor' => $page,
            'selectedEditorMeta' => $this->staticPages()[$page],
            'editorDefinition' => $this->editorDefinitions($page),
            'homePageContent' => $homePageContent,
            'productPageSettings' => $productPageSettings,
            'catalogCategories' => $page === 'home'
                ? Category::query()->orderBy('sort_order')->orderBy('name')->get(['name', 'slug'])
                : collect(),
            'catalogFilterGroups' => $page === 'catalog' ? $getCatalogFilterGroups->handle(false) : collect(),
        ]);
    }

    public function update(
        string $page,
        UpdateHomePageContentRequest $request,
        UpdateHomePageContent $updateHomePageContent,
        UpdateProductPageSettings $updateProductPageSettings,
    ): RedirectResponse {
        abort_unless(in_array($page, ['home', 'product'], true), 404);

        if ($page === 'product') {
            $updateProductPageSettings->handle($request->validated());

            return redirect()
                ->route('admin.pages.editor', ['page' => 'product'])
                ->with('status', 'Настройки карточки товара сохранены.');
        }

        $validated = $request->validated();
        $validated['work_types']['items'] = collect($validated['work_types']['items'])
            ->mapWithKeys(fn (array $item) => [
                $item['slug'] => [
                    'icon' => $item['icon'],
                    'image' => $item['image'] ?? '',
                    'description' => $item['description'],
                ],
            ])
            ->all();

        $updateHomePageContent->handle($validated);

        return redirect()
            ->route('admin.pages.editor', ['page' => 'home'])
            ->with('status', 'Изменения главной страницы сохранены.');
    }

    public function preview(string $page): Response
    {
        abort_unless(isset($this->staticPages()[$page]), 404);

        $filePath = $this->workspaceRoot().DIRECTORY_SEPARATOR.$this->staticPages()[$page]['file'];
        abort_unless(File::exists($filePath), 404);

        $html = File::get($filePath);
        $html = $this->rewriteStaticHtml($html);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function resource(string $path): BinaryFileResponse
    {
        $resolvedPath = $this->resolveResourcePath($path);
        abort_unless($resolvedPath !== null && File::exists($resolvedPath), 404);

        return response()->file($resolvedPath);
    }

    public function legacyEditor(string $page): Response
    {
        abort_unless(isset($this->staticPages()[$page]), 404);

        $html = $this->legacyAdminHtml();
        $html = $this->patchLegacyAdminPageEditor($html, $page);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function legacyProducts(): Response
    {
        $html = $this->legacyAdminHtml();
        $html = $this->patchLegacyAdminProducts($html);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
