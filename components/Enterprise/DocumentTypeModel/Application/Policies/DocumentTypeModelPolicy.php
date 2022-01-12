<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class DocumentTypeModelPolicy
{
    use HandlesAuthorization;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function index(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function delete(User $user, DocumentTypeModel $document_type_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (App::make(DocumentTypeModelRepository::class)->isPublished($document_type_model)) {
            return Response::deny("Document type model is published");
        }

        return Response::allow();
    }

    public function edit(User $user, DocumentTypeModel $document_type_model)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (App::make(DocumentTypeModelRepository::class)->isPublished($document_type_model)) {
            return Response::deny("Document type model is published");
        }

        return Response::allow();
    }

    public function showWysiwygPreview(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function show(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function publish(User $user, DocumentTypeModel $document_type_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (App::make(DocumentTypeModelRepository::class)->isPublished($document_type_model)) {
            return Response::deny("Document type model is already published");
        }

        return Response::allow();
    }

    public function unpublish(User $user, DocumentTypeModel $document_type_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! App::make(DocumentTypeModelRepository::class)->isPublished($document_type_model)) {
            return Response::deny("Document type model is not yet published");
        }

        return Response::allow();
    }
}
