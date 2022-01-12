<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProposalResponsePolicy
{
    use HandlesAuthorization;

    public function index(User $user, Proposal $proposal)
    {
        // @todo this should be passed as parameter!
        $enterprise = $user->enterprise;

        return $user->isSupport()
            ||   ($user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            &&   $user->hasAccessFor($enterprise, [User::ACCESS_TO_MISSION])
            && (
                ($enterprise->is_vendor   && $proposal->vendor->is($enterprise)) ||
                ($enterprise->is_customer && $proposal->offer->customer->is($enterprise))
            ));
    }

    public function indexOfferAnswers(User $user, Offer $offer)
    {
        if (! $offer->customer->exists) {
            return Response::deny("You can't index answers of a malformed offer");
        }

        if (! $offer->exists) {
            return Response::deny("You can't index answers of a missing offer");
        }

        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $offer->customer->is($user->enterprise)) {
            return Response::deny("You can't view the responses for this offer: not your enterprise");
        }

        if (! $user->hasRoleFor($offer->customer, User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY)) {
            return Response::deny("You don't have enough privileges on enterprise {$offer->customer->name}");
        }

        if (! $user->hasAccessFor($offer->customer, User::ACCESS_TO_MISSION)) {
            return Response::deny("You don't have access to missions of {$offer->customer->name}");
        }

        return Response::allow();
    }

    public function create(User $user, Proposal $proposal)
    {
        // @todo this should be passed as parameter!
        $enterprise = $user->enterprise;

        return $user->isSupport()
            || $user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($enterprise, [User::ACCESS_TO_MISSION])
            && $enterprise->is_vendor && $proposal->vendor->is($enterprise)
            && (
                 ! $proposal->offer->customer->isMemberOfSogetrelGroup() ||
                (  $proposal->offer->customer->isMemberOfSogetrelGroup() &&
                 ! $proposal->isReceived() &&
                 ! $proposal->isInterested()
                )
            );
    }

    public function store(User $user, Proposal $proposal)
    {
        return $this->create($user, $proposal);
    }

    public function edit(User $user, ProposalResponse $response)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $user->enterprise->is_vendor
            && $response->proposal->vendor->is($user->enterprise));
    }

    public function update(User $user, ProposalResponse $response)
    {
        return $this->edit($user, $response);
    }

    public function show(User $user, ProposalResponse $response)
    {
        return $user->isSupport()
            || (
                $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
                && (
                    ($user->enterprise->is_vendor && $response->proposal->vendor->is($user->enterprise))
                    || $user->enterprise->is_customer
                        && $response->proposal->missionOffer->customer->is($user->enterprise)
                )
            );
    }

    public function updateResponseStatus(User $user, ProposalResponse $response)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
            && $response->proposal->missionOffer->customer->is($user->enterprise)
            && !$response->isRefused());
    }

    public function mission(User $user, ProposalResponse $response)
    {
        return
            // the support can create the  mission from the response
            // if the mission doesn't exists() already && its status isFinalValidated()
            ($user->isSupport() && !$response->mission()->exists() && $response->isFinalValidated())
            ||
            // the connected user who must have access (IS_ADMIN OR IS_OPERATOR)
            // to the company who issued the proposal, can create the mission from the response
            // if the mission doesn't exists() already && its status isFinalValidated()
            $user->hasRoleFor($response->proposal->offer->customer, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($response->proposal->offer->customer, [User::ACCESS_TO_MISSION])
            && $response->isFinalValidated()
            && !$response->mission()->exists();
    }
}
