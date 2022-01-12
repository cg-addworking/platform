<?php

namespace Components\Sogetrel\Passwork\Domain\UseCases;

use App\Models\Sogetrel\Contract\Type as ContractType;
use Components\Sogetrel\Passwork\Domain\Exceptions\AcceptationIsNotFoundException;
use Components\Sogetrel\Passwork\Domain\Exceptions\ContractTypeIsNotFoundException;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationEntityInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationContractTypeRepositoryInterface;

class CreateAcceptationContractType
{
    protected $acceptationContractTypeRepository;

    public function __construct(AcceptationContractTypeRepositoryInterface $acceptationContractTypeRepository)
    {
        $this->acceptationContractTypeRepository = $acceptationContractTypeRepository;
    }

    public function handle(?AcceptationEntityInterface $acceptation, ?ContractType $contract_type)
    {
        $this->checkAcceptation($acceptation);
        $this->checkContractType($contract_type);

        $acceptation_contract_type = $this->acceptationContractTypeRepository->make();

        $acceptation_contract_type->setNumber();
        $acceptation_contract_type->setAcceptation($acceptation);
        $acceptation_contract_type->setContractType($contract_type);

        return $this->acceptationContractTypeRepository->save($acceptation_contract_type);
    }

    private function checkAcceptation(?AcceptationEntityInterface $acceptation)
    {
        if (is_null($acceptation)) {
            throw new AcceptationIsNotFoundException;
        }
    }

    private function checkContractType(?ContractType $contract_type)
    {
        if (is_null($contract_type)) {
            throw new ContractTypeIsNotFoundException;
        }
    }
}
