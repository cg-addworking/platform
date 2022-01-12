<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Domain\Exceptions\ResponseNotFoundException;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Presenters\ResponseShowPresenterInterface;
use Components\Mission\Offer\Domain\Exceptions\UserHasNotPermissionToShowResponseException;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ResponseRepositoryInterface;

class ShowConstructionResponse
{
    private $offerRepository;
    private $userRepository;
    private $responseRepository;

    public function __construct(
        OfferRepositoryInterface $offerRepository,
        UserRepositoryInterface $userRepository,
        ResponseRepositoryInterface $responseRepository
    ) {
        $this->offerRepository = $offerRepository;
        $this->userRepository = $userRepository;
        $this->responseRepository = $responseRepository;
    }

    public function handle(
        ResponseShowPresenterInterface $responseShowPresenter,
        ?User $authenticated,
        ?Response $response
    ) {
        $this->check($authenticated, $response);

        return $responseShowPresenter->present($response);
    }

    private function check(?User $user, ?Response $response)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($response)) {
            throw new ResponseNotFoundException;
        }

        if (! ($this->offerRepository->userEnterpriseIsOfferOwner($user, $response->getOffer()) ||
            $this->responseRepository->userEnterpriseIsResponseOwner($user, $response) ||
            $this->userRepository->isSupport($user))
        ) {
            throw new UserHasNotPermissionToShowResponseException;
        }
    }
}
