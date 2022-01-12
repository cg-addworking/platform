<?php

namespace Components\Billing\PaymentOrder\Domain\Classes;

interface ReceivedPaymentOutboundInvoiceInterface
{
    public function setOutboundInvoice($outbound_invoice);
    public function setReceivedPayment($received_payment);
}
