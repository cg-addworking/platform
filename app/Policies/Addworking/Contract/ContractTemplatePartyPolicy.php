<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractTemplatePartyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, ContractTemplate $template)
    {
        return $user->can('viewAny', [get_class($template), $template->enterprise]);
    }

    public function view(User $user, ContractTemplateParty $party)
    {
        return $user->can('view', $party->contractTemplate);
    }

    public function create(User $user, ContractTemplate $template)
    {
        return $user->can('create', [get_class($template), $template->enterprise]);
    }

    public function update(User $user, ContractTemplateParty $party)
    {
        return $user->can('update', $party->contractTemplate);
    }

    public function delete(User $user, ContractTemplateParty $party)
    {
        return $user->can('delete', $party->contractTemplate);
    }
}
