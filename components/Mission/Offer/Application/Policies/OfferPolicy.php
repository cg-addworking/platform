<?php

namespace Components\Mission\Offer\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\ProposalRepository;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $sectorRepository;
    protected $offerRepository;
    protected $proposalRepository;

    public function __construct(
        SectorRepository $sectorRepository,
        UserRepository $userRepository,
        OfferRepository $offerRepository,
        ProposalRepository $proposalRepository
    ) {
        $this->sectorRepository = $sectorRepository;
        $this->userRepository = $userRepository;
        $this->offerRepository = $offerRepository;
        $this->proposalRepository = $proposalRepository;
    }

    public function index(User $user)
    {
        return Response::allow();
    }

    public function create(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->sectorRepository->belongsToConstructionSector($user->enterprise)) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You don't have acces to construction offer");
        }

        return Response::allow();
    }

    public function show(User $user, Offer $offer)
    {
        if (! $this->sectorRepository->belongsToConstructionSector($offer->getCustomer())) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if ($this->userRepository->isSupport($user) || $offer->getCustomer()->is($user->enterprise)) {
            return Response::allow();
        }

        if (! $this->proposalRepository->hasProposalFor($offer, $user->enterprise)) {
            return Response::deny('You can\'t answer to this offer');
        }

        return Response::allow();
    }

    public function edit(User $user, Offer $offer)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->sectorRepository->belongsToConstructionSector($offer->getCustomer())) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if (! $this->userRepository->connectedUser()->enterprise->is($offer->getCustomer())) {
            return Response::deny("You don't have acces to construction offer");
        }

        if ($offer->getStatus() === Offer::STATUS_CLOSED) {
            return Response::deny("You cant't modify this construction offer");
        }

        return Response::allow();
    }

    public function sendToEnterprise(User $user, Offer $offer)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->userRepository->connectedUser()->enterprise->is($offer->getCustomer())) {
            return Response::deny("You don't have acces to construction offer");
        }

        if ($offer->getStatus() === OfferEntityInterface::STATUS_CLOSED) {
            return Response::deny("You cant't send this construction offer");
        }

        return Response::allow();
    }

    public function viewProtectedDatas(User $user, Offer $offer)
    {
        if (! $this->sectorRepository->belongsToConstructionSector($offer->getCustomer())) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->userRepository->connectedUser()->enterprise->is($offer->getCustomer())) {
            return Response::deny("You don't have acces to the construction offer recipients");
        }

        return Response::allow();
    }

    public function close(User $user, Offer $offer)
    {
        if (! $offer->getCustomer()->is($user->enterprise)) {
            return Response::deny("You don't have access to close the offer");
        }

        if (! $this->offerRepository->hasAcceptedResponses($offer)) {
            return Response::deny("the offer doesn't have accepted responses");
        }

        if ($offer->getStatus() === OfferEntityInterface::STATUS_CLOSED) {
            return Response::deny("Offer is already closed");
        }

        return Response::allow();
    }

    public function delete(User $user, Offer $offer)
    {
        if (in_array($offer->getStatus(), [
            OfferEntityInterface::STATUS_COMMUNICATED,
            OfferEntityInterface::STATUS_CLOSED ,
            OfferEntityInterface::STATUS_ABANDONED
            ])
        ) {
            return Response::deny('Offer is already communicated');
        }
        if (! ($this->offerRepository->userEnterpriseIsOfferOwner($user, $offer) ||
            $user->isSupport())) {
                return Response::deny("You don't have access to delete the offer");
        }

        return Response::allow();
    }
}
