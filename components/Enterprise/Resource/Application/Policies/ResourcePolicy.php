<?php

namespace Components\Enterprise\Resource\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Resource\Application\Repositories\MemberRepository;
use Components\Enterprise\Resource\Application\Repositories\ResourceRepository;
use Components\Enterprise\Resource\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    use HandlesAuthorization;

    protected $enterpriseRepository;
    protected $userRepository;
    protected $memberRepository;
    protected $resourceRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        MemberRepository $memberRepository,
        ResourceRepository $resourceRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->memberRepository = $memberRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function index(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isVendor($enterprise)) {
            return Response::deny("Enterprise type is not vendor");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("User is not member of this enterprise");
        }

        return Response::allow();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        return $this->index($user, $enterprise);
    }

    public function show(User $user, Resource $resource)
    {
        if ($this->resourceRepository->assignedTo($resource, $user->enterprise)) {
            return Response::allow();
        }

        return $this->index($user, $resource->enterprise);
    }

    public function edit(User $user, Resource $resource)
    {
        return $this->index($user, $resource->enterprise);
    }

    public function update(User $user, Resource $resource)
    {
        return $this->index($user, $resource->enterprise);
    }

    public function destroy(User $user, Resource $resource)
    {
        return $this->index($user, $resource->enterprise);
    }

    public function assign(User $user, Resource $resource)
    {
        return $this->index($user, $resource->enterprise);
    }

    public function attach(User $user, Resource $resource)
    {
        return $this->index($user, $resource->enterprise);
    }
}
