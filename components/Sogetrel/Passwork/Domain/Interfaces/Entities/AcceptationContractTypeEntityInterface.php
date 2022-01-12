<?php

namespace Components\Sogetrel\Passwork\Domain\Interfaces\Entities;

use App\Models\Sogetrel\Contract\Type as ContractType;
use Components\Sogetrel\Passwork\Application\Models\Acceptation;

interface AcceptationContractTypeEntityInterface
{
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber():void;
    public function setAcceptation(Acceptation $acceptation);
    public function setContractType(ContractType $contract_type);

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    //
}
