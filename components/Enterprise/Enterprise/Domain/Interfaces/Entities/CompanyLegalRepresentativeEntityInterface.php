<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyLegalRepresentativeEntityInterface
{
    public function getCityBirth();
    public function getCountryBirth();
    public function getCountryNationality();
    public function getCity();
    public function getCountry();
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getDenomination(): ?string;
    public function getQuality(): string;
    public function getStartsAt();
    public function getEndsAt(): ?string;
    public function getIdentificationNumber(): ?string;
    public function getDateBirth();
    public function getAddress();
    public function getAdditionalAddress();
    public function getOriginData();
    public function getFullAddress();
}
