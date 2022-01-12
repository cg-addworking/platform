<?php
namespace Components\Billing\PaymentOrder\Domain\Classes;

interface PaymentOrderInterface
{
    const STATUS_PENDING  = "pending";
    const STATUS_EXECUTED = "executed";

    public function setExecutedAt(string $date);
    public function setCustomerName(string $name);
    public function setStatus(string $status);
    public function setEnterprise($id);
    public function setIban(string $id);
    public function setOutboundInvoice(string $id);
    public function setNumber();
    public function setDebtorName(string $name);
    public function setDebtorIban(string $iban);
    public function setDebtorBic(string $bic);
    public function setBankReferencePayment(string $reference);
    public function setCreatedBy(string $id);
    public function setFile(string $id);

    public function getId(): ?string;
    public function getCustomerName(): ?string;
    public function getExecutedAt();
    public function getCreatedAt();
    public function getUpdatedAt();
    public function getDeletedAt();
    public function getIban();
    public function getEnterprise();
    public function getStatus();
    public function getNumber();
    public function getBankReferencePayment(): ?string;
    public function getDebtorName();
    public function getDebtorIban();
    public function getDebtorBic();
    public function getFile();
    public function getItems();
    public function getOutboundInvoice();
    public function getTotalAmount(): float;
    public function getReference(): string;
}
