<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;

interface ContractPartyEntityInterface
{
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContract(ContractEntityInterface $contract);
    public function setEnterprise(Enterprise $enterprise);
    public function setContractModelParty(ContractModelPartyEntityInterface $contractModelParty);
    public function setEnterpriseName(string $name);
    public function setDenomination(string $denomination);
    public function setOrder(int $order);
    public function setNumber();
    public function setSignatory(?User $signatory);
    public function setSignatoryName(?string $name);
    public function setSignedAt(string $date);
    public function setYousignMemberId(?string $id): void;
    public function setYousignFileObjectId(?string $id): void;
    public function setDeclinedAt(?string $date): void;
    public function setIsValidator(bool $is_validator): void;
    public function setValidatedAt($validated_at): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getEnterprise(): ?Enterprise;
    public function getContract(): ?ContractEntityInterface;
    public function getContractModelParty(): ?ContractModelPartyEntityInterface;
    public function getDeletedAt();
    public function getSignatory(): ?User;
    public function getDenomination(): string;
    public function getId(): string;
    public function getOrder(): ?int;
    public function getEnterpriseName(): string;
    public function getSignedAt();
    public function getYousignMemberId(): ?string;
    public function getYousignFileObjectId(): ?string;
    public function getUpdatedAt();
    public function getDeclinedAt();
    public function getIsValidator(): bool;
    public function getValidatedAt();
}
