<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Classes;

interface InvoiceParameterInterface
{
    public function getDefaultManagementFeesByVendor(): ?float;
    public function getCustomManagementFeesByVendor(): ?float;
    public function getFixedFeesByVendor(): ?float;
    public function getId(): string;
    public function getSubscription(): ?float;
    public function getIban();
    public function getDiscount();
    public function getDiscountEndsAt();
    public function getDiscountStartsAt();
    public function getCreatedAt();
    public function getUpdatedAt();
    public function getDeletedAt();
    public function getEnterprise();
    public function getAnalyticCode(): ?string;
    public function getBillingFloorAmount(): ?float;
    public function getBillingCapAmount(): ?float;
    public function getStartsAt();
    public function getEndsAt();
    public function getInvoicingFromInboundInvoice(): ?bool;
    public function getStatus(): bool;
    public function getNumber(): int;
    public function getVendorCreatingInboundInvoiceItems(): ?bool;

    public function setEnterprise($enterprise): void;
    public function setIban($iban): void;
    public function setDefaultManagementFeesByVendor(float $value): void;
    public function setCustomManagementFeesByVendor(float $value): void;
    public function setFixedFeesByVendorAmount(float $value): void;
    public function setSubscriptionAmount(float $value): void;
    public function setDiscountAmount(float $value): void;
    public function setDiscountEndsAt(?string $date): void;
    public function setDiscountStartsAt(?string $date): void;
    public function setAnalyticCode(?string $value): void;
    public function setBillingFloorAmount(float $value): void;
    public function setBillingCapAmount(float $value): void;
    public function setStartsAt(string $date): void;
    public function setEndsAt(?string $date): void;
    public function setInvoicingFromInboundInvoice(bool $value): void;
    public function setNumber(): void;
}
