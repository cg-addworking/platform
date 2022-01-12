<?php

namespace Components\Contract\Contract\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Contract\Model\Application\Models\ContractModel;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function rules()
    {
        $enterprise = (new Enterprise)->getTable();
        $contract_model = (new ContractModel)->getTable();

        $rules = [
            'contract.name' => "required|max:255",
            'contract.enterprise' => "required|uuid|exists:{$enterprise},id",
            'contract.contract_model' => "required|uuid|exists:{$contract_model},id",
            'contract.valid_from' => "nullable|date",
            'contract.valid_until' => "nullable|date|after_or_equal:contract.valid_from",
        ];

        $today = Carbon::now()->format('Y-m-d');

        if (is_null($this->input('contract.mission.ends_at'))) {
            $rules['contract.mission.starts_at'] = "sometimes|date|before_or_equal:{$today}";
        } else {
            $rules['contract.mission.starts_at'] = "sometimes|date";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'contract.contract_model.required' =>
                __('components.contract.contract.application.views.contract._form.contract_model_required'),
        ];
    }
}
