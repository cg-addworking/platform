<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;

class PaymentOrderRepository implements PaymentOrderRepositoryInterface
{
    public function save(PaymentOrderInterface $payment_order)
    {
        $saved = $payment_order->save();
        $payment_order->refresh();

        return $saved ? $payment_order : null;
    }

    public function list(Enterprise $enterprise, ?array $filter = null, ?string $search = null)
    {
        return PaymentOrder::query()->whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->latest()->paginate(25);
    }

    public function make($data = []): PaymentOrder
    {
        $class = PaymentOrder::class;

        return new $class($data);
    }

    public function findByNumber(string $number)
    {
        return PaymentOrder::where('number', $number)->first();
    }

    public function getStatuses(): array
    {
        $statuses = [
            PaymentOrderInterface::STATUS_PENDING,
        ];

        return array_mirror($statuses);
    }

    public function hasFile(PaymentOrderInterface $payment_order): bool
    {
        return ! is_null($payment_order->getFile());
    }

    public function getAssociatedInboundInvoices(PaymentOrderInterface $payment_order)
    {
        return InboundInvoice::whereHas('paymentOrderItem', function ($query) use ($payment_order) {
            return $query->whereHas('paymentOrder', function ($query) use ($payment_order) {
                return $query->where('id', $payment_order->id);
            });
        })->orderByDesc('month')->get();
    }

    public function getInboundInvoiceToAssociate(Enterprise $enterprise)
    {
        return InboundInvoice::whereHas('outboundInvoice', function ($query) use ($enterprise) {
            return $query->whereHas('enterprise', function ($query) use ($enterprise) {
                $enterprises = app()->make(FamilyEnterpriseRepository::class)->getDescendants($enterprise, true);
                return $query->whereIn('id', $enterprises->pluck('id'));
            });
        })->doesntHave('paymentOrderItem')->where('status', '!=', InboundInvoice::STATUS_PAID)
            ->orderByDesc('month')->get();
    }

    public function delete(PaymentOrder $payment_order)
    {
        return $payment_order->delete();
    }

    public function getOutboundInvoices(PaymentOrderInterface $payment_order)
    {
        return OutboundInvoice::whereHas('paymentOrderItem', function ($query) use ($payment_order) {
            return $query->whereHas('paymentOrder', function ($query) use ($payment_order) {
                return $query->where('id', $payment_order->getId());
            });
        })->get();
    }
}
