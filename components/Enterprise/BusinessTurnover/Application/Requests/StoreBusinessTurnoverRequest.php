<?php

namespace Components\Enterprise\BusinessTurnover\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessTurnoverRequest extends FormRequest
{
    public function rules()
    {
        return [
            'business_turnover.amount' => "numeric",
        ];
    }
}
