<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Database\Eloquent\Collection;

class EnterpriseDepartmentRepository implements RepositoryInterface
{
    public function getDepartmentsOf(Enterprise $enterprise): Collection
    {
        return Department::whereHas('activities', fn($q) => $q->where('enterprise_id', $enterprise->id))
            ->orderBy('insee_code')->get();
    }
}
