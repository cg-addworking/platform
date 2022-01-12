<?php

namespace Components\Contract\Contract\Application\Requests;

use Components\Contract\Contract\Application\Models\Contract;
use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractMissionRequest extends FormRequest
{
    public function rules()
    {
        $contract = (new Contract)->getTable();
        $mission = (new Mission)->getTable();

        return [
            'contract_id' => "required|uuid|exists:{$contract},id",
            'mission_id' => "required|uuid|exists:{$mission},id",
        ];
    }
}
