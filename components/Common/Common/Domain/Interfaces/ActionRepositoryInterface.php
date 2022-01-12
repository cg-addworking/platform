<?php

namespace Components\Common\Common\Domain\Interfaces;

interface ActionRepositoryInterface
{
    public function make(): ActionEntityInterface;
    public function save(ActionEntityInterface $action): bool;
}
