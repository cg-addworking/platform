<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserNotAllowedToAssociateAnnexToContractException;
use Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use setasign\Fpdi\Fpdi;

class AssociateAnnexToContract
{
    private UserRepositoryInterface $userRepository;
    private ContractRepositoryInterface $contractRepository;
    private ContractPartRepository $contractPartRepository;
    private ContractStateRepository $contractStateRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractRepositoryInterface $contractRepository,
        ContractPartRepository $contractPartRepository,
        ContractStateRepository $contractStateRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function handle(
        User $authUser,
        ?AnnexEntityInterface $annex,
        ?ContractEntityInterface $contract,
        ?array $inputs
    ) {
        $this->checkContract($contract);
        $this->checkUser($authUser, $contract);

        $contract_part = $this->createContractPart($contract, $inputs, $annex->getFile());

        return $this->contractPartRepository->save($contract_part);
    }

    private function checkUser(?User $user, ?ContractEntityInterface $contract)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)
            && (! is_null($contract) && ! $this->userRepository->checkIfUserHasAccessTo($user, $contract))
        ) {
            throw new UserNotAllowedToAssociateAnnexToContractException();
        }
    }

    private function checkContract(?ContractEntityInterface $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }

        if ($this->contractStateRepository->toValidate($contract) ||
            $this->contractStateRepository->toSign($contract) ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract)
        ) {
            throw new ContractInvalidStateException();
        }
    }

    public function createContractPart(?ContractEntityInterface $contract, ?array $inputs, $file)
    {
        $contract_part = $this->contractPartRepository->make();

        $contract_part->setContract($contract);
        $contract_part->setFile($file);
        $contract_part->setDisplayName($inputs['display_name']);
        $contract_part->setName($inputs['display_name']);
        $contract_part->setIsSigned(false);
        $contract_part->setNumber();
        $contract_part->setOrder($this->contractRepository->getContractParts($contract)->count() + 1);

        return $contract_part;
    }
}
