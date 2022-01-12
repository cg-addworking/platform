<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\Enterprise\Application\Models\Activity;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyActivityEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyActivity extends Model implements CompanyActivityEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_activities';

    protected $fillable = [
        'social_object',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'social_object' => 'string',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id')->withDefault();
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function getActivity()
    {
        return $this->activity()->first();
    }

    public function getSocialObject(): ?string
    {
        return $this->social_object;
    }

    public function getStartsAt()
    {
        return $this->starts_at;
    }

    public function getEndsAt()
    {
        return $this->ends_at;
    }

    public function getOriginData(): ?string
    {
        return $this->origin_data;
    }
}
