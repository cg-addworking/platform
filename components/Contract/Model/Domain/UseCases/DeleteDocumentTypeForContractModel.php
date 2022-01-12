<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelDocumentTypeEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteDocumentTypeForContractModel
{
    private $contractModelRepository;
    private $userRepository;
    private $contractModelDocumentTypeRepository;
    private $documentTypeRepository;

    /**
     * DefineDocumentTypeForContractModel constructor.
     */
    public function __construct(
        ContractModelRepositoryInterface $contractModelRepository,
        UserRepositoryInterface $userRepository,
        ContractModelDocumentTypeRepositoryInterface $contractModelDocumentTypeRepository,
        DocumentTypeRepositoryInterface $documentTypeRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository = $userRepository;
        $this->contractModelDocumentTypeRepository = $contractModelDocumentTypeRepository;
        $this->documentTypeRepository = $documentTypeRepository;
    }

    public function handle(
        User $authUser,
        ContractModelDocumentTypeEntityInterface $contract_model_document_type,
        ContractModelPartyEntityInterface $contract_model_party
    ): bool {
        $this->checkUser($authUser);
        $this->checkContractModelParty($contract_model_party);
        return $this->contractModelDocumentTypeRepository->delete($contract_model_document_type);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContractModelParty(ContractModelPartyEntityInterface $contract_model_party)
    {
        if (is_null($contract_model_party)) {
            throw new ContractModelPartyIsNotFoundException();
        }

        $contract_model = $contract_model_party->getContractModel();
        if (is_null($contract_model)) {
            throw new ContractModelIsNotFoundException();
        }

        if ($this->contractModelRepository->isPublished($contract_model)) {
            throw new ContractModelIsPublishedException();
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            throw new ContractModelIsArchivedException();
        }
    }
}
