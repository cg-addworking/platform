<?php

namespace Components\Mission\Mission\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Mission\Domain\Exceptions\EnterpriseIsNotAssociatedToConstructionSectorException;
use Components\Mission\Mission\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Mission\Mission\Domain\Exceptions\EnterpriseIsNotVendorException;
use Components\Mission\Mission\Domain\Exceptions\EnterpriseNotFoundException;
use Components\Mission\Mission\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Mission\Mission\Domain\Exceptions\UserNotFoundException;
use Components\Mission\Mission\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\CostEstimationRepositoryInterface;

class CreateConstructionMission
{
    private $missionRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $workFieldRepository;
    private $sectorRepository;
    private $costEstimationRepository;

    public function __construct(
        MissionRepositoryInterface $missionRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepositoryInterface $userRepository,
        WorkFieldRepositoryInterface $workFieldRepository,
        SectorRepositoryInterface $sectorRepository,
        CostEstimationRepositoryInterface $costEstimationRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->sectorRepository = $sectorRepository;
        $this->costEstimationRepository = $costEstimationRepository;
    }

    public function handle(?User $auth_user, array $inputs, $files = [], $cost_estimation_file = [])
    {
        $customer = $this->enterpriseRepository->find($inputs['enterprise_id']);
        $vendor = $this->enterpriseRepository->find($inputs['vendor_id']);
        $referent = $this->userRepository->find($inputs['referent_id']);

        $this->checkUser($auth_user, $referent);
        $this->checkCustomer($customer, $auth_user);
        $this->checkVendor($vendor, $auth_user);

        $mission = $this->missionRepository->make();
        $mission->setNumber();
        $mission->setLabel($inputs['label']);
        $mission->setStartsAt($inputs['starts_at']);
        $mission->setEndsAt($inputs['ends_at']);
        $mission->setDescription($inputs['description']);
        $mission->setExternalId($inputs['external_id']);
        $mission->setAnalyticCode($inputs['analytic_code']);
        $mission->setCustomer($customer);
        $mission->setReferent($referent);
        $mission->setVendor($vendor);
        $mission->setMilestoneType('monthly');
        $mission->setAmount($inputs['amount']);

        if (! empty($inputs['workfield_id'])) {
            $workfield = $this->workFieldRepository->find($inputs['workfield_id']);
            $mission->setWorkField($workfield);
        }

        $saved = $this->missionRepository->save($mission);

        if (! empty($inputs['departments'])) {
            $mission->setDepartments($inputs['departments']);
        }

        if (! empty($files)) {
            $this->missionRepository->createFiles($files, $mission);
        }

        $this->handleCostEstimation($inputs, $mission, $cost_estimation_file);

        return $saved;
    }

    private function handleCostEstimation($inputs, $mission, $cost_estimation_file)
    {
        $amount_before_taxes = 0;

        if (array_key_exists('cost_estimation', $inputs)
            && array_key_exists('amount_before_taxes', $inputs['cost_estimation'])) {
            $amount_before_taxes = $inputs['cost_estimation']['amount_before_taxes'];
        }

        if ($cost_estimation_file) {
            $cost_estimation = $this->costEstimationRepository->create(
                $amount_before_taxes,
                $cost_estimation_file
            );
            $mission->setCostEstimation($cost_estimation);
            $this->missionRepository->save($mission);
        }
    }

    private function checkUser(?User $user, ?User $referent)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($referent)) {
            throw new UserNotFoundException;
        }
    }

    private function checkCustomer(?Enterprise $customer, ?User $user)
    {
        if (is_null($customer)) {
            throw new EnterpriseNotFoundException;
        }

        if (! $this->enterpriseRepository->isCustomer($customer) && ! $this->userRepository->isSupport($user)) {
            throw new EnterpriseIsNotCustomerException;
        }

        if (! $this->sectorRepository->belongsToConstructionSector($customer)) {
            throw new EnterpriseIsNotAssociatedToConstructionSectorException;
        }
    }

    private function checkVendor(?Enterprise $vendor, ?User $user)
    {
        if (is_null($vendor)) {
            throw new EnterpriseNotFoundException;
        }

        if (! $this->enterpriseRepository->isVendor($vendor) && ! $this->userRepository->isSupport($user)) {
            throw new EnterpriseIsNotVendorException;
        }
    }
}
