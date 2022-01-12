<?php

namespace App\Http\Requests\Addworking\Contract\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Support\Facades\Repository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContractRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route()->parameter('contract'));
    }

    public function rules()
    {
        $statuses = implode(',', Repository::contract()->getAvailableStatuses($this->route('contract')));

        return [
            'contract.status'              => "sometimes|required|string|max:255|in:{$statuses}",
            'contract.file'                => "nullable|file|mimes:pdf|max:4000|min:1",
            'contract.name'                => "required|string|max:255",
            'contract.valid_from'          => "nullable|date",
            'contract.valid_until'         => "nullable|date",
            'contract.external_identifier' => "nullable|string|max:255",
        ];
    }
}
