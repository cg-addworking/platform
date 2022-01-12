<?php

namespace Components\Enterprise\WorkField\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Exceptions\ContributorAlreadyAttachedException;
use Components\Enterprise\WorkField\Domain\Exceptions\ContributorIsNotMemberOfOwnerEnterpriseOrDescendantException;
use Components\Enterprise\WorkField\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserCantAttachContributorException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldIsNotFoundException;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldContributorRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;

class AttachContributorToWorkField
{
    protected $enterpriseRepository;
    protected $sectorRepository;
    protected $userRepository;
    protected $workFieldRepository;
    protected $workFieldContributorRepository;

    public function __construct(
        EnterpriseRepositoryInterface $enterpriseRepository,
        SectorRepositoryInterface $sectorRepository,
        UserRepositoryInterface $userRepository,
        WorkFieldRepositoryInterface $workFieldRepository,
        WorkFieldContributorRepositoryInterface $workFieldContributorRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->sectorRepository = $sectorRepository;
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function handle($authenticated, WorkFieldEntityInterface $work_field, array $inputs)
    {
        $this->checkWorkField($work_field);

        $enterprise = $this->enterpriseRepository->find($inputs['enterprise_id']);
        $this->checkEnterprise($enterprise);

        $this->checkAuthenticated($authenticated, $work_field);

        $contributor = $this->userRepository->find($inputs['contributor_id']);
        $this->checkContributor($contributor, $enterprise, $work_field);

        $work_field_contributor = $this->workFieldContributorRepository->make();

        $work_field_contributor->setNumber();

        if (isset($inputs['is_admin'])) {
            $work_field_contributor->setIsAdmin($inputs['is_admin']);
        }

        $work_field_contributor->setRole($inputs['role']);
        $work_field_contributor->setContributor($contributor);
        $work_field_contributor->setEnterprise($enterprise);
        $work_field_contributor->setWorkField($work_field);

        return $this->workFieldContributorRepository->save($work_field_contributor);
    }

    private function checkWorkfield(WorkFieldEntityInterface $work_field)
    {
        if (is_null($work_field)) {
            throw new WorkFieldIsNotFoundException;
        }
    }

    private function checkAuthenticated(?User $user, WorkFieldEntityInterface $work_field)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        // temporary for the api (workfield creation by api)
        if (is_null($work_field->getCreatedBy())) {
            return true;
        }

        if (!($this->workFieldRepository->isCreatorOf($user, $work_field)
            || $this->workFieldContributorRepository->isAdminOf($user, $work_field))) {
            throw new UserCantAttachContributorException();
        }
    }

    private function checkContributor(?User $contributor, Enterprise $enterprise, WorkFieldEntityInterface $work_field)
    {
        if (is_null($contributor)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (in_array(
            $contributor->id,
            $work_field->workFieldContributors()->pluck('contributor_id')->toArray()
        )) {
            throw new ContributorAlreadyAttachedException;
        }

        if (! in_array(
            $enterprise->id,
            $this->enterpriseRepository->getOwnerAndDescendants($work_field->getOwner())->pluck('id')->toArray()
        )) {
            throw new ContributorIsNotMemberOfOwnerEnterpriseOrDescendantException;
        }
    }

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException();
        }
    }
}
