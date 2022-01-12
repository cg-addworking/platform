<?php

namespace App\Http\Requests\Addworking\Billing\InboundInvoiceItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInboundInvoiceItemRequest extends FormRequest
{
    public function rules()
    {
        return (new StoreInboundInvoiceItemRequest)->rules();
    }
}
