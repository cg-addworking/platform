<?php

namespace Components\Enterprise\Document\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Domain\Exceptions\DocumentTypeIsNotFoundException;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRejectReasonRepositoryInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListDocumentTypeRejectReason
{
    private $userRepository;
    private $documentTypeRejectReasonRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        DocumentTypeRejectReasonRepositoryInterface $documentTypeRejectReasonRepository
    ) {
        $this->userRepository = $userRepository;
        $this->documentTypeRejectReasonRepository = $documentTypeRejectReasonRepository;
    }

    public function handle(
        ?User $auth_user,
        ?DocumentTypeEntityInterface $document_type,
        ?int $page = null
    ) {
        $this->check($auth_user, $document_type);

        return $this->documentTypeRejectReasonRepository->list($document_type, $page);
    }

    public function check(?User $auth_user, ?DocumentTypeEntityInterface $document_type)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
        
        if (is_null($document_type)) {
            throw new DocumentTypeIsNotFoundException();
        }
    }
}
