<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotPublishedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelRepositoryInterface;

class UnpublishDocumentTypeModel
{
    private $documentTypeModelRepository;
    private $userRepository;

    public function __construct(
        DocumentTypeModelRepositoryInterface $documentTypeModelRepository,
        UserRepository $userRepository
    ) {
        $this->documentTypeModelRepository = $documentTypeModelRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        $user,
        DocumentTypeModel $document_type_model
    ) {
        $this->checkUser($user);
        $this->checkDocumentTypeModel($document_type_model);

        $document_type_model->published_at = null;
        $document_type_model->setPublishedBy(null);

        return $this->documentTypeModelRepository->save($document_type_model);
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

        if (! $this->documentTypeModelRepository->isPublished($document_type_model)) {
            throw new DocumentTypeModelIsNotPublishedException();
        }
    }
}
