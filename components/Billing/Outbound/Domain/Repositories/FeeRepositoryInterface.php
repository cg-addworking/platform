<?php

namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;

interface FeeRepositoryInterface
{
    public function save(Fee $fee);

    public function hasFixedFeesByVendorForPeriod(Enterprise $customer, Enterprise $vendor, string $period): bool;

    public function hasSubscriptionForPeriod(Enterprise $customer, string $period): bool;

    public function hasDiscountForPeriod(Enterprise $customer, string $period): bool;

    public function make($data = []): Fee;

    public function list(?array $filter = null, ?string $search = null);

    public function getFeesForOutboundInvoiceItem(OutboundInvoiceItem $item);

    public function delete(Fee $fee);

    public function findByOutboundInvoice(OutboundInvoiceInterface $outboundInvoice);

    public function getManagementFeesOfOutboundInvoiceItemBeforeTaxes(
        OutboundInvoiceItemInterface $outboundInvoiceItem,
        OutboundInvoiceInterface $outboundInvoice
    ): float;

    public function getManagementFeesOfOutboundInvoiceBeforeTaxes(OutboundInvoiceInterface $outboundInvoice): float;

    public function getTypes(): array;

    public function findByNumber(string $number);

    public function findByParentId(string $parentId);

    public function find(string $id);

    public function getFeestoAssociate(OutboundInvoiceInterface $outboundInvoice);

    public function getFeesOfOutboundInvoice(OutboundInvoiceInterface $outboundInvoice);

    public function hasParent(Fee $fee): bool;
}
