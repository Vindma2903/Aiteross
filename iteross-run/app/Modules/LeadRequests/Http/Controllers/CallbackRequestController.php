<?php

namespace App\Modules\LeadRequests\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\LeadRequests\Application\DataTransfer\CallbackRequestData;
use App\Modules\LeadRequests\Application\UseCases\SubmitCallbackRequest;
use App\Modules\LeadRequests\Http\Requests\StoreCallbackRequestRequest;
use Illuminate\Http\RedirectResponse;

class CallbackRequestController extends Controller
{
    public function store(
        StoreCallbackRequestRequest $request,
        SubmitCallbackRequest $submitCallbackRequest,
    ): RedirectResponse {
        $submitCallbackRequest->handle(new CallbackRequestData(
            name: $request->string('name')->toString(),
            phone: $request->string('phone')->toString(),
            description: $request->string('description')->toString(),
            attachment: $request->file('attachment'),
        ));

        return redirect('/')
            ->with('callback_status', 'Заявка отправлена. Мы перезвоним вам в течение рабочего дня.')
            ->with('open_callback_modal', true);
    }
}
