<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Exceptions\UserNotFoundException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Offer\Domain\Exceptions\UserHasNotPermissionToEditOfferException;
use Components\Mission\Offer\Domain\Exceptions\OfferStatusClosedException;

class EditConstructionOffer
{
    private $offerRepository;
    private $userRepository;

    public function __construct(
        OfferRepositoryInterface $offerRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->offerRepository = $offerRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(?User $auth_user, ?OfferEntityInterface $offer, array $inputs, $files = [])
    {
        $referent = $this->userRepository->find($inputs['referent_id']);

        $this->checkUser($auth_user, $referent);
        $this->checkOffer($auth_user, $offer);

        $offer->setLabel($inputs['label']);
        $offer->setStartsAtDesired($inputs['starts_at_desired']);
        $offer->setEndsAt($inputs['ends_at']);
        $offer->setDescription($inputs['description']);
        $offer->setExternalId($inputs['external_id']);
        $offer->setAnalyticCode($inputs['analytic_code']);
        $offer->setReferent($referent);

        if (! empty($inputs['response_deadline'])) {
            $offer->setResponseDeadline($inputs['response_deadline']);
        }
        $saved = $this->offerRepository->save($offer);

        if (! empty($inputs['departments'])) {
            $offer->unsetDepartments($offer->getDepartments());
            $offer->setDepartments($inputs['departments']);
        }

        if (! empty($inputs['skills'])) {
            $offer->unsetSkills($offer->getSkills());
            $offer->setSkills($inputs['skills']);
        }

        if (! empty($files)) {
            $this->offerRepository->createFiles($files, $offer);
        }

        return $saved;
    }

    private function checkUser(?User $user, ?User $referent)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($referent)) {
            throw new UserNotFoundException;
        }
    }

    private function checkOffer(?User $user, ?OfferEntityInterface $offer)
    {
        if (is_null($offer)) {
            throw new OfferNotFoundException;
        }

        if (! $user->enterprise->is($offer->getCustomer()) && ! $user->isSupport()) {
            throw new UserHasNotPermissionToEditOfferException;
        }

        if ($offer->getStatus() === Offer::STATUS_CLOSED) {
            throw new OfferStatusClosedException;
        }
    }
}
