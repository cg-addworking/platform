<?php
namespace Components\Billing\Outbound\Domain\Classes;

interface OutboundInvoiceItemInterface
{
    public function setInvoice(OutboundInvoiceInterface $invoice);

    public function setVatRate(string $id);

    public function setLabel(string $label);

    public function setQuantity(float $quantity);

    public function setUnitPrice(float $unitPrice);

    public function setInboundInvoiceItem(string $id);

    public function setVendor(string $id);

    public function setNumber();
    
    public function setParent($outboundInvoiceItem);

    public function getVatRate();

    public function getLabel(): string;

    public function getQuantity(): float;

    public function getUnitPrice(): float;

    public function getInboundInvoice();

    public function getAmountBeforeTaxes(): float;

    public function getAmountOfTaxes(): float;

    public function getAmountAllTaxesIncluded(): float;

    public function getVendor();

    public function getId(): string;

    public function getNumber():? string;

    public function getParent();

    public function getInboundInvoiceItem();

    public function setIsCanceled(bool $bool);
}
