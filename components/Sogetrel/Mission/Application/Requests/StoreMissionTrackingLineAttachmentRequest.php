<?php

namespace Components\Sogetrel\Mission\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MilestoneRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionRepositoryInterface;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Components\Sogetrel\Mission\Application\Requests\UpdateMissionTrackingLineAttachmentRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMissionTrackingLineAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('create', MissionTrackingLineAttachment::class);
    }

    public function rules()
    {
        $enterprises = (new Enterprise)->getTable();
        $missions    = (new Mission)->getTable();
        $milestones  = (new Milestone)->getTable();

        return (new UpdateMissionTrackingLineAttachmentRequest)->rules() + [
            'customer.id'  => "required|uuid|exists:{$enterprises},id",
            'vendor.id'    => "required|uuid|exists:{$enterprises},id",
            'mission.id'   => "required|uuid|exists:{$missions},id",
            'milestone.id' => "required|uuid|exists:{$milestones},id",
            'file'         => "",
        ];
    }

    public function getCustomer(): Enterprise
    {
        if (! $this->has('customer.id')) {
            throw new \RuntimeException(
                "invalid data: missing key 'customer.id'"
            );
        }

        return $this->validateCustomer(
            $this->container->make(EnterpriseRepositoryInterface::class)->find($this->input('customer.id'))
        );
    }

    public function validateCustomer(Enterprise $customer): Enterprise
    {
        if (! $customer->isCustomer()) {
            throw new \RuntimeException(
                "invalid customer: enterprise {$customer->getId()} is not a customer"
            );
        }

        return $customer;
    }

    public function getVendor(Enterprise $customer): Enterprise
    {
        if (! $this->has('vendor.id')) {
            throw new \RuntimeException(
                "invalid data: missing key 'vendor.id'"
            );
        }

        return $this->validateVendor(
            $this->container->make(EnterpriseRepositoryInterface::class)->find($this->input('vendor.id')),
            $customer
        );
    }

    public function validateVendor(Enterprise $vendor, Enterprise $customer): Enterprise
    {
        if (! $vendor->isVendor()) {
            throw new \RuntimeException(
                "invalid vendor: enterprise {$vendor->getId()} is not a vendor"
            );
        }

        if (! $vendor->isVendorOf($customer)) {
            throw new \RuntimeException(
                "invalid vendor: enterprises {$vendor->getId()} is not a vendor of {$customer->getId()}"
            );
        }

        return $vendor;
    }

    public function getMission(Enterprise $vendor): Mission
    {
        if (! $this->has('mission.id')) {
            throw new \RuntimeException(
                "invalid data: missing key 'mission.id'"
            );
        }

        return $this->validateMission(
            $this->container->make(MissionRepositoryInterface::class)->find($this->input('mission.id')),
            $vendor
        );
    }

    public function validateMission(Mission $mission, Enterprise $vendor): Mission
    {
        if (! $mission->belongsToVendor($vendor)) {
            throw new \RuntimeException(
                "invalid mission: mission {$mission->getId()} doesn't belong to ".
                "vendor {$vendor->getId()}"
            );
        }

        return $mission;
    }

    public function getMilestone(Mission $mission): Milestone
    {
        if (! $this->has('milestone.id')) {
            throw new \RuntimeException(
                "invalid data: missing key 'milestone.id'"
            );
        }

        return $this->validateMilestone(
            $this->container->make(MilestoneRepositoryInterface::class)->find($this->input('milestone.id')),
            $mission
        );
    }

    public function validateMilestone(Milestone $milestone, Mission $mission): Milestone
    {
        if (! $milestone->belongsToMission($mission)) {
            throw new \RuntimeException(
                "invalid milestone: milestone {$milestone->getId()} doesn't belong to ".
                "mission {$mission->getId()}"
            );
        }

        return $milestone;
    }
}
