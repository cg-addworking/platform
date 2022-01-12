<?php

namespace App\Models\Addworking\Enterprise;

use App\Models\Addworking\Common\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EnterpriseCollection extends Collection
{
    public function vendors(): Collection
    {
        return Enterprise::whereHas('customers', function ($q) {
            return $q->whereIn('id', $this->pluck('id'));
        })->get();
    }

    public function jobs(): Builder
    {
        return Job::whereHas('enterprise', function ($q) {
            return $q->whereIn('id', $this->pluck('id'));
        });
    }

    public function ancestors(bool $include_self = false): Builder
    {
        $ids = $this
            ->map(fn($enterprise) => $enterprise->ancestors($include_self))
            ->flatten()
            ->unique('id')
            ->pluck('id');

        return Enterprise::whereIn('id', $ids);
    }

    public function documentTypes(): Builder
    {
        return DocumentType::whereHas('enterprise', function ($q) {
            return $q->whereIn('id', $this->pluck('id'));
        });
    }
}
