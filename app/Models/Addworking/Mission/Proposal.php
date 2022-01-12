<?php

namespace App\Models\Addworking\Mission;

use App\Helpers\HasUuid;
use App\Models\Concerns\HasNumber;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Concerns\Proposal\HasStatuses;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;

class Proposal extends Model implements Htmlable, Searchable
{
    use SoftDeletes,
        HasUuid,
        Viewable,
        Routable,
        Notifiable,
        HasStatuses,
        Commentable, ProposalCompat, HasNumber;

    const UNIT_HOURS               = 'hours';
    const UNIT_DAYS                = 'days';
    const UNIT_FIXED_FEES          = 'fixed_fees';

    const STATUS_DRAFT              = 'draft';
    const STATUS_UNDER_NEGOTIATION  = 'under_negotiation';
    const STATUS_ACCEPTED           = 'accepted';
    const STATUS_REFUSED            = 'refused';
    const STATUS_ASSIGNED           = 'assigned';
    const STATUS_ABANDONED          = 'abandoned';
    const STATUS_ANSWERED           = 'answered';
    const STATUS_INTERESTED         = 'interested';
    const STATUS_RECEIVED           = 'received';
    const STATUS_BPU_SENDED         = 'bpu_sended';

    protected $table = 'addworking_mission_proposals';

    protected $fillable = [
        'vendor', //virtual
        'label',
        'details',
        'external_id',
        'status',
        'need_quotation',
        'valid_from',
        'valid_until',
        'quantity',
        'unit_price',
        'unit',
        'created_by',
        'accepted_by',
        'accepted_at',
        'refused_by', 'refused_at','number'
    ];

    protected $dates = [
        'valid_from',
        'valid_until',
        'accepted_at',
        'refused_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $routePrefix = "mission.proposal";

    protected $searchable = [
      'label'
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_enterprise_id')->withDefault();
    }

    /**
     * Get sogetrel passwork attached to this proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function passwork()
    {
        return $this->belongsTo(Passwork::class, 'vendor_passwork_id')->withDefault();
    }

    /**
     * @deprecated v0.29.4 in favor of offer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function missionOffer()
    {
        return $this->belongsTo(Offer::class, 'mission_offer_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'mission_offer_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refusedBy()
    {
        return $this->belongsTo(User::class, 'refused_by')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by')->withDefault();
    }

    public function responses()
    {
        return $this->hasMany(ProposalResponse::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
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
                return $query->filterVendor($search);
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

    public function scopeOfOffer($query, Offer $offer)
    {
        return $query->whereHas('offer', function ($query) use ($offer) {
            $query->where('id', $offer->id);
        });
    }

    /**
     * @param $query
     * @param Enterprise $enterprise
     * @return mixed
     */
    public function scopeOfVendor($query, Enterprise $enterprise, ?Passwork $passwork = null)
    {
        $query->where('vendor_enterprise_id', $enterprise->id);

        // @todo remove this! proposals should always be attached through enterprise id
        if ($passwork instanceof Passwork && $passwork->exists) {
            $query->orWhere('vendor_passwork_id', $passwork->id);
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeExceptDraft($query)
    {
        return $query->where('status', '!=', self::STATUS_DRAFT);
    }

    public function scopeFilterLabel($query, $label)
    {
        return $query->where(DB::raw('LOWER(label)'), 'like', "%". strtolower($label)."%");
    }

    /**
     * Filtering proposal missions with given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFilterVendor($query, $enterprise)
    {
        return $query->whereHas('vendor', function ($query) use ($enterprise) {
            return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
        });
    }

    public function scopeFilterCustomer($query, $enterprise)
    {
        return $query->whereHas('missionOffer', function ($query) use ($enterprise) {
            return $query->whereHas('customer', function ($query) use ($enterprise) {
                return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
            });
        });
    }

    public function scopeFilterReferent($query, $referent)
    {
        $referent = strtolower($referent);

        return $query->whereHas('offer', function ($query) use ($referent) {
            return $query->whereHas('referent', function ($query) use ($referent) {
                return $query->where(DB::raw('LOWER(firstname) || LOWER(lastname)'), 'like', "%{$referent}%");
            });
        });
    }

    public function scopeFilterStartsAtDesired($query, $date)
    {
        return $query->whereHas('offer', function ($query) use ($date) {
            return $query->where('starts_at_desired', 'like', "%{$date}%");
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    /**
     * Sets the issued_at attribute.
     *
     * @param  mixed $value
     * @return void
     */
    public function setValidFromAttribute($value)
    {
        if (is_string($value) && is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['valid_from'] = $this->fromDateTime($value);
    }

    /**
     * Sets the issued_at attribute.
     *
     * @param  mixed $value
     * @return void
     */
    public function setValidUntilAttribute($value)
    {
        if (is_string($value) && is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['valid_until'] = $this->fromDateTime($value);
    }

    /**
     * @param $value
     */
    public function setQuantityAttribute($value)
    {
        if (!is_null($value) && $value < 0) {
            throw new UnexpectedValueException("Invalid quantity");
        }

        $this->attributes['quantity'] = $value;
    }

    /**
     * @param $value
     */
    public function setUnitAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableUnits())) {
            throw new UnexpectedValueException("Invalid unit");
        }

        $this->attributes['unit'] = $value;
    }

    /**
     * @return float|int
     */
    public function getAmountAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * @param $value
     */
    public function setStatusAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    /**
     * Sets vendor attribute
     *
     * @param $value
     */
    public function setVendorAttribute($value)
    {
        if (is_null($value)) {
            return;
        }

        $this->passwork()->associate($value);

        $user = Passwork::find($value)->user;
        if ($user->enterprise->exists) {
            $this->vendor()->associate($user->enterprise);
        }
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    /**
     * @return array
     */
    public static function getAvailableUnits()
    {
        return [
            self::UNIT_HOURS,
            self::UNIT_DAYS,
            self::UNIT_FIXED_FEES
        ];
    }

    public function getDetailsHtmlAttribute()
    {
        return strip_tags(nl2br($this->details), '<br>');
    }

    public function getOffer()
    {
        return $this->offer()->first();
    }
}
