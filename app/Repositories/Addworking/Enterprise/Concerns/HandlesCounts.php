<?php

namespace App\Repositories\Addworking\Enterprise\Concerns;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\ProposalResponse;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HandlesCounts
{
    public function getVendorsCount($enterprise): int
    {
        try {
            return $this->find($enterprise)->vendors()->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getMissionsCount($enterprise): int
    {
        try {
            $enterprise = $this->find($enterprise);
            return $enterprise->vendorMissions()->count() + $enterprise->customerMissions()->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getProposalsCount($enterprise): int
    {
        try {
            $enterprise = $this->find($enterprise);
            return $enterprise->proposals()->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getVendorInvoicesCount($enterprise): int
    {
        try {
            return InboundInvoice::ofCustomer($this->find($enterprise))->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getCustomerInvoicesCount($enterprise): int
    {
        try {
            return OutboundInvoice::whereHas('enterprise', function ($query) use ($enterprise) {
                $query->where('id', $this->find($enterprise)->id)
                    ->where('is_published', true);
            })->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getPendingContractsCount($enterprise): int
    {
        try {
            return Contract::ofEnterprise($this->find($enterprise))->notActive()->exceptAddendums()->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getActiveContractsCount($enterprise): int
    {
        try {
            return Contract::ofEnterprise($this->find($enterprise))->active()->exceptAddendums()->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getMissionsOfThisMonthCount($enterprise): int
    {
        try {
            $enterprise = $this->find($enterprise);
            return
                $enterprise->vendorMissions()
                    ->where('starts_at', '>=', carbon('first day of this month'))
                    ->count() +
                $enterprise->customerMissions()
                    ->where('starts_at', '>=', carbon('first day of this month'))
                    ->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getOffersToValidateCount($enterprise): int
    {
        try {
            return $enterprise
                ->offers()
                ->whereNotIN('status', [Offer::STATUS_CLOSED, Offer::STATUS_ABANDONED])
                ->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }

    public function getUnreadResponsesCount($enterprise): int
    {
        try {
            $enterprise = $this->find($enterprise);
            return ProposalResponse::whereHas('proposal', function ($query) use ($enterprise) {
                $query->whereHas('offer', function ($q) use ($enterprise) {
                    $q->ofCustomer($enterprise);
                });
            })->where('created_at', '>=', Carbon::now()->subDay())->count();
        } catch (ModelNotFoundException $e) {
            return 0;
        }
    }
}
