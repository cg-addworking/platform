<?php

namespace Components\Billing\PaymentOrder\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_order.customer_name' => "required|string|exists:addworking_enterprise_enterprises,name",
            'payment_order.iban_id'       => "required|uuid|exists:addworking_enterprise_ibans,id",
            'payment_order.executed_at'   => "required|date|after_or_equal:today",
        ];
    }
}
