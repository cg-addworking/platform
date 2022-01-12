<?php

namespace Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface BusinessTurnoverEntityInterface
{
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void;
    public function setYear(int $year): void;
    public function setAmount(float $amount): void;
    public function setEnterprise(Enterprise $enterprise): void;
    public function setEnterpriseName(string $name): void;
    public function setCreatedBy(User $user): void;
    public function setCreatedByName(string $name): void;
    public function setNoActivity(bool $no_activity): void;

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getEnterprise(): Enterprise;
    public function getCreatedBy(): User;
    public function getAmount(): float;
    public function getYear(): int;
    public function getNoActivity(): bool;
    public function getCreatedByName(): string;
}
