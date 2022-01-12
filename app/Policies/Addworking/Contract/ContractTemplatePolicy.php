<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractTemplatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_READONLY)) {
            return Response::deny("Vos privilèges sur l'entreprise {$enterprise->name} sont insuffisants");
        }

        if (! $user->hasAccessFor($enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("Vous n'avez pas accès aux contrats");
        }

        return Response::allow();
    }

    public function view(User $user, ContractTemplate $template)
    {
        if (! $template->exists) {
            return Response::deny("Invalid template");
        }

        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($template->enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_READONLY)) {
            return Response::deny("Vos privilèges sur l'entreprise {$template->enterprise->name} sont insuffisants");
        }

        if (! $user->hasAccessFor($template->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("Vous n'avez pas accès aux contrats");
        }

        return Response::allow();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR)) {
            return Response::deny("Vos privilèges sur l'entreprise {$enterprise->name} sont insuffisants");
        }

        if (! $user->hasAccessFor($enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("Vous n'avez pas accès aux contrats");
        }

        return Response::allow();
    }

    public function update(User $user, ContractTemplate $template)
    {
        if (! $template->exists) {
            return Response::deny("Invalid template");
        }

        return $this->create($user, $template->enterprise);
    }

    public function delete(User $user, ContractTemplate $template)
    {
        return $this->viewAny($user, $template->enterprise);
    }
}
