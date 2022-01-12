<?php

namespace Components\Contract\Model\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\User\User;

interface ContractModelDocumentTypeEntityInterface
{
    public function setContractModelParty(ContractModelPartyEntityInterface $contractModelParty);

    public function setDocumentType($document_type);

    public function setNumber();

    public function setValidationRequired(bool $isValidationRequired);

    public function getValidationRequired(): ?bool;

    public function getNumber(): int;

    public function getContractModelParty(): ?ContractModelPartyEntityInterface;

    public function getDocumentType(): ?DocumentType;

    public function getValidatedBy(): ?User;

    public function getCreatedAt();
}
