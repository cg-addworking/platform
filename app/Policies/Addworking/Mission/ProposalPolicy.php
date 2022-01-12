<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Mission\Proposal;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProposalPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        // @todo this should be passed as parameter!
        $enterprise = $user->enterprise;

        return $user->isSupport()
            ||   $user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            &&   $user->hasAccessFor($enterprise, [User::ACCESS_TO_MISSION])
            && (
                $enterprise->isMemberOfSogetrelGroup() ||
                $enterprise->isVendor()
            );
    }

    public function show(User $user, Proposal $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && (
                ($user->enterprise->is_vendor   && $model->vendor->is($user->enterprise)) ||
                ($user->enterprise->is_customer && $model->missionOffer->customer->is($user->enterprise))
            );
    }

    public function create(User $user)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer;
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user, Proposal $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->missionOffer->customer->is($user->enterprise)
            && $model->isDraft();
    }

    public function update(User $user, Proposal $model)
    {
        return $this->edit($user, $model);
    }

    public function destroy(User $user, Proposal $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->missionOffer->customer->is($user->enterprise)
            && $model->isDraft();
    }

    public function restore(User $user, Proposal $model)
    {
        return $user->isSupport();
    }

    public function forceDelete(User $user, Proposal $model)
    {
        return false;
    }

    public function assign(User $user, Proposal $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->missionOffer->customer->is($user->enterprise)
            && $model->vendor->exists
            && $model->isAccepted();
    }

    public function interestedStatus(User $user, Proposal $proposal)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_vendor && $proposal->vendor->is($user->enterprise)
            && $proposal->offer->customer->isMemberOfSogetrelGroup()
            && $proposal->isReceived()
            && !$proposal->getOffer()->isClosed();
    }

    public function viewCommentsTab(User $user, Proposal $proposal)
    {
        // @todo this should be passed as parameter!
        $enterprise = $user->enterprise;

        return $user->isSupport()
            ||    $user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            &&    $user->hasAccessFor($enterprise, [User::ACCESS_TO_MISSION])
            &&    $proposal->offer->customer->isMemberOfSogetrelGroup()
            &&  ! $proposal->isReceived()
            && (
                 ($enterprise->is_vendor   && $proposal->vendor->is($enterprise)) ||
                 ($enterprise->is_customer && $proposal->missionOffer->customer->is($enterprise))
            );
    }

    public function storeBpu(User $user)
    {
        return $this->create($user);
    }

    public function seeSogetrelAlert(User $user, Proposal $proposal)
    {
        return $user->isSupport()
            || $user->hasRoleFor($proposal->vendor, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($proposal->vendor, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_vendor && $proposal->vendor->is($user->enterprise)
            && $proposal->offer->customer->isMemberOfSogetrelGroup()
            && $proposal->isInterested();
    }
}
