<?php

namespace Components\Mission\Offer\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Offer\Domain\Interfaces\Presenters\OfferListPresenterInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;

class ListOffer
{
    private $offerRepository;

    public function __construct(
        OfferRepositoryInterface $offerRepository
    ) {
        $this->offerRepository = $offerRepository;
    }

    public function handle(
        OfferListPresenterInterface $offer_list_presenter,
        ?User $authenticated,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->check($authenticated);

        return $offer_list_presenter
            ->present($this->offerRepository->list($authenticated, $filter, $search, $page, $operator, $field_name));
    }

    public function check(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
