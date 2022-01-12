<?php

namespace App\Models\Concerns;

use App\Models\Addworking\Enterprise\EnterpriseActivity;

trait HasActivities
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(EnterpriseActivity::class);
    }

    public function hasActivities(): bool
    {
        return count($this->activities) > 0;
    }

    /**
     * @deprecated
     */
    public function getEmployeesCount(): int
    {
        return $this->employees_count;
    }
}
