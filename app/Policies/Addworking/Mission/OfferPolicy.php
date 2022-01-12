<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer;
    }

    public function show(User $user, Offer $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->customer->is($user->enterprise);
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

    public function edit(User $user, Offer $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->customer->is($user->enterprise)
            && ($model->isDraft() || $model->isToProvide());
    }

    public function update(User $user, Offer $model)
    {
        return $this->edit($user, $model);
    }

    public function destroy(User $user, Offer $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->customer->is($user->enterprise)
            && ($model->isDraft() || $model->isToProvide());
    }

    public function restore(User $user, Offer $offer)
    {
        return $user->isSupport();
    }

    public function forceDelete(User $user, Offer $offer)
    {
        return false;
    }

    public function status(User $user, Offer $offer)
    {
        return $user->isSupport();
    }

    public function broadcast(User $user, Offer $offer): Response
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasAccessToMissionFor($offer->customer)) {
            return Response::deny("You don't have access to {$offer->customer->name} missions");
        }

        if (! $user->hasRoleFor($offer->customer, [User::IS_MISSION_OFFER_BROADCASTER])) {
            return Response::deny("You are not able to broadcast offers of {$offer->customer->name}");
        }

        if ($offer->isCommunicated()) {
            return Response::deny("This offer has already been broadcasted");
        }

        return Response::allow();
    }

    public function close(User $user, Offer $offer): Response
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasAccessToMissionFor($offer->customer)) {
            return Response::deny("You don't have access to {$offer->customer->name} missions");
        }

        if (! $user->hasRoleFor($offer->customer, [User::IS_MISSION_OFFER_CLOSER])) {
            return Response::deny("You are not able to close offers of {$offer->customer->name}");
        }

        if (! $offer->isCommunicated()) {
            return Response::deny("This offer hasn't been broadcasted yet");
        }

        return Response::allow();
    }

    public function summary(User $user, Offer $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $model->customer->is($user->enterprise)
            && $model->isClosed();
    }

    public function requestValidation(User $user)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer;
    }

    public function resendProposal(User $user)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer;
    }

    public function assign(User $user, Offer $offer)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_customer
            && $offer->isToProvide();
    }

    public function sendRequestClose(User $user, Offer $offer)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasAccessToMissionFor($offer->customer)) {
            return Response::deny("You don't have access to {$offer->customer->name} missions");
        }

        if (! $offer->isCommunicated()) {
            return Response::deny("This offer hasn't been broadcasted yet");
        }

        return Response::allow();
    }
}
