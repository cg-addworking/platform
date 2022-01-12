<?php
namespace Components\Enterprise\InvoiceParameter\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceParameterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'analytic_code' => 'nullable|string',
            'iban_id' => 'required|uuid|exists:addworking_enterprise_ibans,id',
            'discount_starts_at' => 'nullable|date',
            'discount_ends_at' => 'nullable|date',
            'discount_amount' => 'required|numeric',
            'billing_floor_amount' => 'required|numeric',
            'billing_cap_amount' => 'required|numeric',
            'default_management_fees_by_vendor' => 'required|numeric',
            'custom_management_fees_by_vendor' => 'required|numeric',
            'fixed_fees_by_vendor_amount' => 'required|numeric',
            'subscription_amount' => 'required|numeric',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date',
        ];
    }
}
