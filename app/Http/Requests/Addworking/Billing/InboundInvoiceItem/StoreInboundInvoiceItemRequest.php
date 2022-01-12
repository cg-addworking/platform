<?php

namespace App\Http\Requests\Addworking\Billing\InboundInvoiceItem;

use App\Models\Addworking\Billing\InboundInvoiceItem;
use Illuminate\Foundation\Http\FormRequest;

class StoreInboundInvoiceItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'inbound_invoice_item.label'       => 'required|string|max:255',
            'inbound_invoice_item.quantity'    => 'required|numeric',
            'inbound_invoice_item.unit_price'  => 'required|numeric',
            'inbound_invoice_item.vat_rate_id' => 'required|uuid|exists:addworking_billing_vat_rates,id',
        ];
    }
}
