<?php

namespace Components\Billing\Outbound\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOutboundInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'outbound_invoice.month'        => "required",
            'outbound_invoice.invoiced_at'  => "required",
            'outbound_invoice.due_at'       => "nullable",
            'outbound_invoice.deadline'     => "required|string|exists:addworking_billing_deadline_types,name",
        ];
    }
}
