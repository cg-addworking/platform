<?php

namespace Components\Mission\Offer\Application\Presenters;

use Components\Mission\Offer\Domain\Interfaces\Presenters\OfferShowPresenterInterface;

class OfferShowPresenter implements OfferShowPresenterInterface
{
    public function present($offer)
    {
        return $offer;
    }
}
