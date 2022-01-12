<?php

namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\FeeInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Domain\Exceptions\FeeCreationFailedException;
use Components\Billing\Outbound\Domain\Repositories\FeeRepositoryInterface;

class FeeRepository implements FeeRepositoryInterface
{
    public function save(Fee $fee)
    {
        try {
            $fee->save();
        } catch (FeeCreationFailedException $exception) {
            throw $exception;
        }

        $fee->refresh();

        return $fee;
    }

    public function hasFixedFeesByVendorForPeriod(Enterprise $customer, Enterprise $vendor, string $period): bool
    {
        return Fee::where('type', FeeInterface::FIXED_FEES_TYPE)
            ->whereHas('customer', function ($query) use ($customer) {
                $query->where('id', $customer->id);
            })->whereHas('vendor', function ($query) use ($vendor) {
                $query->where('id', $vendor->id);
            })->whereHas('outboundInvoice', function ($query) use ($period) {
                $query->where('month', $period);
            })->count() > 0;
    }

    public function hasSubscriptionForPeriod(Enterprise $customer, string $period): bool
    {
        return Fee::where('type', FeeInterface::SUBSCRIPTION_TYPE)
            ->whereHas('customer', function ($query) use ($customer) {
                $query->where('id', $customer->id);
            })->whereHas('outboundInvoice', function ($query) use ($period) {
                $query->where('month', $period);
            })->count() > 0;
    }

    public function hasDiscountForPeriod(Enterprise $customer, string $period): bool
    {
        return Fee::where('type', FeeInterface::DISCOUNT_TYPE)
            ->whereHas('customer', function ($query) use ($customer) {
                $query->where('id', $customer->id);
            })->whereHas('outboundInvoice', function ($query) use ($period) {
                $query->where('month', $period);
            })->count() > 0;
    }

    public function findByOutboundInvoice(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->getId());
        })->get();
    }

    public function getManagementFeesOfOutboundInvoiceItemBeforeTaxes(
        OutboundInvoiceItemInterface $outboundInvoiceItem,
        OutboundInvoiceInterface $outboundInvoice
    ): float {
        $fees = Fee::whereIn('type', [Fee::DEFAULT_MANAGMENT_FEES_TYPE, Fee::CUSTOM_MANAGMENT_FEES_TYPE])
            ->whereHas('outboundInvoiceItem', function ($query) use ($outboundInvoiceItem) {
                $query->where('id', $outboundInvoiceItem->getId());
            })->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                $query->where('id', $outboundInvoice->getId());
            })->get();

        return $fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountBeforeTaxes();
        }, 0);
    }

    public function getManagementFeesOfOutboundInvoiceBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float
    {
        $fees = Fee::whereIn('type', [Fee::DEFAULT_MANAGMENT_FEES_TYPE, Fee::CUSTOM_MANAGMENT_FEES_TYPE])
            ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
                $query->where('id', $outboundInvoice->getId());
            })->get();

        return $fees->reduce(function ($carry, Fee $fee) {
            return $carry + $fee->getAmountBeforeTaxes();
        }, 0);
    }

    public function make($data = []): Fee
    {
        $class = Fee::class;

        return new $class($data);
    }

    public function list(?array $filter = null, ?string $search = null)
    {
        return Fee::query()
            ->when($filter['label'] ?? null, function ($query, $label) {
                return $query->filterLabel($label);
            })
            ->when($filter['type'] ?? null, function ($query, $type) {
                return $query->filterType($type);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function getFeesForOutboundInvoiceItem(OutboundInvoiceItem $item)
    {
        return Fee::whereHas('outboundInvoiceItem', function ($query) use ($item) {
            return $query->where('id', $item->id);
        })->get();
    }

    public function delete(Fee $fee)
    {
        return $fee->delete();
    }

    public function getTypes(): array
    {
        $types = [
            FeeInterface::DEFAULT_MANAGMENT_FEES_TYPE,
            FeeInterface::CUSTOM_MANAGMENT_FEES_TYPE,
            FeeInterface::SUBSCRIPTION_TYPE,
            FeeInterface::DISCOUNT_TYPE,
            FeeInterface::FIXED_FEES_TYPE,
            FeeInterface::OTHER_TYPE
        ];

        return array_trans(array_mirror($types), 'billing.outbound.application.views.fee._type.');
    }

    public function findByNumber(string $number)
    {
        return Fee::where('number', $number)->first();
    }

    public function findByParentId(string $parentId)
    {
        return Fee::whereHas('parent', function ($query) use ($parentId) {
            return $query->where('id', $parentId);
        });
    }

    public function find(string $id)
    {
        return Fee::where('id', $id)->first();
    }

    public function getFeestoAssociate(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::where('is_canceled', false)
        ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->id);
        })->get();
    }

    public function getFeesOfOutboundInvoice(OutboundInvoiceInterface $outboundInvoice)
    {
        return Fee::whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->id);
        })->get();
    }

    public function hasParent(Fee $fee): bool
    {
        return $fee->getParent()->exists;
    }
}
