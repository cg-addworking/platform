<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;

interface InboundInvoiceRepositoryInterface
{
    public function find(string $id);
    public function findByNumber(string $number);
    public function findBy(string $siret, string $number, string $month);
    public function hasStatus(InboundInvoice $invoice, string $status): bool;
    public function hasPaymentOrder(InboundInvoice $invoice): bool;
}
