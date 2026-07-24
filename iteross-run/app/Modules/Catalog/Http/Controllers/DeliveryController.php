<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Application\UseCases\GetDeliveryPageContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    public function __invoke(
        Request $request,
        GetDeliveryPageContent $getDeliveryPageContent,
    ): View {
        $user = $request->user();

        return view('delivery', [
            'page' => $getDeliveryPageContent->handle(),
            'accountUrl' => $user?->role === 'admin'
                ? route('admin.dashboard')
                : route('account'),
            'accountLabel' => $user?->role === 'admin'
                ? 'Админка'
                : 'Личный кабинет',
        ]);
    }
}
