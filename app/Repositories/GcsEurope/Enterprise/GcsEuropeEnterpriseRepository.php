<?php

namespace App\Repositories\GcsEurope\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class GcsEuropeEnterpriseRepository implements RepositoryInterface
{
    public function isGcsEurope(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'GCS EUROPE';
    }
}
