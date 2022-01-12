<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;

class ShowDocumentTypeModel
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(
        $authUser,
        DocumentTypeModel $document_type_model
    ) {
        $this->checkUser($authUser);
        $this->checkDocumentTypeModel($document_type_model);

        return $document_type_model;
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
