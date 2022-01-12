<?php
namespace Components\Billing\Outbound\Domain\Repositories;

use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;

interface OutboundInvoiceFileRepositoryInterface
{
    public function generate(OutboundInvoiceInterface $outboundInvoice, $address);

    public function getItemsLines(OutboundInvoiceInterface $outboundInvoice);

    public function getSubscriptionFees(OutboundInvoiceInterface $outboundInvoice);

    public function getFixedFees(OutboundInvoiceInterface $outboundInvoice);

    public function getDiscountFees(OutboundInvoiceInterface $outboundInvoice);

    public function getTotalOfItemsLinesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float;

    public function getTotalOfSubscriptionFeesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float;

    public function getTotalOfFixedFeesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float;

    public function getTotalLinesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float;

    public function getTotalOfDiscountFeesBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float;
}
