<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasEnterprises
{
    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    /**
     * User enterprises pivot attributes
     *
     * @var array
     */
    protected $enterprisesPivot = [
        'job_title',
        'primary',
        'current',
        'is_signatory',
        'is_legal_representative'
    ];

    /**
     * Get the associated enterprises.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enterprises()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'addworking_enterprise_enterprises_has_users'
        )
            ->withPivot(...$this->enterprisesPivot)
            ->withTimestamps();
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    /**
     * Get the user's primary enterprise.
     *
     * !!! ------------------------------------------- !!!
     * !!!                                             !!!
     * !!! THIS METHOD IS THE PIVOT OF THE APPLICATION !!!
     * !!!              DO NOT CHANGE IT               !!!
     * !!!                                             !!!
     * !!! ------------------------------------------- !!!
     *
     * @return \App\Models\Addworking\Enterprise\Enterprise
     */
    public function getEnterpriseAttribute(): Enterprise
    {
        $current = $this->getCurrentEnterprise();

        if ($current->exists) {
            return $current;
        }

        return $this->getPrimaryEnterprise();
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    /**
     * Get the user's primary enterprise.
     *
     * @return \App\Models\Addworking\Enterprise\Enterprise
     */
    public function getPrimaryEnterprise()
    {
        return $this->enterprises()->wherePivot('primary', true)->firstOrNew([]);
    }

    /**
     * Get the user's current enterprise.
     *
     * @return \App\Models\Addworking\Enterprise\Enterprise
     */
    public function getCurrentEnterprise()
    {
        return $this->enterprises()->wherePivot('current', true)->firstOrNew([]);
    }

    /**
     * Set the user's primary enterprise.
     *
     * @param  \App\Models\Addworking\Enterprise\Enterprise $enterprise
     * @return $this
     */
    public function setPrimaryEnterprise(Enterprise $enterprise): self
    {
        DB::transaction(function () use ($enterprise) {
            if ($previous = $this->getPrimaryEnterprise()) {
                $this->enterprises()->updateExistingPivot($previous->id, ['primary' => false]);
            }

            $this->enterprises()->updateExistingPivot($enterprise->id, ['primary' => true]);
        });

        return $this;
    }

    /**
     * Set the user's current enterprise.
     *
     * @param  \App\Models\Addworking\Enterprise\Enterprise $enterprise
     * @return $this
     */
    public function setCurrentEnterprise(Enterprise $enterprise): self
    {
        DB::transaction(function () use ($enterprise) {
            if ($previous = $this->getCurrentEnterprise()) {
                $this->enterprises()->updateExistingPivot($previous->id, ['current' => false]);
            }

            $this->enterprises()->updateExistingPivot($enterprise->id, ['current' => true]);
        });

        return $this;
    }
}
