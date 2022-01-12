<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPaymentOutboundInvoice;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\ReceivedPaymentCreationFailedException;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentRepositoryInterface;

class ReceivedPaymentRepository implements ReceivedPaymentRepositoryInterface
{
    public function save(ReceivedPaymentInterface $payment)
    {
        try {
            $payment->save();
        } catch (ReceivedPaymentCreationFailedException $exception) {
            throw $exception;
        }

        $payment->refresh();

        return $payment;
    }

    public function list(Enterprise $enterprise)
    {
        return ReceivedPayment::query()->whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->latest()->paginate(25);
    }

    public function listAsSupport()
    {
        return ReceivedPayment::query()->latest()->paginate(25);
    }

    public function make($data = []): ReceivedPayment
    {
        $class = ReceivedPayment::class;

        return new $class($data);
    }

    public function findByNumber(string $number)
    {
        return ReceivedPayment::where('number', $number)->first();
    }

    public function getPaymentOutbounds(ReceivedPaymentInterface $received_payment)
    {
        return ReceivedPaymentOutboundInvoice::whereHas('receivedPayment', function ($query) use ($received_payment) {
            return $query->where('id', $received_payment->getId());
        })->get();
    }

    public function getOutboundInvoices(ReceivedPaymentInterface $received_payment)
    {
        return OutboundInvoice::whereHas('receivedPaymentOutbound', function ($query) use ($received_payment) {
            return $query->whereHas('receivedPayment', function ($query) use ($received_payment) {
                return $query->where('id', $received_payment->getId());
            });
        })->get();
    }

    public function hasReceivedPayment(OutboundInvoiceInterface $outboundInvoice)
    {
        return OutboundInvoice::where('id', $outboundInvoice->getId())->has('receivedPaymentOutbound')->exists();
    }

    public function getReceivedPaymentOf(OutboundInvoiceInterface $outboundInvoice)
    {
        return ReceivedPayment::whereHas('receivedPaymentOutbound', function ($query) use ($outboundInvoice) {
            return $query->where('outbound_invoice_id', $outboundInvoice->getId());
        })->first();
    }

    public function delete(?ReceivedPayment $received_payment)
    {
        return $received_payment->delete();
    }

    public function findTrashedByNumber(string $number)
    {
        return ReceivedPayment::onlyTrashed()->where('number', $number)->first();
    }
}
