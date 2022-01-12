<?php

namespace App\Models\Addworking\Mission;

use Components\Enterprise\WorkField\Application\Models\WorkField;
use UnexpectedValueException;
use Illuminate\Support\Facades\DB;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\User\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Addworking\Mission\Mission;
use Illuminate\Contracts\Support\Htmlable;
use App\Models\Addworking\Common\Department;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Edenred\Common\Code as EdenredCode;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use App\Models\Addworking\Mission\Concerns\Offer\HasStatuses;
use App\Models\Everial\Mission\Referential as EverialReferential;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;

class Offer extends Model implements Htmlable, Searchable
{
    use SoftDeletes, HasUuid, Viewable, Routable, HasStatuses;

    const STATUS_DRAFT                = 'draft';
    const STATUS_TO_PROVIDE           = 'to_provide';
    const STATUS_COMMUNICATED         = 'communicated';
    const STATUS_CLOSED               = 'closed';
    const STATUS_ABANDONED            = 'abandoned';

    protected $table = 'addworking_mission_offers';

    protected $fillable = [
        'files', // virtual
        'departments', // virtual
        'number',
        'status',
        'label',
        'description',
        'starts_at_desired',
        'ends_at',
        'external_id',
        'analytic_code',
    ];

    protected $dates = [
        'starts_at_desired',
        'ends_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $routePrefix = "mission.offer";

    protected $searchable = [
        'label',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function customer()
    {
        return $this->belongsTo(Enterprise::class, 'customer_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function referent()
    {
        return $this->belongsTo(User::class, 'referent_id')->withDefault();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'addworking_mission_offers_has_departments')
            ->withTimestamps();
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'mission_offer_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'addworking_mission_offers_has_files')->withTimestamps();
    }

    /**
     * @deprecated v0.47.0
     */
    public function sogetrelPassworks()
    {
        return $this->belongsToMany(
            SogetrelPasswork::class,
            'sogetrel_user_passworks_has_offers',
            'offer_id',
            'passwork_id'
        )->withPivot(['selected_by', 'status'])->withTimestamps();
    }

    public function responses()
    {
        return $this->HasManyThrough(ProposalResponse::class, Proposal::class, 'mission_offer_id', 'proposal_id');
    }

    public function edenredCodes()
    {
        return $this->belongsToMany(
            EdenredCode::class,
            'addworking_mission_offers_has_edenred_codes',
            'offer_id',
            'code_id'
        )->whereNull('addworking_mission_offers_has_edenred_codes.deleted_at')->withTimestamps();
    }

    public function everialReferentialMissions()
    {
        return $this->belongsToMany(
            EverialReferential::class,
            'addworking_mission_offers_has_everial_referential_missions',
            'offer_id',
            'referential_id'
        )->whereNull('addworking_mission_offers_has_everial_referential_missions.deleted_at')->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'addworking_mission_offers_has_skills')->withTimestamps();
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function workfield()
    {
        return $this->belongsTo(WorkField::class, 'workfield_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterCustomer($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterReferent($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeFilterReferent($query, $referent)
    {
        return $query->whereHas('referent', function ($q) use ($referent) {
            $q->where(DB::raw('LOWER(firstname) || LOWER(lastname)'), 'LIKE', "%".strtolower($referent)."%");
        });
    }

    public function scopeOfCustomer($query, Enterprise $enterprise)
    {
        return $query->where('customer_id', $enterprise->id);
    }

    public function scopeExceptDraft($query)
    {
        return $query->where('status', '!=', self::STATUS_DRAFT);
    }

    public function scopeHavingProposalsForVendor($query, Enterprise $enterprise)
    {
        return $query->whereHas('proposals', function ($q) use ($enterprise) {
            $q->where('vendor_enterprise_id', $enterprise->id);
        });
    }

    public function scopeHavingProposalsForCustomer($query, Enterprise $enterprise)
    {
        return $query->whereHas('customer', function ($q) use ($enterprise) {
            $enterprise_ids = $enterprise->descendants()->push($enterprise)->pluck('id');
            $q->whereIn('id', $enterprise_ids);
        });
    }

    public function scopeHavingProposalsForVendorCustomer($query, Enterprise $enterprise)
    {
         return $query->where('customer_id', $enterprise->id)
                    ->where('created_by', Auth::user()->id);
    }

    public function scopeFilterLabel($query, $label)
    {
        return $query->where(DB::raw('LOWER(label)'), 'like', "%". strtolower($label)."%");
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFilterCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }

    public function scopeFilterCustomer($query, $enterprise)
    {
        return $query->whereHas('customer', function ($query) use ($enterprise) {
            return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
        });
    }
    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getDescriptionHtmlAttribute()
    {
        return strip_tags(nl2br($this->description), '<br>');
    }

    public function setStartsAtAttribute($value)
    {
        if (is_string($value) && is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['starts_at_desired'] = $this->fromDateTime($value);
    }

    public function setEndsAtAttribute($value)
    {
        if (is_string($value) && is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['ends_at'] = $this->fromDateTime($value);
    }

    public function setStatusAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public function hasProposalsFor(Enterprise $vendor): bool
    {
        return $this->proposals()->where('vendor_enterprise_id', $vendor->id)->exists();
    }

    public static function getAvailableReferentials(): array
    {
        return EverialReferential::all()->pluck('label', 'id')->toArray();
    }

    public function isClosed(): bool
    {
        return $this->status == self::STATUS_CLOSED;
    }
}
