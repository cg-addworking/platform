<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractPartyIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractPartyEnterpriseException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListContractPartyDocument
{
    private $contractModelDocumentTypeRepository;
    private $userRepository;

    public function __construct(
        ContractModelDocumentTypeRepositoryInterface $contractModelDocumentTypeRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelDocumentTypeRepository = $contractModelDocumentTypeRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        ?User $auth_user,
        ContractPartyEntityInterface $contract_party,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null
    ) {
        $this->checkUser($auth_user, $contract_party);
        $this->checkContractParty($contract_party);

        return $this->contractModelDocumentTypeRepository->list($contract_party, $filter, $search);
    }

    public function checkUser(?User $user, ContractPartyEntityInterface $contract_party)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if ($this->userRepository->isSupport($user)) {
            return true;
        }

        if (! $user->enterprises->contains($contract_party->getEnterprise())) {
            throw new UserIsNotMemberOfTheContractPartyEnterpriseException();
        }

        return true;
    }

    private function checkContractParty($contract_party)
    {
        if (is_null($contract_party)) {
            throw new ContractPartyIsNotFoundException();
        }
    }
}
