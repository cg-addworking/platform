<?php

namespace App\Http\Requests\Addworking\Contract\Contract;

use App\Models\Addworking\Contract\Contract;
use Illuminate\Foundation\Http\FormRequest;

class CreateBlankContractRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('createBlank', [Contract::class, $this->route('enterprise')]);
    }

    public function rules()
    {
        return [
            'contract.name'                => "required|string|max:255",
            'contract.valid_from'          => "nullable|date",
            'contract.valid_until'         => "nullable|date",
            'contract.external_identifier' => "nullable|string|max:255",
        ];
    }
}
