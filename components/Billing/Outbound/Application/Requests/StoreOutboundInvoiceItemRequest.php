<?php

namespace Components\Billing\Outbound\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOutboundInvoiceItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'outbound_invoice_item.label'       => "required",
            'outbound_invoice_item.quantity'    => "required",
            'outbound_invoice_item.unit_price'  => "required",
            'outbound_invoice_item.vat_rate_id' => "required|uuid|exists:addworking_billing_vat_rates,id",
        ];
    }
}
