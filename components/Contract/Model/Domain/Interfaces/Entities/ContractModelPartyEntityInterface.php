<?php

namespace Components\Contract\Model\Domain\Interfaces\Entities;

interface ContractModelPartyEntityInterface
{
    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getPartyDocumentTypes();
    public function getDenomination(): string;
    public function getOrder(): int;
    public function getId(): string;
    public function getContractModel(): ?ContractModelEntityInterface;
    public function getVariables();
    public function getSignaturePosition(): ?string;

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContractModel(ContractModelEntityInterface $contract_model);
    public function setDenomination(string $denomination);
    public function setOrder(int $order);
    public function setNumber();
    public function setSignaturePosition(?string $position): void;
}
