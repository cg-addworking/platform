<?php

namespace Components\Common\Common\Application\Repositories;

use Components\Common\Common\Application\Models\Action;
use Components\Common\Common\Domain\Exceptions\UnableToSaveException;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Common\Common\Domain\Interfaces\ActionRepositoryInterface;

class ActionRepository implements ActionRepositoryInterface
{
    public function make(): ActionEntityInterface
    {
        return new Action;
    }

    public function save(ActionEntityInterface $action): bool
    {
        try {
            $action->save();
        } catch (UnableToSaveException $exception) {
            throw $exception;
        }

        $action->refresh();

        return $action;
    }
}
