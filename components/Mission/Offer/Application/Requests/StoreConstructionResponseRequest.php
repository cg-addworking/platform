<?php

namespace Components\Mission\Offer\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConstructionResponseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'response.file' => 'required|file|mimes:pdf|max:4000|min:1',
            'response.starts_at' => 'required|date',
            'response.ends_at' => 'nullable|date|after_or_equal:response.starts_at',
            'response.argument' => 'required|string',
            'response.amount_before_taxes' => 'required|numeric',
        ];
    }
}
