<?php

namespace App\Http\Requests\Addworking\Billing\InboundInvoice;

use App\Models\Addworking\Billing\InboundInvoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInboundInvoiceRequest extends FormRequest
{
    public function rules()
    {
        $statuses  = implode(',', InboundInvoice::getAvailableStatuses());

        return [
            'file.content'                => 'required|file|min:1|mimes:pdf|max:4000',
            'inbound_invoice.customer_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'inbound_invoice.status'      => "nullable|in:{$statuses}",
            'inbound_invoice.number'      => 'required|string|max:255',
            'inbound_invoice.month'       => 'required|string|regex:~\d{2}/\d{4}~',
            'inbound_invoice.deadline_id' => 'required|uuid|exists:addworking_billing_deadline_types,id',
            'inbound_invoice.amount_before_taxes'             => 'required|numeric',
            'inbound_invoice.amount_of_taxes'                 => 'required|numeric',
            'inbound_invoice.amount_all_taxes_included'       => 'required|numeric',
            'inbound_invoice.note'                            => 'nullable|string',
            'inbound_invoice.admin_amount'                    => 'nullable|numeric', // @deprecated
            'inbound_invoice.admin_amount_of_taxes'           => 'nullable|numeric', // @deprecated
            'inbound_invoice.admin_amount_all_taxes_included' => 'nullable|numeric', // @deprecated
        ];
    }
}
