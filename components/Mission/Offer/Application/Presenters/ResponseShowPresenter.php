<?php

namespace Components\Mission\Offer\Application\Presenters;

use Components\Mission\Offer\Domain\Interfaces\Presenters\ResponseShowPresenterInterface;

class ResponseShowPresenter implements ResponseShowPresenterInterface
{
    public function present($response)
    {
        return $response;
    }
}
