<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\GetDeliveryPageContent;
use App\Modules\Admin\Application\UseCases\GetHeaderContent;
use App\Modules\Admin\Application\UseCases\GetHomePageContent;
use App\Modules\Admin\Application\UseCases\GetProductPageSettings;
use App\Modules\Admin\Application\UseCases\UpdateDeliveryPageContent;
use App\Modules\Admin\Application\UseCases\UpdateHeaderContent;
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
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminPageController extends Controller
{
    use InteractsWithStaticAdminPages;

    public function editor(
        string $page,
        GetDeliveryPageContent $getDeliveryPageContent,
        GetHeaderContent $getHeaderContent,
        GetHomePageContent $getHomePageContent,
        GetProductPageSettings $getProductPageSettings,
        GetCatalogFilterGroups $getCatalogFilterGroups,
    ): View
    {
        abort_unless(isset($this->staticPages()[$page]), 404);

        $deliveryPageContent = $page === 'delivery' ? $getDeliveryPageContent->handle() : null;
        $headerContent = $page === 'header' ? $getHeaderContent->handle() : null;
        $homePageContent = $page === 'home' ? $getHomePageContent->handle() : null;
        $productPageSettings = $page === 'product' ? $getProductPageSettings->handle() : null;

        if ($page === 'header') {
            Log::debug('Admin header editor payload prepared', [
                'page' => $page,
                'header_content_keys' => is_array($headerContent) ? array_keys($headerContent) : [],
                'header_nav_count' => is_array(data_get($headerContent, 'header_nav')) ? count(data_get($headerContent, 'header_nav')) : 0,
                'socials_count' => is_array(data_get($headerContent, 'socials')) ? count(data_get($headerContent, 'socials')) : 0,
                'has_phone' => filled(data_get($headerContent, 'phone')),
                'has_email' => filled(data_get($headerContent, 'email')),
            ]);
        }

        return view('admin.page-editor', [
            'userCount' => User::query()->where('role', User::ROLE_USER)->count(),
            'adminCount' => User::query()->where('role', User::ROLE_ADMIN)->count(),
            'staticPages' => $this->staticPages(),
            'selectedSection' => 'pages',
            'selectedEditor' => $page,
            'selectedEditorMeta' => $this->staticPages()[$page],
            'editorDefinition' => $this->editorDefinitions($page),
            'deliveryPageContent' => $deliveryPageContent,
            'headerContent' => $headerContent,
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
        UpdateDeliveryPageContent $updateDeliveryPageContent,
        UpdateHeaderContent $updateHeaderContent,
        UpdateHomePageContent $updateHomePageContent,
        UpdateProductPageSettings $updateProductPageSettings,
    ): RedirectResponse {
        abort_unless(in_array($page, ['home', 'delivery', 'header', 'product'], true), 404);

        if ($page === 'header') {
            $updateHeaderContent->handle($request->validated());

            return redirect()
                ->route('admin.pages.editor', ['page' => 'header'])
                ->with('status', 'Данные шапки сохранены.');
        }

        if ($page === 'delivery') {
            $updateDeliveryPageContent->handle($request->validated());

            return redirect()
                ->route('admin.pages.editor', ['page' => 'delivery'])
                ->with('status', 'Изменения страницы доставки сохранены.');
        }

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
