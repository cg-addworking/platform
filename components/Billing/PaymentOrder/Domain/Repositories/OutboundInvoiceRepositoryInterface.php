<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;

interface OutboundInvoiceRepositoryInterface
{
    public function findByNumber(string $number);
    public function hasStatus(OutboundInvoiceInterface $outboundInvoice, string $status): bool;
    public function find(string $id);
}
