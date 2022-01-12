<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractAnnex;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractAnnexPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Contract $contract)
    {
        return $user->can('viewAny', [get_class($contract), $contract->enterprise]);
    }

    public function view(User $user, ContractAnnex $contract_annex)
    {
        return $user->can('view', $contract_annex->contract);
    }

    public function create(User $user, Contract $contract)
    {
        return $user->can('create', [get_class($contract), $contract->enterprise]);
    }

    public function update(User $user, ContractAnnex $contract_annex)
    {
        return $user->can('update', $contract_annex->contract);
    }

    public function delete(User $user, ContractAnnex $contract_annex)
    {
        return $user->can('delete', $contract_annex->contract);
    }
}
