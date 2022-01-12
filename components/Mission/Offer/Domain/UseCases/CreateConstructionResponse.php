<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Application\Repositories\ProposalRepository;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseNotVendorException;
use Components\Mission\Offer\Domain\Exceptions\OfferNotCommunicatedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Carbon\Carbon;
use Components\Mission\Offer\Domain\Exceptions\ResponseDeadlineExceededException;

class CreateConstructionResponse
{
    private $responseRepository;
    private $proposalRepository;

    public function __construct(ResponseRepository $responseRepository, ProposalRepository $proposalRepository)
    {
        $this->responseRepository = $responseRepository;
        $this->proposalRepository = $proposalRepository;
    }

    public function handle(?User $auth_user, ?Offer $offer, array $inputs, $file)
    {
        $this->checkUser($auth_user, $offer);
        $this->checkOffer($auth_user, $offer);
        $created_file = $this->responseRepository->createFile($file);

        $response = $this->responseRepository->make();
        $response->setNumber();
        $response->setStartsAt($inputs['starts_at']);
        $response->setEndsAt($inputs['ends_at']);
        $response->setAmountBeforeTaxes($inputs['amount_before_taxes']);
        $response->setArgument($inputs['argument']);
        $response->setOffer($offer);
        $response->setCreatedBy($auth_user);
        $response->setEnterprise($auth_user->enterprise);
        $response->setFile($created_file);
        $saved = $this->responseRepository->save($response);

        $this->responseRepository->sendCreateNotification($saved);

        return $saved;
    }

    public function checkUser(?User $auth_user, ?Offer $offer)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkOffer(?User $auth_user, ?Offer $offer)
    {
        if (is_null($offer)) {
            throw new OfferNotFoundException;
        }

        if ($offer->getStatus() !== OfferEntityInterface::STATUS_COMMUNICATED) {
            throw new OfferNotCommunicatedException;
        }

        if (! $this->proposalRepository->hasProposalFor($offer, $auth_user->enterprise)) {
            throw new EnterpriseNotVendorException;
        }

        if (! empty($offer->getResponseDeadline())) {
            if (Carbon::now()->format('Y-m-d') > $offer->getResponseDeadline()->format('Y-m-d')) {
                throw new ResponseDeadlineExceededException;
            }
        }
    }
}
