<?php

namespace Components\Enterprise\BusinessTurnover\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\BusinessTurnover\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class BusinessTurnoverPolicy
{
    use HandlesAuthorization;

    protected $enterpriseRepository;
    protected $userRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny('Support has no access');
        }

        if (! $this->enterpriseRepository->collectBusinessTurnover($user->enterprise)) {
            return Response::deny('You are not requested to declare your business turnover');
        }

        if ($this->enterpriseRepository->getLastYearBusinessTurnover($user->enterprise)) {
            return Response::deny('You have already declared your business turnover');
        }

        return Response::allow();
    }

    public function skip(User $user)
    {
        if (! Config::get('business_turnover.skippable')) {
            return Response::deny('You can not skip the declaration !');
        }

        if (! Session::has('business_turnover_callback_url')) {
            return Response::deny('You can not use this route directly');
        }

        return Response::allow();
    }
}
