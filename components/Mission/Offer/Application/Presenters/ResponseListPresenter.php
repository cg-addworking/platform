<?php

namespace Components\Mission\Offer\Application\Presenters;

use Components\Mission\Offer\Domain\Interfaces\Presenters\ResponseListPresenterInterface;

class ResponseListPresenter implements ResponseListPresenterInterface
{
    public function present($responses)
    {
        return $responses;
    }
}
