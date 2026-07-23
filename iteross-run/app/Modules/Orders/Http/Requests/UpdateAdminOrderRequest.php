<?php

namespace App\Modules\Orders\Http\Requests;

class UpdateAdminOrderRequest extends StoreAdminOrderRequest
{
    protected $errorBag = 'updateOrder';
}
