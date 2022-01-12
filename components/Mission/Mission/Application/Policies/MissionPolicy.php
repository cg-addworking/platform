<?php

namespace Components\Mission\Mission\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MissionPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $sectorRepository;

    public function __construct(
        SectorRepository $sectorRepository,
        UserRepository $userRepository
    ) {
        $this->sectorRepository = $sectorRepository;
        $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->sectorRepository->belongsToConstructionSector($user->enterprise)) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You don't have acces to create mission");
        }

        return Response::allow();
    }

    public function edit(User $user, Mission $mission)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->sectorRepository->belongsToConstructionSector($user->enterprise)) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You don't have acces to edit mission");
        }

        if (! $user->hasRoleFor($mission->getCustomer(), User::IS_ADMIN)
        &&  $user->getId() !== $mission->getReferent()->getId()) {
            return Response::deny("You don't have acces to edit mission");
        }

        if ($mission->getStatus() !== Mission::STATUS_DRAFT
            && $mission->getStatus() !== Mission::STATUS_READY_TO_START) {
            return Response::deny("You cannot edit this mission");
        }

        return Response::allow();
    }

    public function linkMissionToContract(User $user, Mission $mission)
    {
        if (! is_null($mission->getContract())) {
            return Response::deny("mission has a contract");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_CONTRACT_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        return Response::allow();
    }

    public function delete(User $user, Mission $mission)
    {
        return $user->isSupport()
            || $user->hasRoleFor($mission->customer, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($mission->customer, [User::ACCESS_TO_MISSION]);
    }
}
