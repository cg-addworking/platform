<?php

namespace Components\Mission\Offer\Application\Policies;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Response as ResponseModel;
use Components\Mission\Offer\Application\Repositories\ProposalRepository;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ResponsePolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $proposalRepository;

    public function __construct(
        UserRepository $userRepository,
        ProposalRepository $proposalRepository
    ) {
        $this->userRepository = $userRepository;
        $this->proposalRepository = $proposalRepository;
    }

    public function create(User $user, Offer $offer)
    {
        if (! $this->proposalRepository->hasProposalFor($offer, $user->enterprise)) {
            return Response::deny('You can\'t answer to this offer');
        }

        if ($offer->getStatus() !== OfferEntityInterface::STATUS_COMMUNICATED) {
            return Response::deny("you can't response to this offer");
        }

        return $this->checkIfUserCanRespondTo($user, $offer);
    }

    public function accept(User $user, ResponseModel $response, Offer $offer)
    {
        if ($offer->getStatus() === OfferEntityInterface::STATUS_CLOSED) {
            return Response::deny("This offer is closed");
        }

        if ($response->getStatus() !== ResponseEntityInterface::STATUS_PENDING) {
            return Response::deny("This offer is not pending status");
        }

        if (! $user->enterprise->is($offer->getCustomer())) {
            return Response::deny("you can't accept this offer");
        }

        return Response::allow();
    }

    public function reject(User $user, ResponseModel $response, Offer $offer)
    {
        if ($offer->getStatus() === OfferEntityInterface::STATUS_CLOSED) {
            return Response::deny("This offer is closed");
        }

        if ($response->getStatus() !== ResponseEntityInterface::STATUS_PENDING) {
            return Response::deny("This offer is not pending status");
        }

        if (! $user->enterprise->is($offer->getCustomer())) {
            return Response::deny("you can't accept this offer");
        }

        return Response::allow();
    }

    public function show(User $user, ResponseModel $response, Offer $offer)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! ($user->enterprise->is($offer->getCustomer()) ||
            $user->enterprise->is($response->getEnterprise()))
        ) {
            return Response::deny("you can't see this response");
        }

        return Response::allow();
    }

    public function index(User $user, Offer $offer)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! count($offer->getResponses())) {
            return Response::deny("you can't see responses of this offer");
        }

        return Response::allow();
    }

    public function checkIfUserCanRespondTo(User $user, Offer $offer)
    {
        if (! is_null($offer->getResponseDeadline())
            && Carbon::today()->gt($offer->getResponseDeadline())
        ) {
            return Response::deny('You can\'t answer to this offer');
        }

        return Response::allow();
    }
}
