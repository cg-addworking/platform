<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Enterprise\Concerns\Enterprise\HasInformationPolicy;
use App\Policies\Addworking\Enterprise\Concerns\Enterprise\HasInvitationPolicy;
use App\Policies\Addworking\Enterprise\Concerns\Enterprise\HasMemberPolicy;
use App\Policies\Addworking\Enterprise\Concerns\Enterprise\HasReferentPolicy;
use App\Policies\Addworking\Enterprise\Concerns\Enterprise\HasVendorPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EnterprisePolicy
{
    use HandlesAuthorization,
        HasVendorPolicy,
        HasMemberPolicy,
        HasInvitationPolicy,
        HasInformationPolicy,
        HasReferentPolicy;

    public function index(User $user)
    {
        return $user->isSupport()
            || $user->hasAccessToEnterprise();
    }

    public function seeGroups(User $user)
    {
        if (! $user->isSupport()) {
            return Response::deny("vous devez faire partie du support AddWorking pour voir les groupes");
        }

        return Response::allow();
    }

    public function indexSupport(User $user)
    {
        return $this->seeGroups($user);
    }

    public function show(User $user, Enterprise $model)
    {
        return $user->isSupport()

            // user is member of $model enterprise (with any role)
            || $user->hasRoleFor($model, User::getAvailableRoles())
            && $user->hasAccessFor($model, User::ACCESS_TO_ENTERPRISE)

            // user's enterprise is vendor of $model enterprise
            || $user->enterprise->isVendorOf($model)
            && $user->hasAccessToEnterprise()

            // user's enterprise is customer of $model enterprise
            || $user->enterprise->isCustomerOf($model)
            && $user->hasAccessToEnterprise()

            // user's enterprise is member of sogetrel group && $model has a sogetrel passwork
            || $user->enterprise->isMemberOfSogetrelGroup() && $model->hasSogetrelPasswork()
            && $user->hasAccessToEnterprise()

            // user's enterprise is in the $model enterprise familly
            || $user->enterprise->family()->contains($model)
            && $user->hasAccessToEnterprise();
    }

    public function showRelated(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || $user->enterprise->is($enterprise)
            || $user->enterprise->descendants()->contains($enterprise);
    }

    public function create(User $user)
    {
        return true;
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user, Enterprise $model)
    {
        return $user->isSupport()
            || $user->hasRole(User::IS_ADMIN)
            && $user->hasAccessToEnterprise()
            && $user->enterprise->is($model);
    }

    public function update(User $user, Enterprise $model)
    {
        return $this->edit($user, $model);
    }

    public function destroy(User $user, Enterprise $model)
    {
        return $user->isSystemSuperadmin()
            || $user->isSystemAdmin();
    }

    public function storeEnterpriseVendors(User $user, Enterprise $model)
    {
        return $user->isSupport()
            || $user->hasRole(User::IS_ADMIN, User::IS_OPERATOR)
            && $user->hasAccessToEnterprise()
            && $user->enterprise->is_customer;
    }

    public function indexSubsidiaries(User $user, Enterprise $parent)
    {
        return $user->isSupport()
            || $user->hasAccessToEnterprise();
    }

    public function createSubsidiaries(User $user, Enterprise $parent)
    {
        return $user->isSupport()
            || $user->isAdminOf($parent)
            && $user->hasAccessToEnterprise();
    }

    public function destroySubsidiaries(User $user, Enterprise $parent, Enterprise $child)
    {
        return $this->createSubsidiaries($user, $parent);
    }

    public function attachEnterpriseUser(User $user)
    {
        return $user->isSupport();
    }

    public function showSogetrelData(User $user, Enterprise $enterprise)
    {
        return ($user->isSupport() || $user->enterprise->isSogetrelOrSubsidiary()) && isset($enterprise->sogetrelData);
    }

    public function removePhoneNumbers(User $user, Enterprise $model)
    {
        return $model->phoneNumbers->count() > 1 && $this->edit($user, $model);
    }

    public function synchronizeNavibat(User $user, Enterprise $model)
    {
        return $user->isSupport()
            && Enterprise::fromName('SOGETREL')->family()->vendors()->contains($model)
            && (! isset($model->sogetrelData) || $model->sogetrelData->navibat_sent == false);
    }

    public function zip(User $user, Enterprise $enterprise)
    {
        return $enterprise->documents->onlyValidated()->count() > 0
            && ($user->isSupport()
                || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
                    && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
                    && ($user->enterprise->is($enterprise) ||  $user->enterprise->isCustomerOf($enterprise))));
    }

    public function createCps2(User $user, Enterprise $enterprise)
    {
        if (! $enterprise->isVendor()) {
            return Response::deny("L'entreprise n'est pas un prestataire");
        }

        if (! $user->isSupport()) {
            return Response::deny("Seul le support peut créer des CPS2");
        }

        return Response::allow();
    }

    public function showIframeAirtable(User $user)
    {
        return $user->isSupport()
              || $user->enterprise->isSogetrelOrSubsidiary();
    }

    public function showBusinessTurnover(User $user)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($user->enterprise, [
            User::ROLE_VIEW_BUSINESS_TURNOVER,
            User::ROLE_LEGAL_REPRESENTATIVE
        ])) {
            return Response::deny("You don't have access !");
        }

        return Response::allow();
    }

    public function editOracleId(User $user)
    {
        return $user->isSupport();
    }
}
