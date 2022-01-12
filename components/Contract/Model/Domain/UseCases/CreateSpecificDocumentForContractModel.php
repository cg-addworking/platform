<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartyIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

class CreateSpecificDocumentForContractModel
{
    private $userRepository;
    private $contractModelRepository;
    private $contractModelDocumentTypeRepository;

    public function __construct(
        UserRepository $userRepository,
        ContractModelRepository $contractModelRepository,
        ContractModelDocumentTypeRepository $contractModelDocumentTypeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractModelRepository = $contractModelRepository;
        $this->contractModelDocumentTypeRepository = $contractModelDocumentTypeRepository;
    }

    public function handle(
        ?User $auth_user,
        ?ContractModelPartyEntityInterface $contract_model_party,
        array $inputs,
        $file = null
    ) {
        $this->checkUser($auth_user);
        $this->checkContractModelParty($contract_model_party);
        $this->checkContractModel($contract_model_party->getContractModel());

        $contract_model_document_type = $this->contractModelDocumentTypeRepository->make();
        $contract_model_document_type->setNumber();
        $contract_model_document_type->setContractModelParty($contract_model_party);
        $contract_model_document_type->setName($inputs['display_name']);
        $contract_model_document_type->setDisplayName($inputs['display_name']);
        $contract_model_document_type->setDescription($inputs['description']);
        $contract_model_document_type->setValidationRequired($inputs['validation_required']);

        if (! is_null($file)) {
            $document_model = $this->contractModelDocumentTypeRepository->createFile($file);
            $contract_model_document_type->setDocumentModel($document_model->id);
        }
        
        return $this->contractModelDocumentTypeRepository->save($contract_model_document_type);
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContractModelParty(?ContractModelPartyEntityInterface $contract_model_party)
    {
        if (is_null($contract_model_party)) {
            throw new ContractModelPartyIsNotFoundException();
        }
    }

    private function checkContractModel(?ContractModelEntityInterface $contract_model)
    {
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
