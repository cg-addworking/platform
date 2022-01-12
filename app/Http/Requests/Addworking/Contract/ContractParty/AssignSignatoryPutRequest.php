<?php

namespace App\Http\Requests\Addworking\Contract\ContractParty;

use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Contract\ContractPartyRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class AssignSignatoryPutRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('assignSignatory', $this->route('contract_party'));
    }

    public function rules()
    {
        $user = (new User)->getTable();
        $repo = App::make(ContractPartyRepository::class);

        return [
            'contract_party.user' => [
                "required", "uuid", "exists:{$user},id", function ($attribute, $value, $fail) use ($repo) {
                    $signatories = $repo->getAvailableSignatories($this->route('contract_party'));

                    if (! $signatories->contains(fn($user) => $user->id == $value)) {
                        return $fail("Vous devez choisir un signataire proposé dans la liste");
                    }
                }
            ],
        ];
    }
}
