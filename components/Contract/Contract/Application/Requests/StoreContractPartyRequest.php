<?php

namespace Components\Contract\Contract\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractPartyRequest extends FormRequest
{
    public function rules()
    {
        $enterprise = (new Enterprise)->getTable();
        $user = (new User)->getTable();
        $mission = (new Mission)->getTable();

        $rules = [
            'contract_party.*.enterprise_id' => "required|uuid|exists:{$enterprise},id",
            'contract_party.*.signatory_id' => "required|uuid|exists:{$user},id",
            'contract_party.*.order' => "required|integer",
            'contract_party.*.signed_at' => "nullable|date",
            'contract.mission.id' => "nullable|uuid|exists:{$mission},id",
            'contract.mission.vendor_id' => "nullable|uuid|exists:{$enterprise},id",
            'contract.mission.label' => "sometimes|string|max:255",
            'contract.mission.ends_at' => "nullable|date|after_or_equal:contract.mission.starts_at",
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
            'contract.mission.starts_at.before_or_equal' =>
                __('components.contract.contract.application.requests.store_contract_request.messages.before_or_equal'),
        ];
    }
}
