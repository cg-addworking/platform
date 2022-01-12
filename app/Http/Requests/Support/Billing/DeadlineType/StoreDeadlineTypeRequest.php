<?php

namespace App\Http\Requests\Support\Billing\DeadlineType;

use App\Models\Addworking\Billing\DeadlineType;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeadlineTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'deadline_type.display_name' => 'required|string|max:255',
            'deadline_type.value'        => 'required|numeric|min:0',
            'deadline_type.description'  => 'required|string',
        ];
    }
}
