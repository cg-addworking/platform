<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Components\Billing\PaymentOrder\Domain\Repositories\InboundInvoiceRepositoryInterface;

class InboundInvoiceRepository implements InboundInvoiceRepositoryInterface
{
    public function find(string $id)
    {
        return InboundInvoice::where('id', $id)->first();
    }

    public function findByNumber(string $number)
    {
        return InboundInvoice::where('number', $number)->first();
    }

    public function findBy(string $siret, string $number, string $month)
    {
        return InboundInvoice::where('number', $number)
            ->where('month', $month)
            ->whereHas('enterprise', function ($query) use ($siret) {
                $query->where('identification_number', $siret);
            })->first();
    }

    public function hasStatus(InboundInvoice $invoice, string $status): bool
    {
        return $invoice->status == $status;
    }

    public function hasPaymentOrder(InboundInvoice $invoice) : bool
    {
        return InboundInvoice::where('id', $invoice->id)->has('paymentOrderItem')->count();
    }
}
