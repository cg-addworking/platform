<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Exceptions\EnterpriseIsNotAssociatedToConstructionSectorException;
use Components\Enterprise\WorkField\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Enterprise\WorkField\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsMissingTheWorkFieldCreationRoleException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;

class CreateWorkField
{
    protected $enterpriseRepository;
    protected $sectorRepsository;
    protected $userRepository;
    protected $workFieldRepository;

    public function __construct(
        EnterpriseRepositoryInterface $enterpriseRepository,
        SectorRepositoryInterface $sectorRepository,
        UserRepositoryInterface $userRepository,
        WorkFieldRepositoryInterface $workFieldRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->sectorRepsository = $sectorRepository;
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
    }

    public function handle($authenticated, Enterprise $enterprise, array $inputs)
    {
        $this->checkUser($authenticated);

        $this->checkEnterprise($enterprise);

        $work_field = $this->workFieldRepository->make();

        $work_field->setNumber();
        $work_field->setName(str_slug($inputs['display_name'], '_'));
        $work_field->setDisplayName($inputs['display_name']);
        $work_field->setDescription($inputs['description']);
        $work_field->setEstimatedBudget($inputs['estimated_budget']);
        $work_field->setStartedAt($inputs['started_at']);
        $work_field->setEndedAt($inputs['ended_at']);
        $work_field->setAddress($inputs['address']);
        $work_field->setProjectManager($inputs['project_manager']);
        $work_field->setProjectOwner($inputs['project_owner']);
        $work_field->setExternalId($inputs['external_id']);
        $work_field->setOwner($enterprise);
        $work_field->setCreatedBy($authenticated);
        $work_field->setSpsCoordinator($inputs['sps_coordinator']);

        $work_field = $this->workFieldRepository->save($work_field);

        if (! empty($inputs['departments'])) {
            $work_field->setDepartments($inputs['departments']);
        }

        return $work_field = $this->workFieldRepository->save($work_field);
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_WORKFIELD_CREATOR)) {
            throw new UserIsMissingTheWorkFieldCreationRoleException;
        }
    }

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException();
        }

        if (! $enterprise->isCustomer()) {
            throw new EnterpriseIsNotCustomerException();
        }

        if (! $this->sectorRepsository->belongsToConstructionSector($enterprise)) {
            throw new EnterpriseIsNotAssociatedToConstructionSectorException();
        }
    }
}
