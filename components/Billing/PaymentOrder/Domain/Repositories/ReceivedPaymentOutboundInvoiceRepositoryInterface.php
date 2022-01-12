<?php

namespace Components\Billing\PaymentOrder\Domain\Repositories;

use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentOutboundInvoiceInterface;

interface ReceivedPaymentOutboundInvoiceRepositoryInterface
{
    public function make($data = []);
    public function save(ReceivedPaymentOutboundInvoiceInterface $payment_outbound);
    public function delete(ReceivedPaymentOutboundInvoiceInterface $payment_outbound);
}
