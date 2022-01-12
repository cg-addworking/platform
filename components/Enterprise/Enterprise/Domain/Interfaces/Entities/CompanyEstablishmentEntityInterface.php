<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyEstablishmentEntityInterface
{
    public function getCity();
    public function getCountry();
    public function getFullAddress(): string;
    public function getIdentificationNumber(): string;
    public function getCode(): ?string;
    public function getEstablishmentName(): ?string;
    public function getCommercialName(): ?string;
    public function getCreationDate();
    public function getCessationDate();
    public function getIsHeadquarter(): bool;
    public function getOriginData(): ?string;
}
