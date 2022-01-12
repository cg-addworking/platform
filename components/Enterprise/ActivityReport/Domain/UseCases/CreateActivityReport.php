<?php

namespace Components\Enterprise\ActivityReport\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\ActivityReport\Domain\Exceptions\EnterpriseDoesntHaveAccessToActivityReportException;
use Components\Enterprise\ActivityReport\Domain\Exceptions\EnterpriseIsNotVendorException;
use Components\Enterprise\ActivityReport\Domain\Exceptions\EnterpriseNotFoundException;
use Components\Enterprise\ActivityReport\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\ActivityReport\Domain\Exceptions\VendorNotActiveForAllCustomersException;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportCustomerRepositoryInterface;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportMissionRepositoryInterface;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionRepositoryInterface;
use Components\Module\Module\Domain\Interfaces\ModuleRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateActivityReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $activityReportCustomerRepository;
    private $activityReportMissionRepository;
    private $activityReportRepository;
    private $enterpriseRepository;
    private $missionRepository;
    private $moduleRepository;

    public function __construct(
        ActivityReportCustomerRepositoryInterface $activityReportCustomerRepository,
        ActivityReportMissionRepositoryInterface $activityReportMissionRepository,
        ActivityReportRepositoryInterface $activityReportRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        MissionRepositoryInterface $missionRepository,
        ModuleRepositoryInterface $moduleRepository
    ) {
        $this->activityReportCustomerRepository  = $activityReportCustomerRepository;
        $this->activityReportMissionRepository   = $activityReportMissionRepository;
        $this->activityReportRepository          = $activityReportRepository;
        $this->enterpriseRepository              = $enterpriseRepository;
        $this->moduleRepository                  = $moduleRepository;
        $this->missionRepository                 = $missionRepository;
    }

    public function handle(?User $authUser, ?Enterprise $vendor, array $data)
    {
        $this->checkUser($authUser);
        $this->checkVendor($vendor);

        $this->checkPartnerShips($vendor);

        $activity_report = $this->activityReportRepository->make();

        $activity_report->setVendor($vendor);
        $activity_report->setMonth($data['month']);
        $activity_report->setYear($data['year']);
        $activity_report->setCreatedBy($authUser);
        $activity_report->setNote($data['note']);
        $activity_report->setOtherActivity($data['other_activity']);
        if (isset($data['no_activity'])) {
            $activity_report->setNoActivity();
        }

        $activity_report = $this->activityReportRepository->save($activity_report);

        if (isset($data['customers'])) {
            $this
                ->activityReportCustomerRepository
                ->associateCustomers($activity_report, $this->enterpriseRepository->findByIds($data['customers']));
        }

        if (isset($data['missions'])) {
            $this
                ->activityReportMissionRepository
                ->associateMissions($activity_report, $this->missionRepository->findByIds($data['missions']));
        }

        return $activity_report;
    }

    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkVendor($vendor)
    {
        if (is_null($vendor)) {
            throw new EnterpriseNotFoundException;
        }

        if (! $this->enterpriseRepository->isVendor($vendor)) {
            throw new EnterpriseIsNotVendorException;
        }

        if (! $this->moduleRepository->hasAccessToActivityReport($vendor)) {
            throw new EnterpriseDoesntHaveAccessToActivityReportException;
        }
    }

    public function checkPartnerShips($vendor)
    {
        foreach ($vendor->customers()->pluck('id') as $id) {
            $customer = $this->enterpriseRepository->find($id);
            if ($vendor->vendorInActivityWithCustomer($customer)) {
                return true;
            }
        }

        throw new VendorNotActiveForAllCustomersException;
    }
}
