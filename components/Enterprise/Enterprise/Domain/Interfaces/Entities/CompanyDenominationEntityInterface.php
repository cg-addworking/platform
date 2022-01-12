<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyDenominationEntityInterface
{
    public function getName(): string;
    public function getCommercialName(): ?string;
    public function getAcronym(): ?string;
}
