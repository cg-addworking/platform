<?php

namespace Components\Sogetrel\Passwork\Domain\Interfaces\Repositories;

use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationContractTypeEntityInterface;

interface AcceptationContractTypeRepositoryInterface
{
    public function make($data = []): AcceptationContractTypeEntityInterface;
    public function save(AcceptationContractTypeEntityInterface $acceptation): AcceptationContractTypeEntityInterface;
}
