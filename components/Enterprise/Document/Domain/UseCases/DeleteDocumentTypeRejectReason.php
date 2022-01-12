<?php

namespace Components\Enterprise\Document\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRejectReasonRepositoryInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteDocumentTypeRejectReason
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

    public function handle(User $auth_user, DocumentTypeRejectReason $document_type_reject_reason)
    {
        $this->checkUser($auth_user);

        return $this->documentTypeRejectReasonRepository->delete($document_type_reject_reason);
    }

    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
    }
}
