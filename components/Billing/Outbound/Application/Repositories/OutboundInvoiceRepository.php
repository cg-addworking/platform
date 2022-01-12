<?php

namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceCreationFailedException;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;

class OutboundInvoiceRepository implements OutboundInvoiceRepositoryInterface
{
    private $enterpriseRepository;
    private $deadlineRepository;

    public function __construct()
    {
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->deadlineRepository = new DeadlineRepository;
    }

    public function save(OutboundInvoiceInterface $invoice)
    {
        try {
            $invoice->save();
        } catch (OutboundInvoiceCreationFailedException $exception) {
            throw $exception;
        }

        $invoice->refresh();

        return $invoice;
    }

    public function getStatuses(): array
    {
        $statuses = [
            OutboundInvoiceInterface::STATUS_PENDING,
            OutboundInvoiceInterface::STATUS_FEES_CALCULATED,
            OutboundInvoiceInterface::STATUS_FILE_GENERATED,
            OutboundInvoiceInterface::STATUS_PARTIALLY_PAID,
            OutboundInvoiceInterface::STATUS_FULLY_PAID,
        ];

        return array_mirror($statuses);
    }

    public function getPeriods(): array
    {
        $periods = CarbonPeriod::create(
            Carbon::today()->subMonths(11)->format('Y-m'),
            '1 month',
            Carbon::today()->format('Y-m')
        )->toArray();

        return array_reverse(array_mirror(array_map(fn ($month) => $month->format('m/Y'), $periods)));
    }

    public function findByNumber(string $number)
    {
        return OutboundInvoice::where('number', $number)->first();
    }

    public function hasStatus(OutboundInvoiceInterface $invoice, string $status): bool
    {
        return $invoice->getStatus() == $status;
    }

    public function list(?array $filter = null, ?string $search = null)
    {
        return OutboundInvoice::query()
            ->when($filter['number'] ?? null, function ($query, $number) {
                return $query->filterNumber($number);
            })
            ->when($filter['enterprise'] ?? null, function ($query, $enterprise) {
                return $query->filterEnterprise($enterprise);
            })
            ->when($filter['due_at'] ?? null, function ($query, $due_at) {
                return $query->filterDueAt($due_at);
            })
            ->when($filter['invoiced_at'] ?? null, function ($query, $invoiced_at) {
                return $query->filterInvoicedAt($invoiced_at);
            })
            ->when($filter['month'] ?? null, function ($query, $month) {
                return $query->filterMonth($month);
            })
            ->when($filter['deadline'] ?? null, function ($query, $deadline) {
                return $query->filterDeadline($deadline);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->filterStatus($status);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function make($data = []): OutboundInvoice
    {
        $class = OutboundInvoice::class;

        return new $class($data);
    }

    public function hasInboundInvoice(OutboundInvoiceInterface $outboundInvoice, InboundInvoice $inboundInvoice): bool
    {
        return InboundInvoice::where('id', $inboundInvoice->id)
            ->whereHas('items', function ($query) use ($outboundInvoice) {
                return $query->whereHas('outboundInvoiceItem', function ($query) use ($outboundInvoice) {
                    return $query->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                        return $query->where('id', $outboundInvoice->getId());
                    });
                });
            })->count() > 0;
    }

    public function getItemsOfInboundInvoice(
        OutboundInvoiceInterface $outboundInvoice,
        InboundInvoice $inboundInvoice
    ) {
        return OutboundInvoiceItem::whereHas('inboundInvoiceItem', function ($query) use ($inboundInvoice) {
            $query->whereHas('inboundInvoice', function ($query) use ($inboundInvoice) {
                $query->where('id', $inboundInvoice->id);
            });
        })->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->id);
        })->get();
    }

    public function hasFile(OutboundInvoiceInterface $outboundInvoice): bool
    {
        return $outboundInvoice->getFile()->exists;
    }

    public function find(string $id)
    {
        return OutboundInvoice::where('id', $id)->first();
    }

    public function getOutboundInvoicesForPeriodAndDeadline(
        Enterprise $enterprise,
        string $month,
        DeadlineType $deadline
    ) {
        return OutboundInvoice::whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->whereIn('id', app(FamilyEnterpriseRepository::class)
                ->getAncestors($enterprise, true)->pluck('id'));
        })->whereHas('deadline', function ($query) use ($deadline) {
            return $query->where('id', $deadline->id);
        })->where('month', $month)->get();
    }

    public function updateStatusTo(OutboundInvoiceInterface $outboundInvoice, string $status)
    {
        return $outboundInvoice->update(['status' => $status]);
    }

    public function publish(OutboundInvoiceInterface $outboundInvoice)
    {
        return $outboundInvoice->update(['is_published' => true]);
    }

    public function unpublish(OutboundInvoiceInterface $outboundInvoice)
    {
        return $outboundInvoice->update(['is_published' => false]);
    }

    public function isPublished(OutboundInvoiceInterface $outboundInvoice): bool
    {
        return $outboundInvoice->getPublishStatus();
    }

    public function findByParentId(string $parentId)
    {
        return OutboundInvoice::whereHas('parent', function ($query) use ($parentId) {
            return $query->where('id', $parentId);
        });
    }

    public function hasParent(OutboundInvoiceInterface $outboundInvoice): bool
    {
        return $outboundInvoice->getParent()->exists;
    }

    public function getPaymentOrderOfOutboundInvoice(OutboundInvoiceInterface $outboundInvoice)
    {
        return PaymentOrder::whereHas('items', function ($query) use ($outboundInvoice) {
            $query->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                $query->where('id', $outboundInvoice->getId());
            });
        })->get();
    }

    /**
     * @param OutboundInvoiceInterface $outboundInvoice
     * @return OutboundInvoiceInterface
     * @throws OutboundInvoiceCreationFailedException
     */
    public function validate(User $auth_user, OutboundInvoiceInterface $outboundInvoice)
    {
        $outboundInvoice->setValidatedBy($auth_user);
        $outboundInvoice->setValidateAt(Carbon::now());
        $outboundInvoice->setStatus(OutboundInvoiceInterface::STATUS_VALIDATED);

        return $this->save($outboundInvoice);
    }

    /**
     * @param OutboundInvoiceInterface $outboundInvoice
     * @return bool
     */
    public function isValidated(OutboundInvoiceInterface $outboundInvoice)
    {
        return $outboundInvoice->getStatus() == OutboundInvoiceInterface::STATUS_VALIDATED;
    }

    /**
     * @param OutboundInvoiceInterface $outboundInvoice
     * @return bool
     */
    public function checkIfStatusEqualsToFileGenerated(OutboundInvoiceInterface $outboundInvoice)
    {
        return $outboundInvoice->getStatus() == OutboundInvoiceInterface::STATUS_FILE_GENERATED;
    }
}
