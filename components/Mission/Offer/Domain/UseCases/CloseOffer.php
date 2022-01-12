<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Application\Repositories\MissionRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Mission\Offer\Domain\Exceptions\OfferAlreadyClosedException;
use Components\Mission\Offer\Domain\Exceptions\OfferHasNotAcceptedResponseException;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\CostEstimationRepositoryInterface;

class CloseOffer
{
    private $responseRepository;
    private $missionRepository;
    private $offerRepository;
    private $costEstimationRepository;

    public function __construct(
        ResponseRepository $responseRepository,
        MissionRepository $missionRepository,
        OfferRepository $offerRepository,
        CostEstimationRepositoryInterface $costEstimationRepository
    ) {
        $this->responseRepository = $responseRepository;
        $this->missionRepository = $missionRepository;
        $this->offerRepository = $offerRepository;
        $this->costEstimationRepository = $costEstimationRepository;
    }

    public function handle(?User $auth_user, ?OfferEntityInterface $offer)
    {
        $this->check($auth_user, $offer);

        $offer->setStatus(OfferEntityInterface::STATUS_CLOSED);
        $this->offerRepository->save($offer);

        foreach ($offer->getResponses() as $response) {
            /* @var Response $response */
            if ($response->getStatus() === ResponseEntityInterface::STATUS_ACCEPTED) {
                $this->responseRepository->sendAcceptedNotification($response->getCreatedBy(), $offer);
                $mission = $this->missionRepository->createFromResponse($response);
                $cost_estimation = $this->costEstimationRepository->createFromResponse($response);
                $mission->setCostEstimation($cost_estimation);
                $this->missionRepository->save($mission);
            } else {
                $response->setStatus(ResponseEntityInterface::STATUS_NOT_SELECTED);
                $this->responseRepository->save($response);

                $this->responseRepository->sendDeclinedNotification($response->getCreatedBy(), $offer);
            }
        }

        return $offer;
    }

    public function check(?User $auth_user, ?Offer $offer)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($offer)) {
            throw new OfferNotFoundException;
        }

        if (! $auth_user->enterprise->is($offer->getCustomer())) {
            throw new EnterpriseIsNotCustomerException;
        }

        if (! $this->offerRepository->hasAcceptedResponses($offer)) {
            throw new OfferHasNotAcceptedResponseException;
        }

        if ($offer->getStatus() === OfferEntityInterface::STATUS_CLOSED) {
            throw new OfferAlreadyClosedException;
        }
    }
}
