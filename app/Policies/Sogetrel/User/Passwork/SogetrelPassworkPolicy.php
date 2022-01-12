<?php

namespace App\Policies\Sogetrel\User\Passwork;

use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class SogetrelPassworkPolicy
{
    use HandlesAuthorization;

    protected $familyEnterpriseRepository;
    protected $enterpriseRepository;

    public function __construct(
        FamilyEnterpriseRepository $familyEnterpriseRepository,
        EnterpriseRepository $enterpriseRepository
    ) {
        $this->familyEnterpriseRepository = $familyEnterpriseRepository;
        $this->enterpriseRepository = $enterpriseRepository;
    }

    public function index(User $user)
    {
        return $user->isSupport()
            || $user->hasRole(User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY)
            && $user->hasAccessToUser()
            && $user->enterprise->isSogetrelOrSubsidiary();
    }

    public function show(User $user, Passwork $passwork)
    {
        return $user->isSupport()
            || $user->sogetrelPasswork->is($passwork)
            || $user->hasRole(User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY)
            && $user->hasAccessToUser()
            && $user->enterprise->isSogetrelOrSubsidiary();
    }

    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user, Passwork $passwork)
    {
        return $user->isSupport()
            || ($user->hasRole(User::IS_ADMIN)
                && $user->hasAccessToUser() && $user->enterprise->isSogetrelOrSubsidiary())
            || (!in_array($passwork->status, ['refused', 'blacklisted']) && $user->sogetrelPasswork->is($passwork)
                && $user->hasRole(User::IS_ADMIN));
    }

    public function update(User $user, Passwork $passwork)
    {
        return $this->edit($user, $passwork);
    }

    public function share(User $user, Passwork $passwork)
    {
        return $this->edit($user, $passwork);
    }

    public function destroy(User $user)
    {
        return $user->isSupport();
    }

    public function status(User $user, Passwork $passwork)
    {
        return $passwork->exists
            && $this->index($user)
            && !$passwork->isBlacklisted();
    }

    public function pending(User $user)
    {
        return $this->create($user);
    }

    public function parking(User $user, Passwork $passwork)
    {
        return $this->status($user, $passwork);
    }

    public function contacted(User $user, Passwork $passwork)
    {
        return $this->status($user, $passwork);
    }

    public function comment(User $user, Passwork $passwork)
    {
        return $this->status($user, $passwork);
    }

    public function export(User $user)
    {
        return $this->index($user);
    }

    public function attachToErymaOrSubsidiaries(User $user, Passwork $passwork)
    {
        return $passwork->exists
            && $user->hasRole(User::IS_ADMIN, User::IS_OPERATOR)
            && $this->familyEnterpriseRepository->getDescendants($this->enterpriseRepository->fromName('ERYMA'), true)
                ->contains($user->enterprise)
            && !$passwork->isBlacklisted();
    }
}
