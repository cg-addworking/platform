<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListDocumentTypeOfContractModelParty
{
    private $userRepository;
    private $contractModelDocumentTypeRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractModelDocumentTypeRepositoryInterface $contractModelDocumentTypeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractModelDocumentTypeRepository = $contractModelDocumentTypeRepository;
    }

    public function handle(
        User $auth_user,
        ?ContractModelPartyEntityInterface $contract_model_party,
        ?array $filter = [],
        ?string $search = null
    ) {
        $this->checkUser($auth_user);
        $this->checkContractModelParty($contract_model_party);

        return $this->contractModelDocumentTypeRepository->list($filter, $search, $contract_model_party);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContractModelParty($contract_model_party)
    {
        if (is_null($contract_model_party)) {
            throw new ContractModelPartyIsNotFoundException();
        }
    }
}
