<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

use App\Models\Addworking\Common\File;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;

interface ContractPartEntityInterface
{
    const ORDER_UP = "up";
    const ORDER_DOWN = "down";

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContract(ContractEntityInterface $contract): void;
    public function setContractModelPart(ContractModelPartEntityInterface $contract_model_part): void;
    public function setFile(File $file): void;
    public function setOrder(?int $order): void;
    public function setName(?string $display_name): void;
    public function setDisplayName(?string $display_name): void;
    public function setIsHidden(bool $bool): void;
    public function setSignaturePage(?int $signature_page);
    public function setSignatureMention(?string $signature_mention);
    public function setNumber(): void;
    public function setYousignFileId(?string $id): void;
    public function setIsSigned(bool $is_signed);
    public function setIsUsedInContractBody(bool $is_used_in_contract_body): void;
    public function setSignOnLastPage(bool $sign_on_last_page): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string;
    public function getOrder();
    public function getFile();
    public function getContractModelPart();
    public function getName(): ?string;
    public function getDisplayName(): string;
    public function getIsHidden(): bool;
    public function getNumber(): int;
    public function getSignaturePage(): ?int;
    public function getYousignFileId(): ?string;
    public function getSignedAt();
    public function getSignatureMention(): ?string;
    public function getIsUsedInContractBody(): bool;
    public function getSignOnLastPage(): bool;
}
