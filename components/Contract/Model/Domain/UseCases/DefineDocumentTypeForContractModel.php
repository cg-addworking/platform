<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DefineDocumentTypeForContractModel
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

    public function handle(User $authUser, ContractModelPartyEntityInterface $contract_model_party, array $input)
    {
        $this->checkUser($authUser);
        $this->checkContractModelParty($contract_model_party);
        $contract_model_document_type = $this->contractModelDocumentTypeRepository->make();
        $document_type = $this->documentTypeRepository->find($input['document_type_id']);
        $contract_model_document_type->setContractModelParty($contract_model_party);
        $contract_model_document_type->setDocumentType($document_type);
        $contract_model_document_type->setName($document_type->display_name);
        $contract_model_document_type->setDisplayName($document_type->display_name);
        $contract_model_document_type->setDescription($document_type->description);
        $contract_model_document_type->setValidationRequired($input['validation_required']);
        $contract_model_document_type->setNumber();
        return $this->contractModelDocumentTypeRepository->save($contract_model_document_type);
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
