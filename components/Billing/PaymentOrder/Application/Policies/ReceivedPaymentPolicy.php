<?php

namespace Components\Billing\PaymentOrder\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReceivedPaymentPolicy
{
    use HandlesAuthorization;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        return Response::allow();
    }

    public function index(User $user)
    {
        return $this->create($user);
    }

    public function indexSupport(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user)
    {
        return $this->create($user);
    }

    public function import(User $user)
    {
        return $this->create($user);
    }

    public function delete(User $user)
    {
        return $user->isSupport();
    }
}
