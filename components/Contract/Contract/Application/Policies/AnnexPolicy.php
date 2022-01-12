<?php

namespace Components\Contract\Contract\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnnexPolicy
{
    use HandlesAuthorization;

    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }
        return Response::deny('You do not have access to annex creation');
    }

    public function delete(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }
        return Response::deny("You can't delete Annex");
    }

    /**
     * @param User $user
     * @return Response
     */
    public function indexSupport(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    /**
     * @param User $user
     * @param Annex $annex
     * @return Response
     */
    public function show(User $user, Annex $annex)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if ($this->userRepository->checkIfUserIsMember($user, $annex->getEnterprise())) {
            return Response::allow();
        }

        return Response::deny('You do not have access to annex show');
    }
}
