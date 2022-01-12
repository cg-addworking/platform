<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\OfferStatusWrong;
use Components\Mission\Offer\Domain\Exceptions\UserHasNotPermissionToSendOfferException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ProposalRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;

class SendOfferToEnterprise
{
    private $proposalRepository;
    private $enterpriseRepository;
    private $offerRepository;
    private $userRepository;

    public function __construct(
        ProposalRepositoryInterface $proposalRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        OfferRepositoryInterface $offerRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->proposalRepository = $proposalRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->offerRepository = $offerRepository;
        $this->userRepository  = $userRepository;
    }

    public function handle(?User $auth_user, ?OfferEntityInterface $offer, array $inputs)
    {
        $this->check($auth_user, $offer);

        foreach ($inputs['vendor'] as $vendor_id) {
            $vendor = $this->enterpriseRepository->find($vendor_id);

            $proposal = $this->proposalRepository->make();
            $proposal->setOffer($offer);
            $proposal->setVendor($vendor);
            $proposal->setCreatedBy($auth_user);

            $saved = $this->proposalRepository->save($proposal);

            $this->proposalRepository->sendNotification($saved->getOffer(), $vendor);
        }

        $offer->setStatus(OfferEntityInterface::STATUS_COMMUNICATED);
        $this->offerRepository->save($offer);

        return $offer;
    }

    private function check(?User $user, ?OfferEntityInterface $offer)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (is_null($offer)) {
            throw new OfferNotFoundException();
        }

        if (! $this->offerRepository->userEnterpriseIsOfferOwner($user, $offer)
                && ! $this->userRepository->isSupport($user)) {
            throw new UserHasNotPermissionToSendOfferException();
        }

        if ($offer->getStatus() === OfferEntityInterface::STATUS_CLOSED) {
            throw new OfferStatusWrong();
        }
    }
}
