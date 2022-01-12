<?php

namespace Components\Contract\Model\Domain\Interfaces\Entities;

use App\Models\Addworking\Common\File;

interface ContractModelPartEntityInterface
{
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setDisplayName(string $display_name);
    public function setName(string $display_name);
    public function setText(string $text);
    public function setContractModel(ContractModelEntityInterface $contract_model);
    public function setOrder(int $order);
    public function setIsInitialled(bool $is_initialled);
    public function setIsSigned(bool $is_signed);
    public function setShouldCompile(bool $should_compile);
    public function setFile(File $file);
    public function setNumber();
    public function setSignaturePage(?int $page): void;
    public function setSignatureMention(?string $mention): void;
    public function setSignOnLastPage(bool $sign_on_last_page): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): ?string;
    public function getDisplayName(): ?string;
    public function getText(): ?string;
    public function getContractModel(): ?ContractModelEntityInterface;
    public function getOrder(): ?int;
    public function getIsInitialled(): bool;
    public function getIsSigned(): bool;
    public function getShouldCompile(): bool;
    public function getNumber(): int;
    public function getFile();
    public function getVariables();
    public function getContractParts();
    public function getSignaturePage(): ?int;
    public function getSignatureMention(): ?string;
    public function getSignOnLastPage(): bool;
}
