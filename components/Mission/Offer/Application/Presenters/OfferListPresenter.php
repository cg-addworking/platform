<?php

namespace Components\Mission\Offer\Application\Presenters;

use Components\Mission\Offer\Domain\Interfaces\Presenters\OfferListPresenterInterface;

class OfferListPresenter implements OfferListPresenterInterface
{
    public function present($offers)
    {
        return $offers;
    }
}
