<?php

namespace Components\Enterprise\WorkField\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WorkFieldPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $sectorRepository;
    protected $workFieldContributorRepository;
    protected $workFieldRepository;

    public function __construct(
        SectorRepository $sectorRepository,
        UserRepository $userRepository,
        WorkFieldContributorRepository $workFieldContributorRepository,
        WorkFieldRepository $workFieldRepository
    ) {
        $this->sectorRepository = $sectorRepository;
        $this->userRepository = $userRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
        $this->workFieldRepository = $workFieldRepository;
    }

    public function create(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to the workfield creation process");
        }

        if (! $this->sectorRepository->belongsToConstructionSector($user->enterprise)) {
            return Response::deny("Enterpise is not associated with construction sector!");
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You don't have acces to WorkField");
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_WORKFIELD_CREATOR)) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }
        
        return Response::allow();
    }

    public function edit(User $user, WorkField $work_field)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to the workfield creation process");
        }

        if ($user->hasRoleFor($work_field->getOwner(), User::ROLE_ADMIN)) {
            return Response::allow();
        }

        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return Response::allow();
        }

        if (!($this->workFieldRepository->isCreatorOf($user, $work_field)
            || $this->workFieldContributorRepository->isAdminOf($user, $work_field))) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }
        
        return Response::allow();
    }

    public function show(User $user, WorkField $work_field)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to the workfield creation process");
        }

        if ($user->hasRoleFor($work_field->getOwner(), User::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($user->hasRoleFor($user->enterprise, User::ROLE_WORKFIELD_CREATOR)) {
            return Response::allow();
        }

        if (! $this->workFieldRepository->hasAccessToWorkField($user, $work_field)) {
            return Response::deny("user has no access to workField");
        }
        
        return Response::allow();
    }

    public function delete(User $user, WorkField $work_field)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to the workfield creation process");
        }

        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return Response::allow();
        }

        if (!($this->workFieldRepository->isCreatorOf($user, $work_field)
            || $this->workFieldContributorRepository->isAdminOf($user, $work_field))) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        return Response::allow();
    }

    public function index(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to work field");
        }

        if (! $this->sectorRepository->belongsToConstructionSector($user->enterprise)) {
            return Response::deny("Enterprise is not associated with construction sector");
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You don't have acces to work field");
        }

        if ($user->hasRoleFor($user->enterprise, User::ROLE_WORKFIELD_CREATOR, User::ROLE_ADMIN)) {
            return Response::allow();
        }

        return Response::allow();
    }

    public function archive(User $user, WorkField $work_field)
    {
        return $this->edit($user, $work_field);
    }

    public function seeEntry(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to work field");
        }

        if (! $this->sectorRepository->belongsToConstructionSector($user->enterprise)) {
            return Response::deny("Enterprise is not associated with construction sector");
        }

        if ($user->hasRoleFor($user->enterprise, User::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($user->hasRoleFor($user->enterprise, User::ROLE_WORKFIELD_CREATOR)) {
            return Response::allow();
        }

        if (! $this->workFieldContributorRepository->isContributor($user)) {
            return Response::deny("You can't see work field");
        }

        return Response::allow();
    }

    public function manageContributors(User $user, WorkField $work_field)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::deny("You don't have access to the workfield creation process");
        }

        if ($user->hasRoleFor($work_field->getOwner(), User::ROLE_ADMIN)) {
            return Response::allow();
        }

        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return Response::allow();
        }

        if (!($this->workFieldRepository->isCreatorOf($user, $work_field)
            || $this->workFieldContributorRepository->isAdminOf($user, $work_field))) {
            return Response::deny("Your privileges on the company {$user->enterprise->name} are insufficient");
        }

        return Response::allow();
    }
}
