<?php

namespace Components\Mission\Mission\Application\Presenters;

use Components\Mission\Mission\Domain\Interfaces\Presenters\MissionShowPresenterInterface;

class MissionShowPresenter implements MissionShowPresenterInterface
{
    public function present($mission)
    {
        return $mission;
    }
}
