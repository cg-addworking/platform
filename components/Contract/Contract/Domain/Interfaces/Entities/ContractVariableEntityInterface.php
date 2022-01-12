<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;

interface ContractVariableEntityInterface
{
    public function getContractModelVariable(): ?ContractModelVariableEntityInterface;
    public function getId(): string;
    public function getValue(): ?string;
    public function getDeletedAt();
    public function getContract(): ContractEntityInterface;
    public function getContractParty(): ?ContractPartyEntityInterface;
    public function getOrder(): int;
    public function getValueHtmlAttribute(): ?string;
    public function getValueRequestedAt();
    public function getValueRequestedTo(): ?ContractPartyEntityInterface;

    public function setContract($contract);
    public function setContractModelVariable($contract_model_variable);
    public function setFilledBy(User $user);
    public function setContractParty(ContractPartyEntityInterface $contractParty);
    public function setValue(?string $value);
    public function setNumber();
    public function setOrder(int $order): void;
    public function setValueRequestedTo(User $user): void;
    public function setValueRequestedAt($value_requested_at): void;
}
