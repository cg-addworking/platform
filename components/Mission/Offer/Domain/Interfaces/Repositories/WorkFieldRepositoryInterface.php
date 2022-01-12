<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;

interface WorkFieldRepositoryInterface
{
    public function find(string $id): ?WorkFieldEntityInterface;
    public function findByNumber(?string $number): ?WorkField;
}
