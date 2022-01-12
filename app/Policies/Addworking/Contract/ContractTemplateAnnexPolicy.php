<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateAnnex;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractTemplateAnnexPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, ContractTemplate $contract_template)
    {
        return $user->can('viewAny', [get_class($contract_template), $contract_template->enterprise]);
    }

    public function view(User $user, ContractTemplateAnnex $contract_template_annex)
    {
        return $user->can('view', $contract_template_annex->contractTemplate);
    }

    public function create(User $user, ContractTemplate $contract_template)
    {
        return $user->can('create', [get_class($contract_template), $contract_template->enterprise]);
    }

    public function update(User $user, ContractTemplateAnnex $contract_template_annex)
    {
        return $user->can('update', $contract_template_annex->contractTemplate);
    }

    public function delete(User $user, ContractTemplateAnnex $contract_template_annex)
    {
        return $user->can('delete', $contract_template_annex->contractTemplate);
    }
}
