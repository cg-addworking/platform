<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\UseCases;

use App\Models\Addworking\Enterprise\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelRepositoryInterface;

class ListDocumentTypeModel
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
        $authUser,
        DocumentType $document_type,
        ?array $filter = null,
        ?array $search = null
    ) {
        $this->checkUser($authUser);
        $this->checkDocumentType($document_type);
        return $this->documentTypeModelRepository->list($document_type, $filter, $search);
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

    private function checkDocumentType($document_type)
    {
        if (is_null($document_type)) {
            throw new DocumentTypeIsNotFoundException();
        }
    }
}
