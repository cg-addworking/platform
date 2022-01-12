<?php

namespace App\Http\Requests\Addworking\Contract\Contract;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Contract\Contract;
use Illuminate\Validation\Rule;

class StoreContractRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [Contract::class, $this->route('contract')]);
    }

    public function rules()
    {
        $statuses = implode(',', Contract::getAvailableStatuses());

        return [
            'contract.status'              => "required|string|max:255|in:{$statuses}",
            'contract.name'                => "required|string|max:255",
            'contract.valid_from'          => "date",
            'contract.valid_until'         => "date",
            'contract.external_identifier' => "string|max:255",
        ];
    }
}
