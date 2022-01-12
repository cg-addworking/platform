<?php

namespace Components\Enterprise\Document\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\Document\Domain\Exceptions\DocumentTypeRejectReasonIsNotFoundException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeRejectReasonEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRejectReasonRepositoryInterface;

class UpdateDocumentTypeRejectReason
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
        User $auth_user,
        array $inputs,
        ?DocumentTypeRejectReasonEntityInterface $reject_reason,
        ?DocumentTypeEntityInterface $document_type = null
    ) {
        $this->check($auth_user, $reject_reason);

        $reject_reason->setName(str_slug($inputs['display_name'], '_'));
        $reject_reason->setDisplayName($inputs['display_name']);
        $reject_reason->setMessage($inputs['message']);

        if (! isset($inputs['is_universal'])) {
            $reject_reason->setDocumentType($document_type);
        } else {
            $reject_reason->setDocumentType(null);
        }

        return $this->documentTypeRejectReasonRepository->save($reject_reason);
    }

    public function check(?User $auth_user, ?DocumentTypeRejectReasonEntityInterface $reject_reason)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (is_null($reject_reason)) {
            throw new DocumentTypeRejectReasonIsNotFoundException();
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
    }
}
