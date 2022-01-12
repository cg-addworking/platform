<?php

namespace Components\Enterprise\WorkField\Application\Presenters;

use Components\Enterprise\WorkField\Domain\Interfaces\Presenters\WorkFieldListPresenterInterface;

class WorkFieldListPresenter implements WorkFieldListPresenterInterface
{
    public function present($work_fields)
    {
        return $work_fields;
    }
}
