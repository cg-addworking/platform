<?php

namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderItemInterface;

interface PaymentOrderItemRepositoryInterface
{
    public function save(PaymentOrderItemInterface $payment_order_item);
    public function delete(PaymentOrderItemInterface $payment_order_item);
    public function getItemsOfInboundInvoice(InboundInvoice $inbound_invoice);
    public function markInboundInvoiceAsPaid(InboundInvoice $inbound_invoice);
}
