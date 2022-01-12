<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractTemplatePartyDocumentTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, ContractTemplateParty $party)
    {
        return $user->can('viewAny', [get_class($party), $party->contractTemplate]);
    }

    public function view(User $user, ContractTemplatePartyDocumentType $type)
    {
        return $user->can('view', $type->contractTemplateParty);
    }

    public function create(User $user, ContractTemplateParty $party)
    {
        return $user->can('create', [get_class($party), $party->contractTemplate]);
    }

    public function update(User $user, ContractTemplatePartyDocumentType $type)
    {
        return $user->can('update', $type->contractTemplateParty);
    }

    public function delete(User $user, ContractTemplatePartyDocumentType $type)
    {
        return $user->can('delete', $type->contractTemplateParty);
    }
}
