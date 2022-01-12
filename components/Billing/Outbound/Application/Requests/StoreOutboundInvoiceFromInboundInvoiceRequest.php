<?php

namespace Components\Billing\Outbound\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutboundInvoiceFromInboundInvoiceRequest extends FormRequest
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
            'outbound_invoice.address'      => 'required',
            'outbound_invoice.include_fees' => 'nullable',
            'outbound_invoice.legal_notice' => 'nullable|string'
        ];
    }
}
