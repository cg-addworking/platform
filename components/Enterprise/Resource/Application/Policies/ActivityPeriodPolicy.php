<?php

namespace Components\Enterprise\Resource\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Resource\Application\Repositories\MemberRepository;
use Components\Enterprise\Resource\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ActivityPeriodPolicy
{
    use HandlesAuthorization;

    protected $enterpriseRepository;
    protected $userRepository;
    protected $memberRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        MemberRepository $memberRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->memberRepository = $memberRepository;
    }

    public function index(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("User is not member of this enterprise");
        }

        return Response::allow();
    }

    public function show(User $user, ActivityPeriod $activity_period)
    {
        return $this->index($user, $activity_period->customer);
    }
}
