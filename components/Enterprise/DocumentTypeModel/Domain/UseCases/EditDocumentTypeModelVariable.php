<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\UserRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelVariableIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Illuminate\Support\Facades\App;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsPublishedException;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;

class EditDocumentTypeModelVariable
{
    private $userRepository;
    private $documentTypeModelVariableRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        DocumentTypeModelVariableRepositoryInterface $documentTypeModelVariableRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentTypeModelVariableRepository = $documentTypeModelVariableRepository;
    }

    public function handle(User $auth_user, $document_type_model_variable, array $inputs)
    {
        $this->checkUser($auth_user);
        $this->checkVariable($document_type_model_variable);

        $document_type_model = $document_type_model_variable
            ? $document_type_model_variable->getDocumentTypeModel()
            : null;

        $this->checkDocumentTypeModel($document_type_model);

        $document_type_model_variable->setInputType($inputs['type']);
        $document_type_model_variable->setDefaultValue($inputs['default_value']);
        $document_type_model_variable->setDescription($inputs['description']);
        
        return $this->documentTypeModelVariableRepository->save($document_type_model_variable);
    }

    private function checkUser(User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException;
        }
    }

    private function checkVariable(?DocumentTypeModelVariable $documentTypeModelVariable)
    {
        if (is_null($documentTypeModelVariable)) {
            throw new DocumentTypeModelVariableIsNotFoundException;
        }
    }

    private function checkDocumentTypeModel(?DocumentTypeModel $documentTypeModel)
    {
        if (is_null($documentTypeModel)) {
            throw new DocumentTypeModelIsNotFoundException;
        }

        if (App::make(DocumentTypeModelRepository::class)->isPublished($documentTypeModel)) {
            throw new DocumentTypeModelIsPublishedException;
        }
    }
}
