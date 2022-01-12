<?php

namespace App\Policies\Everial\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Everial\Mission\Referential;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * @todo this policy should recieve the $enterprise as context and not pull it from $user->enterprise
 */
class ReferentialPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        if (! Enterprise::whereName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->exists()) {
            return false;
        }

        $parent = Enterprise::whereName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->first();

        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
                && ($parent->descendants()->push($parent)->contains($user->enterprise) ||
                    $user->enterprise->getAllCustomersAndAncestors()->contains($parent)));
    }

    public function show(User $user, Referential $model)
    {
        return $this->index($user);
    }

    public function create(User $user)
    {
        $parent = Enterprise::whereName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->first();

        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
                && $parent->descendants()->push($parent)->contains($user->enterprise));
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user, Referential $model)
    {
        return $this->create($user);
    }

    public function update(User $user, Referential $model)
    {
        return $this->edit($user, $model);
    }

    public function destroy(User $user, Referential $model)
    {
        $parent = Enterprise::whereName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->first();

        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
                && $parent->descendants()->push($parent)->contains($user->enterprise));
    }
}
