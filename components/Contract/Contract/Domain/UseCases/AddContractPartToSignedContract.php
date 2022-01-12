<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotGenerateException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class AddContractPartToSignedContract
{
    protected $contractPartRepository;
    protected $userRepository;
    protected $contractRepository;
    protected $contractStateRepository;

    public function __construct(
        ContractPartRepositoryInterface $contractPartRepository,
        UserRepositoryInterface $userRepository,
        ContractRepository $contractRepository,
        ContractStateRepository $contractStateRepository
    ) {
        $this->contractPartRepository = $contractPartRepository;
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function handle(
        ?User $auth_user,
        ?ContractEntityInterface $contract,
        ?array $inputs,
        $file
    ) {
        $this->checkContract($contract);
        $this->checkUser($auth_user, $contract);

        $file = $this->contractPartRepository->createFile($file);

        $contract_part = $this->contractPartRepository->make();
        $contract_part->setContract($contract);
        $contract_part->setFile($file);
        $contract_part->setDisplayName($inputs['display_name']);
        $contract_part->setName($inputs['display_name']);
        $contract_part->setIsSigned(false);
        $contract_part->setIsUsedInContractBody(false);
        $contract_part->setNumber();

        $contract_part = $this->contractPartRepository->save($contract_part);

        return $contract_part;
    }

    private function checkUser($auth_user, $contract)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if ($this->userRepository->isSupport($auth_user)) {
            return true;
        }

        if (!$this->contractRepository->isPartyOf($auth_user, $contract)
            && !$this->contractRepository->isOwnerOf($auth_user, $contract)) {
            throw new EnterpriseDoesntHavePartnershipWithContractException;
        }
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException;
        }

        if (!($this->contractStateRepository->toSign($contract) ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract))
        ) {
            throw new ContractInvalidStateException;
        }
    }
}
