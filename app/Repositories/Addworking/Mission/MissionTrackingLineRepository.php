<?php

namespace App\Repositories\Addworking\Mission;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Repositories\BaseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\AccountingExpenseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\EnterpriseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MissionTrackingLineRepository extends BaseRepository
{
    protected $model = MissionTrackingLine::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return $this->missionTrackingBuilder(MissionTrackingLine::query(), $search, $filter)
            ->when($filter['vendor_status'] ?? null, function ($query, $status) {
                return $query->validationVendor($status);
            })
            ->when($filter['customer_status'] ?? null, function ($query, $status) {
                return $query->validationCustomer($status);
            })
            ->when($filter['quantity'] ?? null, function ($query, $quantity) {
                return $query->quantity($quantity);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    private function missionTrackingBuilder(Builder $query, ?string $search = null, ?array $filter = null) : Builder
    {
        return $query
            ->when($filter['customer'] ?? null, function (Builder $query, string $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($filter['vendor'] ?? null, function (Builder $query, $vendor) {
                return $query->filterVendor($vendor);
            })
            ->when($filter['mission'] ?? null, function (Builder $query, $number) {
                return $query->whereHas('missionTracking', function ($query) use ($number) {
                    return $query->whereHas('mission', function ($query) use ($number) {
                        return $query->number($number);
                    });
                });
            })
            ->when($filter['month'] ?? null, function (Builder $query, $month) {
                return $query->whereHas('missionTracking', function ($query) use ($month) {
                    return $query->month($month);
                });
            });
    }

    public function createFromRequest(MissionTracking $tracking, Request $request): MissionTrackingLine
    {
        return transaction(function () use ($request, $tracking) {
            $line = $this->make();
            $line->fill($request->input('line'));

            if ($request->user()->enterprise->is_vendor) {
                $line->validation_vendor = MissionTrackingLine::STATUS_VALIDATED;
            }

            if ($request->user()->enterprise->is_customer) {
                $line->validation_customer = MissionTrackingLine::STATUS_VALIDATED;
            }

            if (! $request->user()->isSupport()) {
                $line->createdBy()->associate($request->user());
            }

            $line->missionTracking()->associate($tracking);

            if ($request->has('line.accounting_expense')) {
                $accounting_expense = App::make(AccountingExpenseRepository::class)
                    ->find($request->input('line.accounting_expense'));

                $line->accountingExpense()->associate($accounting_expense);
            }

            $line->save();

            $default_accounting_expense = App::make(EnterpriseRepository::class)
                ->getByDefaultAccountingExpense($tracking->mission->customer);

            if (is_null($line->accountingExpense()->first()) && ! is_null($default_accounting_expense)) {
                $line->accountingExpense()->associate($default_accounting_expense)->save();
            }
            
            $tracking->update(['status' => MissionTracking::STATUS_SEARCH_FOR_AGREEMENT]);

            return $line;
        });
    }

    public function updateFromRequest(MissionTrackingLine $line, Request $request): MissionTrackingLine
    {
        $accounting_expense = App::make(AccountingExpenseRepository::class)
            ->find($request->input('line.accounting_expense'));

        $line->accountingExpense()->associate($accounting_expense)->save();

        $line->update($request->input('line'));

        return $line;
    }

    public function validation(MissionTrackingLine $line, Request $request): MissionTrackingLine
    {
        $line->fill($request->input('line'));
        $line->save();

        if (($line->validation_vendor == MissionTrackingLine::STATUS_VALIDATED)
            && ($line->validation_customer == MissionTrackingLine::STATUS_VALIDATED)) {
            $line->missionTracking->update(['status' => MissionTracking::STATUS_VALIDATED]);
        }

        return $line;
    }

    public function getLinesFromInboundInvoice(InboundInvoice $inbound_invoice): Collection
    {
        return MissionTrackingLine::whereHas('missionTracking', function ($query) use ($inbound_invoice) {
            $query->whereHas('mission', function ($query) use ($inbound_invoice) {
                $query->ofVendor($inbound_invoice->enterprise)->ofCustomer($inbound_invoice->customer);
            });
        })
        ->doesntHave('invoiceItems')
        ->get()
        ->sortByDesc(function ($line) {
            return $line->missionTracking->mission->number;
        });
    }

    public function isValidated(MissionTrackingLine $line)
    {
        return $line->isValidatedByCustomer() && $line->isValidatedByVendor();
    }

    public function isRejected(MissionTrackingLine $line)
    {
        return $line->isRejectedByCustomer() || $line->isRejectedByVendor();
    }
}
