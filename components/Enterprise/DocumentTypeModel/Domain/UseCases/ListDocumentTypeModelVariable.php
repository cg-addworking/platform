<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;

class ListDocumentTypeModelVariable
{
    private $documentTypeModelVariableRepository;
    private $userRepository;

    public function __construct(
        DocumentTypeModelVariableRepositoryInterface $documentTypeModelVariableRepository,
        UserRepository $userRepository
    ) {
        $this->documentTypeModelVariableRepository = $documentTypeModelVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        $auth_user,
        DocumentTypeModel $document_type_model
    ) {
        $this->checkUser($auth_user);
        $this->checkDocumentTypeModel($document_type_model);

        return $this->documentTypeModelVariableRepository->list($document_type_model);
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

    private function checkDocumentTypeModel($document_type_model)
    {
        if (is_null($document_type_model)) {
            throw new DocumentTypeModelIsNotFoundException();
        }
    }
}
