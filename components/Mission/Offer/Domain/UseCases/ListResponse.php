<?php

namespace Components\Mission\Offer\Domain\UseCases;

use Illuminate\Support\Facades\App;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ResponseRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Presenters\ResponseListPresenterInterface;

class ListResponse
{
    private $responseRepository;

    public function __construct(ResponseRepositoryInterface $responseRepository)
    {
        $this->responseRepository = $responseRepository;
    }

    public function handle(
        ResponseListPresenterInterface $presenter,
        ?User $auth_user,
        ?OfferEntityInterface $offer,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->check($auth_user);
        $this->checkOffer($offer);

        $responses = $this->responseRepository
            ->list($auth_user, $offer, $filter, $search, $page, $operator, $field_name);

        return $presenter->present($responses);
    }

    public function check(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    public function checkOffer(?OfferEntityInterface $offer)
    {
        if (is_null($offer)) {
            throw new OfferNotFoundException;
        }
    }
}
