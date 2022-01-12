<?php

namespace App\Repositories\Edenred\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class EdenredEnterpriseRepository implements RepositoryInterface
{
    public function isEdenred(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'EDENRED';
    }

    public function isPartOfEdenredDomain(Enterprise $enterprise): bool
    {
        if (! Enterprise::whereName('EDENRED')->exists()) {
            return false;
        }

        return $enterprise->isPartOfDomain(Enterprise::fromName('EDENRED'));
    }
}
