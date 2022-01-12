<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyEntityInterface
{
    const SEARCHABLE_ATTRIBUTE_NAME                     = 'denominations.name';
    const SEARCHABLE_ATTRIBUTE_IDENTIFICATION_NUMBER    = 'identification_number';

    public function getLegalForm();
    public function getCountry();
    public function getParent();
    public function getInvoicingDetails();
    public function getActivities();
    public function getEstablishments();
    public function getEmployees();
    public function getLegalRepresentatives();
    public function getDenominations();
    public function getRegistrationOrganizations();
    public function getCompanyShareCapital();
    public function getName();
    public function getIdentificationNumber(): string;
    public function getShortId();
    public function getCreationDate();
    public function getCessationDate();
    public function getIsSoleShareholder(): bool;
    public function getLastUpdatedAt();
    public function getOriginData(): ?string;
}
