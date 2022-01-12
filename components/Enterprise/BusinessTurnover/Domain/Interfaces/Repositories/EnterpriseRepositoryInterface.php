<?php

namespace Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;

interface EnterpriseRepositoryInterface
{
    public function make($data = []): Enterprise;
    public function findBySiret(string $siret): ?Enterprise;
    public function getLastYearBusinessTurnover(Enterprise $enterprise): ?BusinessTurnoverEntityInterface;
    public function collectBusinessTurnover(Enterprise $enterprise): bool;
}
