<?php

namespace Components\Sogetrel\Passwork\Domain\Interfaces\Repositories;

use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationEntityInterface;

interface AcceptationRepositoryInterface
{
    public function make($data = []): AcceptationEntityInterface;
    public function save(AcceptationEntityInterface $acceptation): AcceptationEntityInterface;
}
