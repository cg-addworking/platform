<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyRegistrationOrganizationEntityInterface
{
    public function getOrganization();
    public function getRegisteredAt();
    public function getDelistedAt();
}
