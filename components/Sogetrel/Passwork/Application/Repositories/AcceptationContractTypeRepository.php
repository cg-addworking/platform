<?php

namespace Components\Sogetrel\Passwork\Application\Repositories;

use Components\Sogetrel\Passwork\Application\Models\AcceptationContractType;
use Components\Sogetrel\Passwork\Domain\Exceptions\AcceptationContractTypeCreationFailedException;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationContractTypeEntityInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationContractTypeRepositoryInterface;

class AcceptationContractTypeRepository implements AcceptationContractTypeRepositoryInterface
{
    public function make($data = []): AcceptationContractTypeEntityInterface
    {
        return new AcceptationContractType($data);
    }

    public function save(
        AcceptationContractTypeEntityInterface $acceptation_contract_type
    ): AcceptationContractTypeEntityInterface {
        try {
            $acceptation_contract_type->save();
        } catch (AcceptationContractTypeCreationFailedException $exception) {
            throw $exception;
        }

        $acceptation_contract_type->refresh();

        return $acceptation_contract_type;
    }
}
