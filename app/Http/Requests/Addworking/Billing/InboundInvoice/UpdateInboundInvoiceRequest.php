<?php

namespace App\Http\Requests\Addworking\Billing\InboundInvoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInboundInvoiceRequest extends FormRequest
{
    public function rules()
    {
        $rules = (new StoreInboundInvoiceRequest)->rules();

        // you cannot replace the file, month, and customer of an inbound
        unset($rules['file.content'], $rules['customer.id']);

        return $rules;
    }
}
