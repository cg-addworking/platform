<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\SubcontractingDeclaration;

interface SubcontractingDeclarationRepositoryInterface
{
    public function make(): SubcontractingDeclaration;
    public function save(SubcontractingDeclaration $declaration);
    public function getSubcontractingDeclarationOf(Contract $contract);
    public function delete(SubcontractingDeclaration $declaration);
}
