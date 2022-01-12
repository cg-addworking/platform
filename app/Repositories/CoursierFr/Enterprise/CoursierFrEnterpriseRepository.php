<?php

namespace App\Repositories\CoursierFr\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class CoursierFrEnterpriseRepository implements RepositoryInterface
{
    public function isCoursierFr(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'COURSIER.FR';
    }
}
