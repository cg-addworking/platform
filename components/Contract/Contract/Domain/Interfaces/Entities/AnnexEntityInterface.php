<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

interface AnnexEntityInterface
{
    public function enterprise();
    public function file();
    public function setEnterprise($enteprise);
    public function setFile($value);
    public function setName(string $name);
    public function setNumber();
    public function setDisplayName(string $display_name);
    public function setDescription(?string $description);
    public function getId();
    public function getEnterprise();
    public function getFile();
    public function getNumber(): ?int;
    public function getName(): string;
    public function getDisplayName(): string;
    public function getDescription(): ?string;
    public function getDeletedAt();
    public function getCreatedAt();
}
