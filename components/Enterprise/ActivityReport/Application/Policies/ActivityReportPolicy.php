<?php

namespace Components\Enterprise\ActivityReport\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportRepository;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseMembershipRepository;
use DateTime;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ActivityReportPolicy
{
    use HandlesAuthorization;

    private $activityReportRepository;
    private $enterpriseRepository;
    private $membershipRepository;

    public function __construct(
        ActivityReportRepository $activityReportRepository,
        EnterpriseRepository $enterpriseRepository,
        EnterpriseMembershipRepository $membershipRepository
    ) {
        $this->activityReportRepository = $activityReportRepository;
        $this->enterpriseRepository     = $enterpriseRepository;
        $this->membershipRepository     = $membershipRepository;
    }

    public function create(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isVendor($enterprise)) {
            return Response::deny("Enterprise type is not vendor");
        }

        if (! $enterprise->isVendorOfSogetrelSubsidiaries()) {
            return Response::deny("You cannot create an activity report because you don't belong to Sogetrel");
        }

        if (! $this->membershipRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("User is not member of this vendor enterprise");
        }

        return Response::allow();
    }

    public function submit(User $user, Enterprise $enterprise, DateTime $date)
    {
        if (! is_null($this->activityReportRepository->getActivityReportAt($enterprise, $date))) {
            return Response::deny("An activity report has been already submitted for this month");
        }

        return Response::allow();
    }
}
