<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractVariable;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractVariablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Contract $contract)
    {
        return $user->can('viewAny', [get_class($contract), $contract->enterprise]);
    }

    public function view(User $user, ContractVariable $contract_variable)
    {
        return $user->can('view', $contract_variable->contract);
    }

    public function create(User $user, Contract $contract)
    {
        return $user->can('create', [get_class($contract), $contract->enterprise]);
    }

    public function update(User $user, ContractVariable $contract_variable)
    {
        return $user->can('update', $contract_variable->contract);
    }

    public function delete(User $user, ContractVariable $contract_variable)
    {
        return $user->can('delete', $contract_variable->contract);
    }
}
