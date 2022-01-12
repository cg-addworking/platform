<?php

namespace Components\Enterprise\Document\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DocumentTypeRejectReasonPolicy
{
    use HandlesAuthorization;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function delete(User $user)
    {
        return $this->index($user);
    }

    public function create(User $user)
    {
        return $this->index($user);
    }

    public function edit(User $user)
    {
        return $this->index($user);
    }

    public function update(User $user)
    {
        return $this->index($user);
    }
}
