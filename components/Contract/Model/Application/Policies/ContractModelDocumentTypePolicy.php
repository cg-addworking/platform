<?php

namespace Components\Contract\Model\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractModelDocumentTypePolicy
{
    use HandlesAuthorization;

    private $contractModelRepository;
    private $userRepository;
    private $documentTypeRepository;

    public function __construct(
        ContractModelRepository $contractModelRepository,
        UserRepository $userRepository,
        DocumentTypeRepository $documentTypeRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository = $userRepository;
        $this->documentTypeRepository = $documentTypeRepository;
    }

    public function index(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function create(User $user, ContractModelParty $contract_model_party)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        $contract_model = $contract_model_party->getContractModel();

        if ($this->contractModelRepository->isPublished($contract_model)) {
            return Response::deny("Published contract model can not be modified");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny("Archived contract model can not be modified");
        }

        $count_document_types = count(
            $this->documentTypeRepository
                ->getFromEnterpriseExcludeThoseInContractModelParty(
                    $contract_model->getEnterprise(),
                    $contract_model_party
                )
        );

        if ($count_document_types == 0) {
            return Response::deny("There is no documents type to associate to this party");
        }

        return Response::allow();
    }

    public function delete(User $user, ContractModelDocumentType $contract_model_document_type)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        $contract_model = $contract_model_document_type->getContractModelParty()->getContractModel();

        if ($this->contractModelRepository->isPublished($contract_model)) {
            return Response::deny("Published contract model can not be modified");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny("Archived contract model can not be modified");
        }

        return Response::allow();
    }
}
