<?php

namespace Components\Billing\Outbound\Domain\Classes;

interface FeeInterface
{
    const DEFAULT_MANAGMENT_FEES_TYPE = "default_management_fees";
    const CUSTOM_MANAGMENT_FEES_TYPE = "custom_management_fees";
    const SUBSCRIPTION_TYPE = "subscription";
    const DISCOUNT_TYPE = "discount";
    const FIXED_FEES_TYPE = "fixed_fees";
    const OTHER_TYPE = "other";

    public function setLabel(string $label);

    public function setType(string $type);

    public function setAmountBeforeTaxes(float $amount, float $fees);

    public function setVendor($vendor);

    public function setItem($item);

    public function setInvoice($invoice);

    public function setInvoiceParameter($param);

    public function setVatRate($vatRate);

    public function setCustomer($customer);

    public function getVatRate();

    public function getAmountBeforeTaxes(): ?float;

    public function getAmountOfTaxes(): float;

    public function getType(): ?string;

    public function getVendor();

    public function getOutboundInvoiceItem();

    public function getLabel();

    public function getOutboundInvoice();

    public function getCustomer();

    public function setNegativeAmountBeforeTaxes(float $fees);

    public function setParent($fee);

    public function setIsCanceled(bool $bool);

    public function setNumber();

    public function getId();

    public function getNumber();

    public function getParent();
}
