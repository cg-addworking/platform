<?php

namespace Components\Enterprise\Document\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRejectReasonRepositoryInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateDocumentTypeRejectReason
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

    public function handle(User $auth_user, array $inputs, ?DocumentTypeEntityInterface $document_type = null)
    {
        $this->checkUser($auth_user);

        $reject_reason = $this->documentTypeRejectReasonRepository->make();
        $reject_reason->setName(str_slug($inputs['display_name'], '_'));
        $reject_reason->setDisplayName($inputs['display_name']);
        $reject_reason->setMessage($inputs['message']);
        $reject_reason->setNumber();

        if (! isset($inputs['is_universal'])) {
            $reject_reason->setDocumentType($document_type);
        }

        return $this->documentTypeRejectReasonRepository->save($reject_reason);
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
