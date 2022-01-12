<?php
namespace Components\Billing\PaymentOrder\Domain\Classes;

interface ReceivedPaymentInterface
{
    public function setEnterprise($enterprise);
    public function setIban($iban);
    public function setCreatedBy($user);
    public function setNumber();
    public function setBankReferencePayment(string $reference);
    public function setIbanReference(string $iban);
    public function setBicReference(string $bic);
    public function setAmount(float $amount);
    public function setReceivedAt(string $received_at);
    public function setAgicapId(string $agicap_id);

    public function getId(): ?string;
    public function getEnterprise();
    public function getIban();
    public function getCreatedBy();
    public function getNumber(): int;
    public function getBankReferencePayment(): ?string;
    public function getIbanReference(): ?string;
    public function getBicReference(): ?string;
    public function getAmount(): ?float;
    public function getReceivedAt();
    public function getAgicapId(): ?string;
    public function getDeletedAt();
}
