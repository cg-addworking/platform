<?php

namespace App\Http\Requests\Support\Billing\VatRate;

use App\Models\Addworking\Billing\VatRate;
use Illuminate\Foundation\Http\FormRequest;

class StoreVatRateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vat_rate.display_name' => 'required|string|max:255',
            'vat_rate.value'        => 'required|numeric|min:0|max:100',
            'vat_rate.description'  => 'required|string',
        ];
    }
}
