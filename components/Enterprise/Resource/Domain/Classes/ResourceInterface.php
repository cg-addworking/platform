<?php
namespace Components\Enterprise\Resource\Domain\Classes;

interface ResourceInterface
{
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------

    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getEmail(): ?string;

    public function getRegistrationNumber(): ?string;

    public function getStatus(): ?string;

    public function getNote(): ?string;

    public function getNumber(): int;

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------

    public function setFirstName(?string $first_name);

    public function setLastName(?string $last_name);

    public function setVendor($vendor);

    public function setCreator($user);

    public function setEmail(?string $email);

    public function setNumber();

    public function setRegistrationNumber(?string $registration_number);

    public function setStatus(string $status);

    public function setNote(?string $note);
}
