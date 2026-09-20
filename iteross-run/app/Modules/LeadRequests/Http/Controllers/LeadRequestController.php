<?php

namespace App\Modules\LeadRequests\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\LeadRequests\Application\DataTransfer\LeadRequestData;
use App\Modules\LeadRequests\Application\UseCases\SubmitLeadRequest;
use App\Modules\LeadRequests\Http\Requests\StoreLeadRequestRequest;
use Illuminate\Http\RedirectResponse;

class LeadRequestController extends Controller
{
    public function store(
        StoreLeadRequestRequest $request,
        SubmitLeadRequest $submitLeadRequest,
    ): RedirectResponse {
        $delivered = $submitLeadRequest->handle(new LeadRequestData(
            companyName: $request->string('company_name')->toString(),
            phone: $request->string('phone')->toString(),
            email: $request->string('email')->toString(),
            taskDescription: $request->string('task_description')->toString(),
            attachment: $request->file('attachment'),
        ));

        $redirect = redirect()->to(rtrim(url('/'), '/').'/#lead-form-section');

        if (! $delivered) {
            return $redirect
                ->withInput()
                ->withErrors(['delivery' => 'Не удалось отправить заявку. Пожалуйста, попробуйте позже или позвоните нам.']);
        }

        return $redirect
            ->with('status','Заявка отправлена. Мы свяжемся с вами в течение рабочего дня.');
    }
}
