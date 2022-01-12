<?php

namespace Components\Billing\PaymentOrder\Application\Repositories;

use Components\Billing\PaymentOrder\Application\Models\ReceivedPaymentOutboundInvoice;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentOutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Domain\Exceptions\ReceivedPaymentOutboundInvoiceCreationFailedException;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentOutboundInvoiceRepositoryInterface;

class ReceivedPaymentOutboundInvoiceRepository implements ReceivedPaymentOutboundInvoiceRepositoryInterface
{
    public function make($data = [])
    {
        $class = ReceivedPaymentOutboundInvoice::class;

        return new $class($data);
    }

    public function save(ReceivedPaymentOutboundInvoiceInterface $payment_outbound)
    {
        try {
            $payment_outbound->save();
        } catch (ReceivedPaymentOutboundInvoiceCreationFailedException $exception) {
            throw $exception;
        }

        $payment_outbound->refresh();

        return $payment_outbound;
    }

    public function delete(ReceivedPaymentOutboundInvoiceInterface $payment_outbound)
    {
        return $payment_outbound->delete();
    }
}
