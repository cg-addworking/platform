<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;

interface OutboundInvoiceItemRepositoryInterface
{
    public function make($data = []): OutboundInvoiceItemInterface;
    public function getAmountIncludingAllTaxesOfInboundInvoice(
        InboundInvoice $inbound_invoice,
        OutboundInvoiceInterface $outbound_invoice
    ): float;
}
