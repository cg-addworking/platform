<?php
namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceItemCreationFailedException;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;

class OutboundInvoiceItemRepository implements OutboundInvoiceItemRepositoryInterface
{
    public function save(OutboundInvoiceItemInterface $item)
    {
        try {
            $item->save();
        } catch (OutboundInvoiceItemCreationFailedException $exception) {
            throw $exception;
        }

        $item->refresh();

        return $item;
    }

    public function delete(OutboundInvoiceItemInterface $item)
    {
        return $item->delete();
    }

    public function make($data = []): OutboundInvoiceItem
    {
        $class = OutboundInvoiceItem::class;

        return new $class($data);
    }

    public function getItemsOfOutboundInvoice(OutboundInvoiceInterface $outboundInvoice)
    {
        return OutboundInvoiceItem::whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->id);
        })->get();
    }

    public function hasFees(OutboundInvoiceItem $item): bool
    {
        return OutboundInvoiceItem::where('id', $item->id)->has('fees')->count();
    }

    public function findByNumber(string $number)
    {
        return OutboundInvoiceItem::where('number', $number)->first();
    }

    public function setNegativeUnitPrice(float $unitPrice)
    {
        $negativePrice = 0 - $unitPrice;

        return $negativePrice;
    }

    public function findByParentId(string $parentId)
    {
        return OutboundInvoiceItem::whereHas('parent', function ($query) use ($parentId) {
            return $query->where('id', $parentId);
        });
    }

    public function find(string $id)
    {
        return OutboundInvoiceItem::where('id', $id)->first();
    }

    public function getItemsToAssociate(OutboundInvoiceInterface $outboundInvoice)
    {
        return OutboundInvoiceItem::where('is_canceled', false)
        ->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->id);
        })->get();
    }

    public function hasParent(string $id): bool
    {
        return OutboundInvoiceItem::where('id', $id)->whereNotNull('parent_id')->count();
    }

    public function hasInboundInvoiceItem(string $id): bool
    {
        return OutboundInvoiceItem::where('id', $id)->whereNotNull('inbound_invoice_item_id')->count();
    }
}
