<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Mission\Offer\Domain\Exceptions\OfferCantBeDeletedException;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;

class DeleteOffer
{
    private $offerRepository;
    private $userRepository;

    public function __construct(
        OfferRepositoryInterface $offerRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->offerRepository = $offerRepository;
        $this->userRepository =  $userRepository;
    }

    public function handle(?User $auth_user, ?OfferEntityInterface $offer)
    {
        $this->check($auth_user, $offer);

        return $this->offerRepository->delete($offer);
    }

    public function check(?User $auth_user, ?Offer $offer)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($offer)) {
            throw new OfferNotFoundException;
        }

        if (in_array($offer->getStatus(), [
            OfferEntityInterface::STATUS_COMMUNICATED,
            OfferEntityInterface::STATUS_CLOSED ,
            OfferEntityInterface::STATUS_ABANDONED
            ])
        ) {
            throw new OfferCantBeDeletedException;
        }
        if (! ($this->offerRepository->userEnterpriseIsOfferOwner($auth_user, $offer) ||
            $this->userRepository->isSupport($auth_user))) {
            throw new EnterpriseIsNotCustomerException;
        }
    }
}
