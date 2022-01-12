<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\UserHasNotPermissionToShowOfferException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Presenters\OfferShowPresenterInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ProposalRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ShowConstructionOffer
{
    private $proposalRepository;
    private $offerRepository;
    private $userRepository;

    public function __construct(
        ProposalRepositoryInterface $proposalRepository,
        OfferRepositoryInterface $offerRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->proposalRepository = $proposalRepository;
        $this->offerRepository = $offerRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(OfferShowPresenterInterface $offerShowPresenter, ?User $authenticated, ?Offer $offer)
    {
        $this->check($authenticated, $offer);

        return $offerShowPresenter->present($offer);
    }

    private function check(?User $user, ?Offer $offer)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($offer)) {
            throw new OfferNotFoundException;
        }

        if (! ($this->offerRepository->userEnterpriseIsOfferOwner($user, $offer) ||
            $this->userRepository->isSupport($user) ||
            $this->proposalRepository->hasProposalFor($offer, $user->enterprise))) {
            throw new UserHasNotPermissionToShowOfferException;
        }
    }
}
