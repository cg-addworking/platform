<?php

namespace Components\Enterprise\Enterprise\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    use HandlesAuthorization;

    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function index(User $user)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny('User is not support');
        }

        return Response::allow();
    }

    public function show(User $user, Company $company)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny('User is not support');
        }

        return Response::allow();
    }
}
