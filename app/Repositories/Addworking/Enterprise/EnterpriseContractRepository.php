<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use RuntimeException;

class EnterpriseContractRepository implements RepositoryInterface
{
    public function hasSignedContracts(Enterprise $enterprise, string $type): bool
    {
        $count = 0;

        $contracts = $enterprise->contracts()->where('type', $type)->get();

        foreach ($contracts as $contract) {
            $count += $contract->users()
                ->whereIn('id', $enterprise->signatories->pluck('id'))
                ->wherePivot('signed', true)
                ->count();
        }

        return $count;
    }

    public function hasCps1(Enterprise $enterprise): bool
    {
        return $enterprise->contracts()->ofType('cps1')->exists();
    }

    public function hasCps2(Enterprise $enterprise): bool
    {
        return $enterprise->contracts()->ofType('cps2')->exists();
    }

    public function hasCps3(Enterprise $enterprise): bool
    {
        return $enterprise->contracts()->ofType('cps3')->exists();
    }
}
