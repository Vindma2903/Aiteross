<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\GetHomePageContent;
use App\Modules\Catalog\Application\UseCases\GetCatalogCategories;
use App\Modules\Favorites\Application\UseCases\GetFavoriteProductIdsForRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(
        Request $request,
        GetCatalogCategories $getCatalogCategories,
        GetFavoriteProductIdsForRequest $getFavoriteProductIdsForRequest,
        GetHomePageContent $getHomePageContent,
    ): View {
        $categories = $getCatalogCategories->handle();
        $page = $getHomePageContent->handle();
        $user = $request->user();

        return view('home', [
            'categories' => $categories,
            'page' => $page,
            'favoriteCount' => count($getFavoriteProductIdsForRequest->handle($request)),
            'accountUrl' => $user?->role === 'admin'
                ? route('admin.dashboard')
                : route('account'),
            'accountLabel' => $user?->role === 'admin'
                ? 'Админка'
                : 'Личный кабинет',
        ]);
    }
}
