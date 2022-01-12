<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Presenters;

use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;

interface WorkFieldShowPresenterInterface
{
    public function present(WorkFieldEntityInterface $work_field);
}
