<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Contract\ContractDocument;
use App\Models\Addworking\User\User;
use App\Support\Facades\Repository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractDocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, ContractParty $contract_party)
    {
        return $user->can('view', $contract_party);
    }

    public function view(User $user, ContractDocument $contract_document)
    {
        return $user->can('view', $contract_document->contractParty);
    }

    public function create(User $user, ContractParty $contract_party)
    {
        if (! $contract_party->exists) {
            return Response::deny("impossible de créer le document sans partie prennante");
        }

        return $user->can('create', [ContractParty::class, $contract_party->contract]);
    }

    public function update(User $user, ContractDocument $contract_document)
    {
        return $user->can('update', $contract_document->contractParty);
    }

    public function delete(User $user, ContractDocument $contract_document)
    {
        return $user->can('destroy', $contract_document->contractParty);
    }
}
