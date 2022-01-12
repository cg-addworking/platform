<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;

class EnterpriseIbanRepository implements RepositoryInterface
{
    public function getIban(Enterprise $enterprise): Iban
    {
        return $enterprise->ibans()->approved()->first() ?? new Iban;
    }

    public function hasApprovedIban(Enterprise $enterprise): bool
    {
        if (! $enterprise->ibans()->exists()) {
            return false;
        }

        if (is_null($enterprise->ibans()->approved()->first())) {
            return false;
        }

        return true;
    }
}
