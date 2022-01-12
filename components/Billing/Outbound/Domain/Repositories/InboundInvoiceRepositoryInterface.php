<?php
namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;

interface InboundInvoiceRepositoryInterface
{
    public function find(string $id);
 
    public function findByNumber(string $number);

    public function findBy(string $siret, string $number, string $month);

    public function hasStatus(InboundInvoice $invoice, string $status): bool;

    public function hasItems(InboundInvoice $invoice): bool;

    public function getInboundInvoicesToAssociate(Enterprise $customer, OutboundInvoiceInterface $outboundInvoice);

    public function getInboundInvoicesToDissociate(Enterprise $customer, OutboundInvoiceInterface $outboundInvoice);
}
