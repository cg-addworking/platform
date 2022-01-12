<?php
namespace Components\Billing\PaymentOrder\Domain\Classes;

interface PaymentOrderItemInterface
{
    public function setPaymentOrder($payment_order);
    public function setInboundInvoice($inbound_invoice);
    public function setOutboundInvoice($outbound_invoice);
    public function setIban($iban);
    public function setNumber();
    public function setEnterpriseName(string $name);
    public function setEnterpriseIban(string $iban);
    public function setEnterpriseBic(string $bic);
    public function setAmount(float $amount);

    public function getPaymentOrder();
    public function getInboundInvoice();
    public function getOutboundInvoice();
    public function getIban();
    public function getNumber();
    public function getEnterpriseName();
    public function getEnterpriseIban();
    public function getEnterpriseBic();
    public function getAmount();
    public function getReference(): string;
    public function getReferenceForVendor(): string;
}
