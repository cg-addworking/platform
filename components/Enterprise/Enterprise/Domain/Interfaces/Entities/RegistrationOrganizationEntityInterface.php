<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface RegistrationOrganizationEntityInterface
{
    public function getCountry();
    public function getName(): string;
    public function getAcronym(): string;
    public function getLocation(): ?string;
    public function getCode();
}
