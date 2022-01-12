<?php

namespace Components\Enterprise\BusinessTurnover\Domain\UseCases;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\BusinessTurnoverAlreadyExistsException;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\EnterpriseIsNotRequestedToDeclareBusinessTurnoverException;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\SupportCantCreateBusinessTurnoverException;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\BusinessTurnoverRepositoryInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateBusinessTurnover
{
    protected $businessTurnoverRepository;
    protected $enterpriseRepository;
    protected $userReposirory;

    public function __construct(
        BusinessTurnoverRepositoryInterface $businessTurnoverRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->businessTurnoverRepository = $businessTurnoverRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userReposirory = $userRepository;
    }

    public function handle($authenticated, $enterprise, $inputs)
    {
        $this->checkUser($authenticated);
        $this->checkEnterprise($enterprise);

        $business_turnover = $this->businessTurnoverRepository->make();

        $business_turnover->setNumber();
        $business_turnover->setYear(Carbon::now()->subYear()->year);
        $business_turnover->setEnterprise($enterprise);
        $business_turnover->setEnterpriseName($enterprise->name);
        $business_turnover->setCreatedBy($authenticated);
        $business_turnover->setCreatedByName($authenticated->name);

        if (isset($inputs['no_activity'])) {
            $business_turnover->setNoActivity(true);
        } else {
            $business_turnover->setAmount($inputs['amount']);
        }

        return $this->businessTurnoverRepository->save($business_turnover);
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if ($this->userReposirory->isSupport($user)) {
            throw new SupportCantCreateBusinessTurnoverException;
        }
    }

    private function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException;
        }

        if (! $this->enterpriseRepository->collectBusinessTurnover($enterprise)) {
            throw new EnterpriseIsNotRequestedToDeclareBusinessTurnoverException;
        }

        if (! is_null($this->enterpriseRepository->getLastYearBusinessTurnover($enterprise))) {
            throw new BusinessTurnoverAlreadyExistsException;
        }
    }
}
