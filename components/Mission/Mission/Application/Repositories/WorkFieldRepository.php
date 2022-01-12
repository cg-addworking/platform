<?php

namespace Components\Mission\Mission\Application\Repositories;

use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;

class WorkFieldRepository implements WorkFieldRepositoryInterface
{
    public function find(string $id): ?WorkField
    {
        return WorkField::where('id', $id)->first();
    }

    public function findByNumber(?string $number): ?WorkField
    {
        return WorkField::where('number', $number)->first();
    }
}
