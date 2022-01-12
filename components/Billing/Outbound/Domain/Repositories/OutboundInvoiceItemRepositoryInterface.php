<?php
namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;

interface OutboundInvoiceItemRepositoryInterface
{
    public function save(OutboundInvoiceItemInterface $item);

    public function delete(OutboundInvoiceItemInterface $item);

    public function make($data = []): OutboundInvoiceItemInterface;

    public function getItemsOfOutboundInvoice(OutboundInvoiceInterface $outboundInvoice);

    public function hasFees(OutboundInvoiceItem $item): bool;

    public function findByNumber(string $number);

    public function setNegativeUnitPrice(float $unitPrice);

    public function findByParentId(string $parentId);

    public function find(string $id);

    public function getItemsToAssociate(OutboundInvoiceInterface $outboundInvoice);

    public function hasParent(string $id): bool;

    public function hasInboundInvoiceItem(string $id): bool;
}
