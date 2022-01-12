<?php

namespace App\Policies\Addworking\Contract;

use App\Repositories\Addworking\Contract\ContractRepository;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractPartyPolicy
{
    use HandlesAuthorization;

    protected $repositories = [];

    public function __construct(ContractRepository $contract)
    {
        $this->repositories['contract'] = $contract;
    }

    public function viewAny(User $user, Contract $contract)
    {
        return $user->can('view', $contract);
    }

    public function view(User $user, ContractParty $contract_party)
    {
        return $user->can('view', $contract_party->contract);
    }

    public function create(User $user, Contract $contract)
    {
        return $user->can('create', [Contract::class, $contract->enterprise]);
    }

    public function update(User $user, ContractParty $contract_party)
    {
        return $user->can('update', $contract_party->contract);
    }

    public function delete(User $user, ContractParty $contract_party)
    {
        return $user->can('destroy', $contract_party->contract);
    }

    public function updateSignatoryStatus(User $user, ContractParty $contract_party)
    {
        if (! $user->isSupport()) {
            return Response::deny("Seul un membre du support AddWorking peut changer les status de signature");
        }

        return Response::allow();
    }

    public function assignSignatory(User $user, ContractParty $contract_party)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if ($this->repositories['contract']->isLocked($contract_party->contract)) {
            return Response::deny("Le contrat est verouillé");
        }

        if (! $user->hasRoleFor($contract_party->enterprise, User::ROLE_SIGNATORY, User::ROLE_ADMIN)) {
            return Response::deny("Vous devez être signataire ou administrateur");
        }

        if (! $user->hasAccessFor($contract_party->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("Vous devez avoir accès aux contrats");
        }

        return Response::allow();
    }

    public function dissociateSignatory(User $user, ContractParty $contract_party)
    {
        if (! $contract_party->user()->exists()) {
            return Response::deny("Aucun signataire n'est actuellement associé");
        }

        return $this->assignSignatory($user, $contract_party);
    }
}
