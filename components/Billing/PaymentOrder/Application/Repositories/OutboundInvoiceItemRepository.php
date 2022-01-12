<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;

class OutboundInvoiceItemRepository implements OutboundInvoiceItemRepositoryInterface
{
    public function make($data = []): OutboundInvoiceItem
    {
        $class = OutboundInvoiceItem::class;

        return new $class($data);
    }

    public function getAmountIncludingAllTaxesOfInboundInvoice(
        InboundInvoice $inbound_invoice,
        OutboundInvoiceInterface $outbound_invoice
    ): float {
        $items = OutboundInvoiceItem::whereHas('inboundInvoiceItem', function ($query) use ($inbound_invoice) {
            return $query->whereHas('inboundInvoice', function ($query) use ($inbound_invoice) {
                return $query->where('id', $inbound_invoice->id);
            });
        })->whereHas('outboundInvoice', function ($query) use ($outbound_invoice) {
            return $query->where('id', $outbound_invoice->id);
        })->get();

        return round($items->reduce(function ($carry, OutboundInvoiceItem $item) {
            return $carry + $item->getAmountAllTaxesIncluded();
        }, 0), 2);
    }
}
