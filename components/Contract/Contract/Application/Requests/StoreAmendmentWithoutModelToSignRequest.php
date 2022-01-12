<?php

namespace Components\Contract\Contract\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Foundation\Http\FormRequest;

class StoreAmendmentWithoutModelToSignRequest extends FormRequest
{
    public function rules()
    {
        $enterprise = (new Enterprise)->getTable();
        $mission = (new Mission)->getTable();

        $rules = [
            'contract.name' => "required|max:255",
            'contract.valid_from' => "nullable|date",
            'contract.valid_until' => "nullable|date|after_or_equal:contract.valid_from",
            'contract.external_identifier' => "nullable|string",
            'contract_part.display_name' => "required|max:255",
            'contract_part.file' => "required|mimes:pdf|max:15000|min:1",
            'contract_part.signature_mention' => "required|string",
            'contract_part.signature_page' => "required|integer|min:1",
            'contract.mission.id' => "nullable|uuid|exists:{$mission},id",
            'contract.mission.vendor_id' => "nullable|uuid|exists:{$enterprise},id",
            'contract.mission.label' => "sometimes|string|max:255",
            'contract.mission.ends_at' => "nullable|date|after_or_equal:contract.mission.starts_at",
            'contract_party.*.signatory_id' => "required",
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
