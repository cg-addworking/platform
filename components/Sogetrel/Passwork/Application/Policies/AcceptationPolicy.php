<?php

namespace Components\Sogetrel\Passwork\Application\Policies;

use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use App\Policies\Sogetrel\User\Passwork\SogetrelPassworkPolicy;
use Components\Sogetrel\Passwork\Application\Models\Acceptation;
use Components\Sogetrel\Passwork\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class AcceptationPolicy
{
    use HandlesAuthorization;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(User $user, SogetrelPasswork $passwork)
    {
        if (! App::make(SogetrelPassworkPolicy::class)->status($user, $passwork)) {
            return Response::deny();
        }
        
        return Response::allow();
    }

    public function index(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("You don't havec access to this resource");
        }

        return Response::allow();
    }
}
