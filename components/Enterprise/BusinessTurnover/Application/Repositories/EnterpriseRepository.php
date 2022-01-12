<?php

namespace Components\Enterprise\BusinessTurnover\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function make($data = []): Enterprise
    {
        return new Enterprise($data);
    }

    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function getLastYearBusinessTurnover(Enterprise $enterprise): ?BusinessTurnoverEntityInterface
    {
        $last_year = Carbon::now()->subYear()->year;

        return $enterprise
            ->businessTurnovers()
            ->where('year', $last_year)
            ->first();
    }

    public function collectBusinessTurnover(Enterprise $enterprise): bool
    {
        return $enterprise->collect_business_turnover;
    }
}
