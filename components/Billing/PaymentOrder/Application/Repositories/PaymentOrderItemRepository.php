<?php

namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use Carbon\Carbon;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderItemInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderItemRepositoryInterface;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Addworking\Billing\InboundInvoiceRepository;

class PaymentOrderItemRepository implements PaymentOrderItemRepositoryInterface
{
    public function save(PaymentOrderItemInterface $payment_order_item)
    {
        $saved = $payment_order_item->save();
        $payment_order_item->refresh();

        return $saved ? $payment_order_item : null;
    }

    public function delete(PaymentOrderItemInterface $payment_order_item)
    {
        return $payment_order_item->delete();
    }

    public function getItemsOfInboundInvoice(InboundInvoice $inbound_invoice)
    {
        return PaymentOrderItem::whereHas('inboundInvoice', function ($query) use ($inbound_invoice) {
            $query->where('id', $inbound_invoice->id);
        })->get();
    }

    public function markInboundInvoiceAsPaid(InboundInvoice $inbound_invoice)
    {
        $inboundInvoiceRepository = App::make(InboundInvoiceRepository::class);
        $inboundInvoiceRepository->comment($inbound_invoice);
        $now = Carbon::now();
        ActionTrackingHelper::track(
            Auth::user(),
            ActionEntityInterface::PAID_INBOUND_INVOICE,
            $inbound_invoice,
            __(
                'addworking.billing.inbound_invoice.tracking.paid',
                [
                    'user' => 'AddWorking',
                    'date' => $now->format('d/m/Y'),
                    'datetime' => $now->format('H:i'),
                ]
            )
        );

        return InboundInvoice::where('id', $inbound_invoice->id)->update(['status' => InboundInvoice::STATUS_PAID]);
    }
}
