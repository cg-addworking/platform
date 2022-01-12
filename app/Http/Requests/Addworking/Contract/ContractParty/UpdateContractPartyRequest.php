<?php

namespace App\Http\Requests\Addworking\Contract\ContractParty;

use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Support\Facades\Repository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractPartyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('update', $this->route('contract_party'));
    }

    public function rules()
    {
        $user  = (new User)->getTable();
        $users = Repository::contractParty()
            ->getAvailableSignatories($this->route('contract_party'))
            ->pluck('id')->join(',');

        return [
            'contract_party.denomination' => "required|string|max:255",
            'contract_party.user'         => "required|uuid|exists:{$user},id|in:{$users}",
            'contract_party.signed'       => "sometimes|nullable|boolean",
            'contract_party.signed_at'    => "sometimes|nullable|date",
            'contract_party.declined'     => "sometimes|nullable|boolean",
            'contract_party.declined_at'  => "sometimes|nullable|date",
        ];
    }
}
