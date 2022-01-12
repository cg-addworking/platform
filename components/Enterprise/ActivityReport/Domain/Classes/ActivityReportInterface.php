<?php

namespace Components\Enterprise\ActivityReport\Domain\Classes;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface ActivityReportInterface
{
    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------
    public function getVendor(): Enterprise;
    public function getYear(): string;
    public function getMonth(): string;
    public function getNote(): ?string;

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------
    public function setVendor(Enterprise $vendor): void;
    public function setYear(int $year): void;
    public function setMonth(int $month): void;
    public function setCreatedBy(User $user): void;
    public function setNote(?string $note): void;
    public function setOtherActivity(?string $other_activity): void;
    public function setNoActivity(): void;
}
