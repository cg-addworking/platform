<?php

namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;

interface PaymentOrderRepositoryInterface
{
    public function save(PaymentOrderInterface $payment_order);
    public function list(Enterprise $enterprise, ?array $filter = null, ?string $search = null);
    public function make($data = []): PaymentOrder;
    public function findByNumber(string $number);
    public function getStatuses(): array;
    public function hasFile(PaymentOrderInterface $payment_order): bool;
    public function getAssociatedInboundInvoices(PaymentOrderInterface $payment_order);
    public function getInboundInvoiceToAssociate(Enterprise $enterprise);
    public function delete(PaymentOrder $payment_order);
    public function getOutboundInvoices(PaymentOrderInterface $payment_order);
}
